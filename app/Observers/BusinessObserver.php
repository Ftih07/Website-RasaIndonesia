<?php

namespace App\Observers;

use App\Models\Business;
use App\Models\Role;
use App\Helpers\NotificationHelper;

class BusinessObserver
{
    public function updating(Business $business): void
    {
        // Cek apakah sebelumnya belum terverifikasi dan sekarang di-set true
        if (!$business->getOriginal('is_verified') && $business->is_verified) {
            $user = $business->user;

            // Assign role 'seller' ke user (jika belum punya)
            if ($user && !$user->roles()->where('name', 'seller')->exists()) {
                $role = Role::where('name', 'seller')->first();
                if ($role) {
                    $user->roles()->attach($role->id);
                }
            }
        }
    }

    public function deleted(Business $business): void
    {
        if ($business->user) {
            // Hapus role seller
            if ($business->user->hasRole('seller')) {
                $business->user->removeRole('seller');
            }

            // Kirim notifikasi penghapusan
            NotificationHelper::send(
                $business->user_id,
                'Bisnismu telah dihapus',
                'Bisnis "' . $business->name . '" telah dihapus oleh admin.',
                route('dashboard') // arahkan ke dashboard seller
            );
        }
    }
}

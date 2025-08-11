<?php

namespace App\Observers;

use App\Models\Business;
use App\Models\Role;
use App\Helpers\NotificationHelper;

class BusinessObserver
{
    public function updating(Business $business): void
    {
        // Case: bisnis baru diverifikasi
        if (!$business->getOriginal('is_verified') && $business->is_verified) {
            $user = $business->user;

            if ($user && !$user->roles()->where('name', 'seller')->exists()) {
                $role = Role::where('name', 'seller')->first();
                if ($role) {
                    $user->roles()->attach($role->id);
                }
            }
        }

        // Case: cabut kepemilikan
        $originalUserId = $business->getOriginal('user_id');
        if ($originalUserId && is_null($business->user_id)) {
            $user = \App\Models\User::find($originalUserId);

            if ($user && $user->hasRole('seller')) {
                $user->removeRole('seller');
            }

            // Optional: ubah is_verified jadi false
            $business->is_verified = false;
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

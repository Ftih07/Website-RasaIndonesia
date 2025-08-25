<?php

namespace App\Filament\Resources\ChatResource\Pages;

use App\Filament\Resources\ChatResource;
use App\Filament\Widgets\ChatMessagesWidget;
use App\Models\Message;
use Filament\Resources\Pages\ViewRecord;

class ViewChat extends ViewRecord
{
    protected static string $resource = ChatResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            ChatMessagesWidget::make(['record' => $this->record]),
        ];
    }

    public function mount($record): void
    {
        parent::mount($record);

        // tandai semua pesan lawan yg belum dibaca jadi read
        Message::where('chat_id', $this->record->id)
            ->where('is_read', false)
            ->where('sender_id', '!=', auth()->id())
            ->update([
                'is_read'  => true,
                'read_at'  => now(),
            ]);
    }
}

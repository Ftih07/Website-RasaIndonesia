<?php

namespace App\Filament\Pages;

use Filament\Forms;
use Filament\Pages\Page;
use Filament\Notifications\Notification;
use App\Models\ProsperityExpoSentEmail;
use App\Mail\ProsperityExpoMail;
use Illuminate\Support\Facades\Mail;
use Livewire\WithFileUploads;

class BulkEmailSender extends Page implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;
    use WithFileUploads;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.pages.bulk-email-sender';
    protected static ?string $navigationGroup = 'Prosperity Expo';

    public $data = [
        'csv_file' => null,
    ]; // ✅ simpan di array

    public function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('csv_file')
                    ->label('Upload CSV')
                    ->acceptedFileTypes(['text/csv'])
                    ->required()
                    ->directory('bulk-csv')
                    ->maxFiles(1)
                    ->multiple(false),
            ])
            ->statePath('data'); // ✅ simpan state di $data
    }

    public function submit()
    {
        $state = $this->form->getState(); // Ambil data dari form
        $path = $state['csv_file'] ?? null;

        if (is_array($path)) {
            $path = $path[0] ?? null;
        }

        if (!$path) {
            Notification::make()
                ->title('No file uploaded!')
                ->danger()
                ->send();
            return;
        }

        $filePath = storage_path('app/public/' . $path);
        if (!file_exists($filePath)) {
            Notification::make()
                ->title('File not found!')
                ->danger()
                ->send();
            return;
        }

        $handle = fopen($filePath, 'r');
        $rows = [];
        $header = null;

        while (($data = fgetcsv($handle, 0, ',')) !== false) {
            if ($header === null) {
                $data[0] = preg_replace('/^\xEF\xBB\xBF/', '', $data[0]);
                $header = $data;
            } else {
                $rows[] = array_combine($header, $data);
            }
        }
        fclose($handle);

        foreach ($rows as $row) {
            ProsperityExpoSentEmail::create([
                'recipient_name'   => $row['Name'] ?? null,
                'email'            => $row['Email'] ?? null,
                'company_brand'    => $row['Company Name'] ?? null,
                'participant_type' => $row['Participant Type'] ?? null,
                'link'             => !empty($row['qr_code'])
                    ? 'https://tasteofindonesia.com.au/prosperity-expo/thank-you/' . $row['qr_code']
                    : null,
            ]);
        }

        Notification::make()
            ->title('Data imported successfully!')
            ->success()
            ->send();
    }
}

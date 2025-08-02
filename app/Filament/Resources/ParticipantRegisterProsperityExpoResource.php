<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ParticipantRegisterProsperityExpoResource\Pages;
use App\Models\ParticipantRegisterProsperityExpo;
use App\Exports\ParticipantRegisterProsperityExpoExport; // Assuming this export class exists
use Filament\Forms; // Import for Filament Form components
use Filament\Forms\Form; // Import for the Form class
use Filament\Resources\Resource; // Base class for Filament Resources
use Filament\Tables; // Import for Filament Table components
use Filament\Tables\Table; // Import for the Table class
use Filament\Notifications\Notification; // Import for Filament notifications
use Illuminate\Database\Eloquent\Builder; // Import for Eloquent query builder
use Maatwebsite\Excel\Facades\Excel; // Import for Excel facade (for export functionality)

// This class defines a Filament Resource for managing ParticipantRegisterProsperityExpo records.
// Filament Resources provide a quick way to build administration interfaces (CRUD operations)
// for your Eloquent models with minimal code.
class ParticipantRegisterProsperityExpoResource extends Resource
{
    // Specifies the Eloquent model that this Filament Resource manages.
    // This tells Filament which database table this resource interacts with.
    protected static ?string $model = ParticipantRegisterProsperityExpo::class;

    // Defines the Heroicon to be used as the navigation icon for this resource in the Filament sidebar.
    protected static ?string $navigationIcon = 'heroicon-o-users';

    // Sets the label that will appear in the Filament sidebar navigation.
    protected static ?string $navigationLabel = 'Event Participants';

    // Sets the singular label for the model, used in various parts of the UI (e.g., "New Participant").
    protected static ?string $modelLabel = 'Participant';

    // Sets the plural label for the model, used in table titles and other plural contexts.
    protected static ?string $pluralModelLabel = 'Participants';

    // Organizes this resource under a specific group in the Filament sidebar navigation.
    protected static ?string $navigationGroup = 'Prosperity Expo';

    // Determines the sorting order of this resource within its navigation group. Lower numbers appear first.
    protected static ?int $navigationSort = 1;

    /**
     * Defines the form schema for creating and editing Participant records.
     * This method builds the input fields that users will interact with.
     *
     * @param Form $form The Filament Form instance.
     * @return Form The configured Form instance.
     */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Section for Personal Information
                Forms\Components\Section::make('Personal Information')
                    ->description('Basic participant details') // A short description for the section
                    ->schema([
                        // Grid layout with 2 columns for better organization of fields
                        Forms\Components\Grid::make(2)
                            ->schema([
                                // Text input field for participant's full name
                                Forms\Components\TextInput::make('name')
                                    ->label('Full Name') // Label displayed on the form
                                    ->required() // Makes this field mandatory
                                    ->maxLength(255) // Sets maximum character length
                                    ->placeholder('Enter full name'), // Placeholder text

                                // Text input field for participant's email address
                                Forms\Components\TextInput::make('email')
                                    ->label('Email Address')
                                    ->email() // Adds email validation
                                    ->required()
                                    ->unique(ignoreRecord: true) // Ensures email is unique (ignores current record on edit)
                                    ->maxLength(255)
                                    ->placeholder('email@example.com'),
                            ]),

                        // Text input field for participant's contact number
                        Forms\Components\TextInput::make('contact')
                            ->label('Phone Number / WhatsApp Number')
                            ->tel() // Adds telephone number validation
                            ->required()
                            ->maxLength(20)
                            ->placeholder('+62 xxx-xxxx-xxxx'),
                    ]),

                // Section for Company Information
                Forms\Components\Section::make('Company Information')
                    ->description('Company and professional details')
                    ->schema([
                        // Grid layout with 2 columns
                        Forms\Components\Grid::make(2)
                            ->schema([
                                // Text input for company name
                                Forms\Components\TextInput::make('company_name')
                                    ->label('Company Name / Brand')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('PT. Company Name'),

                                // Text input for job position
                                Forms\Components\TextInput::make('position')
                                    ->label('Position / Title')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('CEO, Manager, etc.'),
                            ]),

                        // Text input for company type
                        Forms\Components\TextInput::make('company_type')
                            ->label('Type of Business / Industry')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Manufacturing, Trading, Services, etc.'),

                        // Textarea for product/service description
                        Forms\Components\Textarea::make('product_description')
                            ->label('Brief Description of Products/Services')
                            ->required()
                            ->rows(3) // Sets the number of visible rows for the textarea
                            ->maxLength(1000)
                            ->placeholder('Describe your company products or services...'),

                        // Optional text input for company social media username
                        Forms\Components\TextInput::make('company_social_media_username')
                            ->label('Social Media Username')
                            ->maxLength(255)
                            ->placeholder('@company_username')
                            ->helperText('Optional: Instagram, LinkedIn, or other social media handle'), // Small helper text below the field
                    ]),

                // Section for Participation Details
                Forms\Components\Section::make('Participation Details')
                    ->description('Event participation type and pricing')
                    ->schema([
                        // Radio button group for participant type (Exhibitor/Sponsor/Visitor)
                        Forms\Components\Radio::make('participant_type')
                            ->label('Participantion Type')
                            ->required()
                            ->options(static::getParticipantTypeOptions()) // Options are pulled from a helper method
                            ->descriptions([ // Adds descriptive text below each radio option
                                'Exhibitor : Rp. 10.000.000' => 'Standard exhibition booth with basic amenities',
                                'Sponsor : Rp. 25.000.000' => 'Premium sponsorship package with enhanced visibility',
                                'Visitor : Free' => 'Visit the exhibition for free, discover a wide range of offerings, and forge valuable connections.',
                            ])
                            ->inline(false), // Displays options vertically

                        // File upload field for company profile document
                        Forms\Components\FileUpload::make('company_profile')
                            ->label('Company Profile Document')
                            ->directory('prosperity-expo/company-profiles') // Storage directory for uploaded files
                            ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document']) // Allowed file types
                            ->maxSize(5120) // Maximum file size in KB (5MB)
                            ->helperText('Upload company profile (PDF, DOC, DOCX - Max 5MB)')
                            ->downloadable() // Allows downloading the uploaded file
                            ->previewable(false), // Disables previewing the file in the form
                    ]),

                // Section for System Information (typically for admin use, hidden by default)
                Forms\Components\Section::make('System Information')
                    ->description('System generated and status information')
                    ->schema([
                        // Grid layout with 2 columns
                        Forms\Components\Grid::make(2)
                            ->schema([
                                // Text input for QR Code (disabled, auto-generated)
                                Forms\Components\TextInput::make('qr_code')
                                    ->label('QR Code')
                                    ->disabled() // Makes the field read-only
                                    ->helperText('Auto-generated after registration'),

                                // Select dropdown for attendance status
                                Forms\Components\Select::make('status')
                                    ->label('Attendance Status')
                                    ->options(static::getStatusOptions()) // Options pulled from a helper method
                                    ->placeholder('Select status')
                                    ->helperText('Update participant attendance status'),
                            ]),
                    ])
                    ->collapsible() // Makes the section collapsible
                    ->collapsed(), // Makes the section collapsed by default
            ]);
    }

    /**
     * Defines the table schema for listing Participant records.
     * This method builds the columns, filters, and actions for the data table.
     *
     * @param Table $table The Filament Table instance.
     * @return Table The configured Table instance.
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Text column for participant's name
                Tables\Columns\TextColumn::make('name')
                    ->label('Participant Name')
                    ->searchable() // Allows searching by name
                    ->sortable() // Allows sorting by name
                    ->weight('medium'), // Sets font weight

                // Text column for email
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable()
                    ->toggleable(), // Allows hiding/showing this column

                // Text column for company name
                Tables\Columns\TextColumn::make('company_name')
                    ->label('Company')
                    ->searchable()
                    ->sortable()
                    ->wrap(), // Wraps text if it's too long

                // Badge column for participant type (displays as a colored badge)
                Tables\Columns\TextColumn::make('participant_type')
                    ->label('Package')
                    ->badge() // Renders the text as a badge
                    ->color(fn(string $state): string => match (true) { // Sets badge color based on state
                        str_contains($state, 'Sponsor') => 'success',
                        str_contains($state, 'Exhibitor') => 'info',
                        str_contains($state, 'Visitor') => 'gray', // Added for Visitor
                        default => 'gray', // Default fallback
                    })
                    ->formatStateUsing( // Formats the displayed text for the badge
                        fn(string $state): string => match (true) {
                            str_contains($state, 'Sponsor') => 'Sponsor',
                            str_contains($state, 'Exhibitor') => 'Exhibitor',
                            str_contains($state, 'Visitor') => 'Visitor', // Added for Visitor
                            default => 'N/A', // Default fallback
                        }
                    ),

                // Text column for QR Code
                Tables\Columns\TextColumn::make('qr_code')
                    ->label('QR Code')
                    ->searchable()
                    ->toggleable()
                    ->copyable() // Allows copying the QR code to clipboard
                    ->copyMessage('QR code copied!') // Message shown after copying
                    ->fontFamily('mono'), // Sets a monospaced font for the QR code

                // Badge column for attendance status
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([ // Defines colors for different status values
                        'success' => 'present',
                        'danger' => 'not_found',
                        'secondary' => fn($state) => $state === null, // Gray for null status
                    ])
                    ->formatStateUsing(fn(?string $state): string => match ($state) { // Formats display text
                        'present' => 'Present',
                        'not_found' => 'Absent',
                        default => 'Not Checked',
                    }),

                Tables\Columns\TextColumn::make('company_profile')
                    ->label('Company Profile')
                    ->formatStateUsing(function (?string $state) {
                        return $state
                            ? '<a href="' . asset('storage/' . $state) . '" target="_blank">View File</a>'
                            : '-';
                    })
                    ->html(),

                // Text column for registration date and time
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Registered')
                    ->dateTime('M j, Y H:i') // Formats the date and time
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                // Select filter for attendance status
                Tables\Filters\SelectFilter::make('status')
                    ->label('Attendance Status')
                    ->options(static::getStatusOptions()) // Options from helper method
                    ->placeholder('All Statuses'),

                // Select filter for participant package type
                Tables\Filters\SelectFilter::make('participant_type')
                    ->label('Package Type')
                    ->options([ // Explicitly defined options for the filter
                        'Exhibitor : Rp. 10.000.000' => 'Exhibitor',
                        'Sponsor : Rp. 25.000.000' => 'Sponsor',
                        'Visitor : Free' => 'Visitor',
                    ])
                    ->placeholder('All Packages'),

                // Date range filter for registration date
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label('Registered From'),
                        Forms\Components\DatePicker::make('created_until')
                            ->label('Registered Until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        // Applies the date range filter to the query
                        return $query
                            ->when(
                                $data['created_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
            ])
            ->headerActions([
                // Action button to export all participants to Excel
                Tables\Actions\Action::make('export_excel')
                    ->label('Export to Excel')
                    ->icon('heroicon-o-document-arrow-down') // Icon for the button
                    ->color('success') // Color of the button
                    ->action(function () {
                        try {
                            // Display a success notification when export starts
                            Notification::make()
                                ->title('Export Started')
                                ->body('Your Excel file is being generated...')
                                ->success()
                                ->send();

                            // Trigger the Excel download using Maatwebsite\Excel
                            return Excel::download(
                                new ParticipantRegisterProsperityExpoExport, // Instantiates the export class
                                'prosperity-expo-participants-' . now()->format('Y-m-d') . '.xlsx' // File name
                            );
                        } catch (\Exception $e) {
                            // Display an error notification if export fails
                            Notification::make()
                                ->title('Export Failed')
                                ->body('There was an error generating the Excel file.')
                                ->danger()
                                ->send();
                        }
                    }),
                // ✅ Export ke CSV
                Tables\Actions\Action::make('export_csv')
                    ->label('Export to CSV')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('info')
                    ->action(function () {
                        try {
                            Notification::make()
                                ->title('Export Started')
                                ->body('Your CSV file is being generated...')
                                ->success()
                                ->send();

                            return Excel::download(
                                new ParticipantRegisterProsperityExpoExport,
                                'prosperity-expo-participants-' . now()->format('Y-m-d') . '.csv',
                                \Maatwebsite\Excel\Excel::CSV // 🔥 Writer type CSV
                            );
                        } catch (\Exception $e) {
                            Notification::make()
                                ->title('Export Failed')
                                ->body('There was an error generating the CSV file.')
                                ->danger()
                                ->send();
                        }
                    }),
            ])
            ->actions([
                // View Action: Opens a slide-over modal to view participant details
                Tables\Actions\ViewAction::make()
                    ->slideOver(),

                // Edit Action: Opens a slide-over modal to edit participant details
                Tables\Actions\EditAction::make()
                    ->slideOver(),

                // Custom Action: Mark participant as 'present'
                Tables\Actions\Action::make('mark_present')
                    ->label('Mark Present')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->action(function (ParticipantRegisterProsperityExpo $record) {
                        // Updates the participant's status to 'present'
                        $record->update(['status' => 'present']);

                        // Sends a success notification
                        Notification::make()
                            ->title('Status Updated')
                            ->body("{$record->name} marked as present.")
                            ->success()
                            ->send();
                    })
                    ->visible( // This action is only visible if the status is NOT already 'present'
                        fn(ParticipantRegisterProsperityExpo $record): bool =>
                        $record->status !== 'present'
                    ),
            ])
            ->bulkActions([
                // Group for bulk actions (actions that apply to multiple selected records)
                Tables\Actions\BulkActionGroup::make([
                    // Delete Bulk Action: Allows deleting multiple selected records
                    Tables\Actions\DeleteBulkAction::make(),

                    // Custom Bulk Action: Mark multiple selected participants as 'present'
                    Tables\Actions\BulkAction::make('mark_present_bulk')
                        ->label('Mark Selected as Present')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(function ($records) {
                            $count = $records->count(); // Get count of selected records
                            // Iterate through selected records and update their status
                            $records->each(fn($record) => $record->update(['status' => 'present']));

                            // Send a success notification
                            Notification::make()
                                ->title('Bulk Update Successful')
                                ->body("{$count} participants marked as present.")
                                ->success()
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion(), // Deselects records after the action is done

                    // Custom Bulk Action: Export selected participants to Excel
                    Tables\Actions\BulkAction::make('export_selected')
                        ->label('Export Selected')
                        ->icon('heroicon-o-document-arrow-down')
                        ->color('info')
                        ->action(function ($records) {
                            // Get IDs of selected records
                            $ids = $records->pluck('id')->toArray();
                            // Trigger Excel download for only the selected IDs
                            return Excel::download(
                                new ParticipantRegisterProsperityExpoExport($ids), // Passes selected IDs to the export class
                                'selected-participants-' . now()->format('Y-m-d') . '.xlsx'
                            );
                        }),
                ]),
            ])
            ->defaultSort('created_at', 'desc') // Sets default sorting for the table (newest first)
            ->striped() // Adds alternating row colors for better readability
            ->paginated([10, 25, 50, 100]); // Defines pagination options for the table
    }

    /**
     * Defines any relation managers for this resource.
     * Relation managers allow managing related data (e.g., if a participant had multiple registrations).
     *
     * @return array
     */
    public static function getRelations(): array
    {
        return [
            // Add relation managers here if needed (e.g., ParticipantRegisterProsperityExpoRelationManager::class)
        ];
    }

    /**
     * Defines the pages (routes) associated with this resource.
     * This maps URLs to specific Filament pages (list, create, edit, view).
     *
     * @return array
     */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListParticipantRegisterProsperityExpos::route('/'), // List all participants
            'create' => Pages\CreateParticipantRegisterProsperityExpo::route('/create'), // Create a new participant
            'edit' => Pages\EditParticipantRegisterProsperityExpo::route('/{record}/edit'), // Edit an existing participant
            'view' => Pages\ViewParticipantRegisterProsperityExpo::route('/{record}'), // View details of a participant
        ];
    }

    /**
     * Helper method to provide options for the 'participant_type' field (radio buttons and filter).
     *
     * @return array
     */
    protected static function getParticipantTypeOptions(): array
    {
        return [
            'Exhibitor : Rp. 10.000.000' => 'Exhibitor : Rp. 10.000.000',
            'Sponsor : Rp. 25.000.000' => 'Sponsor : Rp. 25.000.000',
            'Visitor : Free' => 'Visitor : Free',
        ];
    }

    /**
     * Helper method to provide options for the 'status' field (select dropdown and filter).
     *
     * @return array
     */
    protected static function getStatusOptions(): array
    {
        return [
            'present' => 'Present',
            'not_found' => 'Not Found',
            null => 'Not Checked', // Represents the default null status in the database
        ];
    }

    /**
     * Get navigation badge (show count of participants)
     * This method displays the total number of participants next to the navigation item in the sidebar.
     *
     * @return string|null
     */
    public static function getNavigationBadge(): ?string
    {
        // Counts all records in the associated model's table.
        return static::getModel()::count();
    }
}

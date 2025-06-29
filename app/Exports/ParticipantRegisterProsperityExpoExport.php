<?php

namespace App\Exports;

use App\Models\ParticipantRegisterProsperityExpo; // Import the Eloquent Model for participants
use Maatwebsite\Excel\Concerns\FromCollection; // Interface to define that the export will be from an Eloquent collection
use Maatwebsite\Excel\Concerns\WithHeadings; // Interface to define custom headings for the Excel file

// This class is responsible for exporting participant data to an Excel file.
// It uses the Maatwebsite\Excel package to achieve this.
//
// It implements two key interfaces:
// - FromCollection: Tells the package to get data from an Eloquent collection.
// - WithHeadings: Allows us to define the column headers in the Excel file.
class ParticipantRegisterProsperityExpoExport implements FromCollection, WithHeadings
{
    /**
     * The `collection` method is required by the `FromCollection` interface.
     * It defines which data will be fetched from the database and included in the export.
     *
     * @return \Illuminate\Support\Collection Returns an Eloquent collection of participant records.
     */
    public function collection()
    {
        // Fetch all participant records from the database.
        // We explicitly select only the columns we want to include in the Excel export.
        // This helps to keep the exported file clean and only contains relevant data.
        return ParticipantRegisterProsperityExpo::all([
            'id',
            'name',
            'email',
            'company_name',
            'position',
            'contact',
            'participant_type',
            'company_type',
            'product_description',
            'status',
            'created_at', // The timestamp when the participant registered
        ]);
    }

    /**
     * The `headings` method is required by the `WithHeadings` interface.
     * It defines the column headers (the first row) for the Excel file.
     * These headings should correspond to the order of the columns returned by the `collection()` method.
     *
     * @return array Returns an array of strings, where each string is a column heading.
     */
    public function headings(): array
    {
        // These are the human-readable names that will appear as the column titles
        // in the generated Excel spreadsheet.
        return [
            'ID',
            'Name',
            'Email',
            'Company Name',
            'Position',
            'Contact',
            'Participant Type',
            'Company Type',
            'Product Description',
            'Status',
            'Registered At' // Corresponds to 'created_at' from the database
        ];
    }
}

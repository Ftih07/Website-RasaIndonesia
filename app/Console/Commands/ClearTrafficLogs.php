<?php

namespace App\Console\Commands;

use Illuminate\Console\Command; // Import the base Command class for Artisan commands.
use App\Models\TrafficLog;    // Import the TrafficLog Eloquent model.

/**
 * ClearTrafficLogs
 *
 * This is a custom Laravel Artisan console command. Its purpose is to
 * clear all records from the `traffic_logs` database table. This can be useful
 * for data hygiene, resetting analytics, or managing database size.
 */
class ClearTrafficLogs extends Command
{
    /**
     * The name and signature of the console command.
     * This defines how the command is invoked from the command line.
     *
     * Example usage: `php artisan traffic:clear`
     *
     * @var string
     */
    protected $signature = 'traffic:clear';

    /**
     * The console command description.
     * This description is displayed when running `php artisan list` or `php artisan help traffic:clear`.
     *
     * @var string
     */
    protected $description = 'Clear all traffic log records from the database.';

    /**
     * Execute the console command.
     * This method contains the main logic that is run when the command is executed.
     *
     * @return int Returns a Command::SUCCESS or Command::FAILURE constant.
     */
    public function handle(): int
    {
        // Ask for user confirmation before proceeding with the deletion.
        // This is a safety measure to prevent accidental data loss.
        if ($this->confirm('Are you sure you want to delete ALL traffic logs? This action cannot be undone.')) {
            // If the user confirms, truncate the `traffic_logs` table.
            // `truncate()` is a very efficient way to remove all rows from a table,
            // effectively resetting it (and often resetting auto-increment IDs).
            TrafficLog::truncate();

            // Display a success message to the console.
            $this->info('✅ All traffic logs have been cleared successfully.');
        } else {
            // If the user cancels the operation, display a warning message.
            $this->warn('❌ Action cancelled.');
        }

        // Return a success status, indicating the command completed its execution (whether confirmed or cancelled).
        return Command::SUCCESS;
    }
}
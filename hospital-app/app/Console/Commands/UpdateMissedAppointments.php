<?php

namespace App\Console\Commands;

use App\Models\Appointment;
use Illuminate\Console\Command;

class UpdateMissedAppointments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'appointments:update-missed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update status of appointments that were missed by patients';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = now();

        // Find confirmed appointments where end_time has passed by at least 1 hour
        // and status is still 'confirmed' (meaning not 'completed' or 'cancelled')

        $missedCount = Appointment::where('status', 'confirmed')
            ->where(function ($query) use ($now) {
                // Past dates
                $query->where('appointment_date', '<', $now->toDateString())
                      ->orWhere(function ($q) use ($now) {
                          // Today, but time has passed by 1 hour
                          $q->where('appointment_date', $now->toDateString())
                            ->where('end_time', '<', $now->subHour()->toTimeString());
                      });
            })
            ->update(['status' => 'missed']);

        $this->info("Updated {$missedCount} appointments to 'missed' status.");
    }
}

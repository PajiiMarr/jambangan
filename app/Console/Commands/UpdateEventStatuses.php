<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Events;
use Illuminate\Support\Facades\Log;

class UpdateEventStatuses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'events:update-event-statuses';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update event statuses based on their dates';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Cron job is running!');
        $this->info('Running event status update...');  // Log a message when the task runs
        
        $today = now()->format('Y-m-d');
        $events = Events::all();
        Log::info('Scheduled command is running!', ['today' => $today]);


        foreach ($events as $event) {
            $status = $this->getEventStatus($event->start_date, $event->end_date, $today);

            if ($event->status !== $status) {
                $event->status = $status;
                $event->save();
            }
        }

        $this->info('Event statuses updated.');
    }


    public function getEventStatus($startDate, $endDate, $today)
    {
        if ($today < $startDate) {
            return 'Upcoming';
        } elseif ($today >= $startDate && $today <= $endDate) {
            return 'Ongoing';
        } else {
            return 'Completed';
        }
    }
}

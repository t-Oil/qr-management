<?php

namespace App\Listeners;

use App\Models\Task;
use Dompdf\Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class HardDeleteHistoryTask
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        try {
            $date = now()->subDays(config('project.sub_days'))->format('Y-m-d');

            Task::query()->where('task_date', '<=', $date)->forceDelete();

            \Log::info(`Delete Tasks before {$date} successful`);
        } catch (Exception $e) {
            \Log::error($e->getMessage());
        }
    }
}

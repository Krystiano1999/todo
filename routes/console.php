<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

use Illuminate\Console\Scheduling\Schedule;
use App\Jobs\SendTaskReminderJob;
use App\Models\Task;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

app()->singleton(Schedule::class, function ($app) {
    return new Schedule;
});

app(Schedule::class)->call(function () {
    $tasks = Task::where('due_date', now()->addDay()->toDateString())
        ->where('status', '!=', 'done')
        ->with('user')
        ->get();

    foreach ($tasks as $task) {
        SendTaskReminderJob::dispatch($task);
    }
})->dailyAt('13:15');

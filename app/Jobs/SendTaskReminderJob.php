<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Mail\TaskReminderMail;
use App\Models\Task;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendTaskReminderJob implements ShouldQueue
{
    use Queueable, SerializesModels, Dispatchable, InteractsWithQueue;

    public Task $task;

    /**
     * Create a new job instance.
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Execute the job.
     * 
     * @return void
     */
    public function handle(): void
    {
        \Log::info('MAIL_FROM_ADDRESS: ' . config('mail.from.address'));
        \Log::info('MAIL_FROM_NAME: ' . config('mail.from.name'));
        
        $mail = new TaskReminderMail($this->task);
    
        \Log::info('Mail Envelope:', [
            'from' => $mail->envelope()->from,
            'subject' => $mail->envelope()->subject,
        ]);
    
        Mail::to($this->task->user->email)->send($mail);
    }
}

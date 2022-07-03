<?php

namespace FatemeMahmoodi\LaravelToDo\Mail;

use FatemeMahmoodi\LaravelToDo\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendEmailTaskStatusUpdated extends Mailable
{
    use Queueable, SerializesModels;

    private $task;

    /**
     * @param Task $task
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.sendmail')
            ->subject(config('app.name') . ':task status update info')
            ->with('content', $this->task);
    }
}

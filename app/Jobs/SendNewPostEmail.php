<?php

namespace App\Jobs;

use App\Mail\NewPostEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNewPostEmail implements ShouldQueue
{
    use Queueable;
    public $incoming;
    public $tries=3;
    public $backoff = 30;
    /**
     * Create a new job instance.
     */
    public function __construct($incoming)
    {
        $this->incoming = $incoming;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        
        Mail::to($this->incoming['sendTo'])
            ->send(new NewPostEmail([
                'name'=> $this->incoming['name'], 
                'title'=> $this->incoming['title']]));
    }
}

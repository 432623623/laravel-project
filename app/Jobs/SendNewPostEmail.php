<?php

namespace App\Jobs;

use App\Mail\NewPostEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendNewPostEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;    
    
    public array $incoming;

    public $tries=3;
    public $backoff = 30;
    /**
     * Create a new job instance.
     */
    public function __construct(array $incoming)
    {
        $this->incoming = $incoming;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {        
        Mail::to($this->incoming['sendTo'])
            ->send(new NewPostEmail($this->incoming));
    }
}

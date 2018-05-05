<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Mail;
use App\Mail\verificationMail;
class verificationJob implements ShouldQueue
{
    public $userdata;
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($userdata)
    {
        $this->userdata = $userdata;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
      $to_email = $this->userdata->email;
      Mail::to($to_email)->send(new verificationMail($this->userdata));
    }
}

<?php

namespace App\Jobs;

use AlibabaCloud\SDK\Dysmsapi\V20170525\Models\AddShortUrlResponseBody\data;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TestJobs implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->queue = 'testjobs';
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     *
     * php artisan queue:work --sleep=3 --tries=2 --timeout=600 --daemon 或者
     * php artisan queue:work --queue=testjobs --sleep=3 --tries=2 --timeout=600 --daemon
     */
    public function handle()
    {
        print_r($this->data);
    }
}

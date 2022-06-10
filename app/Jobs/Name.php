<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use SebastianBergmann\CodeCoverage\Report\PHP;

class Name implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $name;

    /**
     * Create a new job instance.
     *
     * @param $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * Execute the job.
     *
     * @return void
     *
     * php artisan queue:work --sleep=3 --tries=2 --timeout=600 --daemon
     *
     * .env 配置 QUEUE_CONNECTION=redis
     */
    public function handle()
    {
        echo 'Name is ' . $this->name;
    }
}

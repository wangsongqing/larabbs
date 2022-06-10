<?php


namespace App\Console\Commands;


use App\Jobs\Name;
use App\Jobs\TestJobs;
use App\Models\User;
use Darabonba\GatewaySpi\Models\InterceptorContext\request;
use Illuminate\Console\Command;

class ChangeName extends Command
{
    // 供我们调用命令
    protected $signature = 'larabbs:change-name';

    // 命令的描述
    protected $description = '测试';

    // 最终执行的方法
    public function handle(User $user)
    {
        dispatch((new Name('wsq')));
        dispatch(new TestJobs(['age'=>20,'addr'=>'beijing']));
        TestJobs::dispatch(['age'=>88,'addr'=>'chengdu']);
    }
}

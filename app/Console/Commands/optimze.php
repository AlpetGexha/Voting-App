<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class optimze extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'optimize:all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->call('optimize:clear');
        $this->call('route:clear');
        $this->call('config:clear');
        $this->call('view:clear');
        $this->call('cache:clear');
        $this->call('settings:clear-cache');
        $this->call('schedule:clear-cache');
        $this->call('queue:flush');
        $this->call('queue:clear');
        $this->call('icons:clear');
        $this->call('geoip:clear');
        $this->call('event:clear');
        $this->call('debugbar:clear');
        $this->call('permission:cache-reset');
        // $this->call('ban:delete-expired');
        return Command::SUCCESS;
    }
}

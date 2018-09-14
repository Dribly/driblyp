<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Tap;

class CheckOverrunningTaps extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'overrun:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to validate no tap appears to be overrunning';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
//        $tap = Tap::where()->
    }
}

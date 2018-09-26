<?php

namespace App\Console\Commands;

use Faker\Provider\DateTime;
use Illuminate\Console\Command;
use App\Tap;

class CheckOverrunningTaps extends Command {
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
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        $targetTime = new DateTime('now');
        $targetTime->sub(new DateInterval('P2h'));
//        $twoHoursAgo = date_sub(new \DateTime('now'), '');
        $taps = Tap::where('reported_state', 'on')->whereDate('last_on', '>=',$targetTime->format('Y-m-d H:i:s'));
        foreach ($taps as $naughtyTap)
        {
            $naughtyTap->turnTap('off');
        }
    }
}

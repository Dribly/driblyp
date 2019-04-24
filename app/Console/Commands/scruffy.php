<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Library\Services\WeatherService;
class scruffy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'go:scruffy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $weather = new WeatherService();
        var_dump($weather->getPrecipitationForecast(55.444,-0.33333 ));

        //
    }
}

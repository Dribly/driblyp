<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ListenMqtt extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mqtt:listen';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Listens to MQTT and carries on';



    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(\App\Library\Services\CloudMQTT $client)
    {
        $client->readMessage('#');//
    }
}

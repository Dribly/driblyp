<?php

namespace App\Console\Commands;

use App\Library\Services\CloudMQTT;
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
        $tapReply = rtrim($client->makeFeedName(CloudMQTT::FEED_TAPREPLY, '#'), '/');
        $tapIdentify = rtrim($client->makeFeedName(CloudMQTT::FEED_TAPIDENTIFY, '#'), '/');
        $sensorReading = rtrim($client->makeFeedName(CloudMQTT::FEED_WATERSENSOR, '#'), '/');
        $sensorIdentify = rtrim($client->makeFeedName(CloudMQTT::FEED_WATERSENSORIDENTIFY, '#'), '/');
        $feeds = [$tapReply, $tapIdentify, $sensorReading, $sensorIdentify];
        vaR_dump($feeds);
        $client->readMessage($feeds);//
    }
}

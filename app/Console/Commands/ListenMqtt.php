<?php

namespace App\Console\Commands;

use App\Library\Services\CloudMQTT;
use Illuminate\Console\Command;

class ListenMqtt extends Command {
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
    public function handle(\App\Library\Services\CloudMQTT $client) {
        $abandoned = false;
        $interval = 5;
        $maxInterval = 120;
        $backoffAmount = 1.1;

        $tapReply = rtrim($client->makeFeedName(CloudMQTT::FEED_TAPREPLY, '#'), '/');
        $tapIdentify = rtrim($client->makeFeedName(CloudMQTT::FEED_TAPIDENTIFY, '#'), '/');
        $sensorReading = rtrim($client->makeFeedName(CloudMQTT::FEED_WATERSENSOR, '#'), '/');
        $sensorIdentify = rtrim($client->makeFeedName(CloudMQTT::FEED_WATERSENSORIDENTIFY, '#'), '/');
        $feeds = [$tapReply, $tapIdentify, $sensorReading, $sensorIdentify];
        vaR_dump($feeds);
        while (!$abandoned) {
            try {
                $client->readMessage($feeds);
                // reset backoff
                $interval = 5;
            } catch (\ErrorException $e) {
                if ($interval <= ($maxInterval)) {
                    echo "Could not connect, sleeping for " . floor($interval) . " at " . date('H:i:s') . "\n";
                    sleep(floor($interval));
                    $interval *= $backoffAmount;
//                    $backoffAmount = max(5, $backoffAmount /  1.0005);
                } else {
                    // Causes failure
                    $abandoned = true;
                }
//                var_dump($e);
            } catch (\Exception $e) {

                var_dump([$e->getMessage(), get_class($e)]);
            }
        }
    }
}

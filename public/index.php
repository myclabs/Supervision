<?php

use Guzzle\Http\Client;
use Guzzle\Http\Exception\BadResponseException;
use Silex\Application;
use Silex\Provider\TwigServiceProvider;
use Supervision\GearmanMonitor;

require_once __DIR__ . '/../vendor/autoload.php';

$app = new Application();
$app['debug'] = true;
$app->register(new TwigServiceProvider(), ['twig.path' => __DIR__ . '/../views']);

// Home
$app->get(
    '/',
    function (Application $app) {

        // Versions
        $devSlots = [
            'inventory1',
            'inventory2',
            'inventory3',
        ];
        $testSlots = [
            'inventory1',
            'inventory2',
        ];
        $prodSlots = [
        ];
        $versions = [];
        foreach ($devSlots as $slot) {
            $client = new Client('http://supervision:superpasswordenclair@dev.myc-sense.com/');
            try {
                $response = $client->get('/' . $slot . '/version.php')->send();
                $body = $response->getBody(true);
                if ($response->getStatusCode() == 200 && strpos($body, '<!DOCTYPE html>') === false) {
                    $version = $body;
                } else {
                    $version = 'unknown';
                }
            } catch (BadResponseException $e) {
                $version = 'unknown (' . $e->getMessage() . ')';
            }
            $versions['dev'][$slot] = $version;
        }
        foreach ($testSlots as $slot) {
            $client = new Client('http://test.myc-sense.com/');
            try {
                $response = $client->get('/' . $slot . '/version.php')->send();
                $body = $response->getBody(true);
                if ($response->getStatusCode() == 200 && strpos($body, '<!DOCTYPE html>') === false) {
                    $version = $body;
                } else {
                    $version = 'unknown';
                }
            } catch (BadResponseException $e) {
                $version = 'unknown (' . $e->getMessage() . ')';
            }
            $versions['test'][$slot] = $version;
        }
        foreach ($prodSlots as $slot) {
            $client = new Client('http://prod.myc-sense.com/');
            try {
                $response = $client->get('/' . $slot . '/version.php')->send();
                $body = $response->getBody(true);
                if ($response->getStatusCode() == 200 && strpos($body, '<!DOCTYPE html>') === false) {
                    $version = $body;
                } else {
                    $version = 'unknown';
                }
            } catch (BadResponseException $e) {
                $version = 'unknown (' . $e->getMessage() . ')';
            }
            $versions['prod'][$slot] = $version;
        }

        // Gearman monitoring
        try {
            $monitor = new GearmanMonitor();

            $response = $monitor->cmd('status');
            $tasks = GearmanMonitor::getResponseAsString($response, 'status');

            $response = $monitor->cmd('workers');
            $workers = GearmanMonitor::getResponseAsString($response, 'workers');
        } catch (Exception $e) {
            $monitor = null;
            $tasks = '';
            $workers = '';
        }

        return $app['twig']->render(
            'home.twig',
            [
                'monitor'  => $monitor,
                'tasks'    => $tasks,
                'workers'  => $workers,
                'versions' => $versions,
            ]
        );
    }
);

$app->run();

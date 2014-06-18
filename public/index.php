<?php

use Guzzle\Http\Client;
use Guzzle\Http\Exception\BadResponseException;
use Silex\Application;
use Silex\Provider\TwigServiceProvider;

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
            'inventory4',
        ];
        $testSlots = [
            'inventory1',
            'inventory2',
            'inventory3',
        ];
        $prodSlots = [
            'demo1',
            'demo2',
            'demo3',
            'demo4',
            'demo5',
        ];
        $versions = [];
        foreach ($devSlots as $slot) {
            $client = new Client('http://dev.myc-sense.com/');
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

        // Inventory en prod
        $client = new Client('http://app.myc-sense.com/');
        try {
            $response = $client->get('/version.php')->send();
            $body = $response->getBody(true);
            if ($response->getStatusCode() == 200 && strpos($body, '<!DOCTYPE html>') === false) {
                $version = $body;
            } else {
                $version = 'unknown';
            }
        } catch (BadResponseException $e) {
            $version = 'unknown (' . $e->getMessage() . ')';
        }
        $inventoryVersion = $version;

        return $app['twig']->render('home.twig', [
            'versions' => $versions,
            'inventoryVersion' => $inventoryVersion,
        ]);
    }
);

$app->run();

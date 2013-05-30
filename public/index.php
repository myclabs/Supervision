<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Silex\Application;
use Silex\Provider\TwigServiceProvider;
use Supervision\GearmanMonitor;

$app = new Application();
$app->register(new TwigServiceProvider(), ['twig.path' => __DIR__ . '/../views']);

// Home
$app->get('/', function (Application $app) {

    // Gearman monitoring
    try {
        $monitor = new GearmanMonitor();

        $response = $monitor->cmd('status');
        $tasks = Default_Model_GearmanMonitor::getResponseAsString($response, 'status');

        $response = $monitor->cmd('workers');
        $workers = Default_Model_GearmanMonitor::getResponseAsString($response, 'workers');
    } catch (Exception $e) {
        $monitor = null;
        $tasks = '';
        $workers = '';
    }

    return $app['twig']->render(
        'home.twig',
        [
            'monitor' => $monitor,
            'tasks'   => $tasks,
            'workers' => $workers,
        ]
    );
});

$app->run();

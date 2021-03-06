<?php

declare(strict_types=1);

use Davidwyly\Pronto\Http\Request;
use Davidwyly\Pronto\Http\Controller;
use Davidwyly\Pronto\Http\Router;

require_once(__DIR__ . '/../config/bootstrap.php');

try {
    $router = new Router(new Request());

    /**
     * Define routes paired with controller callbacks here
     */
    $router->get('/fibonacci', function (Request $request) {
        (new Controller\TestController($request))->fibonacci();
    });

    $router->post('/custom', function (Request $request) {
        (new Controller\TestController($request))->custom();
    });

} catch (Exception $e) {
    http_response_code($e->getCode());
    die(json_encode(['error' => $e->getMessage()], JSON_PRETTY_PRINT));
}
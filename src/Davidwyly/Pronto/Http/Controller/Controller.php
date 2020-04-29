<?php

declare(strict_types=1);

namespace Davidwyly\Pronto\Http\Controller;

use Davidwyly\Pronto\Http\Request;
use Exception;

abstract class Controller
{
    const HTTP_SUCCESS               = 200;
    const HTTP_CREATED               = 201;
    const HTTP_CLIENT_ERROR          = 400;
    const HTTP_NOT_FOUND             = 404;
    const HTTP_METHOD_NOT_ALLOWED    = 405;
    const HTTP_UNACCEPTED_MEDIA_TYPE = 415;
    const HTTP_SERVER_ERROR          = 500;

    /**
     * @var Request
     */
    public Request $request;

    /**
     * Controller constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param     $data
     * @param int $http_response_code
     */
    protected function renderSuccess($data, $http_response_code = self::HTTP_SUCCESS): void
    {
        http_response_code($http_response_code);
        die(json_encode($data, JSON_PRETTY_PRINT));
    }

    /**
     * @param Exception $e
     */
    protected function renderFail(Exception $e): void
    {
        http_response_code($e->getCode());
        die(json_encode(['error' => $e->getMessage()], JSON_PRETTY_PRINT));
    }
}
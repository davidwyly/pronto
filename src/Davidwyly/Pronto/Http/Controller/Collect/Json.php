<?php

declare(strict_types=1);

namespace Davidwyly\Pronto\Http\Controller\Collect;

use Davidwyly\Pronto\Exception\ControllerException;
use stdClass;

trait Json
{
    /**
     * @return stdClass
     * @throws ControllerException
     */
    protected function collectJson(): stdClass
    {
        if (empty($this->request->post['json'])) {
            throw new ControllerException("Empty JSON in request", self::HTTP_CLIENT_ERROR);
        }
        return $this->request->post['json'];
    }
}
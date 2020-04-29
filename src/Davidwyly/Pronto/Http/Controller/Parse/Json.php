<?php

declare(strict_types=1);

namespace Davidwyly\Pronto\Http\Controller\Parse;

use stdClass;

interface Json
{
    public function parseJson(stdClass $data): array;
}
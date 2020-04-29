<?php

declare(strict_types=1);

namespace Davidwyly\Pronto\Http\Controller\Parse;

use SimpleXMLElement;

interface Xml
{
    public function parseXml(SimpleXMLElement $data): array;
}
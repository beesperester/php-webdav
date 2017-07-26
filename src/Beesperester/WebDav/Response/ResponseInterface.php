<?php

namespace Beesperester\WebDav\Response;

interface ResponseInterface
{
    public function __construct($content = '', $status = 200, $headers = array());
}

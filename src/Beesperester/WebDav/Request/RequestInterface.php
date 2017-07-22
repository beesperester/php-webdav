<?php

namespace Beesperester\WebDav\Request;

interface RequestInterface
{
    /**
     * Handle the request and return xml
     *
     * @return SimpleXMLElement
     */
    public function handle();
}
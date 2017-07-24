<?php

namespace Beesperester\WebDav\Request;

interface RequestInterface
{
    /**
     * Handle the request and return response
     *
     * @return SimpleXMLElement
     */
    public function handle();
}
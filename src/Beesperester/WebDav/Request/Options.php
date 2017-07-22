<?php

namespace Beesperester\WebDav\Request;

// WebDav
use Request;

// SimpleXML
use \SimpleXMLElement;

class Options extends Request
{
    /**
     * Handle the request and return xml
     *
     * @return SimpleXMLElement
     */
    public function handle()
    {
        return new SimpleXMLElement('<foo/>');
    }
}
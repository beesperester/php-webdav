<?php

namespace Beesperester\WebDav\Request;

// WebDav
use Request;

// SimpleXML
use \SimpleXMLElement;

// Illuminate
use Illuminate\Http\Response as IlluminateResponse;

class Options extends Request
{
    /**
     * Handle the request and return xml
     *
     * @return Illuminate\Http\Response
     */
    public function handle()
    {
        return Response::create('foo');
    }
}

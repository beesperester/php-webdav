<?php

namespace Beesperester\WebDav\Request;

// WebDav
use Beesperester\WebDav\Request\Request;

// SimpleXML
use \SimpleXMLElement;

// Illuminate
use Illuminate\Http\Response as IlluminateResponse;

class Options extends Request
{
    public static $methods = [
        'COPY',
        'DELETE',
        'GET',
        'HEAD',
        'MKCOL',
        'MOVE',
        'OPTIONS',
        'POST',
        'PROPFIND',
        'PROPPATCH',
        'PUT'
    ];

    /**
     * Handle the request and return response
     *
     * @return Illuminate\Http\Response
     */
    public function handle()
    {
        return IlluminateResponse::create(Null, 200)
            ->header('Allows', strtoupper(implode(' ', static::$methods)))
            ->header('DAV', 1);
    }
}

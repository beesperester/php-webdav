<?php

namespace Beesperester\WebDav\Request;

// WebDav
use Beesperester\WebDav\Request\Request;

// SimpleXML
use \SimpleXMLElement;

// Illuminate
use Illuminate\Http\Response as IlluminateResponse;

class Get extends Request
{
    /**
     * Handle the request and return response
     *
     * @return Illuminate\Http\Response
     */
    public function handle()
    {
        return IlluminateResponse::create(Null, 200)
            ->header('DAV', 1);
    }
}

<?php

namespace Beesperester\WebDav;

// Illuminate
use Illuminate\Http\Request;
use Illuminate\Http\Response;

// WebDav
use Request\Options;

class WebDav
{
    /**
     * Handle request by WebDav client and return appropriate response
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\Response
     */
    public static function handleRequest(Request $request)
    {
        switch (strtolower($request->method())) {
            case 'options':
                return Options::create($request->path(), $request->getContent())->handle();
        }
    }
}

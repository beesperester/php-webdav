<?php

namespace Beesperester\WebDav;

// Illuminate
use Illuminate\Http\Request;
#use Illuminate\Http\Response;

// Collection
use Beesperester\WebDav\FS\Collection;

// Request
use Beesperester\WebDav\Request\Get;
use Beesperester\WebDav\Request\Options;
use Beesperester\WebDav\Request\Propfind;

// Response
#use Beesperester\WebDav\Response\Collection;

// Exception
use Beesperester\WebDav\Exception\InvalidMethodException;

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
            case 'get':
                return Get::create($request->path(), $request->getContent());
                
            case 'options':
                return Options::create($request->path(), $request->getContent());

            case 'propfind':
                return Propfind::create($request->path(), $request->getContent());
        }

        throw new InvalidMethodException();
    }

    /**
     * Handle propfind request and return response
     *
     * @return Illuminate\Http\Response
     */
    public static function propfind($callback)
    {
        $request = Request::createFromGlobals();

        return $callback($request->path());
    }

    public static function createCollection(array $data)
    {
        return Collection::fromData($data);
    }
}

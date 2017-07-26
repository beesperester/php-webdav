<?php

namespace Beesperester\WebDav\Response;

// Illumiante
use Illuminate\Http\Response as IlluminateResponse;
use Illuminate\Http\Request as IlluminateRequest;

abstract class Response extends IlluminateResponse implements ResponseInterface
{
    /**
     * @var SimpleXMLElement $xml
     */
    public $xml;

    /**
     * Create new response from request
     *
     * @param Illuminate\Http\Request
     *
     * @return Response
     */
    public static function fromRequest(Request $request)
    {
        $xml = simplexml_load_string($request->getContent());

        $response = new static();

        $response->xml = $xml;

        return $response;
    }
}

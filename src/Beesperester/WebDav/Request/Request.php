<?php

namespace Beesperester\WebDav\Request;

// SimpleXML
use \SimpleXMLElement;

abstract class Request implements RequestInterface
{
    /**
     * The request path
     *
     * @var string $request_path
     */
    public $request_path;

    /**
     * The request body
     *
     * @var string $request_body
     */
    public $request_body;

    /**
     * Construct new request from request path and request body
     *
     * @param string $request_path
     * @param string $request_body
     */
    public function __construct($request_path = '/', $request_body = '')
    {
        $this->request_body = $request_body;
        $this->request_path = $request_path;
    }

    /**
     * Handle the request and return xml
     *
     * @return SimpleXMLElement
     */
    abstract public function handle();
}
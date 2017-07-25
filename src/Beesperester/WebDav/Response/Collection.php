<?php

namespace Beesperester\WebDav\Response;

// Illuminate
use Illuminate\Http\Request;
use Illuminate\Http\Response as IlluminateResponse;

use Beesperester\WebDav\Response\Response;

class Collection extends Response
{
    public function __construct($path = '/', array $data = [])
    {
        $this->path = $path;
        $this->collection = $data;
    }

    public static function fromData($path = '/', array $data = [])
    {
        return new static($path, $data);
    }

    public function handle()
    {
        $xml = new \SimpleXMLElement('<multistatus/>');

        $xml->addAttribute('xmlns', 'DAV:');

        $response = $xml->addChild('response');

        $href = $response->addChild('href', $this->path);

        // known
        $propstat = $response->addChild('propstat');

        $prop = $propstat->addChild('prop');

        $prop->addChild('displayname', $this->path);

        $prop->addChild('resourcetype')->addChild('collection');

        $content = simplexml_format($xml);

        return IlluminateResponse::create($content, 207)
            ->header('DAV', 1);
    }
}

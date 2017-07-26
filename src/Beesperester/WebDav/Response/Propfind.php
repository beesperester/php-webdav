<?php

namespace Beesperester\WebDav\Response;

// WebDav
use Beesperester\WebDav\FS\Collection;

class Propfind extends Response
{
    /*public function __construct($content = '', $status = 200, $headers = array())
    {
        parent::__construct($content, $status, $headers);
    }*/

    public static function fromCollection(Collection $collection = null)
    {
        $xml = new \SimpleXMLElement('<multistatus/>');

        $xml->addAttribute('xmlns', 'DAV:');

        if ($collection) {
            simplexml_append($xml, $collection->toXml());

            if ($collection->children) {
                foreach ($collection->children as $resource) {
                    simplexml_append($xml, $resource->toXml());
                }
            }
        }

        $content = simplexml_format($xml);

        $status = 207;

        $headers = [
            'DAV' => 1,
        ];

        return new static($content, $status, $headers);
    }
}

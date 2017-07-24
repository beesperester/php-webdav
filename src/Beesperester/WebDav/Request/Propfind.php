<?php

namespace Beesperester\WebDav\Request;

// WebDav
use Beesperester\WebDav\Request\Request;

// SimpleXML
use \SimpleXMLElement;

// Illuminate
use Illuminate\Http\Response as IlluminateResponse;

class Propfind extends Request
{
    protected $collection = [
        [
            'displayname' => 'some_dir',
            'href' => '/some_dir',
            'collection' => []
        ],
        [
            'displayname' => 'some_other_dir',
            'href' => '/some_other_dir',
            'collection' => [
                [
                    'displayname' => 'some_sub_dir',
                    'href' => '/some_other_dir/some_sub_dir'
                ]
            ]
        ]
    ];

    /**
     * Handle the request and return response
     *
     * @return Illuminate\Http\Response
     */
    public function handle()
    {
        $xml = new \SimpleXMLElement('<multistatus/>');

        $xml->addAttribute('xmlns', 'DAV:');

        $response = $xml->addChild('response');

        $href = $response->addChild('href', '/');

        // known
        $propstat = $response->addChild('propstat');

        $prop = $propstat->addChild('prop');

        $prop->addChild('displayname', 'root');

        $prop->addChild('resourcetype')->addChild('collection');

        foreach ($this->collection as $collection) {
            $response = $xml->addChild('response');

            $href = $response->addChild('href', $collection['href']);

            // known
            $propstat = $response->addChild('propstat');

            $prop = $propstat->addChild('prop');

            $prop->addChild('displayname', $collection['displayname']);

            $prop->addChild('resourcetype')->addChild('collection');
        }        

        $content = simplexml_format($xml);

        return IlluminateResponse::create($content, 207)
            ->header('DAV', 1);
    }
}

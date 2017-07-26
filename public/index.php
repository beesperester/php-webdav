<?php

// configure error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// require dependencies
require_once __DIR__.'/../vendor/autoload.php';

// Carbon
use Carbon\Carbon;

// Illuminate
use Illuminate\Http\Request;

// WebDav
use Beesperester\WebDav\WebDav;
use Beesperester\WebDav\Response\Propfind;
use Beesperester\WebDav\FS\Collection;
use Beesperester\WebDav\Exception\InvalidMethodException;

// basic server logic
$request = Request::createFromGlobals();

$path = $request->path();

$url = 'http://ubuntu.local';

$virtual_fs = WebDav::createCollection([
    'displayname' => 'root',
    'root' => true,
    'base_url' => $url,
    'creationdate' => Carbon::now(),
    'getlastmodified' => Carbon::now(),
    'children' => [
        WebDav::createCollection([
            'displayname' => 'foo',
            'base_url' => $url,
            'creationdate' => Carbon::now(),
            'getlastmodified' => Carbon::now(),
            'children' => [
                WebDav::createCollection([
                    'displayname' => 'bar',
                    'base_url' => $url.'/foo',
                    'creationdate' => Carbon::now(),
                    'getlastmodified' => Carbon::now(),
                ]),
            ],
        ]),
        WebDav::createFile([
            'displayname' => 'foo.txt',
            'base_url' => $url,
            'creationdate' => Carbon::now(),
            'getlastmodified' => Carbon::now(),
            'getcontenttype' => 'text/plain',
            'getcontentlength' => 123456,
        ]),
    ],
]);

function flatten(Collection $collection)
{
    $flat_collection = [$collection->getUri() => $collection];

    foreach ($collection->children as $resource) {
        if ($resource instanceof Collection) {
            $flat_collection = array_merge($flat_collection, flatten($resource));
        } else {
            $flat_collection[$resource->getUri()] = $resource;
        }
    }

    return $flat_collection;
}

$flat_fs = flatten($virtual_fs);

//echo '<pre>'; print_r($flat_fs); die();

//echo '<pre>'; print_r(array_keys($flat_fs)); die();

/*if (in_array($request->fullUrl(), array_keys($flat_fs)))
{
    $propfind = Propfind::fromCollection($flat_fs[$request->fullUrl()]);

    $propfind->send();
}*/

WebDav::handleRequest($request, function ($request) {
    switch (strtolower($request->method())) {
        case 'get':
            return;
        case 'options':
            return;
        case 'propfind':
            return Propfind::fromRequest($request);
    }

    throw new InvalidMethodException();
});

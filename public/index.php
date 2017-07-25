<?php

// configure error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// require dependencies
require_once __DIR__.'/../vendor/autoload.php';

// Illuminate
use Illuminate\Http\Request;

// WebDav
use Beesperester\WebDav\WebDav;
use Beesperester\WebDav\Response\Collection;

// basic server logic
$request = Request::createFromGlobals();

/*$tree = [
    WebDav::createCollection([
        'displayname' => 'some_dir',
        'root' => '/'
    ]),
    WebDav::createCollection([
        'displayname' => 'some_other_dir',
        'root' => '/',
        'children' => [
            WebDav::createCollection([
                'displayname' => 'some_sub_dir',
                'root' => '/some_other_dir/'
            ])
        ]
    ])
];*/

//$webdav = WebDav::handleRequest($request);

//$webdav->handle()->send();

$response = WebDav::propfind(function ($path) {
    switch($path) {
        case 'foo':
            $data = [
                WebDav::createCollection([
                    'displayname' => 'bar',
                    'root' => '/foo',
                ])
            ];
            break;
        default:
            $data = [
                WebDav::createCollection([
                    'displayname' => 'foo',
                    'root' => '/',
                ])
            ]; 
    }

    return Collection::fromData($path, $data);
});

$response->handle()->send();

#$response->send();
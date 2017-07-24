<?php

// configure error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// require dependencies
require_once __DIR__ . '/../vendor/autoload.php';

// Illuminate
use Illuminate\Http\Request;

// WebDav
use Beesperester\WebDav\WebDav;

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

WebDav::handleRequest($request))->send();

#$webdav->send();

#$webdav->handle()->send();

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

WebDav::handleRequest($request)->send();

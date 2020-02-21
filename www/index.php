<?php

namespace SimpleSAML\Module\sanitycheck;

use SimpleSAML\Configuration;
use SimpleSAML\Module\sanitycheck\Controller;
use SimpleSAML\Session;
use Symfony\Component\HttpFoundation\Request;

$config = Configuration::getInstance();
$session = Session::getSessionFromRequest();
$request = Request::createFromGlobals();

$controller = new Controller\SanityCheck($config, $session);
$output = $request->get('output');

$response = $controller->main($output);
$response->send();

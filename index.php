<?php

session_start();

$view = new stdClass();
$view->pageTitle = "Navin's Wordery";
require_once('Views/index.phtml');
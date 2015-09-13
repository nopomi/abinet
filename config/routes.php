<?php

  $routes->get('/', function() {
    HelloWorldController::index();
  });

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });

    $routes->get('/mydegrees', function() {
    HelloWorldController::mydegrees();
  });

    $routes->get('/degree', function() {
    HelloWorldController::degree();
  });

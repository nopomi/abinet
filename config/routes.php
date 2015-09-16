<?php

$routes->get('/', function() {
    HelloWorldController::index();
});

$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});

$routes->get('/home', function() {
    HelloWorldController::home();
});

$routes->get('/mydegrees', function() {
    HelloWorldController::mydegrees();
});

$routes->get('/degrees', function() {
    DegreeController::index();
});

$routes->get('/degrees/new', function(){
    DegreeController::create();
});

$routes->post('/degrees/new', function(){
    DegreeController::store();
});

$routes->get('/degree', function() {
    HelloWorldController::degree();
});

$routes->get('/degrees/edit/:id', function($id){
    DegreeController::modify($id);
});

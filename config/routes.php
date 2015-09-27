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

$routes->get('/login', function() {
UserController::login();
});

$routes->post('/login', function() {
UserController::handle_login();
});

$routes->get('/mydegrees', function() {
DegreeController::myDegrees();
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

$routes->get('/degree/:id/update', function($id){
DegreeController::edit($id);
});

$routes->post('/degree/:id/update', function($id){
DegreeController::update($id);
});

$routes->post('/degree/:id/delete', function($id){
DegreeController::delete($id);
});

$routes->post('/favorite/:id/delete', function($id){
FavoriteController::delete($id);
});

<?php
use Core\Response;

$router->get('', 'RestControllers::home');

$router->get('api/service-type', 'ServiceTypeControllers::readAll');
$router->get('api/service-type/:id', 'ServiceTypeControllers::read');
$router->post('api/service-type', 'ServiceTypeControllers::create');
$router->patch('api/service-type/:id', 'ServiceTypeControllers::update');
$router->delete('api/service-type/:id', 'ServiceTypeControllers::delete');

$router->get('api/service-provided', 'ServiceProvidedControllers::readAll');
$router->get('api/service-provided/:id', 'ServiceProvidedControllers::read');
$router->post('api/service-provided', 'ServiceProvidedControllers::create');
$router->patch('api/service-provided/:id', 'ServiceProvidedControllers::update');
$router->delete('api/service-provided/:id', 'ServiceProvidedControllers::delete');

$router->get('api/total-time-saved', 'TotalTimeSavedControllers::getSum');

?>
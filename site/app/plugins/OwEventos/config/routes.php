<?php

use Cake\Routing\Router;

Router::plugin('OwEventos', function ($routes) {
    $routes->fallbacks('InflectedRoute'); 
});

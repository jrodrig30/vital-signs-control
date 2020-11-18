<?php

use Cake\Routing\Router;

Router::plugin('OwCore', function ($routes) {
    $routes->fallbacks('InflectedRoute'); 
});

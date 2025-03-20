<?php 

return [
    'routeLoader' => [
        'class' => 'Tomazo\Router\RouteLoader\ControllerRouteLoader',
        'attr' => [
            'namespace' => 'App\Controller',
            'controllersPath' => __DIR__ . '/../../src/Controller'
        ]
    ] ,
   'routeResolver' => [
        'class' => 'Tomazo\Router\RouteResolver\SimpleRouteResolver',
        'attr' => []
    ] ,
];
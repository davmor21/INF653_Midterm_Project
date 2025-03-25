<?php
declare(strict_types = 1);
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
    exit();

    

    echo '<pre>';
    print_r(getenv('SITE_URL'));
    echo '<br>';
    print_r($_SERVER);
    echo '</pre>';
    
    phpinfo();   
}
    echo '<h1>INF653 Midterm Project - Davon Morris</h1>';


<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Author.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate author object
    $auth = new Author($db);

    // Get ID

    $auth->id = isset($_GET['id']) ? $_GET['id'] : die();

    $auth->read_single();

    if($auth->author){
        $auth_arr = array(
            'id' => $auth->id,
            'author' => $auth->author
        );
        print_r(json_encode($auth_arr));
    }

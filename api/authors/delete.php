<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Author.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate blog post object
    $auth = new Author($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    if (empty($data->author)) {
        echo json_encode(array('message' => 'Missing Required Parameters'));
        exit();
    }
    
?>
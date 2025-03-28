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

    if (!isset($data->id) || empty($data->id)) {
        echo json_encode(array('message' => 'author_id Not Found'));
        exit(); // Exit if the ID is missing
    }
    // Set property to delete
    $auth->id = $data->id;

    // Delete author
    if($auth->delete()){
        echo json_encode(
            array('id' => $auth->id)
        );   
    } else {
        echo json_encode(
            array('message' => 'Author Not Deleted')
        );
    }

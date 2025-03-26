<?php
    
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');
    
    include_once '../../config/Database.php';
    include_once '../../models/Author.php';
    
    // Connect to Database
    $database = new Database();
    $db = $database->connect();
    
    // Instantiate Author Object
    $author = new Author($db);
    
    // Get raw data
    $data = json_decode(file_get_contents("php://input"));
    
    if (!isset($data->author) || empty($data->author)) {
        echo json_encode(array("message" => "Missing Required Parameters"));
        exit();
    }
    
    // Set properties/ID to update
    $author->id = $data->id;
    $author->author = $data->author;
    
    // Update author
    if($author->update()){
        echo json_encode(
            array('message' => 'updated author', 'id' => $author->id, 'author' => $author)
        );   
    } else {
        echo json_encode(
            array('message' => 'Missing Required Parameters')
    );
    }

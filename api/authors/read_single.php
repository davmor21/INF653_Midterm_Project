<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Author.php';

    //Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    //Instantiate author object
    $author = new Author($db);

    //Get ID
    $author->id = isset($_GET['id']) ? $_GET['id'] : die(json_encode(["message" => "Missing ID parameter"]));

    //Calls read_single method
    $author->read_single();

    //Check if result contains data
    if ($author->author) {

        echo json_encode([$author]);
    } else {
        //If no record is found for ID
        echo json_encode(["message" => "author_id Not Found"]);
    }
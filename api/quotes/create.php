<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';
    include_once '../../models/Author.php';
    include_once '../../models/Category.php';

    // Connect to Database
    $database = new Database();
    $db = $database->connect();

    // Instantiate Objects
    $quote = new Quote($db);
    
    // Get raw data
    $data = json_decode(file_get_contents("php://input"));

    // Check for required parameters and make sure they are not empty
    if (!isset($data->quote) || !isset($data->author_id) || !isset($data->category_id) || 
        !strlen($data->quote) || !strlen($data->author_id) || !strlen($data->category_id)) {
        echo json_encode(
            array('message' => 'Missing Required Parameters')
        );
        exit(); 
    }
    $author = new Author($db);
    $category = new Category($db);

    //author_id check
    if (!$author->exists($data->author_id)) {
        echo json_encode(array("message" => "author_id Not Found"));
        exit();
    }

    //category_id check
        if (!$category->exists($data->category_id)) {
            echo json_encode(array("message" => "category_id Not Found"));
            exit();
    }
    $quote->quote = $data->quote;
    $quote->author_id = $data->author_id;
    $quote->category_id = $data->category_id;

    // Create quote
    if ($quote->create()) {
        echo json_encode(array('id' => $quote->id,  'quote' => $quote->quote, 'author_id' => $quote->author_id, 'category_id' => $quote->category_id));
    } else {
        echo json_encode(array('message' => 'Quote Not Created'));
    }


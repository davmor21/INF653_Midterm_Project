<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';

    // Connect to Database
    $database = new Database();
    $db = $database->connect();

    // Instantiate Quote Object
    $quote = new Quote($db);

    // Get raw data
    $data = json_decode(file_get_contents("php://input"));

    // Make sure parameters are there
    if (!isset($data->quote) || !isset($data->author_id) || !isset($data->category_id)) {
        echo json_encode(array("message" => "Missing Required Parameters"));
        exit();
    }
    
    $author_id = $data->author_id;
    $category_id = $data->category_id;
    $quote_text = $data->quote;
    $quote_id = $data->id;

    //Check if author exists
    if (!$author->exists($author_id)) {
        echo json_encode(array("message" => "author_id Not Found"));
        exit();
    }

    //Check if category exists
    if (!$category->exists($category_id)) {
        echo json_encode(array("message" => "category_id Not Found"));
        exit();
    }

    // Set properties/ID to update
    $quote->id = $data->id;
    $quote->quote = $data->quote;
    $quote->author_id = $data->author_id;
    $quote->category_id = $data->category_id;

    // Update quote

    if (!$quote->exists($quote->id)) {
        echo json_encode(array("message" => "No Quotes Found"));
        exit();
    }
    
    //Call update method
    if($quote->update()) {
        echo json_encode(
        array("id" => $quote->id,
              "quote" => $quote->quote,
              "author_id" => $quote->author_id,
              "category_id" => $quote->category_id));
    
    } else {
        echo json_encode(
            array("message" => "Update Failed"));
    
        }

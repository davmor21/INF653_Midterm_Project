<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';

    // Connect to Database
    $database = new Database();
    $db = $database->connect();

    // Instantiate Quote Object
    $quote = new Quote($db);

    // Get ID
    $quote->id = isset($_GET['id']) ? $_GET['id'] : die(json_encode(["message" => "Missing ID parameter"]));

    // Get quote
    $quote->read_single();

    // Check if author is set
    if ($quote->author) {

    // Create array
    $quote_arr = array (
        'id' => $quote->id,
        'quote' => $quote->quote,
        'author' => $quote->author,
        'category' => $quote->category    
    );

    // Convert to JSON
    print_r(json_encode($quote_arr));
    } else{
        print_r(json_encode(["message" => "No quotes found"]));
    }

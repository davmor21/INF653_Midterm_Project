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

    // Get author_id and/or category_id if provided
    $quote->author_id = isset($_GET['author_id']) ? $_GET['author_id'] : null;
    $quote->category_id = isset($_GET['category_id']) ? $_GET['category_id'] : null;

    // Quote Read Query
    $result = $quote->read();

    // Get Row Count
    $num = $result->rowCount();

    // See if any Quotes Exist
    if($num > 0) {
        // Quote array
        $quote_arr = array();
        $quote_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $quote_item = array(
                    'id' => $row['id'],
                    'quote' => $row['quote'],
                    'author' => $row['Author Name'],
                    'category' => $row['Category']    
                );

            // Push to "data"
            array_push($quote_arr['data'], $quote_item);
        } 
        // Turn to JSON and output
        echo json_encode($quote_arr);
    } else {
        echo json_encode(
            array('message' => 'No Quotes Found')
        );
    }

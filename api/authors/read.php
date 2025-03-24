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

    // Author query
    $result = $auth->read();
    // Get row count
    $num = $result->rowCount();

    // Check if any authors
    if($num > 0){
        // author array
        $authors_arr = array();
        $authors_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $author_item = array(
                'id' => $id,
                'author' => $author
            );

            // Push to "data"
            array_push($authors_arr['data'], $author_item);
        }

        // Turn to JSOB & output
        echo json_encode($authors_arr);
    } else{
        // No authors
        echo json_encode(
            array('message' => 'No authors Found')
        );
    }
?>
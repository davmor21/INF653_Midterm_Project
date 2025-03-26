<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    // Connect to Database
    $database = new Database();
    $db = $database->connect();

    // Instantiate Category Object
    $category = new Category($db);

    // Category Read Query
    $result = $category->read();

    // Get Row Count
    $num = $result->rowCount();

    // See if any Categories Exist
    if($num > 0) {
        // Category array
        $cat_arr = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $cat_item = array(
            'id' => $id,
            'category' => $category
        );

        array_push($cat_arr, $cat_item);
    } 

    // Turn to JSON and output
    echo json_encode($cat_arr);
    } else {
        echo json_encode(
            array('message' => 'No Categories Found.')
        );
    }

<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    // Connect to Database
    $database = new Database();
    $db = $database->connect();

    // Instantiate Category Object
    $category = new Category($db);

    // Get raw data
    $data = json_decode(file_get_contents("php://input"));

    if (!isset($data->category) || empty($data->category)) {
        echo json_encode(array("message" => "Missing Required Parameters"));
        exit();
    }

    // Set properties/ID to update
    $category->id = $data->id;
    $category->category = $data->category;

    // Update category

    if($category->update()){
        echo json_encode(
            array('id' => $category->id, 'category' => $category->category)
        );   
    } else {
        echo json_encode(
            array('message' => 'Category Not Updated')
    );
    }

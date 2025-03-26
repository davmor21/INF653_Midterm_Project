<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
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

// Check required parameters
if (empty($data->category)) {
    echo json_encode(array('message' => 'Missing Required Parameters'));
    exit();
}


$category->category = $data->category;

// Create category

if($category->create()){

    // Get new ID and category
    $new_category_id = $category->id;
    echo json_encode(
        array('id' => $new_category_id, 'category' => $category->category)
    );   
} else {
    echo json_encode(
        array('message' => 'Category Not Created')
    );
}


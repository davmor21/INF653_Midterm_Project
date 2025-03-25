<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    $method = $_SERVER['REQUEST_METHOD'];

    if ($method === 'OPTIONS') {
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
        header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
        exit();
    }

    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    // Connect to the database
    $database = new Database();
    $db = $database->connect();

    // Instantiate the Category Object
    $category = new Category($db);

    // Get ID
    $id = isset($_GET['id']) ? $_GET['id'] : null;

    // Handle files based on the request method
    switch ($method) {
        case 'GET':
            if ($id) {
                // Include the file to get a single category
                include_once 'read_single.php';
            } else {
                // Include the file to get all categories
                include_once 'read.php';
            }
            break;

        case 'POST':
            // Include the file to create a new category
            include_once 'create.php';
            break;

        case 'PUT':
            // Include the file to update an existing category
            include_once 'update.php';
            break;

        case 'DELETE':
            // Include the file to delete a category
            include_once 'delete.php';
            break;

            // Default message / invalid request
        default:
            echo json_encode(array('message' => 'Invalid Request Method'));
            break;
    }
?>
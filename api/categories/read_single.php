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

    // Get ID
    $category->id = isset($_GET['id']) ? $_GET['id'] : die();

    // Get category
    $category->read_single();

    // Check if category exists
    if ($category->category) {
        // Create category array if the category exists
        $cat_arr = [
            'id' => $category->id,
            'category' => $category->category
        ];

        // Convert to JSON
        echo json_encode($cat_arr);
    } else {
        // If no category found, print error message
        echo json_encode(['message' => 'category_id Not Found', 'id' => $category->id, 'category' => $category->category]);
    }

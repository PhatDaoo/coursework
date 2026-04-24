<?php
include_once 'includes/DatabaseConnection.php';
include_once 'includes/DatabaseFunctions.php';

//Secure admin
if (!$is_admin) {
    header('Location: index.php');
    exit();
}

if (isset($_POST['submit'])) {
    try {
        $film_name = trim($_POST['film_name']);
        $publish_date = $_POST['publish_date'];
        $imageName = null;

        // Poster upload 
        if (!empty($_FILES['film_image']['name']) && $_FILES['film_image']['error'] == UPLOAD_ERR_OK) {
            if (!is_dir('uploads')) mkdir('uploads', 0777, true);
            
            $imageName = time() . '_poster_' . basename($_FILES['film_image']['name']); 
            move_uploaded_file($_FILES['film_image']['tmp_name'], 'uploads/' . $imageName);
        }

        insertFilm($pdo, $film_name, $publish_date, $imageName);

        header('Location: admin.php?success=film_added');
        exit();

    } catch (PDOException $e) {
        $title = 'Error';
        $output = 'Error: ' . $e->getMessage();
    }
} else {
    $title = 'Add New Film';
    ob_start();
    include 'templates/addfilm.html.php';
    $output = ob_get_clean();
}

include 'templates/layout.html.php';
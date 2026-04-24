<?php
include_once 'includes/DatabaseConnection.php';
include_once 'includes/DatabaseFunctions.php';

if (!$is_admin) {
    header('Location: index.php');
    exit();
}

if (isset($_POST['submit'])) {
    try {
        $id = $_POST['id'];
        $film_name = trim($_POST['film_name']);
        $publish_date = $_POST['publish_date'];
        $imageName = $_POST['current_image'] ?? null;

        // Image
        if (!empty($_FILES['film_image']['name']) && $_FILES['film_image']['error'] == UPLOAD_ERR_OK) {
            if (!is_dir('uploads')) mkdir('uploads', 0777, true);
            $imageName = time() . '_poster_' . basename($_FILES['film_image']['name']); 
            move_uploaded_file($_FILES['film_image']['tmp_name'], 'uploads/' . $imageName);
        }

        // Update film
        query($pdo, 'UPDATE `film` SET `film_name` = :name, `publish_date` = :pdate, `image` = :image WHERE `id` = :id', [
            ':name' => $film_name,
            ':pdate' => $publish_date,
            ':image' => $imageName,
            ':id' => $id
        ]);

        header('Location: admin.php?success=film_updated');
        exit();
    } catch (PDOException $e) {
        $title = 'Error';
        $output = 'Error: ' . $e->getMessage();
    }
} else {
    if (!isset($_GET['id'])) {
        header('Location: admin.php');
        exit();
    }

    $film = query($pdo, 'SELECT * FROM `film` WHERE `id` = :id', [':id' => $_GET['id']])->fetch();
    
    if (!$film) {
        die("<h2 style='color:red; text-align:center;'>Error: Film not found!</h2>");
    }

    $title = 'Edit Film: ' . $film['film_name'];
    ob_start();
    include 'templates/editfilm.html.php';
    $output = ob_get_clean();
}
include 'templates/layout.html.php';
<?php
session_start();
global $DBH;
global $SITE_URL;
require_once __DIR__ . "/../config/config.php";
require_once __DIR__ . '/../db/dbConnect.php';

if (!isset($_SESSION['user'])) {
    header('Location: '. $SITE_URL . '/user.php');
    exit;
}

if (!empty($_POST['title']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
    $filename = $_FILES['file']['name'];
    $filesize = $_FILES['file']['size'];
    $filetype = $_FILES['file']['type'];
    $tmp_name = $_FILES['file']['tmp_name'];
    $destination = __DIR__ . '/../uploads/' . $filename;

    $title = $_POST['title'];
    $description = $_POST['description'];
    $user_id = $_SESSION['user']['user_id'];

    // vain kuvia ja videoita
    $allowed_types = array('image/jpeg', 'image/png', 'image/gif',
        'image/webp', 'video/mp4', 'video/webm', 'video/ogg', 'video/mov');
    if (!in_array($filetype, $allowed_types)) {
        exit('Invalid file type.');
    }

	// check file size
	$max_size = 1024 * 1024 * 8; // 8MB

	if ($filesize > $max_size) {
		echo "File too large";
		exit;
	}

	// double check that file does not contain php
	if ( str_contains( $filename, '.php' ) ) {
		echo "Invalid file name";
		exit;
	}


	if (move_uploaded_file($tmp_name, $destination)) {
        echo "File uploaded successfully";
    } else {
        echo "Error uploading file";
    }

    $sql = "INSERT INTO MediaItems (user_id, filename, filesize, media_type, title, description) VALUES (:user_id, :filename, :filesize, :media_type, :title, :description)";
    $data = [
        'user_id' => $user_id,
        'filename' => $filename,
        'filesize' => $filesize,
        'media_type' => $filetype,
        'title' => $title,
        'description' => $description
    ];
    try {
        $STH = $DBH->prepare($sql);
        $STH->execute($data);
        if ($STH->rowCount() > 0) {
            header('Location: ' . $SITE_URL);
            exit;
        }
    } catch (PDOException $error) {
        echo "Could not insert data to the database.";
        file_put_contents(__DIR__ . '/../logs/PDOErrors.txt', 'insertData.php - ' . $error->getMessage(), FILE_APPEND);
    }

} else {
    exit("No file uploaded"); // tai die()
}
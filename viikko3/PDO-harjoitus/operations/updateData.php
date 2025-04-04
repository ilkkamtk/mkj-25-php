<?php
session_start();
global $DBH;
global $SITE_URL;
require_once __DIR__ . "/../config/config.php";
require_once __DIR__ . '/../db/dbConnect.php';

if (!empty($_POST['media_id'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $media_id = $_POST['media_id'];

    $sql = "UPDATE MediaItems SET title = :title, description = :description 
            WHERE media_id = :media_id AND user_id = :user_id";

    $data = [
        'title' => $title,
        'description' => $description,
        'user_id' => $_SESSION['user']['user_id'],
        'media_id' => $media_id
    ];

    try {
        $STH = $DBH->prepare($sql);
        $STH->execute($data);
        // get update result
        if ($STH->rowCount() > 0) {
            header('Location: ' . $SITE_URL);
            exit;
        }


    } catch (PDOException $error) {
        echo "Could not update data in the database.";
        file_put_contents(__DIR__ . '/../logs/PDOErrors.txt', 'updateData.php - ' . $error->getMessage(), FILE_APPEND);
    }

} else {
    exit("No file updated"); // tai die()
}
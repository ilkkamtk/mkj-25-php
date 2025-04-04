<?php
global $DBH;
global $SITE_URL;
require_once __DIR__ . "/../config/config.php";
require_once __DIR__ . '/../db/dbConnect.php';

if (!empty($_GET['media_id'])) {
    // tiedoston deletointi
    $fileSql = "SELECT * FROM MediaItems WHERE media_id = :media_id";
    $data = ['media_id' => $_GET['media_id']];

    try {
        $fileSTH = $DBH->prepare($fileSql);
        $fileSTH->execute($data);
        $row = $fileSTH->fetch();
        unlink(__DIR__ . "/../uploads/" . $row['filename']);
    } catch (PDOException $error) {
        echo "Could not delete media item.";
        file_put_contents(__DIR__ . '/../logs/PDOErrors.txt', 'deleteData.php - file delete - ' . $error->getMessage(), FILE_APPEND);
    }

    $sql = "DELETE FROM MediaItems WHERE media_id = :media_id";



    try {
        $STH = $DBH->prepare($sql);
        $STH->execute($data);
        if ($STH->rowCount() > 0) {
            header('Location: ' . $SITE_URL);
        }
    } catch (PDOException $error) {
        echo "Could not delete media item.";
        file_put_contents(__DIR__ . '/../logs/PDOErrors.txt', 'deleteData.php - database delete - ' . $error->getMessage(), FILE_APPEND);
    }

}
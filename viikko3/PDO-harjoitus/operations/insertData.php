<?php
global $DBH;
require_once __DIR__ . '/../db/dbConnect.php';

if ( !empty($_POST['title']) && $_FILES['file']['error'] === UPLOAD_ERR_OK ) {
    $filename    = $_FILES['file']['name'];
    $filesize    = $_FILES['file']['size'];
    $filetype    = $_FILES['file']['type'];
    $tmp_name    = $_FILES['file']['tmp_name'];
    $destination = __DIR__ . '/../uploads/' . $filename;

    if ( move_uploaded_file( $tmp_name, $destination ) ) {
        echo "File uploaded successfully";
    } else {
        echo "Error uploading file";
    }
} else {
    exit("No file uploaded"); // tai die()
}
<?php
include "databases.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['userId'];

    $deleteQuery = mysqli_query($induction, "DELETE FROM `client` WHERE `id` = $userId");

    if ($deleteQuery) {
        header('Content-Type: application/json');
        echo '{"status": true, "error": null}';
    } else {
        header('Content-Type: application/json');
        echo '{"status": false, "error": {"code": 104, "message": "Error deleting user"}}';
    }
}
?>

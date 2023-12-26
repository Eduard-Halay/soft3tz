<?php
include "databases.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['userId'];

    $deleteQuery = mysqli_query($induction, "DELETE FROM `client` WHERE `id` = $userId");

    if ($deleteQuery) {
        echo '{"status": true, "error": null}';
    } else {
        echo '{"status": false, "error": {"code": 104, "message": "Error deleting user"}}';
    }
}
?>

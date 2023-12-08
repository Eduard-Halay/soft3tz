<?php
include "databases.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['userId'];

     $deleteQuery = mysqli_query($induction, "DELETE FROM `client` WHERE `id` = $userId");

     if ($deleteQuery) {
        echo 'User deleted successfully';
    } else {
        echo 'Error deleting user';
    }
}
?>

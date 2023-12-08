<?php
include "databases.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $lastname = $_POST['lastname'];
    $role = $_POST['role'];
    $status = $_POST['status'];

     $query = "INSERT INTO `client` (`name`, `lastname`, `role`, `status`) VALUES ('$name', '$lastname', '$role', '$status')";
    mysqli_query($induction, $query);
}
?>

<?php
include "databases.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $lastname = $_POST['lastname'];
    $role = $_POST['role'];
    $status = $_POST['status'];

    $query = "INSERT INTO `client` (`name`, `lastname`, `role`, `status`) VALUES ('$name', '$lastname', '$role', '$status')";
    mysqli_query($induction, $query);

    // Получение данных нового пользователя
    $newUserId = mysqli_insert_id($induction);
    $result = mysqli_query($induction, "SELECT * FROM `client` WHERE `id` = $newUserId");
    $newUserData = mysqli_fetch_assoc($result);

    // Возвращение данных в формате JSON
    header('Content-Type: application/json');
    echo json_encode($newUserData);
}
?>

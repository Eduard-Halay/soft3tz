<?php
include "databases.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $users = isset($_POST['users']) ? $_POST['users'] : [];
    $newStatus = isset($_POST['newStatus']) ? $_POST['newStatus'] : '';

    $successResponse = ['status' => true, 'error' => null, 'users' => []];
    $errors = [];

    $foundUsers = [];

    foreach ($users as $userData) {
        $userId = isset($userData['id']) ? $userData['id'] : null;

        if ($userId !== null) {
            $selectQuery = "SELECT `status` FROM `client` WHERE `id`='$userId'";
            $result = mysqli_query($induction, $selectQuery);

            if ($result) {
                $row = mysqli_fetch_assoc($result);

                if ($row) {
                    $status = $row['status'];
                    $foundUsers[] = ['id' => $userId, 'status' => $status];
                } else {
                    $errors[] = ['userId' => $userId, 'error' => 'User with id ' . $userId . ' not found'];
                }
            } else {
                $errors[] = ['userId' => $userId, 'error' => 'Error querying user with id ' . $userId];
            }
        } else {
            $errors[] = ['error' => 'User id is missing'];
        }
    }

    if (empty($errors)) {
      
        foreach ($foundUsers as $userData) {
            $userId = $userData['id'];
            $status = $userData['status'];

            $updateQuery = "UPDATE `client` SET `status`='$newStatus' WHERE `id`='$userId'";
            if (!mysqli_query($induction, $updateQuery)) {
                $errors[] = ['userId' => $userId, 'error' => 'Error updating status'];
            } else {
                $successResponse['users'][] = ['id' => $userId, 'status' => $newStatus];
            }
        }
    }

    if (!empty($errors)) {
        $successResponse['status'] = false;
        $successResponse['error'] = $errors;
    }

    echo json_encode($successResponse);
} else {
    http_response_code(400);
    echo json_encode(['status' => false, 'error' => ['code' => 105, 'message' => 'Invalid request method']]);
}

?>

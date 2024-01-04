<?php
include "databases.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $users = $_POST['users'];
    $newStatus = $_POST['newStatus'];

    $successResponse = ['status' => true, 'error' => null, 'users' => []];
    $errors = [];

    foreach ($users as $userData) {
        $userId = $userData['id'];
        $updateQuery = "UPDATE `client` SET `status`='$newStatus' WHERE `id`='$userId'";

        if (mysqli_query($induction, $updateQuery)) {
            $selectQuery = "SELECT `status` FROM `client` WHERE `id`='$userId'";
            $result = mysqli_query($induction, $selectQuery);

            if ($result) {
                $row = mysqli_fetch_assoc($result);
                $status = $row['status'];

                if ($row) {
                    $successResponse['users'][] = ['id' => $userId, 'status' => $status];
                } else {
                  
                    $errors[] = ['userId' => $userId, 'error' => 'User with id ' . $userId . ' not found'];
                }
            }
        } else {
            $errors[] = ['userId' => $userId, 'error' => 'Error updating status'];
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

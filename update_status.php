<?php
include "databases.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userIds = isset($_POST['userIds']) ? $_POST['userIds'] : '';
    $newStatus = isset($_POST['newStatus']) ? $_POST['newStatus'] : '';

    $successResponse = ['status' => true, 'error' => null, 'ids' => []];
    $errorResponse = ['status' => false, 'error' => [], 'ids' => []];

    if (empty($userIds)) {
        $errorResponse['error'] = ['code' => 106, 'message' => 'No valid users selected'];
        echo json_encode($errorResponse);
        exit;
    }

    $userIdsArray = explode(',', $userIds);

  
    $hasError = false;

    foreach ($userIdsArray as $userId) {
        $selectQuery = "SELECT `status` FROM `client` WHERE `id`='$userId'";
        $result = mysqli_query($induction, $selectQuery);

        if ($result) {
            $row = mysqli_fetch_assoc($result);

            if ($row) {
                $status = $row['status'];

            
                if ($status !== $newStatus) {
                
                    $existingError = array_filter($errorResponse['error'], function ($error) use ($userId) {
                        return $error['userId'] === $userId;
                    });

                    if (empty($existingError)) {
                     
                        $successResponse['ids'][] = $userId;
                    } else {
                     
                        $errorResponse['error'][] = ['userId' => $userId, 'error' => 'Error updating status'];
                        $hasError = true;
                    }
                }
            } else {
              
                $errorResponse['error'][] = ['userId' => $userId, 'error' => 'User with id ' . $userId . ' not found'];
                $hasError = true;
            }
        } else {
       
            $errorResponse['error'][] = ['userId' => $userId, 'error' => 'Error querying user with id ' . $userId];
            $hasError = true;
        }
    }

    if ($hasError) {
        $errorResponse['status'] = false;
        header('Content-Type: application/json');
        echo json_encode($errorResponse);
    } else {
       
        header('Content-Type: application/json');
        echo json_encode($successResponse);
        
        foreach ($successResponse['ids'] as $userId) {
            $updateQuery = "UPDATE `client` SET `status`='$newStatus' WHERE `id`='$userId'";
            mysqli_query($induction, $updateQuery);
        }
    }
} else {
    http_response_code(400);
    echo json_encode(['status' => false, 'error' => ['code' => 105, 'message' => 'Invalid request method']]);
}
?>

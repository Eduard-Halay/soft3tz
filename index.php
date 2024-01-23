<?php
include "databases.php";
$result = mysqli_query($induction, "SELECT * FROM `client`");
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin</title>

    <!-- Подключение Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Подключение Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Подключение jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha384-UG8ao2jwOWB7/oDdObZc6ItJmwUkR/PfMyt9Qs5AwX7PsnYn1CRKCTWyncPTWvaS" crossorigin="anonymous"></script>

    <!-- Подключение Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="style.css">
    
  
</head>
<body>

    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <div class="client">
                
                    <h2>Users</h2>

                    <div class="mt-3 d-flex align-items-center">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">Add</button>
                     <select class="form-select rounded" id="actionSelect" style="margin-right: 10px;margin-left: 10px;">
                        <option class='activ'>-Please-Select-</option>
                        <option value="activate">Set Active</option>
                         <option value="deactivate">Set Not active</option>
                         <option value="delete">Delete</option>
                     </select>
                    <button type="button" class="btn btn-primary" id="applyChangesButton">OK</button>
                    </div>

                    <div id="messageBox" class="mt-3 alert alert-danger" style="display: none;"></div>
                   
                    <br>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">
                                    <input type="checkbox" id="selectAllCheckbox">
                                </th>
                                <th scope="col">Name</th>
                                <th scope="col">Role</th>
                                <th scope="col">Status</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
$roles = [1 => "admin", 2 => "user"];

while ($bd = mysqli_fetch_assoc($result)) {
    $userId = $bd['id'];
    $statusClass = ($bd['status'] == '1') ? 'active' : '';

    ?>
    <tr data-user-id='<?= $userId ?>'>
        <td><input type='checkbox' class='selectCheckbox'></td>
        <td><?= $bd['name'] ?>&nbsp;<?= $bd['lastname'] ?></td>
        <td><?= $roles[$bd['role']] ?></td>
        <td class='text-center align-middle'><div class='status-circle <?= $statusClass ?>'></div></td>
        <td class='text-center align-middle'>
            <a href='#' class='btn border-dark btn-sm ms-1 btn-rounded editUserBtn' data-user-id='<?= $userId ?>'><i class='fas fa-pen-to-square'></i></a>
            <a href='#' class='btn border-dark btn-sm me-1 btn-rounded deleteUserBtn'><i class='fas fa-trash-alt'></i></a>
        </td>
    </tr>

    <!-- Модальное окно для редактирования -->
    <div class='modal fade' id='editModal<?= $userId ?>' tabindex='-1' aria-labelledby='editModalLabel' aria-hidden='true'>
        <div class='modal-dialog'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title' id='editModalLabel'>Update User</h5>
                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                </div>
                <div class='modal-body'>
                    <form id='editForm<?= $userId ?>'>
                        <div class='mb-3'>
                            <div id='editMessageBox<?= $userId ?>' class='mt-3 alert alert-danger' style='display: none;'></div>
                            <label for='editName<?= $userId ?>' class='form-label'>Name</label>
                            <input type='text' class='form-control' id='editName<?= $userId ?>' value='<?= $bd['name'] ?>'>
                        </div>
                        <div class='mb-3'>
                            <label for='editLastname<?= $userId ?>' class='form-label'>Lastname</label>
                            <input type='text' class='form-control' id='editLastname<?= $userId ?>' value='<?= $bd['lastname'] ?>'>
                        </div>
                        <div class='mb-3'>
                            <label for='editStatus<?= $userId ?>' class='form-label'>Status</label>
                            <div class='form-check form-switch'>
                                <input class='form-check-input' type='checkbox' id='editStatus<?= $userId ?>'<?= ($bd['status'] == '1') ? " checked" : "" ?>>
                                <label class='form-check-label' for='editStatus<?= $userId ?>'></label>
                            </div>
                        </div>
                        <div class='mb-3'>
                            <label for='editRole<?= $userId ?>' class='form-label'>Role</label>
                            <select class='form-select' id='editRole<?= $userId ?>'>
                                <?php
                                foreach ($roles as $roleId => $roleName) {
                                    $selected = ($bd['role'] == $roleId) ? ' selected' : '';
                                    echo "<option value='{$roleId}'{$selected}>{$roleName}</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </form>
                </div>
                <div class='modal-footer'>
                    <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                    <button type='button' class='btn btn-primary' onclick='updateUser(<?= $userId ?>)'>Update</button>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>
</tbody>
</table>


                    <div class="mb-3 d-flex align-items-center">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">Add</button>
                        <select class="form-select" id="actionSelect2" style="margin-right: 10px;margin-left: 10px;">
                            <option class='activ'>-Please-Select-</option>
                            <option value="activate">Set Active</option>
                            <option value="deactivate">Set Not Active</option>
                            <option value="delete">Delete</option>
                        </select>
                        <button type="button" class="btn btn-primary" id="applyChangesButton2">OK</button>
                    </div>



      

    
                    <script>
                    
                    function updateStatus(userIds, newStatus) {
    var errors = [];
    var updatedUserIds = [];

    var requestData = {
        userIds: userIds.join(','), 
        newStatus: newStatus
    };

    if (userIds.length === 0) {
        showMessage('No valid users selected.');
        return;
    }

    $.ajax({
        type: 'POST',
        url: 'update_status.php',
        data: requestData,
        cache: false,
        dataType: 'json',
        success: function (response) {
            if (response && response.status !== undefined) {
                if (response.status === false) {
                    if (response.error && response.error.length > 0) {
                        showMessage('Error updating status: ' + response.error[0].error);
                    } else {
                        showMessage('Unknown error updating status.');
                    }

                    $('.selectCheckbox').prop('checked', false);
                    updateSelectAllCheckbox();
                } else {
                    if (response.ids && response.ids.length > 0) {
                        updateElements(response.ids, newStatus);
                        updateModalStatus(response.ids[0], newStatus);
                    }

                    $('.selectCheckbox').prop('checked', false);
                    updateSelectAllCheckbox();
                }
            } else {
                showMessage('Invalid response format');
            }
        },
        error: function (xhr, status, error) {
            showMessage('Error updating status');
            $(document).trigger('ajaxError', [xhr, status, error]);
        }
    });
}

function updateModalStatus(userId, newStatus) {
    var statusCheckbox = $('#editStatus' + userId);

    statusCheckbox.prop('checked', newStatus === '1');
}

function updateElements(userIds, newStatus) {
    userIds.forEach(function (userId) {
        var statusCircle = $('tr[data-user-id="' + userId + '"] .status-circle');
        var isActive = newStatus === '1';
        
        statusCircle.toggleClass('active', isActive);
        statusCircle.css('background-color', isActive ? 'green' : 'gray');
    });
}

function updateStatusCheckboxes() {
    var checkedUserIds = [];
    $('.selectCheckbox:checked').each(function () {
        checkedUserIds.push($(this).closest('tr').data('user-id'));
    });

}



$(document).ready(function () {

    $('#selectAllCheckbox').on('change', function () {
    var isChecked = $(this).prop('checked');
    $('.selectCheckbox').prop('checked', isChecked);
    updateStatusCheckboxes();
});






    var selectAllCheckbox = $('#selectAllCheckbox');
    var checkboxes = $('.selectCheckbox');

    $('body').on('change', '.selectCheckbox', function () {
        var allChecked = true;
        $('.selectCheckbox').each(function () {
            if (!this.checked) {
                allChecked = false;
                return false;
            }
        });

        selectAllCheckbox.prop('checked', allChecked);
    });

    $('#applyChangesButton').on('click', applyChanges);
    $('#applyChangesButton2').on('click', applyChanges2);

    function applyChanges() {
        var actionSelect = document.getElementById('actionSelect');
        var selectedAction = actionSelect.value;

        var selectedUserIds = [];
        $('.selectCheckbox:checked').each(function () {
            selectedUserIds.push($(this).closest('tr').data('user-id'));
        });

        if (selectedUserIds.length === 0) {
            showMessage('Please select at least one user.');
            return;
        }

        switch (selectedAction) {
            case 'activate':
                updateStatus(selectedUserIds, '1');
                break;
            case 'deactivate':
                updateStatus(selectedUserIds, '0');
                break;
            case 'delete':
                deleteUsers(selectedUserIds);
                break;
            default:
                showMessage('Please select the action');
                return;
        }
    }

    function applyChanges2() {
        var actionSelect2 = document.getElementById('actionSelect2');
        var selectedAction2 = actionSelect2.value;

        var selectedUserIds2 = [];
        $('.selectCheckbox:checked').each(function () {
            selectedUserIds2.push($(this).closest('tr').data('user-id'));
        });

        if (selectedUserIds2.length === 0) {
            showMessage('Please select at least one user.');
            return;
        }

        switch (selectedAction2) {
            case 'activate':
                updateStatus(selectedUserIds2, '1');
                break;
            case 'deactivate':
                updateStatus(selectedUserIds2, '0');
                break;
            case 'delete':
                deleteUsers(selectedUserIds2);
                break;
            default:
                showMessage('Please select the action');
                return;
        }
    }

    var selectAllCheckbox = $('#selectAllCheckbox');
    var checkboxes = $('.selectCheckbox');

    selectAllCheckbox.change(function () {
    checkboxes.prop('checked', this.checked);
    updateStatusCheckboxes();
});

checkboxes.change(function () {
    updateSelectAllCheckbox();
});


$('body').on('change', '.selectCheckbox', function () {
    updateSelectAllCheckbox();
    updateStatusCheckboxes();
});







    $('.editUserBtn').click(function () {
        var userId = $(this).data('user-id');
        showEditModal(userId);
    });

    $('#saveChangesBtn').click(function () {
    });

    $('.deleteUserBtn').click(function () {
        var userId = $(this).closest('tr').data('user-id');
        var userName = $(this).closest('tr').find('td:eq(0)').text(); 
        var userLastname = $(this).closest('tr').find('td:eq(1)').length > 0
            ? $(this).closest('tr').find('td:eq(1)').text()
            : '';

        $('#deleteConfirmationModal').data('user-id', userId);
        $('#deleteConfirmationModal').data('user-name', userName);
        $('#deleteConfirmationModal').data('user-lastname', userLastname);
        $('#deleteConfirmationModal').data('user-ids', [userId]); 

        $('#deleteConfirmationModal .modal-body').html('Are you sure you want to delete ' + userName + ' ' + userLastname + '?');

        $('#deleteConfirmationModal').modal('show');
    });

    $('#confirmDeleteBtn').click(function () {
        var userIds = $('#deleteConfirmationModal').data('user-ids');
        if (userIds && Array.isArray(userIds)) {
            userIds.forEach(function (userId) {
                deleteUser(userId);
            });
        } else {
            console.error('Invalid user IDs:', userIds);
        }
        $('#deleteConfirmationModal').modal('hide');
    });

});

$('body').on('click', '.deleteUserBtn', function () {
    var userId = $(this).closest('tr').data('user-id');
    var userName = $(this).closest('tr').find('td:eq(0)').text();
    var userLastname = $(this).closest('tr').find('td:eq(1)').length > 0
        ? $(this).closest('tr').find('td:eq(1)').text()
        : '';
    $('#deleteConfirmationBody').html('Are you sure you want to delete ' + userName + ' ' + userLastname + '?');
    $('#deleteConfirmationModal').data('user-ids', [userId]);
    $('#deleteConfirmationModal').modal('show');
});


// Обработчик кнопки подтверждения удаления
$('#confirmDeleteBtn').click(function () {
    var userIds = $('#deleteConfirmationModal').data('user-ids');
    var userNames = $('#deleteConfirmationModal').data('user-names');
    if (userIds && Array.isArray(userIds) && userNames && Array.isArray(userNames)) {
        userIds.forEach(function (userId, index) {
            deleteUser(userId, userNames[index]);
        });
    } else {
        console.error('Invalid user IDs or names:', userIds, userNames);
    }
    $('#deleteConfirmationModal').modal('hide');
});
function deleteUsers() {
    var selectedUserIds = [];
    var selectedUserNames = [];

    $('.selectCheckbox:checked').each(function () {
        var userId = $(this).closest('tr').data('user-id');
        var userName = $('tr[data-user-id="' + userId + '"] td:nth-child(2)').text().trim();
        selectedUserIds.push(userId);
        selectedUserNames.push(userName);
    });

    if (selectedUserIds.length === 0) {
        showMessage('Please select at least one user.');
        return;
    }

    var confirmationText = selectedUserIds.length > 1
        ? 'Are you sure you want to delete users?'
        : 'Are you sure you want to delete ' + selectedUserNames[0] + '?';

    $('#deleteConfirmationBody').text(confirmationText);

    $('#deleteConfirmationModal').modal('show');
    $('#deleteConfirmationModal').data('user-ids', selectedUserIds);
    $('#deleteConfirmationModal').data('user-names', selectedUserNames);
}



// Обработчик кнопки подтверждения удаления
$('#confirmDeleteBtn').click(function () {
    var userIds = $('#deleteConfirmationModal').data('user-ids');
    var userNames = $('#deleteConfirmationModal').data('user-names');
    if (userIds && Array.isArray(userIds) && userNames && Array.isArray(userNames)) {
        userIds.forEach(function (userId, index) {
            deleteUser(userId, userNames[index]);
        });
    } else {
        console.error('Invalid user IDs or names:', userIds, userNames);
    }
    $('#deleteConfirmationModal').modal('hide');
});



// Функция удаления пользователя 
function deleteUser(userId, userName) {
    var userRow = $('tr[data-user-id="' + userId + '"]');
    if (!userRow.length) {
        showMessage('There is no object with this id', 'error');
        return;
    }

    var formData = new FormData();
    formData.append('userId', userId);

    $.ajax({
        type: 'POST',
        url: 'delete_user.php',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function () {
            
            var userRow = $('tr[data-user-id="' + userId + '"]');
            if (userRow.length) {
                userRow.remove();
            } else {
                console.error('User with id ' + userId + ' not found');
                showMessage('User ' + userName + ' with id ' + userId + ' not found. The changes you entered are saved; to see them, refresh the page.');
            }
        },
        error: function (xhr, status, error) {
            console.error('Error deleting user:', status, error);
            console.error('XHR object:', xhr.responseText);
            showMessage('Error deleting user ' + userName + '. Please try again.');
        }
    });
}




function showMessage(message) {
   
    var modal = $('#messageModal');
    var modalBody = $('#messageModalBody');
    modalBody.text(message);
    modal.modal('show');

   
    //setTimeout(function () {
      //  modal.modal('hide');
  //  }, 3000);
}


function createEditModal(userId, userData) {
   
    var modal = $('<div class="modal fade" id="editModal' + userId + '" tabindex="-1" aria-labelledby="editModalLabel' + userId + '" aria-hidden="true">');
    
   
    modal.append('<div class="modal-dialog"><div class="modal-content">');
    modal.find('.modal-content').append('<div class="modal-header"><h5 class="modal-title" id="editModalLabel' + userId + '">Update User</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>');
    modal.find('.modal-content').append('<div class="modal-body">');
    
    modal.find('.modal-body').append('<div class="mt-3 alert alert-danger" id="editMessageBox' + userId + '" style="display: none;"></div>');


    var form = $('<form id="editForm' + userId + '">');
    form.append('<div class="mb-3"><label for="editName' + userId + '" class="form-label">Name</label><input type="text" class="form-control" id="editName' + userId + '" value="' + userData.name_first + '"></div>');
form.append('<div class="mb-3"><label for="editLastname' + userId + '" class="form-label">Lastname</label><input type="text" class="form-control" id="editLastname' + userId + '" value="' + userData.name_last + '"></div>');

    form.append('<div class="mb-3"><label for="editStatus' + userId + '" class="form-label">Status</label><div class="form-check form-switch"><input class="form-check-input" type="checkbox" id="editStatus' + userId + '" ' + (userData.status === '1' ? 'checked' : '') + '><label class="form-check-label" for="editStatus' + userId + '"></label></div></div>');
    form.append('<div class="mb-3"><label for="editRole' + userId + '" class="form-label">Role</label><select class="form-select" id="editRole' + userId + '"><option value="2" ' + (userData.role === '2' ? 'selected' : '') + '>User</option><option value="1" ' + (userData.role === '1' ? 'selected' : '') + '>Admin</option></select></div>');
    modal.find('.modal-body').append(form);
    
    
    modal.find('.modal-content').append('<div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button><button type="button" class="btn btn-primary" onclick="updateUser(' + userId + ')">Update</button></div>');
    
    
    modal.append('</div></div>');

    return modal;
}
function addUser() {
    var nameInput = $('#addName');
    var lastnameInput = $('#addLastname');
    var roleSelect = $('#addRole');
    var statusCheckbox = $('#addStatus');
    var errorMessage = $('#errorMessage');

    var name = nameInput.val().trim();
    var lastname = lastnameInput.val().trim();
    var role = (roleSelect.val() === 'admin' || roleSelect.val() === '1') ? 1 : 2;
    var selectAllStatus = $('#selectAllCheckbox').prop('checked');
    var status = selectAllStatus ? '1' : (statusCheckbox.prop('checked') ? '1' : '0');

    if (name === '' || lastname === '') {
        errorMessage.text('Please enter both your first and last name.');
        return;
    }

    errorMessage.text('');

    var formData = new FormData();
    formData.append('name', name);
    formData.append('lastname', lastname);
    formData.append('role', role);
    formData.append('status', status);

    $.ajax({
        type: 'POST',
        url: 'add_user.php',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (response) {
            if (response !== null && typeof response === 'object' && response.hasOwnProperty('user')) {
                var userData = response.user;

                var newRow = "<tr data-user-id='" + userData.id + "'>";
                newRow += "<td><input type='checkbox' class='selectCheckbox'></td>";
                newRow += "<td>" + userData.name_first + "&nbsp;" + userData.name_last + "</td>";
                newRow += "<td>" + (userData.role === '1' ? 'admin' : 'user') + "</td>";
                newRow += "<td class='text-center align-middle'><div class='status-circle " + (userData.status === '1' ? 'active' : '') + "'></div></td>";
                newRow += "<td class='text-center align-middle'>";
                newRow += "<a href='#' class='btn border-dark btn-sm ms-1 btn-rounded editUserBtn' data-user-id='" + userData.id + "'><i class='fas fa-pen-to-square'></i></a>";
                newRow += "<a href='#' class='btn border-dark btn-sm me-1 btn-rounded deleteUserBtn'><i class='fas fa-trash-alt'></i></a>";
                newRow += "</td>";
                newRow += "</tr>";

                $('tbody').append(newRow);
                $('#addUserModal').modal('hide');

                updateSelectAllCheckbox();

                var editModal = createEditModal(userData.id, userData);
                $('body').append(editModal);
            } else {
                console.error('Invalid response format or null:', response);
            }
        },
        error: function (xhr, status, error) {
            console.error('Error adding user:', status, error);
            console.error('XHR object:', xhr.responseText);
        }
    });
}







$(document).ready(function () {
    $('#addUserModal').on('hidden.bs.modal', function () {
        $('#addUserForm').trigger('reset');
        $('#errorMessage').text(''); 
    });

    $('#addUserButton').on('click', function () {
        addUser();
    });
});

$(document).ready(function () {
    $('body').on('click', '.editUserBtn', function () {
        var userId = $(this).data('user-id');
        showEditModal(userId);
    });
});

function showEditModal(userId) {
    
    $('#editModal' + userId).modal('show');
}
var currentUserId = null;

function hideEditModal(userId) {
    var editModal;

    if (userId) {
        currentUserId = userId;
    }

    if (currentUserId !== null) {
        editModal = $('#editModal' + currentUserId);
        if (editModal.length) {
            editModal.modal('hide');
        } else {
            console.error('Modal window for user with ID ' + currentUserId + ' not found');
        }
    } else {
        console.error('userId is not defined');
    }
}

function updateUser(userId) {
    var errors = [];

    function handleUpdateError(xhr, status, error) {
        var errorMessage;

        if (xhr.responseJSON && xhr.responseJSON.error) {
            errorMessage = xhr.responseJSON.error.message;
        } else {
            errorMessage = 'Error updating user';
        }

        if (userId && $('#editModal' + userId).length) {
           

            $('#editMessageBox' + userId).text(errorMessage).addClass('alert-danger').show();
        }

        errors.push({ userId: currentUserId, error: errorMessage });
        showMessage(errorMessage, 'error');
    }

    var userRow = $('tr[data-user-id="' + userId + '"]');
    if (!userRow.length) {
        var error = { userId: userId, error: 'Object with this ID not found' };
        errors.push(error);
        showMessage(error.error, 'error');
        return;
    }

    var nameInput = $('#editName' + userId);
    var lastnameInput = $('#editLastname' + userId);
    var statusCheckbox = $('#editStatus' + userId);
    var roleSelect = $('#editRole' + userId);

    var name = nameInput.val().trim();
    var lastname = lastnameInput.val().trim();
    var status = statusCheckbox.prop('checked') ? '1' : '0';
    var role = roleSelect.val() === '1' ? '1' : '2';

    var formData = new FormData();
    formData.append('userId', userId);
    formData.append('name', name);
    formData.append('lastname', lastname);
    formData.append('status', status);
    formData.append('role', role);

    $.ajax({
        type: 'POST',
        url: 'update_user.php',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (response) {
            handleUpdateSuccess(userId, response, statusCheckbox, nameInput, lastnameInput);
        },
        error: function (xhr, status, error) {
            handleUpdateError(xhr, status, error);
        },
        complete: function () {

        }
    });
}
function handleUpdateSuccess(userId, response, statusCheckbox, nameInput, lastnameInput) {
    if (response && response.status !== undefined) {
        if (response.status === false) {
            var errorMessage;
            if (response.error && response.error.message) {
                errorMessage = response.error.message;
            } else {
                errorMessage = 'Error updating user';
            }

            $('#editMessageBox' + userId).text(errorMessage).addClass('alert-danger').show();

            
            $('#editModal' + userId).on('hidden.bs.modal', function () {
                
                $('#editMessageBox' + userId).text('').removeClass('alert-danger');
                $('#editMessageBox' + userId).text(errorMessage).addClass('alert-danger').hide();
            });

           
        } else {
            if (response.status === true) {
                var userRow = $('tr[data-user-id="' + userId + '"]');
                if (userRow.length) {
                    var userData = response.user;

                    userRow.find('td:nth-child(2)').html(userData.name_first + ' ' + userData.name_last);
                    userRow.find('td:nth-child(3)').text(userData.role === '1' ? 'admin' : 'user');

                    var statusCircle = userRow.find('.status-circle');
statusCircle.toggleClass('active', userData.status === '1');
                    statusCircle.css('background-color', '');
                    
                     if ($('#editModal' + userId).length) {
                         hideEditModal(userId);
                     }
                } else {
                    console.error('User row not found');
                }
            } else {
                handleUpdateError(null, 'error', response);
            }
        }
    } else {
        console.error('Invalid response format');
    }
}


function handleUpdateError(xhr, status, error) {
    var errorMessage;

    if (xhr && xhr.responseJSON && xhr.responseJSON.error) {
        errorMessage = xhr.responseJSON.error.message;
    } else if (error && error.error) {
        errorMessage = error.error;
    } else {
        errorMessage = 'Error updating user';
    }

    showMessage(errorMessage, 'error');

    // if ($('#editModal' + (userId || currentUserId)).length) {
    //     hideEditModal(userId);
    // }
}


function updateSelectAllCheckbox() {
    var selectAllCheckbox = $('#selectAllCheckbox');
    var checkboxes = $('.selectCheckbox');

    selectAllCheckbox.prop('checked', checkboxes.length === checkboxes.filter(':checked').length);
}


$('body').on('change', '.selectCheckbox', function () {
    updateSelectAllCheckbox();
});


$('#selectAllCheckbox').change(function () {
    var isChecked = $(this).prop('checked');
    $('.selectCheckbox').prop('checked', isChecked);
    updateSelectAllCheckbox();  
    updateStatusCheckboxes();
});


</script>




            </div>
        </div>
    </div>

<!-- модальное окно для добавления пользователя -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Add User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addUserForm">
                    <div class="mb-3">
                        <label for="addName" class="form-label">First name</label>
                        <input type="text" class="form-control" id="addName" required>
                    </div>
                    <div class="mb-3">
                        <label for="addLastname" class="form-label">Last name</label>
                        <input type="text" class="form-control" id="addLastname" required>
                    </div>
                 
                    <div id="errorMessage" class="mb-3 text-danger"></div>
                      <div class="mb-3">
                        <label for="addStatus" class="form-label">Status</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="addStatus" checked>
                        </div>
                       </div>
                     <div class="mb-3">
                        <label for="addRole" class="form-label">Role</label>
                        <select class="form-select" id="addRole" required>
                            <option value="2">User</option>
                            <option value="1">Admin</option>
                        </select>
                    </div>
                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="addUser()">Add User</button>
            </div>
        </div>
    </div>
</div>

     
<!-- Модальное окно подтверждения удаления -->
<div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmationModalLabel">Delete Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="deleteConfirmationBody">
                Are you sure you want to delete ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="messageModalLabel">Message</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="messageModalBody">
                <!-- Текст сообщения -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



</body>
</html>

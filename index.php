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
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#userModal<?=$userId?>" data-operation="add">Add</button>
                  
                    
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
       <a href="#" class="btn border-dark btn-sm ms-1 btn-rounded editUserBtn" data-bs-toggle="modal" data-bs-target="#userModal" data-user-id="<?= $userId ?>" data-operation="edit"><i class='fas fa-pen-to-square'></i></a>
            <a href='#' class='btn border-dark btn-sm me-1 btn-rounded deleteUserBtn'><i class='fas fa-trash-alt'></i></a>
        </td>
    </tr>

    <!-- обьединенное модальное окно  -->
<div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">Add User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="userForm">
                    <div class="mb-3">
                    <div id='UserMessageBox' class='mt-3 alert alert-danger' style='display: none;'></div>
                        <label for="userName" class="form-label">First name</label>
                        <input type="text" class="form-control" id="userName" required>
                    </div>
                    <div class="mb-3">
                        <label for="userLastname" class="form-label">Last name</label>
                        <input type="text" class="form-control" id="userLastname" required>
                    </div>

                    <div id="errorMessage" class="mb-3 text-danger"></div>
                    <div class="mb-3">
                        <label for="userStatus" class="form-label">Status</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="userStatus" checked>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="userRole" class="form-label">Role</label>
                        <select class="form-select" id="userRole" required>
                            <option value="2">User</option>
                            <option value="1">Admin</option>
                        </select>
                    </div>

                    <!-- Добавьте скрытое поле для указания текущей операции -->
                    <input type="hidden" id="operationType" value="add">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <!-- Измените текст кнопки в зависимости от операции -->
                <button type="button" class="btn btn-primary" onclick="performOperation()">Add User</button>
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
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#userModal" data-operation='add'>Add</button>
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

   
}
////////////////////////////////////////////////////////////////




function performOperation() {
        var operationType = $('#operationType').val();

        switch (operationType) {
            case 'add':
                addUser();
                break;
            case 'edit':
                updateUser(currentUserId);
                break;
            default:
                showMessage('Invalid operation type');
        }
    }
    $(document).ready(function () {
    $('#userModal').on('hidden.bs.modal', function () {
        $('#userForm').trigger('reset');
        $('#errorMessage').text('');
        $('#operationType').val('add');
    });

   
    $('.editUserBtn').click(function () {
        var userId = $(this).data('user-id');
        currentUserId = userId;
        showEditModal(userId);

       
        $('#operationType').val('edit');

        
        $('#userModalLabel').text('Update User');
        $('.modal-footer button.btn-primary').text('Update User');
    });

    
    $('#userModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var modal = $(this);

        if (button.data('operation') === 'edit') {
            modal.find('.modal-title').text('Update  User');
            modal.find('.modal-footer button.btn-primary').text('Update User');
        } else if(button.data('operation') === 'add') {
            modal.find('.modal-title').text('Add User');
            modal.find('.modal-footer button.btn-primary').text('Add User');
            
        }
    });

   
    $('#addUserButton').on('click', function () {
        addUser();
    });

   
    $('body').on('click', '.editUserBtn', function () {
        var userId = $(this).data('user-id');
        var fullName = $(this).closest('tr').find('td:nth-child(2)').text().trim();
        
        var nameMatch = fullName.match(/^(\S+)\s+(\S+)$/);

        if (nameMatch) {
            var userData = {
                name_first: nameMatch[1],
                name_last: nameMatch[2],
                status: $(this).closest('tr').find('.status-circle').hasClass('active') ? '1' : '0',
                role: $(this).closest('tr').find('td:nth-child(3)').text() === 'admin' ? '1' : '2'
            };

            showEditModal(userId, userData);
        } else {
            console.error('Invalid user data:', userData);
            return; 
        }
    });

    function showEditModal(userId, userData) {
    $('#userForm').trigger('reset');

    if (userData && userData.name_first && userData.name_last) {
        $('#userName').val(userData.name_first);
        $('#userLastname').val(userData.name_last);
        $('#userStatus').prop('checked', userData.status === '1');
        $('#userRole').val(userData.role);

      
        $('#operationType').val('edit');

       
        $('#userModalLabel').text('Update User');
        $('.modal-footer button.btn-primary').text('Update User');

       
        $('#userModal').modal('show');
    }
}
});






function addUser() {
    var nameInput = $('#userName');
    var lastnameInput = $('#userLastname');
    var roleSelect = $('#userRole');
    var statusCheckbox = $('#userStatus');
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
                newRow += "<a href='#' class='btn border-dark btn-sm ms-1 btn-rounded editUserBtn' data-user-id='" + userData.id + "' data-operation='edit'><i class='fas fa-pen-to-square'></i></a>";
                newRow += "<a href='#' class='btn border-dark btn-sm me-1 btn-rounded deleteUserBtn'><i class='fas fa-trash-alt'></i></a>";
                newRow += "</td>";
                newRow += "</tr>";

               
                $('tbody').append(newRow);
                $('#userModal').data('user-id', userData.id);  
                currentUserId = userData.id;  
                $('#userModal' ).modal('hide');

                updateSelectAllCheckbox();

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



var currentUserId = null;

function updateUser(userId) {
    var userRow = $('tr[data-user-id="' + userId + '"]');
    var nameInput = $('#userName');
    var lastnameInput = $('#userLastname');
    var statusCheckbox = $('#userStatus');
    var roleSelect = $('#userRole');

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
            handleUpdateResponse(userId, response);
        },
        error: function (xhr, status, error) {
            handleUpdateError(userId, xhr, status, error);
        },
        complete: function () {
         
        }
    });
}

function handleUpdateResponse(userId, response) {
    if (response && response.status !== undefined) {
        if (response.status === true) {
            updateUserData(userId, response.user);
            hideEditModal(userId);
        } else {
            handleUpdateError(userId, null, 'error', response);

            
        }
    } else {
        console.error('Invalid response format');
    }
}
function handleUpdateError(userId, xhr, status, error) {
    var errorMessage = 'Error updating user';

    if (xhr && xhr.responseJSON && xhr.responseJSON.error) {
        errorMessage = xhr.responseJSON.error.message;
    } else if (error) {
        if (typeof error === 'string') {
          
            errorMessage = error;
        } else if (error.error && error.error.message) {
           
            errorMessage = error.error.message;
        }
    }

 
    $('#UserMessageBox').text(errorMessage).addClass('alert-danger').show();

    if (userId && $('#userModal').length) {
        
        $('#userModal').off('hidden.bs.modal');

        
        $('#userModal').on('hidden.bs.modal', function () {
            $('#UserMessageBox').text('').removeClass('alert-danger').hide();
           
            $('#userForm').trigger('reset');
        $('#errorMessage').text('');
        $('#operationType').val('add');
        });
    }
}


function updateUserData(userId, userData) {
    var userRow = $('tr[data-user-id="' + userId + '"]');
    if (userRow.length) {
        userRow.find('td:nth-child(2)').html(userData.name_first + ' ' + userData.name_last);
        userRow.find('td:nth-child(3)').text(userData.role === '1' ? 'admin' : 'user');

        var statusCircle = userRow.find('.status-circle');
        statusCircle.toggleClass('active', userData.status === '1');
        statusCircle.css('background-color', '');
    } else {
        console.error('User row not found');
    }
}

function hideEditModal(userId) {
    $('#userModal' ).modal('hide');
    
}


//////////////////////////////////
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
             
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



</body>
</html>

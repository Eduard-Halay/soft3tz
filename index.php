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

    
    
    <style>
        .status-circle {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: inline-block;
        }

        .status-active {
            background-color: green;
        }

        .status-inactive {
            background-color: gray;
        }
        .form-select{
            width:160px;
            padding-left: 20px;
            padding-right: 20px;
        }
        .form-check-input:checked {
    background-color: #2ecc71; 
}
    </style>
</head>
<body>

    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <div class="client">
                
                    <h2>Users</h2>

                    <div class="mt-3 d-flex align-items-center">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">Add</button>
                     <select class="form-select rounded" id="actionSelect">
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
while ($bd = mysqli_fetch_assoc($result)) {
    $userId = $bd['id'];
    echo "<tr data-user-id='{$userId}'>";
    echo "<td><input type='checkbox' class='selectCheckbox'></td>";
    echo "<td>{$bd['name']}&nbsp;{$bd['lastname']}</td>";
    echo "<td>";
echo ($bd['role'] == '1') ? 'admin' : 'user';
echo "</td>";
    $statusClass = ($bd['status'] == '1') ? 'status-active' : 'status-inactive';
    echo "<td class='text-center align-middle'><div class='status-circle {$statusClass}'></div></td>";
    echo "<td class='text-center align-middle'>";
    echo "<a href='#' class='btn border-dark btn-sm ms-1 btn-rounded editUserBtn' data-user-id='{$userId}'><i class='fas fa-pen-to-square'></i></a>";

    echo "<a href='#' class='btn border-dark btn-sm me-1 btn-rounded deleteUserBtn'><i class='fas fa-trash-alt'></i></a>";
    echo "</td>";
    echo "</tr>";

    // Модальное окно для редактирования
    echo "<div class='modal fade' id='editModal{$userId}' tabindex='-1' aria-labelledby='editModalLabel' aria-hidden='true'>";
    echo "  <div class='modal-dialog'>";
    echo "    <div class='modal-content'>";
    echo "      <div class='modal-header'>";
    echo "        <h5 class='modal-title' id='editModalLabel'>Update User</h5>";
    echo "        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>";
    echo "      </div>";
    echo "      <div class='modal-body'>";
    echo "        <form id='editForm{$userId}'>";
    echo "          <div class='mb-3'>";
    echo "            <label for='editName{$userId}' class='form-label'>Name</label>";
    echo "            <input type='text' class='form-control' id='editName{$userId}' value='{$bd['name']}'>";
    echo "          </div>";
    echo "          <div class='mb-3'>";
    echo "            <label for='editLastname{$userId}' class='form-label'>Lastname</label>";
    echo "            <input type='text' class='form-control' id='editLastname{$userId}' value='{$bd['lastname']}'>";
    echo "          </div>";
    echo "          <div class='mb-3'>";
    echo "            <label for='editStatus{$userId}' class='form-label'>Status</label>";
    echo "            <div class='form-check form-switch'>";
    echo "              <input class='form-check-input' type='checkbox' id='editStatus{$userId}'";
    echo ($bd['status'] == '1') ? " checked" : "";
    echo ">";
    echo "              <label class='form-check-label' for='editStatus{$userId}'></label>";
    echo "            </div>";
    echo "          </div>";
    echo "          <div class='mb-3'>";
    echo "            <label for='editRole{$userId}' class='form-label'>Role</label>";
    echo "            <select class='form-select' id='editRole{$userId}'>";
    echo "              <option value='user' " . (($bd['role'] == 'user') ? 'selected' : '') . ">User</option>";
    echo "              <option value='admin' " . (($bd['role'] == 'admin') ? 'selected' : '') . ">Admin</option>";
    echo "            </select>";
    echo "          </div>";
    echo "        </form>";
    echo "      </div>";
    echo "      <div class='modal-footer'>";
    echo "        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>";
    echo "        <button type='button' class='btn btn-primary' onclick='updateUser({$userId})'>Update</button>";
    echo "      </div>";
    echo "    </div>";
    echo "  </div>";
    echo "</div>";
}
?>

</tbody>
</table>

                    <div class="mt-3 d-flex align-items-center">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">Add</button>
                        <select class="form-select" id="actionSelect2">
                            <option class='activ'>-Please-Select-</option>
                            <option value="activate">Set Active</option>
                            <option value="deactivate">Set Not Active</option>
                            <option value="delete">Delete</option>
                        </select>
                        <button type="button" class="btn btn-primary" id="applyChangesButton2">OK</button>
                    </div>



      

    
                    <script>
// Checkbox
$(document).ready(function () {
    var selectAllCheckbox = $('#selectAllCheckbox');
    var checkboxes = $('.selectCheckbox');

    selectAllCheckbox.change(function () {
        checkboxes.prop('checked', this.checked);
    });

    checkboxes.change(function () {
        var allChecked = true;
        checkboxes.each(function () {
            if (!this.checked) {
                allChecked = false;
                return false; 
            }
        });

        selectAllCheckbox.prop('checked', allChecked);
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

// Обработка подтверждения удаления
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

function deleteUser(userId) {
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
                console.error('User row not found');
            }
        },
        error: function (xhr, status, error) {
            console.error('Error deleting user:', status, error);
            console.error('XHR object:', xhr.responseText);
        }
    });
}
function createEditModal(userId, userData) {
   
    var modal = $('<div class="modal fade" id="editModal' + userId + '" tabindex="-1" aria-labelledby="editModalLabel' + userId + '" aria-hidden="true">');
    
   
    modal.append('<div class="modal-dialog"><div class="modal-content">');
    modal.find('.modal-content').append('<div class="modal-header"><h5 class="modal-title" id="editModalLabel' + userId + '">Update User</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>');
    modal.find('.modal-content').append('<div class="modal-body">');
    
   
    var form = $('<form id="editForm' + userId + '">');
    form.append('<div class="mb-3"><label for="editName' + userId + '" class="form-label">Name</label><input type="text" class="form-control" id="editName' + userId + '" value="' + userData.name + '"></div>');
    form.append('<div class="mb-3"><label for="editLastname' + userId + '" class="form-label">Lastname</label><input type="text" class="form-control" id="editLastname' + userId + '" value="' + userData.lastname + '"></div>');
    form.append('<div class="mb-3"><label for="editStatus' + userId + '" class="form-label">Status</label><div class="form-check form-switch"><input class="form-check-input" type="checkbox" id="editStatus' + userId + '" ' + (userData.status === '1' ? 'checked' : '') + '><label class="form-check-label" for="editStatus' + userId + '"></label></div></div>');
    form.append('<div class="mb-3"><label for="editRole' + userId + '" class="form-label">Role</label><select class="form-select" id="editRole' + userId + '"><option value="user" ' + (userData.role === 'user' ? 'selected' : '') + '>User</option><option value="admin" ' + (userData.role === 'admin' ? 'selected' : '') + '>Admin</option></select></div>');
    modal.find('.modal-body').append(form);
    
    
    modal.find('.modal-content').append('<div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button><button type="button" class="btn btn-primary" onclick="updateUser(' + userId + ')">Update</button></div>');
    
    
    modal.append('</div></div>');

    return modal;
}
 
function addUser() {
    var nameInput = document.getElementById('addName');
    var lastnameInput = document.getElementById('addLastname');
    var roleSelect = document.getElementById('addRole');
    var statusCheckbox = document.getElementById('addStatus');
    var errorMessage = document.getElementById('errorMessage');

    var name = nameInput.value.trim();
    var lastname = lastnameInput.value.trim();
    
    // Получаем числовое значение роли
    var role = (roleSelect.value === 'admin') ? 1 : 2;
    
    var status = statusCheckbox.checked ? '1' : '0';

    if (name === '' || lastname === '') {
        errorMessage.textContent = 'Please enter both your first and last name.';
        return;
    }

    errorMessage.textContent = '';

    var formData = new FormData();
    formData.append('name', name);
    formData.append('lastname', lastname);
    formData.append('role', role);
    formData.append('status', status);

    jQuery.ajax({
        type: 'POST',
        url: 'add_user.php',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (response) {
            var newRow = "<tr data-user-id='" + response.id + "'>";
            newRow += "<td><input type='checkbox' class='selectCheckbox'></td>";
            newRow += "<td>" + response.name + "&nbsp;" + response.lastname + "</td>";
            
            // Отображаем текстовое значение роли
            newRow += "<td>" + (role === 1 ? 'admin' : 'user') + "</td>";
            
            newRow += "<td class='text-center align-middle'><div class='status-circle " + (response.status === '1' ? 'status-active' : 'status-inactive') + "'></div></td>";
            newRow += "<td class='text-center align-middle'>";
            newRow += "<a href='#' class='btn border-dark btn-sm ms-1 btn-rounded editUserBtn' data-user-id='" + response.id + "'><i class='fas fa-pen-to-square'></i></a>";
            newRow += "<a href='#' class='btn border-dark btn-sm me-1 btn-rounded deleteUserBtn'><i class='fas fa-trash-alt'></i></a>";
            newRow += "</td>";
            newRow += "</tr>";

            jQuery('tbody').append(newRow);
            jQuery('#addUserModal').modal('hide');

            var editModal = createEditModal(response.id, response);
            $('body').append(editModal);
        },
        error: function (xhr, status, error) {
            console.error('Error adding user:', status, error);
            console.error('Объект XHR:', xhr.responseText);
        }
    });
}



function showMessage(message) {
    var messageBox = $('#messageBox');
    messageBox.text(message);
    messageBox.show();

    setTimeout(function () {
        messageBox.hide();
    }, 5000);
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

function updateUser(userId) {
    var nameInput = $('#editName' + userId);
    var lastnameInput = $('#editLastname' + userId);
    var statusCheckbox = $('#editStatus' + userId);
    var roleSelect = $('#editRole' + userId);

    var name = nameInput.val();
    var lastname = lastnameInput.val();
    var status = statusCheckbox.prop('checked') ? '1' : '0';
    
    // Получаем числовое значение роли
    var role = (roleSelect.val() === 'admin') ? 1 : 2;

    var formData = {
        userId: userId,
        name: name,
        lastname: lastname,
        status: status,
        role: role
    };

    $.ajax({
        type: 'POST',
        url: 'update_user.php',
        data: formData,
        success: function (data) {
            var userRow = $('tr[data-user-id="' + userId + '"]');
            if (userRow.length) {
                userRow.find('td:nth-child(2)').text(name + ' ' + lastname);
                
                // Отображаем текстовое значение роли
                userRow.find('td:nth-child(3)').text((role === 1) ? 'admin' : 'user');

                var statusCircle = userRow.find('.status-circle');
                statusCircle.removeClass().addClass('status-circle ' + (status === '1' ? 'status-active' : 'status-inactive'));

                var editModal = $('#editModal' + userId);
                if (editModal.length) {
                    // Проверка наличия модального окна перед его скрытием
                    editModal.modal('hide');
                } else {
                    console.error('Edit modal not found');
                }
            } else {
                console.error('User row not found');
            }
        },
        error: function (xhr, status, error) {
            console.error('Error updating user:', status, error);
        },
        complete: function () {
        }
    });
}

</script>



<script>
$(document).ready(function () {
    var selectAllCheckbox = $('#selectAllCheckbox');
    var checkboxes = $('.selectCheckbox');

    selectAllCheckbox.change(function () {
        checkboxes.prop('checked', this.checked);
    });

    checkboxes.change(function () {
        var allChecked = true;
        checkboxes.each(function () {
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
            showMessage('Please select the  action');
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
                    <!--  элемент для вывода сообщения об ошибке -->
                    <div id="errorMessage" class="mb-3 text-danger"></div>
                    <div class="mb-3">
                        <label for="addRole" class="form-label">Role</label>
                        <select class="form-select" id="addRole" required>
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="addStatus" class="form-label">Status</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="addStatus" checked>
                        </div>
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




<script>
     
      function updateStatus(userIds, newStatus) {
        userIds.forEach(function (userId) {
            var statusCircle = $('tr[data-user-id="' + userId + '"] .status-circle');

            
            $.ajax({
                type: 'POST',
                url: 'update_status.php',
                data: { userId: userId, newStatus: newStatus },
                cache: false,
                dataType: 'json',
                success: function (response) {
                    if (response && response.status !== undefined) {
                        statusCircle.css('background-color', response.status === '1' ? 'green' : 'gray');
                    } else {
                        console.error('Invalid response format:', response);
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error updating status:', status, error);   
                    console.error('XHR object:', xhr.responseText);
                },
                complete: function () {
                   
                }
            });
        });
    }

    // Функция удаления пользователей
    function deleteUsers(userIds) {
        
        $('#deleteConfirmationModal').modal('show');

      
        $('#deleteConfirmationModal').data('user-ids', userIds);
    }
    
</script>
</body>
</html>

$(document).ready(function () {
    getDataAccount();
    let userPar = '';
    let userName = '';
    let userId = '';
    let role = '';
    let email = '';
    let password = '';
    let userIdDelete = '';

    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        iconColor: 'white',
        showConfirmButton: false,
        customClass: {
            popup: 'colored-toast',
        },
        timer: 2000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
    });

    $('#dataTable').on('click', '.edit-button', function () {
        userPar = $(this).data('par');
        userName = $(this).data('name');
        userId = $(this).data('id');
        role = $(this).data('role');
        email = $(this).data('email');
        password = $(this).data('password');

        $('#user_name_input').val(userName);
        $('#user_id_input').val(userId);
        $('#role_input').val(role);
        $('#email_input').val(email);
        $('#password_input').val(password);
    });

    $('#btn-save-edit').on('click', function () {
        var editData = {
            id: userPar,
            user_name: $('#user_name_input').val(),
            user_id: $('#user_id_input').val(),
            role: $('#role_input').val(),
            email: $('#email_input').val(),
            password: $('#password_input').val()
        };

        $.ajax({
            url: '/edit-user',
            type: 'POST',
            dataType: 'json',
            contentType: 'application/json',
            data: JSON.stringify(editData),
            success: function (response) {
                if(response.success){
                    Toast.fire({
                        icon: 'success',
                        title: response.message
                    }).then(() => {
                        getDataAccount();
                        $('#bd-example-modal-lg').modal('hide');
                    });
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: response.message
                    });
                }
            },
            error: function (response) {
                Toast.fire({
                    icon: 'error',
                    title: "An error occurred while sending data"
                });
            }
        });

    });

    $('#dataTable').on('click', '.delete-button', function () {
        userIdDelete = $(this).data('id');
    });

    $('#btn-save-delete').on('click', function () {
        var deletedData = {
            id_item: userIdDelete
        };

        $.ajax({
            url: '/delete-user',
            type: 'POST',
            dataType: 'json',
            contentType: 'application/json',
            data: JSON.stringify(deletedData),
            success: function (response) {
                if(response.success){
                    Toast.fire({
                        icon: 'success',
                        title: response.message
                    }).then(() => {
                        getDataAccount();
                        $('#confirmation-modal').modal('hide');
                    });
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: response.message
                    });
                }
            },
            error: function (response) {
                Toast.fire({
                    icon: 'error',
                    title: "An error occurred while sending data"
                });
            }
        });
    });

    $('#close-add').on('click', function () {
        $('#addItemForm')[0].reset();
    });

    $('#close-add2').on('click', function () {
        $('#addItemForm')[0].reset();
    });

    $('#btn-add-save').on('click', function () {
        event.preventDefault();
        var nameUser = $('#inputName').val();
        var idUser = $('#inputId').val();
        var role = $('#inputRole').val();
        var email = $('#inputEmail').val();
        var password = $('#inputPassword').val();

        if (!nameUser || !idUser || !role || !email || !password) {
            Toast.fire({
                icon: 'warning',
                title: "Fill in all the data first"
            }).then(() => {
            });
            return;
        }

        $.ajax({
            url: '/add-user',
            type: 'POST',
            dataType: 'json',
            contentType: 'application/json',
            data: JSON.stringify({
                user_name: nameUser,
                user_id: idUser,
                role: role,
                email: email,
                password: password
            }),
            success: function (response) {
                if (response.success) {
                    Toast.fire({
                        icon: 'success',
                        title: "Successfully saved data"
                    }).then(() => {
                        getDataAccount();
                        $('#bd-add').modal('hide');
                        $('#addItemForm')[0].reset();
                    });
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: response.message
                    });
                }
            },
            error: function () {
                Toast.fire({
                    icon: 'error',
                    title: "An error occurred while sending data"
                });
            }
        });
    });

    $('#btn-import-excel').on('click', function () {
        var input = document.createElement('input');
        input.type = 'file';

        input.onchange = function (e) {
            var file = e.target.files[0];
            if (file) {
                var formData = new FormData();
                formData.append('excelFile', file);

                $.ajax({
                    url: '/import-excel-user',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        if (response.success) {
                            Toast.fire({
                                icon: 'success',
                                title: "Data imported successfully"
                            }).then(() => {
                                getDataAccount();
                            });
                        } else {
                            Toast.fire({
                                icon: 'error',
                                title: 'An error occurred while importing data: ' + response.error
                            });
                        }
                    },
                    error: function (error) {
                        if (error.responseJSON && error.responseJSON.error) {
                            Toast.fire({
                                icon: 'error',
                                title: error.responseJSON.error
                            }).then(() => {
                                getDataAccount();
                            });
                        } else {
                            Toast.fire({
                                icon: 'error',
                                title: "An error occurred while sending data"
                            });
                        }
                    }
                });
            }
        };
        input.click();
    });

});

var currentPage;
function getDataAccount() {
    $.ajax({
        url: '/data-tabel-account',
        method: 'GET',
        dataType: 'json',
        success: function (response) {
            var stockTable = $('#dataTable').DataTable();
            currentPage = stockTable.page();
            stockTable.clear().draw();

            response.data.forEach(function (item, index) {
                var noUrut = index + 1;
                var dropdownHTML = `
                    <div class="dropdown">
                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#"
                            role="button" data-toggle="dropdown">
                            <i class="dw dw-more"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                            <a class="dropdown-item edit-button" data-par="${item.id}"
                                data-name="${item.user_name}"
                                data-id="${item.user_id}"
                                data-role="${item.role}"
                                data-email="${item.email}"
                                data-password="${item.password}" data-toggle="modal"
                                data-target="#bd-example-modal-lg" id="edit-btn"><i class="dw dw-edit2"></i>
                                Edit</a>
                            <a class="dropdown-item delete-button" data-id="${item.id}"
                                data-toggle="modal" data-target="#confirmation-modal"><i
                                    class="dw dw-delete-3"></i> Delete</a>
                        </div>
                    </div>
                `;

                stockTable.row.add([
                    noUrut,
                    item.user_name,
                    item.user_id,
                    item.role,
                    item.email,
                    item.password,
                    dropdownHTML
                ]).draw(false);
            });
            stockTable.page(currentPage).draw(false);
        },
        error: function (xhr, status, error) {
            console.error('Error:', error);
        }
    });
}
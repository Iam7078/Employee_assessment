$(document).ready(function () {
    getDataEmployee();
    let employeePar = '';
    let employeeName = '';
    let employeeId = '';
    let department = '';
    let unit = '';
    let directLeader = '';
    let employeeIdDelete = '';

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

    $('#close-add').on('click', function () {
        $('#addItemForm')[0].reset();
    });

    $('#close-add2').on('click', function () {
        $('#addItemForm')[0].reset();
    });

    $('#btn-add-save').on('click', function () {
        event.preventDefault();
        var nameEmployee = $('#inputName').val();
        var idEmployee = $('#inputId').val();
        var dempartment = $('#inputDepartment').val();
        var unit = $('#inputUnit').val();
        var directLeader = $('#inputDirectLeader').val();

        if (!nameEmployee || !idEmployee || !dempartment || !unit || !directLeader) {
            Toast.fire({
                icon: 'warning',
                title: "Fill in all the data first"
            });
            return;
        }

        $.ajax({
            url: '/add-employee',
            type: 'POST',
            dataType: 'json',
            contentType: 'application/json',
            data: JSON.stringify({
                employee_name: nameEmployee,
                employee_id: idEmployee,
                department: dempartment,
                unit: unit,
                direct_leader: directLeader
            }),
            success: function (response) {
                if (response.success) {
                    Toast.fire({
                        icon: 'success',
                        title: "Successfully saved data"
                    }).then(() => {
                        getDataEmployee();
                        $('#modal-add').modal('hide');
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

    $('#dataTable').on('click', '.edit-button', function() {
        employeePar = $(this).data('par');
        employeeName = $(this).data('name');
        employeeId = $(this).data('id');
        department = $(this).data('department');
        unit = $(this).data('unit');
        directLeader = $(this).data('leader');

        $('#employee_name_input').val(employeeName);
        $('#employee_id_input').val(employeeId);
        $('#department_input').val(department);
        $('#unit_input').val(unit);
        $('#direct_leader_input').val(directLeader);
    });

    $('#btn-save-edit').on('click', function () {
        var editData = {
            id: employeePar,
            employee_name: $('#employee_name_input').val(),
            employee_id: $('#employee_id_input').val(),
            department: $('#department_input').val(),
            unit: $('#unit_input').val(),
            direct_leader: $('#direct_leader_input').val()
        };
    
        $.ajax({
            url: '/edit-employee',
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
                        getDataEmployee();
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

    $('#dataTable').on('click', '.delete-button', function() {
        employeeIdDelete = $(this).data('id');
    });

    $('#btn-save-delete').on('click', function () {
        var deletedData = {
            id_item: employeeIdDelete
        };

        $.ajax({
            url: '/delete-employee',
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
                        getDataEmployee();
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

    $('#btn-import-excel').on('click', function () {
        var input = document.createElement('input');
        input.type = 'file';
    
        input.onchange = function (e) {
            var file = e.target.files[0];
            if (file) {
                var formData = new FormData();
                formData.append('excelFile', file);
    
                $.ajax({
                    url: '/import-excel-employee',
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
                                getDataEmployee();
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
                                getDataEmployee();
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
function getDataEmployee() {
    $.ajax({
        url: '/data-tabel-employee',
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
                                data-name="${item.employee_name}"
                                data-id="${item.employee_id}"
                                data-department="${item.department}"
                                data-unit="${item.unit}"
                                data-leader="${item.direct_leader}" data-toggle="modal"
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
                    item.employee_name,
                    item.employee_id,
                    item.department,
                    item.unit,
                    item.direct_leader,
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
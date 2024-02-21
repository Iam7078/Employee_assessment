$(document).ready(function () {
    getDataDepartmentTargets();
    let idEdit = '';
    let employeeIdEdit = '';
    let yearEdit = '';
    let initialWeightEdit = '';

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

    // Add Data
    $('#close-add').on('click', function () {
        $('#addItemForm')[0].reset();
    });

    $('#close-add2').on('click', function () {
        $('#addItemForm')[0].reset();
    });

    $('#addWeight').on('input', function () {
        var value = $(this).val();
        if (!/^[1-9]\d*$/.test(value)) {
            Toast.fire({
                icon: 'error',
                title: `Enter a valid number (positive whole number greater than 0).`
            }).then(() => {
                $(this).val('');
            });
        }
    });

    $('#btn-add-save').on('click', function () {
        event.preventDefault();
        var employee_id = $('#addEmployeeId').val();
        var parameter = $('#addParameter').val();
        var weight = $('#addWeight').val();
        var remark = $('#addRemark').val();

        if (!employee_id || !parameter || !weight || !remark) {
            Toast.fire({
                icon: 'warning',
                title: "Fill in all the data first"
            }).then(() => {
            });
            return;
        }

        $.ajax({
            url: '/add-assessment-department-target',
            type: 'POST',
            dataType: 'json',
            contentType: 'application/json',
            data: JSON.stringify({
                employee_id: employee_id,
                parameter: parameter,
                weight: weight,
                remark: remark
            }),
            success: function (response) {
                if (response.success) {
                    Toast.fire({
                        icon: 'success',
                        title: "Successfully saved data"
                    }).then(() => {
                        getDataDepartmentTargets();
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


    // Edit Data
    $('#dataTable').on('click', '.edit-button', function () {
        idEdit = $(this).data('id');
        yearEdit = $(this).data('year');
        employeeIdEdit = $(this).data('employee_id');
        parameter = $(this).data('parameter');
        initialWeightEdit = $(this).data('weight');
        remark = $(this).data('remark');

        $('#editParameter').val(parameter);
        $('#editWeight').val(initialWeightEdit);
        $('#editRemark').text(remark);
    });

    $('#editWeight').on('input', function () {
        var value = $(this).val();
        if (!/^[1-9]\d*$/.test(value)) {
            Toast.fire({
                icon: 'error',
                title: `Enter a valid number (positive whole number greater than 0).`
            }).then(() => {
                $(this).val('');
            });
        }
    });

    $('#btn-save-edit').on('click', function () {
        var editData = {
            id: idEdit,
            employee_id: employeeIdEdit,
            year: yearEdit,
            initial_weight: initialWeightEdit,
            parameter: $('#editParameter').val(),
            weight: $('#editWeight').val(),
            remark: $('#editRemark').val()
        };

        $.ajax({
            url: '/edit-assessment-department-target',
            type: 'POST',
            dataType: 'json',
            contentType: 'application/json',
            data: JSON.stringify(editData),
            success: function (response) {
                if (response.success) {
                    Toast.fire({
                        icon: 'success',
                        title: response.message
                    }).then(() => {
                        getDataDepartmentTargets();
                        $('#modal-edit').modal('hide');
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


    // Delete Data
    $('#dataTable').on('click', '.delete-button', function () {
        userIdDelete = $(this).data('id');
    });

    $('#btn-save-delete').on('click', function () {
        var deletedData = {
            id: userIdDelete
        };

        $.ajax({
            url: '/delete-assessment-department-target',
            type: 'POST',
            dataType: 'json',
            contentType: 'application/json',
            data: JSON.stringify(deletedData),
            success: function (response) {
                if (response.success) {
                    Toast.fire({
                        icon: 'success',
                        title: response.message
                    }).then(() => {
                        getDataDepartmentTargets();
                        $('#modal-delete').modal('hide');
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
                    url: '/import-assessment-department-target',
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
                                getDataDepartmentTargets();
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
                                getDataDepartmentTargets();
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
function getDataDepartmentTargets() {
    $.ajax({
        url: '/data-tabel-department-target',
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
                            <a class="dropdown-item edit-button" data-id="${item.id}"
                                data-employee_id="${item.employee_id}"
                                data-year="${item.year}"
                                data-parameter="${item.parameter}"
                                data-remark="${item.remark}"
                                data-weight="${item.weight}" data-toggle="modal"
                                data-target="#modal-edit" id="edit-btn"><i class="dw dw-edit2"></i>
                                Edit</a>
                            <a class="dropdown-item delete-button" data-id="${item.id}"
                                data-toggle="modal" data-target="#modal-delete"><i
                                    class="dw dw-delete-3"></i> Delete</a>
                        </div>
                    </div>
                `;

                stockTable.row.add([
                    noUrut,
                    item.year,
                    item.employee_name,
                    item.parameter,
                    item.remark,
                    item.weight,
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
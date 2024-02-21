$(document).ready(function () {
    var id = $('#id').text().trim();
    let idDelete = '';
    let idEdit = '';
    let employeeIdEdit = '';
    let yearEdit = '';
    let initialWeightEdit = '';
    getDataDepartmentTarget(id);
    
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
        var employee_id = $('#id').text().trim();
        var parameter = $('#addParameter').val();
        var weight = $('#addWeight').val();
        var remark = $('#addRemark').val();

        if (!parameter || !weight || !remark) {
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
                        getDataDepartmentTarget(id);
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
    $('#tabel-target').on('click', '.edit-button', function () {
        idEdit = $(this).data('id');
        yearEdit = $(this).data('year');
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
            employee_id: id,
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
                        getDataDepartmentTarget(id);
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
    $('#tabel-target').on('click', '.delete-button', function () {
        idDelete = $(this).data('id');
    });

    $('#btn-save-delete').on('click', function () {
        var deletedData = {
            id: idDelete
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
                        getDataDepartmentTarget(id);
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

});

function getDataDepartmentTarget(id) {
    $.ajax({
        url: '/data-subordinate-target?employee_id=' + id,
        method: 'GET',
        dataType: 'json',
        success: function (response) {
            $('.tabel-parameter tbody').empty();
            response.data.forEach(function (item) {
                var dropdownHTML = `
                    <div class="dropdown">
                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#"
                            role="button" data-toggle="dropdown">
                            <i class="dw dw-more"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                            <a class="dropdown-item edit-button" data-id="${item.id}"
                                data-year="${item.year}"
                                data-parameter="${item.parameter}"
                                data-weight="${item.weight}"
                                data-remark="${item.remark}" data-toggle="modal"
                                data-target="#modal-edit"><i class="dw dw-edit2"></i>
                                Edit</a>
                            <a class="dropdown-item delete-button" data-id="${item.id}"
                                data-toggle="modal" data-target="#modal-delete"><i
                                    class="dw dw-delete-3"></i> Delete</a>
                        </div>
                    </div>
                `;

                var row = `
                    <tr>
                        <td>${item.year}</td>
                        <td>${item.parameter}</td>
                        <td>${item.remark}</td>
                        <td>${item.weight}</td>
                        <td>${dropdownHTML}</td>
                    </tr>
                `;

                var tableBodyId = '#table-body';
                $(tableBodyId).append(row);
            });
        },
        error: function (xhr, status, error) {
            console.error('Error:', error);
        }
    });
}

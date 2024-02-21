$(document).ready(function () {
    getDataParameter();
    let statusID = '';
    let statusCategory = '';
    let statusWeight = '';
    let idEdit = '';
    let yearEdit = '';
    let statusEdit = '';
    let parameterE = '';
    let weightE = '';
    let remarkE = '';
    let category = '';
    let weightCetegory = '';

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

    $('.tabel-parameter').on('click', '.edit-button', function () {
        idEdit = $(this).data('id');
        yearEdit = $(this).data('year');
        statusEdit = $(this).data('status');
        parameterE = $(this).data('parameter');
        weightE = $(this).data('weight');
        remarkE = $(this).data('remark');
        category = $(this).data('category');
        weightCetegory = $(this).data('weight_category');
        
        var title = 'Edit Data ' + category + ' (' + weightCetegory + '%)';
        $('#editParameter').val(parameterE);
        $('#editWeight').val(weightE);
        $('#editRemark').text(remarkE);
        $('#titleEdit').text(title);
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
            parameter: $('#editParameter').val(),
            weight: $('#editWeight').val(),
            remark: $('#editRemark').val(),
            initial_weight: weightE,
            status: statusEdit,
            year: yearEdit
        };

        $.ajax({
            url: '/edit-assessment-parameter',
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
                        getDataParameter();
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

    $('.tabel-parameter').on('click', '.delete-button', function () {
        userIdDelete = $(this).data('id');
    });

    $('#btn-save-delete').on('click', function () {
        var deletedData = {
            id_item: userIdDelete
        };

        $.ajax({
            url: '/delete-assessment-parameter',
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
                        getDataParameter();
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

    $('#close-add').on('click', function () {
        $('#addItemForm')[0].reset();
    });

    $('#close-add2').on('click', function () {
        $('#addItemForm')[0].reset();
    });

    $('.button-add').on('click', function () {
        statusID = $(this).data('cek');
        statusCategory = $(this).data('category');
        statusWeight = $(this).data('weight');

        var titleModalAdd = `Add Data ` + statusCategory + ` (` + statusWeight + `)`;
        $('#titleAdd').text(titleModalAdd);
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
        var parameter = $('#addParameter').val();
        var remark = $('#addRemark').val();
        var weight = $('#addWeight').val();

        if (!parameter || !remark || !weight) {
            Toast.fire({
                icon: 'warning',
                title: "Fill in all the data first"
            }).then(() => {
            });
            return;
        }

        $.ajax({
            url: '/add-assessment-parameter',
            type: 'POST',
            dataType: 'json',
            contentType: 'application/json',
            data: JSON.stringify({
                status: statusID,
                max_weight: statusWeight,
                parameter: parameter,
                remark: remark,
                weight: weight
            }),
            success: function (response) {
                if (response.success) {
                    Toast.fire({
                        icon: 'success',
                        title: "Successfully saved data"
                    }).then(() => {
                        getDataParameter();
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

    // $('#btn-import-excel').on('click', function () {
    //     var input = document.createElement('input');
    //     input.type = 'file';

    //     input.onchange = function (e) {
    //         var file = e.target.files[0];
    //         if (file) {
    //             var formData = new FormData();
    //             formData.append('excelFile', file);

    //             $.ajax({
    //                 url: '/import-excel-user',
    //                 type: 'POST',
    //                 data: formData,
    //                 processData: false,
    //                 contentType: false,
    //                 success: function (response) {
    //                     if (response.success) {
    //                         Toast.fire({
    //                             icon: 'success',
    //                             title: "Data imported successfully"
    //                         }).then(() => {
    //                             getDataAccount();
    //                         });
    //                     } else {
    //                         Toast.fire({
    //                             icon: 'error',
    //                             title: 'An error occurred while importing data: ' + response.error
    //                         });
    //                     }
    //                 },
    //                 error: function (error) {
    //                     if (error.responseJSON && error.responseJSON.error) {
    //                         Toast.fire({
    //                             icon: 'error',
    //                             title: error.responseJSON.error
    //                         }).then(() => {
    //                             getDataAccount();
    //                         });
    //                     } else {
    //                         Toast.fire({
    //                             icon: 'error',
    //                             title: "An error occurred while sending data"
    //                         });
    //                     }
    //                 }
    //             });
    //         }
    //     };
    //     input.click();
    // });

});

function getDataParameter() {
    $.ajax({
        url: '/data-tabel-parameter',
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
                                data-status="${item.status}"
                                data-status_detail="${item.status_detail}"
                                data-parameter="${item.parameter}"
                                data-weight="${item.weight}"
                                data-remark="${item.remark}"
                                data-category="${item.category}"
                                data-weight_category="${item.weight_category}" data-toggle="modal"
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

                var tableBodyId = '#table-body' + item.status;
                $(tableBodyId).append(row);
            });
        },
        error: function (xhr, status, error) {
            console.error('Error:', error);
        }
    });
}

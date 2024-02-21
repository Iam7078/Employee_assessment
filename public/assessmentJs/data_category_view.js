$(document).ready(function () {
    getDataCategory();
    let idEdit = '';
    let weightAwal = '';
    let idHapus = '';

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

    $('#inputWeight').on('input', function () {
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
        var inputCategory = $('#inputCategory').val();
        var inputWeight = $('#inputWeight').val();

        if (!inputCategory || !inputWeight) {
            Toast.fire({
                icon: 'warning',
                title: "Fill in all the data first"
            });
            return;
        }

        $.ajax({
            url: '/add-assessment-category',
            type: 'POST',
            dataType: 'json',
            contentType: 'application/json',
            data: JSON.stringify({
                category: inputCategory,
                weight: inputWeight
            }),
            success: function (response) {
                if (response.success) {
                    Toast.fire({
                        icon: 'success',
                        title: "Successfully saved data"
                    }).then(() => {
                        getDataCategory();
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

    $('#dataTable').on('click', '.edit-button', function () {
        idEdit = $(this).data('id');
        categoryEdit = $(this).data('category');
        weightEdit = $(this).data('weight');
        yearEdit = $(this).data('year');
        weightAwal = $(this).data('weight');

        $('#category_input').val(categoryEdit);
        $('#weight_input').val(weightEdit);
    });

    $('#weight_input').on('input', function () {
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
            category: $('#category_input').val(),
            weight: $('#weight_input').val(),
            year: yearEdit,
            weight_awal: weightAwal
        };

        $.ajax({
            url: '/edit-assessment-category',
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
                        getDataCategory();
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

    $('#dataTable').on('click', '.delete-button', function () {
        userIdDelete = $(this).data('id');
    });

    $('#btn-save-delete').on('click', function () {
        var deletedData = {
            id_item: userIdDelete
        };

        $.ajax({
            url: '/delete-assessment-category',
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
                        getDataCategory();
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
    //                             getDataCategory();
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
    //                             getDataCategory();
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

var currentPage;
function getDataCategory() {
    $.ajax({
        url: '/data-tabel-category',
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
                                data-year="${item.year}"
                                data-status="${item.status}"
                                data-category="${item.category}"
                                data-weight="${item.weight}" data-toggle="modal"
                                data-target="#modal-edit"><i class="dw dw-edit2"></i>
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
                    item.status,
                    item.category,
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
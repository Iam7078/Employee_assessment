$(document).ready(function () {
    getDataScoreProportion();
    let idEdit = '';

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

    $('#addSelf').on('input', function () {
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
    $('#addLeader').on('input', function () {
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
    $('#addSenior').on('input', function () {
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
        var addSelf = parseFloat($('#addSelf').val());
        var addLeader = parseFloat($('#addLeader').val());
        var addSenior = parseFloat($('#addSenior').val());
        var jumlah = addSelf + addLeader + addSenior;

        if (!addSelf || !addLeader || !addSenior) {
            Toast.fire({
                icon: 'warning',
                title: "Fill in all the data first"
            });
            return;
        }

        if (jumlah != 100) {
            Toast.fire({
                icon: 'warning',
                title: "Total score must be 100"
            });
            return;
        }

        $.ajax({
            url: '/add-score-proportion',
            type: 'POST',
            dataType: 'json',
            contentType: 'application/json',
            data: JSON.stringify({
                self: addSelf,
                leader: addLeader,
                senior_gm: addSenior
            }),
            success: function (response) {
                if (response.success) {
                    Toast.fire({
                        icon: 'success',
                        title: "Successfully saved data"
                    }).then(() => {
                        getDataScoreProportion();
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
        selfEdit = $(this).data('self');
        leaderEdit = $(this).data('leader');
        seniorEdit = $(this).data('senior_gm');

        $('#editSelf').val(selfEdit);
        $('#editLeader').val(leaderEdit);
        $('#editSenior').val(seniorEdit);
    });

    $('#editSelf').on('input', function () {
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
    $('#editLeader').on('input', function () {
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
    $('#editSenior').on('input', function () {
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
        var editSelf = parseFloat($('#editSelf').val());
        var editLeader = parseFloat($('#editLeader').val());
        var editSenior = parseFloat($('#editSenior').val());
        var jumlah = editSelf + editLeader + editSenior;

        if (jumlah != 100) {
            Toast.fire({
                icon: 'warning',
                title: "Total score must be 100"
            });
            return;
        }
        
        var editData = {
            id: idEdit,
            self: editSelf,
            leader: editLeader,
            senior_gm: editSenior
        };

        $.ajax({
            url: '/edit-score-proportion',
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
                        getDataScoreProportion();
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
            id: userIdDelete
        };

        $.ajax({
            url: '/delete-score-proportion',
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
                        getDataScoreProportion();
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

});

var currentPage;
function getDataScoreProportion() {
    $.ajax({
        url: '/data-tabel-score-proportion',
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
                                data-self="${item.self}"
                                data-leader="${item.leader}"
                                data-senior_gm="${item.senior_gm}" data-toggle="modal"
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
                    item.self,
                    item.leader,
                    item.senior_gm,
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
$(document).ready(function () {
    getDataSubordinate();

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

    $('#btn-import-excel').on('click', function () {
        var input = document.createElement('input');
        input.type = 'file';

        input.onchange = function (e) {
            var file = e.target.files[0];
            if (file) {
                var formData = new FormData();
                formData.append('excelFile', file);

                $.ajax({
                    url: '/import-department-target-sub',
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
                                getDataSubordinate();
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
                                getDataSubordinate();
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
function getDataSubordinate() {
    $.ajax({
        url: '/data-tabel-subordinate',
        method: 'GET',
        dataType: 'json',
        success: function (response) {
            var stockTable = $('#dataTable').DataTable();
            currentPage = stockTable.page();
            stockTable.clear().draw();

            response.data.forEach(function (item, index) {
                var noUrut = index + 1;
                var userStatusHtml = '<span style="background-color: ' + item.status_color + '; color: white; padding: 3px 10px; border-radius: 5px;">' + item.status_text + '</span>';
                var buttonHTML = `
                    <button class="btn btn-link font-30 p-0 line-height-1 no-arrow" onclick="redirectToDetail(${item.employee_id})">
                        <i class="icon-copy fa fa-plus-square mr-2"></i>Add
                    </button>
                `;

                stockTable.row.add([
                    noUrut,
                    item.employee_name,
                    item.employee_id,
                    item.department,
                    item.unit,
                    userStatusHtml,
                    buttonHTML
                ]).draw(false);
            });
            stockTable.page(currentPage).draw(false);
        },
        error: function (xhr, status, error) {
            console.error('Error:', error);
        }
    });
}

function redirectToDetail(employeeId) {
    window.location.href = "/detailSubordinate?employee_id=" + employeeId;
}
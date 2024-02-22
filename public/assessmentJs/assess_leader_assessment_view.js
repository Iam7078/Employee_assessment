$(document).ready(function () {
    getDataSubordinateAssess();
});

var currentPage;
function getDataSubordinateAssess() {
    $.ajax({
        url: '/data-tabel-subordinate-assess',
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
                        <i class="icon-copy fa fa-pencil-square-o mr-2"></i>Assess
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
    window.location.href = "/detail-subordinate-assess?employee_id=" + employeeId;
}
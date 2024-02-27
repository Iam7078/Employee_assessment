$(document).ready(function () {
    const year = document.getElementById('year').getAttribute('data-year');
    getDataReportLeader(year);
});

var currentPage;
function getDataReportLeader(year) {
    $.ajax({
        url: '/data-tabel-report-leader?year=' + year,
        method: 'GET',
        dataType: 'json',
        success: function (response) {
            var stockTable = $('#dataTable').DataTable();
            currentPage = stockTable.page();
            stockTable.clear().draw();

            response.data.forEach(function (item, index) {
                var noUrut = index + 1;
                var buttonHTML = `
                    <a class="btn btn-link font-30 p-0 line-height-1 no-arrow" href="/Em/rLeaDe?year=${year}&employee_id=${item.employee_id}">
                        <i class="icon-copy fa fa-eye mr-2"></i>Details
                    </a>
                `;

                stockTable.row.add([
                    noUrut,
                    item.employee_name,
                    item.employee_id,
                    item.department,
                    item.unit,
                    item.self,
                    item.leader,
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
$(document).ready(function () {
    const year = document.getElementById('year').getAttribute('data-year');
    getDataFinalResult(year);

    $('#btn-export-result').click(function () {
        exportDataPacking(year);
    });

    function exportDataPacking(year) {
        window.location = '/export-data-result?year=' + year;
    }
});

var currentPage;
function getDataFinalResult(year) {
    $.ajax({
        url: '/data-tabel-final-result?year=' + year,
        method: 'GET',
        dataType: 'json',
        success: function (response) {
            var stockTable = $('#dataTable').DataTable();
            currentPage = stockTable.page();
            stockTable.clear().draw();

            response.data.forEach(function (item, index) {
                var noUrut = index + 1;

                stockTable.row.add([
                    noUrut,
                    item.employee_name,
                    item.employee_id,
                    item.department,
                    item.unit,
                    item.direct_leader,
                    item.self,
                    item.leader,
                    item.senior_gm,
                    item.final_result,
                    item.grades
                ]).draw(false);
            });
            stockTable.page(currentPage).draw(false);
        },
        error: function (xhr, status, error) {
            console.error('Error:', error);
        }
    });
}
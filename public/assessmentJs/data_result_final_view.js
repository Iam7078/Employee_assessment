$(document).ready(function () {
    getDataScoreProportion();
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
                var buttonHTML = `
                    <button class="btn btn-link font-30 p-0 line-height-1 no-arrow" onclick="redirectToDetail(${item.year})">
                        <i class="icon-copy fa fa-eye mr-2"></i>Details
                    </button>
                `;

                stockTable.row.add([
                    noUrut,
                    item.year,
                    item.self,
                    item.leader,
                    item.senior_gm,
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

function redirectToDetail(year) {
    window.location.href = "/detail-final-result?year=" + year;
}
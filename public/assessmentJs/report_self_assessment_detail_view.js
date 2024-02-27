$(document).ready(function () {
    const year = document.getElementById('year').getAttribute('data-year');
    getDataReportSelf(year);
});

function getDataReportSelf(year) {
    $.ajax({
        url: '/data-tabel-report-self?year=' + year,
        method: 'GET',
        dataType: 'json',
        success: function (response) {
            $('.tabel-assessment tbody').empty();
            response.data.forEach(function (item) {
                var row = `
                    <tr>
                        <td>${item.parameter}</td>
                        <td>${item.remark}</td>
                        <td>${item.weight}</td>
                        <td>${item.value}</td>
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
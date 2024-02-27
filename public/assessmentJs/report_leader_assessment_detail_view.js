$(document).ready(function () {
    const year = document.getElementById('year').getAttribute('data-year');
    var id = $('#id').text().trim();
    getDataReportLeader(year, id);
});

function getDataReportLeader(year, id) {
    $.ajax({
        url: '/data-tabel-report-leader-detail?year=' + year + '&employee_id=' + id,
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
                        <td>${item.leader}</td>
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
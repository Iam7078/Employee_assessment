$(document).ready(function () {
    getDataAssessment();
    var data = {};
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

    $('#submitBtn').click(function () {
        var hasilPerhitunganArray = [];
        var idCuy = $(this).data('id');
        var jumlah = $(this).data('count');

        for (var i = 1; i <= jumlah; i++) {
            $('select[name="nilai' + i + '"]').each(function (index, element) {
                var selectedValue = parseInt($(element).val(), 10);
                var weight = parseInt($(element).data('weight'), 10);
                var hasilPerhitungan = (selectedValue / 5) * weight;
                hasilPerhitunganArray.push(hasilPerhitungan);

                var namaKolom = i + "_" + (index + 1);
                data[namaKolom] = hasilPerhitungan;
            });
        }

        data['employee_id'] = idCuy;
        data['jumlah'] = jumlah;

        var totalHasilPerhitungan = hasilPerhitunganArray.reduce((a, b) => a + b, 0);
        var totalFormatted = totalHasilPerhitungan.toFixed(2);
        data['hasil_akhir'] = totalFormatted;

        $(`#hasil-akhir`).text(totalFormatted);

        $("html, body").animate({ scrollTop: 0 }, "slow");

        var cekId = {
            employee_id: idCuy
        };

        $.ajax({
            url: '/cek-id-self-result',
            type: 'POST',
            dataType: 'json',
            contentType: 'application/json',
            data: JSON.stringify(cekId),
            success: function (response) {
                if (response.success) {
                    $('#submitBtn2').show();
                    $('#submitBtn3').show();
                    $('#submitBtn').hide();
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: response.message
                    }).then(() => {
                    });
                }
            },
            error: function () {
                Toast.fire({
                    icon: 'error',
                    title: "An error occurred while sending data"
                }).then(() => {
                });
            }
        });
    });

    $('#submitBtn').click(function() {
        var idCuy = $(this).data('id');
        var jumlah = $(this).data('count');

        var hasilPerhitunganArray = [];
        
        for (var i = 1; i <= jumlah; i++) {
            var hasilPerhitunganArrayX = [];
            var pj = $('select[name="nilai' + i + '"]').length;
    
            $('select[name="nilai' + i + '"]').each(function(index, element) {
                var selectedValue = parseInt($(element).val(), 10);
                var weight = parseInt($(element).data('weight'), 10);
                var hasilPerhitungan = (selectedValue / 5) * weight;
                var namaKolom = i + "_" + (index + 1);
    
                hasilPerhitunganArray.push(hasilPerhitungan);
                hasilPerhitunganArrayX.push(hasilPerhitungan);
                data[namaKolom] = hasilPerhitungan;
            });
    
            data['pj' + i] = pj;
        }
    
        var totalHasilPerhitungan = hasilPerhitunganArray.reduce((a, b) => a + b, 0);
        var totalFormatted = totalHasilPerhitungan.toFixed(2);
    
        data['employee_id'] = idCuy;
        data['hasil_akhir'] = totalFormatted;
        data['jumlah'] = jumlah;
    
        $(`#hasil-akhir`).text(totalFormatted);
        $("html, body").animate({ scrollTop: 0 }, "slow");

        var cekId = {
            employee_id: idCuy
        };

        $.ajax({
            url: '/cek-id-self-result',
            type: 'POST',
            dataType: 'json',
            contentType: 'application/json',
            data: JSON.stringify(cekId),
            success: function (response) {
                if (response.success) {
                    $('#submitBtn2').show();
                    $('#submitBtn3').show();
                    $('#submitBtn').hide();
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: response.message
                    }).then(() => {
                    });
                }
            },
            error: function () {
                Toast.fire({
                    icon: 'error',
                    title: "An error occurred while sending data"
                }).then(() => {
                });
            }
        });
    });

    $('#submitBtn3').click(function () {
        $('#submitBtn2').hide();
        $('#submitBtn3').hide();
        $('#submitBtn').show();
    });

    $('#submitBtn2').click(function () {
        $.ajax({
            url: '/add-self-result',
            type: 'POST',
            dataType: 'json',
            contentType: 'application/json',
            data: JSON.stringify(data),
            success: function (response) {
                if (response.success) {
                    Toast.fire({
                        icon: 'success',
                        title: "You have successfully assessed"
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: response.message
                    }).then(() => {
                    });
                }
            },
            error: function () {
                Toast.fire({
                    icon: 'error',
                    title: "An error occurred while sending data"
                }).then(() => {
                });
            }
        });
    });

});

function getDataAssessment() {
    $.ajax({
        url: '/data-tabel-self-assessment',
        method: 'GET',
        dataType: 'json',
        success: function (response) {
            $('.tabel-assessment tbody').empty();
            response.data.forEach(function (item) {
                var selectHTML = `
                    <select class="custom-select form-control-sm sele" name="nilai${item.status}" data-weight="${item.weight}">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                `;

                var row = `
                    <tr>
                        <td>${item.parameter}</td>
                        <td>${item.remark}</td>
                        <td>${item.weight}</td>
                        <td>${selectHTML}</td>
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
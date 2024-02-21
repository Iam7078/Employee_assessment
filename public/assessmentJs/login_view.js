$(document).ready(function () {
    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        iconColor: 'white',
        showConfirmButton: false,
        customClass: {
            popup: 'colored-toast',
        },
        timer: 1500,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
    });

    $('#btn-login').on('click', function () {
        event.preventDefault();
        var email = $("#email").val();
        var password = $("#password").val();

        if (!email || !password) {
            Toast.fire({
                icon: 'warning',
                title: 'Fill in all the data first',
            });
            return;
        }
        $.ajax({
            url: '/login-user',
            type: 'POST',
            dataType: 'json',
            data: JSON.stringify({ email: email, password: password }),
            contentType: 'application/json',
            success: function (response) {
                if (response.status === 'success') {
                    Toast.fire({
                        icon: 'success',
                        title: "Signed in successfully"
                    }).then(() => {
                        window.location.href = response.redirect;
                    });
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: response.message,
                    });
                }
            },
            error: function (xhr, textStatus, errorThrown) {
                Toast.fire({
                    icon: 'error',
                    title: 'Terjadi kesalahan saat mengirim permintaan.'
                });
            }
        });
    });
});
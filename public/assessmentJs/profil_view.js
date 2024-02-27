$(document).ready(function () {
    const password = document.getElementById('password').getAttribute('data-password');
    let pas = '';
    let pass = '';
    let Id = '';

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

    $('#btn-update-pass').on('click', function () {
        pas = $('#pass1').val();
        pass = $('#pass2').val();
        Id = $(this).data('id');

        if (!pas || !pass) {
            Toast.fire({
                icon: 'warning',
                title: "Fill in all the data first"
            }).then(() => {
            });
            return;
        }

        $.ajax({
            url: '/edit-password',
            type: 'POST',
            dataType: 'json',
            contentType: 'application/json',
            data: JSON.stringify({old_password: pas, password: pass, id: Id }),
            success: function (response) {
                if (response.success) {
                    Toast.fire({
                        icon: 'success',
                        title: "Successfully saved data"
                    }).then(() => {
                        $('#pass1').val('');
                        $('#pass2').val('');
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
});
$(document).ready(function () {
    $('#login').on('submit', function (event) {
        event.preventDefault();
        let username_value = $('#username').val();
        let password_value = $('#password').val();
        if (username_value != "") {
            $('#username').removeClass('input-error');
            $('#username-error').html('');
        } else {
            $('#username').addClass('input-error');
            $('#username-error').html('Username is required');
            return false;
        }

        if (password_value != "") {
            $('#password').removeClass('input-error');
            $('#password-error').html('');
        } else {
            $('#password').addClass('input-error');
            $('#password-error').html('Password is required');
            return false;
        }
        //Check captcha value
        if (validateForm() && username_value != "" && password_value != "") {
            $('#scode').removeClass('input-error');
            var formData = {
                action: 'login',
                username: username_value,
                password: password_value
            }
            $.ajax({
                type: 'POST',
                url: '../Controllers/LoginController.php',
                data: formData,
                dataType: 'json',
                success: function (response) {
                    console.log(response);
                    // let data = JSON.parse(response);
                    if (response.status === 'success') {
                        window.location.href = response.redirect;
                    } else if (response.status == 'error') {
                        $('#username').addClass('input-error');
                        $('#password').addClass('input-error');
                        Swal.fire({
                            title: "Error",
                            text: "Invalid username or password",
                            icon: "error"
                        });
                        refreshCaptcha();
                        document.getElementById('captchavalue').value = "";
                    } else if(response.status === 'warning') {
                        Swal.fire({
                            title: "warning",
                            text: response.message,
                            icon: "error"
                        });
                    }
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                    Swal.fire({
                        title: "Error",
                        text: "Something went wrong! Please try again.",
                        icon: "error"
                    });
                }
            })
        } else {
            $('#scode').addClass('input-error');
        }


    })
})
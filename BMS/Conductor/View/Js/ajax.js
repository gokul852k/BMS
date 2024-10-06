// Admin Logout Ajax
$(document).ready(function () {
    $('.logout').on('click', function (event) {
        event.preventDefault();
        var formData = {
            action: 'logout'
        }
        $.ajax({
            type: 'POST',
            url: '../Controllers/SessionController.php',
            data: formData,
            dataType: 'json',
            success: function (response) {
                if(response.status === 'success') {
                    let redirectUrl = '../../../Authentication/View/user_login.php';
                    window.location.href = redirectUrl;
                }
                else if (response.status === 'error') {
                    Swal.fire({
                        title: "Error",
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

    })
})

function changeLanguage(code) {
    var formData = {
        code: code,
        action: 'changeLanguage'
    }
    $.ajax({
        type: 'POST',
        url: '../Controllers/SessionController.php',
        data: formData,
        dataType: 'json',
        success: function (response) {
            if(response.status === 'success') {
                window.location.reload();
            }
            else if (response.status === 'error') {
                Swal.fire({
                    title: "Opps",
                    text: 'Error',
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

}

function toggleDropdown() {
    const dropdownMenu = document.querySelector('.dropdown-menu-l');
    dropdownMenu.style.display = (dropdownMenu.style.display === 'block') ? 'none' : 'block';
}

// Optional: Close the dropdown if clicking outside of it
document.addEventListener('click', function(event) {
    const dropdown = document.querySelector('.dropdown-l');
    if (!dropdown.contains(event.target)) {
        document.querySelector('.dropdown-menu-l').style.display = 'none';
    }
});
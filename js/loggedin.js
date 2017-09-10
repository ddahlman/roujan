$(document).ready(function () {
    const storage = sessionStorage.getItem('token');
    console.log(storage);
    $.get('http://localhost/roujan/api/?/login&token=' + storage)
        .then((response) => {
            const user = response.users[0].username;
            $('#user').append(`${user}`);
        }).fail((jqxhr, status, error) => {
            $('#error2').html(`request failed due to: ${status} and the problem was: ${error}`);
        });
    /*================ logout =======================*/

    $('.logOut').on('click', () => {
        $.ajax({
            url: "http://localhost/roujan/api/?/login",
            type: "DELETE",
            data: { logout: true },
            success: function (response) {
                session = "&token=" + response.session;
                sessionStorage.clear();
                window.location = 'index.php';
                console.log(session);
            }
        });
    });

});
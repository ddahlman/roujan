$(document).ready(function () {
    /*login form*/
    $('#loginForm').on('click', (e) => {
        e.preventDefault();
        let loginform = ` <div class='well col-sm-6 col-sm-offset-3'>
        <h1>Login</h1>
        <form class='form-horizontal'>
          <div class='form-group'>
            <label for="username">Användarnamn</label>
            <input type="text" id="username" class='form-control inp' placeholder="Användarnamn">
          </div>
          <div class='form-group'>
            <label for="password">Lösenord</label>
            <input type="password" id="password" class='form-control inp' placeholder="Lösenord">
          </div>
          <input class='btn btn-info' type="button" id='login-btn' value="Logga in">
          <span id='login-error'></span>
        </form>
      </div>`;
        $('#forms').html(loginform);
    });
    /*reg form*/
    $('#regForm').on('click', (e) => {
        e.preventDefault();
        let regform = ` <div class='well col-sm-6 col-sm-offset-3'>
        <h1>Registrering</h1>
        <form class='form-horizontal'>
          <div class='form-group'>
            <label for="username">Användarnamn</label>
            <input type="text" id="reg-username" class='form-control inp' placeholder="Användarnamn">
          </div>
          <div class='form-group'>
            <label for="password">Lösenord</label>
            <input type="password" id="reg-password" class='form-control inp' placeholder="Lösenord">
          </div>
          <input class='btn btn-info' type="button" id='reg-btn' value="Registrera dig">
          <span id='reg-success'></span>
        </form>
      </div>`;
        $('#forms').html(regform);
    });

    /*Login*/
    var session = "";
    var storage = sessionStorage.getItem('token');

    console.log(storage);
    $('.container').on('click', '#login-btn', (e) => {
        e.preventDefault();
        let login = {
            username: document.getElementById('username').value,
            password: document.getElementById('password').value
        };

        $.post('http://localhost/roujan/api/?/login', login).then((response) => {
            session = "&token=" + response.session;
            console.log(response);
            if (response.session === null || response.session === undefined) {
                let inputs = document.querySelectorAll('.inp');
                [...inputs].map(inp => inp.value = "");
                $('#login-error').html('fel login!');
            } else {
                sessionStorage.setItem('token', response.session);
                window.location.href = "home_load.php";

            }
        });
    });

    /*Registration*/
    $('.container').on('click', '#reg-btn', (e) => {
        e.preventDefault();
        let reg = {
            username: document.getElementById('reg-username').value,
            password: document.getElementById('reg-password').value
        };

        $.post('http://localhost/roujan/api/?/login', reg).then((response) => {

            let inputs = document.querySelectorAll('.inp');
            [...inputs].map(inp => inp.value = "");
            $('#reg-success').html('Du är registrerad!');
        });
    });


    /*   $('.checkLogin').on('click', () => {
          console.log(session);
          $.get('http://danieldahlman.se/api/?/login' + session)
              .then((response) => {
                  console.log(response);
              }).fail((jqxhr, status, error) => {
                  console.log(`request failed due to: ${status} and the problem was: ${error}`);
              });
  
      }); */


});
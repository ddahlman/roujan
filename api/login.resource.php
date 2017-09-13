<?php
#
# Den här klassen ska köras om vi anropat resursen user i vårt API genom /?/login
#
class _login extends Resource{ // Klassen ärver egenskaper från den generella klassen Resource som finns i resource.class.php
    # Här deklareras de variabler/members som objektet ska ha
    public $id, $name, $users, $request;
    # Här skapas konstruktorn som körs när objektet skapas
    function __construct($resource_id, $request){
        
        # Om vi fått med ett id på resurser (Ex /?/login/15) och det är ett nummer sparar vi det i objektet genom $this->id
        if(is_numeric($resource_id))
        $this->id = $resource_id;
        # Vi sparar också det som kommer med i URL:en efter vårt id som en array
        $this->request = $request;
    }
    # Denna funktion körs om vi anropat resursen genom HTTP-metoden GET
    function GET($input, $db){
        $this->id = $_SESSION['login_user'];
    }
    
    function POST($input, $db) {
        $username = escape($input['username']);
        $password = escape($input['password']);
        
        $salt = 'MinaFöräldrarsHemIRoujanMåsteHaSäkerhetEllerVadTYckerDu?0243';
        $password = crypt($password, $salt);
        
        $query = "SELECT * FROM login
        WHERE username = '$username'
        AND password = '$password'";
        
        $result = mysqli_query($db, $query);
        /*  $this->name = $user['username'];
        $this->id = $user['id']; */
        
        if (mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);
            $_SESSION['login_user'] = $user['id'];//sets the key to login_user and the value to $id
            $this->session = session_id();
        }
    }
    function DELETE(){
        session_destroy();
        if(isset( $_SESSION['login_user'] ))
        echo "nått gick fel";
    }
    
}
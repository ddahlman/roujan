<?php
#
# Den här klassen ska köras om vi anropat resursen user i vårt API genom /?/login
#
class _user extends Resource{ // Klassen ärver egenskaper från den generella klassen Resource som finns i resource.class.php
    # Här deklareras de variabler/members som objektet ska ha
    public $id, $firstname, $lastname, $email, $phone, $users, $request;
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
        if($this->id){ // Om vår URL innehåller ett ID på resursen hämtas bara den usern
            $query = "SELECT *
            FROM user
            WHERE id = $this->id";
            
            $result = mysqli_query($db, $query);
            $user = mysqli_fetch_assoc($result);
            $this->firstname = $user['firstname'];
            
        }else{ // om vår URL inte innehåller ett ID hämtas alla users
            $query = "SELECT *
            FROM user
            ";
            $result = mysqli_query($db, $query);
            $data = [];
            while($row = mysqli_fetch_assoc($result)){
                $data[] = $row;
            }
            $this->users = $data;
        }
    }
    
    function POST($input, $db) {
        $firstname = escape($input['firstname']);
        $lastname = escape($input['lastname']);
        
        $query = "INSERT INTO user (firstname, lastname)
        VALUES ('$firstname', '$lastname')";
        
        if(mysqli_query($db, $query)) {
            $this->firstname = $firstname;
            $this->lastname = $lastname;
        }
    }
}
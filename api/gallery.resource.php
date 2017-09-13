<?php
#
# Den här klassen ska köras om vi anropat resursen user i vårt API genom /?/user
#
class _gallery extends Resource{ // Klassen ärver egenskaper från den generella klassen Resource som finns i resource.class.php
    # Här deklareras de variabler/members som objektet ska ha
    public $id, $dir, $request;
    # Här skapas konstruktorn som körs när objektet skapas
    function __construct($resource_id, $request){
        
        # Om vi fått med ett id på resurser (Ex /?/user/15) och det är ett nummer sparar vi det i objektet genom $this->id
        if(is_numeric($resource_id))
        $this->id = $resource_id;
        # Vi sparar också det som kommer med i URL:en efter vårt id som en array
        $this->request = $request;
    }
    # Denna funktion körs om vi anropat resursen genom HTTP-metoden GET
    function GET($input, $db){
        if($this->id){ // Om vår URL innehåller ett ID på resursen hämtas bara den usern
            $query = "SELECT *
            FROM login
            WHERE id = $this->id";
            
            $result = mysqli_query($db, $query);
            $user = mysqli_fetch_assoc($result);
            $this->name = $user['username'];
            
        }else{ // om vår URL inte innehåller ett ID hämtas alla users
            $query = "SELECT *
            FROM login
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
        // loop through the array of files, $key is like index
        foreach($_FILES['files']['name'] as $key => $file) {
            $dir = '../img/gallery/' . $file;
            
            move_uploaded_file($_FILES['files']['tmp_name'][$key], $dir);
            $query = "INSERT INTO gallery (dir)
            VALUES ('$dir')";
            
            mysqli_query($db, $query);
        }
    }
}
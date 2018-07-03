<?php
#
# Den här klassen ska köras om vi anropat resursen user i vårt API genom /?/user
#
class _galleryheader extends Resource{ // Klassen ärver egenskaper från den generella klassen Resource som finns i resource.class.php
    # Här deklareras de variabler/members som objektet ska ha
    public $id, $header, $allheaders, $header_images, $request;
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
        # Här kollar vi om det efterfrågats en "collection" inom resursen, exempelvis "friends" i URL:en /?/user/15/friends
        $collection = "";
        if(isset($this->request[0])) $collection = $this->request[0];
        # Beroende på vilken "collection" som anropats gör vi olika saker
        switch($collection){
            case 'images':
                if($this->id){ // Om vår URL innehåller ett ID på resursen hämtas bara den usern
                    $query = "SELECT g.dir, g.id
                    FROM galleryheader AS gh INNER JOIN
                    gallery AS g ON
                    gh.headerID = g.headerID
                    WHERE gh.headerID = $this->id";
                    
                    $result = mysqli_query($db, $query);
                    $data = [];
                    while($row = mysqli_fetch_assoc($result)){
                        $data[] = $row;
                }
                $this->header_images = $data;
            }
            break;
        
        default: // Om det inte är en collection, eller om den inte är definierad ovan
            $this->getUserData($input, $db);
    }
}
# Den här funktionen är privat och kan bara köras inom objektet, inte utanför
private function getUserData($input, $db){
    if($this->id){ // Om vår URL innehåller ett ID på resursen hämtas bara den usern
        $query = "SELECT *
        FROM galleryheader
        WHERE headersID = $this->id";
        
        $result = mysqli_query($db, $query);
        $header = mysqli_fetch_assoc($result);
        $this->header = $header['header'];
        
    }else{ // om vår URL inte innehåller ett ID hämtas alla users
        $query = "SELECT *
        FROM galleryheader
        ";
        $result = mysqli_query($db, $query);
        $data = [];
        while($row = mysqli_fetch_assoc($result)){
            $data[] = $row;
        }
        $this->allheaders = $data;
    }
}

# Denna funktion körs om vi anropat resursen genom HTTP-metoden PUT
function PUT($input, $db){
    # I denna funktion uppdateras en specifik user med den input vi fått
    # Observera att allt uppdaterad varje gång och att denna borde byggas om så att bara det vi skickar med uppdateras
    if($this->id){
        $header = escape($input['header']);
        
        $query = "UPDATE galleryheader
        SET header = '$header'
        WHERE headersID = $this->id
        ";
        if(mysqli_query($db, $query)) {
            $this->header = $header;
        }
    }else{
        echo "No resource given";
    }
}
}
<?php 

    function getContacts(){
        include 'db.php';
        try {
            return $conn->query("SELECT * FROM contactos");
        } catch (Exception $e){
            echo "Error!!".$e->getMessage()."<br>";
            return false;
        }
    }

    // Obtiene un contacto y toma un id
    // Get a contact and id
    function getContact($id){
        include 'db.php';
        try {
            return $conn->query("SELECT * FROM contactos WHERE id = $id");
        } catch (Exception $e){
            echo "Error!!".$e->getMessage()."<br>";
            return false;
        }
    }

?>
<?php
$action = isset($_POST['action'])?$_POST['action']:$_GET['action'];

if($action == 'create'){
    // Creara un nuevo registro en la base de datos.
    // Create a new register in database.
    require_once('../functions/db.php');

    // Validar entradas
    // Validate entries
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $business = filter_var($_POST['business'], FILTER_SANITIZE_STRING);
    $phone = filter_var($_POST['phone'], FILTER_SANITIZE_STRING);

    try {
        $stmt = $conn->prepare("INSERT INTO contactos (nombre, empresa, telefono) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $business, $phone);
        $stmt->execute();
        if($stmt->affected_rows == 1){
            $answer = array(
                'answer' => 'right',
                'insert_id' => $stmt->insert_id,
                'data' => array(
                    'name' => $name,
                    'business' => $business,
                    'phone' => $phone,
                    'insert_id' => $stmt->insert_id
                )
            );
        }

        $stmt->close();
        $conn->close();

    } catch (Exception $e) {
        $answer = array(
            'error' => $e->getMessage()
        );
    }

    echo json_encode($answer);
}
elseif($action == 'delete'){
    // Creara un nuevo registro en la base de datos.
    // Create a new register in database.
    require_once('../functions/db.php');

    // Validar entradas
    // Validate entries
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    try {
        $stmt = $conn->prepare("DELETE FROM contactos WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        if($stmt->affected_rows == 1):
            $answer = array(
                'answer' => 'right'
            );
        endif;

        $stmt->close();
        $conn->close();

    } catch (Exception $e) {
        $answer = array(
            'error' => $e->getMessage()
        );
    }

    echo json_encode($answer);
}

elseif($action == 'edit'){
    // Creara un nuevo registro en la base de datos.
    // Create a new register in database.
    require_once('../functions/db.php');

    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $business = filter_var($_POST['business'], FILTER_SANITIZE_STRING);
    $phone = filter_var($_POST['phone'], FILTER_SANITIZE_STRING);
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);

    try{
        $stmt = $conn->prepare("UPDATE contactos SET nombre = ?, empresa = ?, telefono = ? WHERE id = ?");
        $stmt->bind_param("sssi", $name, $business, $phone, $id);
        $stmt->execute();
        if($stmt->affected_rows == 1){
            $answer = array(
                'answer' => 'right'
            );
        }else{
            $answer = array(
                'answer' => 'error'
            );
        }
        $stmt->close();
        $conn->close();

    }catch (Exception $e) {
        $answer = array(
            'error' => $e->getMessage()
        );
    }

    echo json_encode($answer);

}
?> 
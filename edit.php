<?php 
include 'includes/functions/functions.php';
include 'includes/layouts/header.php';

$id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
if(!$id){
    die('No es valido');
}

$result = getContact($id);
$contact = $result->fetch_assoc();
?>
<div class="bar-container">
    <div class="container bar">
        <a href="./" class="btn back">Volver</a>
        <h1>Editar Contacto</h1>
    </div>
</div>

<div class="bg-cornflower-black container shadow">
    <form id="contact" action="#">
        <legend>Edite el contacto</legend>
        <?php include 'includes/layouts/form.php'; ?>
    </form>
</div>

<?php include 'includes/layouts/footer.php'; ?>

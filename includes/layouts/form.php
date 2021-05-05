<?php
    $id = isset($contact['id'])?$contact['id']:'';
    $name = isset($contact['nombre'])?$contact['nombre']:'';
    $business = isset($contact['empresa'])?$contact['empresa']:'';
    $phone = isset($contact['telefono'])?$contact['telefono']:'';
    $btnValue = isset($contact['nombre'])? 'Guardar': 'Añadir';
    $action = isset($contact['id'])? 'edit': 'create';
?>

<div class="fields">
    <div class="field">
        <label for="name">Nombre:</label>
        <input type="text" placeholder="Nombre Contacto" id="name" value="<?php echo $name; ?>">
    </div>

    <div class="field">
        <label for="business">Empresa:</label>
        <input type="text" placeholder="Empresa Contacto" id="business" value="<?php echo $business; ?>">
    </div>

    <div class="field">
        <label for="phone">Telefono:</label>
        <input type="tel" placeholder="Numero Contacto" id="phone" value="<?php echo $phone; ?>">
    </div>
</div>

<div class="field send">
    <input type="hidden" id="action" value="<?php echo $action; ?>">
    <input type="hidden" id="id" value="<?php echo $id; ?>">
    <input type="submit" value="<?php echo $btnValue; ?>">
</div>
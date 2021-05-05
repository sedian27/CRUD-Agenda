<?php
    include 'includes/functions/functions.php';
    include 'includes/layouts/header.php'; 
?>

<div class="bar-container">
    <h1>Agenda de Contactos</h1>
</div>

<div class="bg-cornflower-black container shadow">
    <form id="contact" action="#">
        <legend>Añada un contacto <span>Todos los campos son obligatorios</span></legend>
        <?php include 'includes/layouts/form.php'; ?>
    </form>
</div>

<div class="bg-cornflower container shadow contacts">
    <div class="contacts-container">
        <h2>Contactos</h2>
        <input type="text" id="search" class="seeker shadow" placeholder="Buscar Contactos...">
        <p class="total-contacts"><span>0</span> Contactos</p>

        <div class="table-container"> 
            <table id="list-contacts" class="list-contacts">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Empresa</th>
                        <th>Teléfono</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php $contacts = getContacts();
                    if($contacts->num_rows):
                        foreach($contacts as $contact):
                    ?>
                    <tr>
                        <td><?php echo $contact['nombre']; ?></td>
                        <td><?php echo $contact['empresa']; ?></td>
                        <td><?php echo $contact['telefono']; ?></td>
                        <td>
                            <a class="btn btn-edit" href="edit.php?id=<?php echo $contact['id']; ?>"><i class="fas fa-pen-square"></i></a>
                            <button data-id="<?php echo $contact['id']; ?>" type="button" class="btn btn-delete">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                <?php 
                        endforeach;
                    endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'includes/layouts/footer.php'; ?>
const formContacts = document.querySelector('#contact'),
      listContacts = document.querySelector('#list-contacts tbody'),
      browserInput = document.querySelector('#search');

eventListeners();

function eventListeners(){
    // Cuando el formulario de crear o editar se ejecuta:
    // when the form to create or edit execute:
    formContacts.addEventListener('submit', readForm);

    // Listener para eliminar el boton.
    // Listener for delete the button. 
    if(listContacts){
        listContacts.addEventListener('click', deleteContact);
    }

    //Browser
    browserInput.addEventListener('input', searchContact);
    contactsAmount();
}

function readForm(e){
    e.preventDefault();
    // Leer datos de los inputs:
    // read data of the inputs:
    const name = document.querySelector('#name').value,
          business = document.querySelector('#business').value,
          phone = document.querySelector('#phone').value,
          action = document.querySelector('#action').value;
    if(name == '' || business == '' || phone == ''){
        // 2 parametros texto y clase
        // 2 parameters text and class
        showNotification('Todos los campos son Obligatorios', 'error');
    }else{
        // Pasa validación, crear llamado a ajax.
        // Pass validation, create ajax call.
        const infoContact = new FormData();
        infoContact.append('name', name);
        infoContact.append('business', business);
        infoContact.append('phone', phone);
        infoContact.append('action', action);

        if(action == 'create'){
            // Crear un nuevo contacto.
            // Create a new contact.
            insert(infoContact);
        }else{
            // Editar el contacto.
            // Edit the contact.
            const contactId = document.querySelector('#id').value;
            infoContact.append('id', contactId);
            updateContact(infoContact);
        }
    }
}

// Inserta en la base de datos vía Ajax.
// Insert to the database with Ajax.

function insert(data){
    // Llamado a Ajax.
    // Call Ajax.

    // Crear el objeto.
    // Create object.
    const xhr = new XMLHttpRequest();

    // Abrir conexión.
    // Open conection.
    xhr.open('POST', 'includes/models/contact-model.php', true);

    // Pasar los datos.
    // Pass data.
    xhr.onload = function(){
        if(this.status == 200){
            // Leer respuesta de php
            // read the answer from php
            const answer = JSON.parse(xhr.responseText);

            // inserta un nuevo elemento a la tabla
            // insert new element in table
            const newContact = document.createElement('tr');
            newContact.innerHTML = `
            <td>${answer.data.name}</td>
            <td>${answer.data.business}</td>
            <td>${answer.data.phone}</td>
            `;

            // crear contenedor para los botones.
            // create container for buttons.
            const containerActions = document.createElement('td');

            // crear icono de editar.
            // create edit icon.
            const editIcon = document.createElement('i');
            editIcon.classList.add('fas', 'fa-pen-square');

            // crea el enlace para editar
            // create link to edit
            const btnEdit = document.createElement('a');
            btnEdit.appendChild(editIcon);
            btnEdit.href = `edit.php?id=${answer.data.insert_id}`;
            btnEdit.classList.add('btn','btn-edit');

            // Agregar al padre.
            // Add to father.
            containerActions.appendChild(btnEdit);

            // crear icono de eliminar
            // create delete icon.
            const deleteIcon = document.createElement('i');
            deleteIcon.classList.add('fas', 'fa-trash-alt');

            // create boton de eliminar.
            // create delete button.
            const btnDelete = document.createElement('button');
            btnDelete.appendChild(deleteIcon);
            btnDelete.setAttribute('data-id', answer.data.insert_id);
            btnDelete.classList.add('btn','btn-delete');

            // Agregar al padre.
            // Add to father.
            containerActions.appendChild(btnDelete);

            // Agregarlo al tr
            // Add to tr
            newContact.appendChild(containerActions);

            // Agregarlos con los contactos
            // Add with the contacts
            listContacts.appendChild(newContact);

            // Reiniciar formulario
            // Reset Form
            document.querySelector('form').reset();
            // Mostrar la notificacion
            // Show notification.
            showNotification('Contacto agregado correctamente', 'right');
            contactsAmount();
        }
    }

    // Enviar los datos.
    // Send data.
    xhr.send(data);
}

// Actualizar contacto
// Update contact
function updateContact(data){
    // Create object
    const xhr = new XMLHttpRequest();

    // Open conecction
    xhr.open('POST', 'includes/models/contact-model.php', true);
    // read answer
    xhr.onload = function(){
        if(this.status == 200){
            const answer = JSON.parse(xhr.responseText);
            if(answer.answer == 'correcto'){
                // show notification
                showNotification('Contacto editado correctamente','right');
            }else{
                showNotification('Hubo un error','error');
            }
            // After 3 seconds redirect to index
            setTimeout(()=>{
                window.location.href('/');
            }, 4000);
        }
    }
    // send data
    xhr.send(data);
}

// Eliminar Contacto
// Delete contact

function deleteContact(e){
    if(e.target.parentElement.classList.contains('btn-delete')){
        // Tomar id
        // Get id
        const id = e.target.parentElement.getAttribute('data-id');

        // preguntar si están seguros de eliminar el contacto.
        // ask if they are sure to delete contact.
        const answer = confirm('¿Estás seguro(a)?')
        if(answer){
            // Llamado a Ajax.
            // Call Ajax.

            // Crear el objeto.
            // Create object.
            const xhr = new XMLHttpRequest();

            // Abrir conexión.
            // Open conection.
            xhr.open('GET', `includes/models/contact-model.php?id=${id}&action=delete`, true);

            // Pasar los datos.
            // Pass data.
            xhr.onload = function(){
                if(this.status == 200){
                    // Leer el resultado de php
                    // read the result from php
                    const result = JSON.parse(xhr.responseText);
                    if(result.answer == 'right'){
                        // Eliminar el contacto del DOM
                        // Delete the contact of the DOM
                        console.log(e.target.parentElement.parentElement.parentElement);
                        e.target.parentElement.parentElement.parentElement.remove();
                        // Mostrar una notificación
                        // Show notification
                        showNotification('Contacto eliminado','right');
                        contactsAmount();
                    }else{
                        // Mostrar una notificación
                        // Show notification
                        showNotification('Hubo un error...','error');
                    }
                }
            }

            // Enviar los datos.
            // Send data.
            xhr.send();
        }

    }
}

// Search contact
function searchContact(e){
    const expression = new RegExp(e.target.value, "i"),
          contacts = document.querySelectorAll('tbody tr');

          contacts.forEach(contact => {
              contact.style.display = 'none';
              if(contact.childNodes[1].textContent.replace(/\s/g," ").search(expression) != -1){
                contact.style.display = 'table-row';
              }
              contactsAmount();
          })
}

// Notificacion en pantalla.
// On-screen notification.
function showNotification(message, Class){
    const notification = document.createElement('div');
    notification.classList.add(Class, 'notification', 'shadow');
    // Text to show:
    notification.textContent = message;

    // formulario:
    // form:
    formContacts.insertBefore(notification, document.querySelector('form legend'));

    // Ocultar y mostrar notificación
    // Hide and show notification
    setTimeout(() => {
        notification.classList.add('visible');
        setTimeout(() => {
            notification.classList.remove('visible');
            setTimeout(() => {
                notification.remove();
            }, 500);
        }, 3000);
    }, 100);
}

// contacts amount
function contactsAmount(){
    const totalContacts = document.querySelectorAll('tbody tr'),
          numberContainer = document.querySelector('.total-contacts span');
    let total = 0;
    totalContacts.forEach(contact => {
        if(contact.style.display == '' || contact.style.display == 'table-row'){
            total++;
        }
    });

    numberContainer.textContent = total;
}

App.Pages.Whatsapp_settings = (function () {
    const $saveSettings = $('#save-settings'); 
    const $sendWhatsappSettings = $('#send-whatsapp-settings'); 

    /**
     * Check if the form has invalid values.
     *
     * @return {Boolean}
     */
    function isInvalid() {
        try {
            $('#whatsapp-settings .is-invalid').removeClass('is-invalid');

            // Validate required fields.

            let missingRequiredFields = false;

            $('#whatsapp-settings .required').each((index, requiredField) => {
                const $requiredField = $(requiredField);

                if (!$requiredField.val()) {
                    $requiredField.addClass('is-invalid');
                    missingRequiredFields = true;
                }
            });

            if (missingRequiredFields) {
                throw new Error(lang('fields_are_required'));
            }

            return false;
        } catch (error) {
            App.Layouts.Backend.displayNotification(error.message);
            return true;
        }
    }

    /**
    function deserialize(whatsappSettings) {
        whatsappSettings.forEach((whatsappSetting) => {
            const $field = $('[data-field="' + whatsappSetting.name + '"]');

            $field.is(':checkbox')
                ? $field.prop('checked', Boolean(Number(whatsappSetting.value)))
                : $field.val(whatsappSetting.value);
        });
    }

    function serialize() {
        const whatsappSettings = [];

        $('[data-field]').each((index, field) => {
            const $field = $(field);

            whatsappSettings.push({
                name: $field.data('field'),
                value: $field.is(':checkbox') ? Number($field.prop('checked')) : $field.val(),
            });
        });

        return whatsappSettings;
    }

    /**
     * Save the account information.
     
    function onSaveSettingsClick() {
        if (isInvalid()) {
            App.Layouts.Backend.displayNotification(lang('settings_are_invalid'));

            return;
        }

        const whatsappSettings = serialize();

        App.Http.WhatsappSettings.save(whatsappSettings).done(() => {
            App.Layouts.Backend.displayNotification(lang('settings_saved'));
        });
    }
    */

    /**
     * My code Debut : Function send_message_whatsapp
     */
    

    function onSendMessageWhatsapp() { 
        console.log("#########################");
        console.log("onSendMessageWhatsapp onSendMessageWhatsapp");

        // ########################  BLOC 1  ##############################


        // Numéro du destinataire et message prédéfini
        // const phoneNumber = '261329217076'; // Numéro du destinataire
        // const message = 'Bonjour, ceci est un message automatisé.';

        // URL de WhatsApp Web avec numéro et message encodé
        //const whatsappUrl = `https://web.whatsapp.com/send?phone=${phoneNumber}&text=${encodeURIComponent(message)}`;
        
        // Ouvre WhatsApp Web dans un nouvel onglet
        //window.open(whatsappUrl, '_blank');


        // ########################  BLOC 2  ##############################



        // const phoneNumbers = ['261329217076', '33612751881', '33614965961']; // Ajouter les numéros souhaités
        // const message = 'Bonjour, ceci est un message automatisé.';

        // const linksContainer = document.getElementById('whatsapp-settings');
        // linksContainer.innerHTML = ''; 

        // phoneNumbers.forEach((number) => {
        //     const whatsappUrl = `https://web.whatsapp.com/send?phone=${number}&text=${encodeURIComponent(message)}`;
        //     const linkElement = document.createElement('a');
        //     linkElement.href = whatsappUrl;
        //     linkElement.target = '_blank';
        //     linkElement.textContent = `Envoyer message à ${number}`;
        //     linkElement.style.display = 'block';
        //     linksContainer.appendChild(linkElement);
        // });



        // ########################  BLOC 3  ##############################

        // const phoneNumbers = ['261329217076', '33612751881', '33614965961']; // Ajouter les numéros souhaités
        // const message = 'Bonjour, ceci est un message automatisé.';

        // // Sélectionner le conteneur où le tableau sera ajouté
        // const linksContainer = document.getElementById('whatsapp-settings');
        // linksContainer.innerHTML = ''; // Vider le conteneur au cas où

        // // Créer le tableau
        // const table = document.createElement('table');
        // table.classList.add('table', 'table-striped');

        // // Créer l'en-tête du tableau
        // const thead = document.createElement('thead');
        // const headerRow = document.createElement('tr');

        // // Colonne "Message à envoyer"
        // const messageHeader = document.createElement('th');
        // messageHeader.textContent = 'Message à envoyer';
        // headerRow.appendChild(messageHeader);

        // // Colonne "Client"
        // const clientHeader = document.createElement('th');
        // clientHeader.textContent = 'Clients';
        // headerRow.appendChild(clientHeader);

        // thead.appendChild(headerRow);
        // table.appendChild(thead);

        // // Créer le corps du tableau
        // const tbody = document.createElement('tbody');

        // phoneNumbers.forEach((number) => {
        //     const whatsappUrl = `https://web.whatsapp.com/send?phone=${number}&text=${encodeURIComponent(message)}`;

        //     // Créer une ligne pour chaque numéro
        //     const row = document.createElement('tr');

        //     // Colonne pour le message
        //     const messageCell = document.createElement('td');
        //     messageCell.textContent = message;
        //     row.appendChild(messageCell);

        //     // Colonne pour le client (numéro de téléphone avec lien)
        //     const clientCell = document.createElement('td');
        //     const linkElement = document.createElement('a');
        //     linkElement.href = whatsappUrl;
        //     linkElement.target = '_blank';
        //     linkElement.textContent = `Envoyer message à ${number}`;
        //     clientCell.appendChild(linkElement);
        //     row.appendChild(clientCell);

        //     // Ajouter la ligne au corps du tableau
        //     tbody.appendChild(row);
        // });

        // // Ajouter le corps du tableau au tableau principal
        // table.appendChild(tbody);

        // // Ajouter le tableau au conteneur
        // linksContainer.appendChild(table);
            



    // ########################  BLOC 4  ##############################



    // const phoneNumbers = ['261329217076', '33612751881', '33614965961', '776992092']; // Ajouter les numéros souhaités
    // const message = 'Bonjour, ceci est un message automatisé.';

    // // Sélectionner le conteneur où le tableau sera ajouté
    // const linksContainer = document.getElementById('whatsapp-settings');
    // linksContainer.innerHTML = ''; // Vider le conteneur au cas où

    // // Créer le tableau
    // const table = document.createElement('table');
    // table.classList.add('table', 'table-striped');

    // // Créer l'en-tête du tableau
    // const thead = document.createElement('thead');
    // const headerRow = document.createElement('tr');

    // // Colonne "No"
    // const numberHeader = document.createElement('th');
    // numberHeader.innerHTML = 'N<sup>o</sup>'; // Le "o" en exposant
    // headerRow.appendChild(numberHeader);

    // // Colonne "Message à envoyer"
    // const messageHeader = document.createElement('th');
    // messageHeader.textContent = 'Message à envoyer';
    // headerRow.appendChild(messageHeader);

    // // Colonne "Client"
    // const clientHeader = document.createElement('th');
    // clientHeader.textContent = 'Client';
    // headerRow.appendChild(clientHeader);

    // thead.appendChild(headerRow);
    // table.appendChild(thead);

    // // Créer le corps du tableau
    // const tbody = document.createElement('tbody');

    // phoneNumbers.forEach((number, index) => {
    //     const whatsappUrl = `https://web.whatsapp.com/send?phone=${number}&text=${encodeURIComponent(message)}`;

    //     // Créer une ligne pour chaque numéro
    //     const row = document.createElement('tr');

    //     // Colonne pour le numéro de ligne
    //     const numberCell = document.createElement('td');
    //     numberCell.textContent = index + 1; // Affiche le numéro de ligne automatiquement
    //     row.appendChild(numberCell);

    //     // Colonne pour le message
    //     const messageCell = document.createElement('td');
    //     messageCell.textContent = message;
    //     row.appendChild(messageCell);

    //     // Colonne pour le client (numéro de téléphone avec lien)
    //     const clientCell = document.createElement('td');
    //     const linkElement = document.createElement('a');
    //     linkElement.href = whatsappUrl;
    //     linkElement.target = '_blank';
    //     linkElement.textContent = `Envoyer message à ${number}`;
    //     clientCell.appendChild(linkElement);
    //     row.appendChild(clientCell);

    //     // Ajouter la ligne au corps du tableau
    //     tbody.appendChild(row);
    // });

    // // Ajouter le corps du tableau au tableau principal
    // table.appendChild(tbody);

    // // Ajouter le tableau au conteneur
    // linksContainer.appendChild(table);


        
    // ########################  BLOC 4  ##############################


    
    const phoneNumbers = [
        { number: '261329217076', name: 'Monsieur Ali' },
        { number: '33612751881', name: 'Monsieur Baye' },
        { number: '33614965961', name: 'Monsieur Arfan' },
        { number: '776992092', name: 'Monsieur Adrien' }
    ];
    
    const message = 'Bonjour, ceci est un message automatisé. Pour votre rendez-vous chez Coridigital';
    
    // Sélectionner le conteneur où le tableau sera ajouté
    const linksContainer = document.getElementById('whatsapp-settings');
    linksContainer.innerHTML = ''; // Vider le conteneur au cas où
    
    // Créer le tableau
    const table = document.createElement('table');
    table.classList.add('table', 'table-striped');
    
    // Créer l'en-tête du tableau
    const thead = document.createElement('thead');
    const headerRow = document.createElement('tr');
    
    // Colonne "No"
    const numberHeader = document.createElement('th');
    numberHeader.innerHTML = 'N<sup>o</sup>'; // Le "o" en exposant
    headerRow.appendChild(numberHeader);
    
    // Colonne "Client"
    const clientHeader = document.createElement('th');
    clientHeader.textContent = 'Client';
    headerRow.appendChild(clientHeader);
    
    // Colonne "Téléphone"
    const phoneHeader = document.createElement('th');
    phoneHeader.textContent = 'Téléphone';
    headerRow.appendChild(phoneHeader);
    
    // Colonne "Envoyer"
    const actionHeader = document.createElement('th');
    actionHeader.textContent = 'Action';
    headerRow.appendChild(actionHeader);
    
    thead.appendChild(headerRow);
    table.appendChild(thead);
    
    // Créer le corps du tableau
    const tbody = document.createElement('tbody');
    
    phoneNumbers.forEach((entry, index) => {
        const whatsappUrl = `https://web.whatsapp.com/send?phone=${entry.number}&text=${encodeURIComponent(message)}`;
    
        // Créer une ligne pour chaque numéro
        const row = document.createElement('tr');
    
        // Colonne pour le numéro de ligne
        const numberCell = document.createElement('td');
        numberCell.textContent = index + 1; // Affiche le numéro de ligne automatiquement
        row.appendChild(numberCell);
    
        // Colonne pour le client (nom)
        const clientCell = document.createElement('td');
        clientCell.textContent = entry.name;
        row.appendChild(clientCell);
    
        // Colonne pour le téléphone
        const phoneCell = document.createElement('td');
        phoneCell.textContent = entry.number;
        row.appendChild(phoneCell);
    
        // Colonne pour le bouton "Envoyer"
        const actionCell = document.createElement('td');
        const sendButton = document.createElement('button');
        sendButton.textContent = 'Envoyer';
        sendButton.classList.add('btn', 'btn-success');
        sendButton.onclick = () => {
            window.open(whatsappUrl, '_blank');
        };
        actionCell.appendChild(sendButton);
        row.appendChild(actionCell);
    
        // Ajouter la ligne au corps du tableau
        tbody.appendChild(row);
    });
    
    // Ajouter le corps du tableau au tableau principal
    table.appendChild(tbody);
    
    // Ajouter le tableau au conteneur
    linksContainer.appendChild(table);

    


        console.log("#########################");
    }

    /**
     * My code Fin : Function send_message_whatsapp
     */




    /**
     * Initialize the module.
     */
    function initialize() {
        /**
        $saveSettings.on('click', onSaveSettingsClick);
        */
        $sendWhatsappSettings.on('click',onSendMessageWhatsapp);

        const whatsappSettings = vars('whatsapp-settings');
        /**
        deserialize(whatsappSettings);
        */
    }

    document.addEventListener('DOMContentLoaded', initialize);

    return {};
})();

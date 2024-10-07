<?php extend('layouts/backend_layout'); ?>

<?php section('styles'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<?php end_section('styles'); ?>

<?php section('content'); ?>

<div id="whatsapp-send-message-page" class="container-fluid backend-page">
    <div class="row mb-4">
        <div class="col-sm-3 offset-sm-1">
            <?php component('settings_nav'); ?>
        </div> 
        <div id="whatsapp-send-message" class="col-sm-6">
            <form>
                <fieldset>
                    <div class="d-flex justify-content-between align-items-center border-bottom mb-4 py-2">
                        <h4 class="text-black-50 mb-0 fw-light">
                            <?= lang('whatsapp_send_message')?>
                        </h4>

                        <div>
                            <a href="<?= site_url('customers') ?>" class="btn btn-outline-primary me-2">
                                <i class="fas fa-chevron-left me-2"></i>
                                <?= lang('back') ?>
                            </a>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div id="appointments-table-container" class="mb-3">

                            </div>
                        </div>
                    </div>

                    <?php slot('after_primary_appointment_fields'); ?>
                </fieldset>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const url = 'whatsapp_settings/getAppointments'; // URL pour récupérer les rendez-vous
            const linksContainer = document.getElementById('appointments-table-container');
            linksContainer.innerHTML = ''; // Vider le conteneur avant d'ajouter le tableau

            // Fonction pour formater la date et l'heure
            function formatDateTime(datetime) {
                const dateObj = new Date(datetime);
                const optionsDate = { year: 'numeric', month: 'long', day: 'numeric' }; // Format de la date
                const optionsTime = { hour: '2-digit', minute: '2-digit' }; // Format de l'heure

                return {
                    date: dateObj.toLocaleDateString('fr-FR', optionsDate),  // Format de la date
                    time: dateObj.toLocaleTimeString('fr-FR', optionsTime)    // Format de l'heure
                };
            }

            // Requête AJAX pour récupérer les rendez-vous
            fetch(url)
                .then(response => response.json())
                .then(appointments => {
                    if (appointments.error) {
                        linksContainer.textContent = 'Erreur lors de la récupération des rendez-vous.';
                        return;
                    }

                    // Créer le tableau
                    const table = document.createElement('table');
                    table.classList.add('table', 'table-striped', 'table-bordered', 'table-sm');

                    // En-tête du tableau
                    const thead = document.createElement('thead');
                    const headerRow = document.createElement('tr');
                    ['N°', 'Client', 'Téléphone', 'Jour', 'Heures', 'Service', 'Statut', 'Action'].forEach(text => {
                        const th = document.createElement('th');
                        th.textContent = text;
                        headerRow.appendChild(th);
                    });
                    thead.appendChild(headerRow);
                    table.appendChild(thead);

                    // Corps du tableau
                    const tbody = document.createElement('tbody');
                    table.appendChild(tbody);

                    // Parcourir les rendez-vous
                    appointments.forEach((appointment, index) => {
                        const url_client = `whatsapp_settings/getClientsWithRoleAndAppointments/${appointment.id_users_customer}`;
                        
                        // Formater les dates et heures
                        const startDate = formatDateTime(appointment.start_datetime);
                        const endDate = formatDateTime(appointment.end_datetime);

                        // pour chaque rendez-vous récupere le service associé
                        const url_service = `whatsapp_settings/getClientsWithRoleAndAppointmentsAndService/${appointment.id_services}`;
                        fetch(url_service)
                            .then(response => response.json())
                            .then(services => {
                                if (services.error || services.length === 0) {
                                    console.error('Erreur lors de la récupération du service.');
                                    linksContainer.textContent = 'Erreur lors de la récupération du service.';
                                    return;
                                }
                                
                                // pour chaque rendez-vous récupère le client associé
                                fetch(url_client)
                                    .then(response => response.json())
                                    .then(clients => {
                                        if (clients.error || clients.length === 0) {
                                            console.error('Erreur lors de la récupération du client.');
                                            linksContainer.textContent = 'Erreur lors de la récupération du client.';
                                            return;
                                        }

                                        const client = clients[0]; // Supposons qu'il n'y ait qu'un seul client
                                        const message = `Bonjour, ${client.first_name} ${client.last_name}. Ceci est un rappel de votre rendez-vous du: ${startDate.date} de : ${startDate.time} À ${endDate.time} pour le service : ${services.name}`;
                                        const whatsappUrl = `https://web.whatsapp.com/send?phone=${client.phone_number}&text=${encodeURIComponent(message)}`;

                                        const row = document.createElement('tr');

                                        // Cellule numéro
                                        const numberCell = document.createElement('td');
                                        numberCell.textContent = index + 1;
                                        row.appendChild(numberCell);

                                        // Cellule nom du client
                                        const clientCell = document.createElement('td');
                                        clientCell.textContent = `${client.first_name} ${client.last_name}`;
                                        row.appendChild(clientCell);

                                        // Cellule téléphone
                                        const phoneCell = document.createElement('td');
                                        phoneCell.textContent = client.phone_number;
                                        row.appendChild(phoneCell);

                                       

                                        // Cellule Jour (Date RDV)
                                        const daterdvCell = document.createElement('td');
                                        daterdvCell.textContent = startDate.date;
                                        row.appendChild(daterdvCell);

                                        // Cellule Heures (Début et Fin)
                                        const heureCell = document.createElement('td');
                                        heureCell.textContent = 'De : ' + startDate.time + ' À ' + endDate.time;
                                        row.appendChild(heureCell);

                                        // Cellule Service
                                        const servicesCell = document.createElement('td');
                                        servicesCell.textContent = services.name;
                                        row.appendChild(servicesCell);

                                        // Cellule statut
                                        const statutCell = document.createElement('td');
                                        statutCell.textContent = appointment.status;
                                        row.appendChild(statutCell);

                                        // Cellule bouton "Envoyer"
                                        const actionCell = document.createElement('td');
                                        const sendButton = document.createElement('button');
                                        sendButton.textContent = 'Envoyer';
                                        sendButton.classList.add('btn', 'btn-success', 'btn-sm');
                                        sendButton.onclick = () => {
                                            window.open(whatsappUrl, '_blank');
                                        };
                                        actionCell.appendChild(sendButton);
                                        row.appendChild(actionCell);

                                        tbody.appendChild(row);
                                    })
                                    .catch(error => {
                                        console.error('Erreur lors de la récupération du client :', error);
                                        linksContainer.textContent = 'Erreur lors de la récupération des clients.';
                                    });
                            })
                            .catch(error => {
                                console.error('Erreur lors de la récupération du service :', error);
                                linksContainer.textContent = 'Erreur lors de la récupération du service.';
                            });
                    });

                    // Ajouter le tableau au conteneur après avoir fini de peupler le tableau
                    linksContainer.appendChild(table);
                })
                .catch(error => {
                    console.error('Erreur lors de la récupération des rendez-vous :', error);
                    linksContainer.textContent = 'Erreur lors de la récupération des rendez-vous.';
                });
        });
    </script>



</div>

<?php end_section('content'); ?>

<?php section('scripts'); ?>
<script src="<?= asset_url('assets/js/utils/url.js') ?>"></script>
<?php end_section('scripts'); ?>
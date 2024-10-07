<?php extend('layouts/backend_layout'); ?>

<?php section('styles'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<?php end_section('styles'); ?>

<?php section('content'); ?>

<div id="whatsapp-send-message-page" class="container-fluid backend-page">
    <div class="row mb-4">
        <div id="whatsapp-send-message" class="col-sm-6 mx-auto">
            <form>
                <fieldset>
                    <div class="d-flex justify-content-between align-items-center border-bottom mb-4 py-2">
                        <h4 class="text-black-50 mb-0 fw-light">
                            <?= lang('whatsapp_send_message') ?>
                        </h4>

                        <div>
                            <a href="<?= site_url('customers') ?>" class="btn btn-outline-primary me-2">
                                <i class="fas fa-chevron-left me-2"></i>
                                <?= lang('back') ?>
                            </a>
                        </div>
                    </div>

                    <!-- Zone de recherche et filtre par service -->
                    <div class="row mb-4">
                        <div class="col-6 d-flex">
                            <input type="text" id="searchInput" class="form-control me-2" placeholder="Rechercher un client">
                            <button type="button" id="searchButton" class="btn btn-primary">Recherche</button>
                        </div>

                        <div class="col-6 d-flex justify-content-end">
                            <select id="serviceFilter" class="form-select me-2">
                                <option value="all">Tous les services</option>
                                <!-- Liste des services -->
                            </select>
                            <button type="button" id="filterButton" class="btn btn-primary">Filtrer</button>
                        </div>
                    </div>

                    <!-- Ajout de filtres pour la date -->
                    <div class="row mb-4">
                        <div class="col-6 d-flex">
                            <input type="date" id="startDateInput" class="form-control me-2" placeholder="Date de début">
                            <input type="date" id="endDateInput" class="form-control me-2" placeholder="Date de fin">
                        </div>

                        <div class="col-6 d-flex justify-content-end">
                            <select id="statusFilter" class="form-select me-2">
                                <option value="all">Tous les statuts</option>
                                <option value="active">Actif</option>
                                <option value="inactive">Inactif</option>
                                <!-- Ajoutez d'autres statuts si nécessaire -->
                            </select>
                            <button type="button" id="statusFilterButton" class="btn btn-primary">Filtrer par statut</button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div id="appointments-table-container" class="mb-3 d-flex justify-content-center">
                                <!-- Le tableau sera inséré ici -->
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
            const searchInput = document.getElementById('searchInput');
            const searchButton = document.getElementById('searchButton');
            const serviceFilter = document.getElementById('serviceFilter');
            const filterButton = document.getElementById('filterButton');
            const startDateInput = document.getElementById('startDateInput');
            const endDateInput = document.getElementById('endDateInput');
            const statusFilter = document.getElementById('statusFilter');
            const statusFilterButton = document.getElementById('statusFilterButton');
            linksContainer.innerHTML = ''; // Vider le conteneur avant d'ajouter le tableau

            // Fonction pour formater la date et l'heure
            function formatDateTime(datetime) {
                const dateObj = new Date(datetime);
                const optionsDate = { year: 'numeric', month: 'long', day: 'numeric' };
                const optionsTime = { hour: '2-digit', minute: '2-digit' };

                return {
                    date: dateObj.toLocaleDateString('fr-FR', optionsDate),
                    time: dateObj.toLocaleTimeString('fr-FR', optionsTime)
                };
            }

            // Fonction pour charger les services dans le filtre
            function loadServices() {
                fetch('whatsapp_settings/getServices')
                    .then(response => response.json())
                    .then(services => {
                        if (services.error) {
                            console.error('Erreur lors de la récupération des services.');
                            return;
                        }

                        services.forEach(service => {
                            const option = document.createElement('option');
                            option.value = service.id;
                            option.textContent = service.name;
                            serviceFilter.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Erreur lors de la récupération des services :', error));
            }

            // Charger les services au chargement de la page
            loadServices();

            // Requête AJAX pour récupérer les rendez-vous
            fetch(url)
                .then(response => response.json())
                .then(appointments => {
                    if (appointments.error) {
                        linksContainer.textContent = 'Erreur lors de la récupération des rendez-vous.';
                        return;
                    }

                    const table = document.createElement('table');
                    table.classList.add('table', 'table-striped', 'table-bordered', 'table-sm', 'text-center');

                    const thead = document.createElement('thead');
                    const headerRow = document.createElement('tr');
                    ['N°', 'Client', 'Téléphone', 'Jour', 'Heures', 'Service', 'Statut', 'Envoyer', 'Activer'].forEach(text => {
                        const th = document.createElement('th');
                        th.textContent = text;
                        headerRow.appendChild(th);
                    });
                    thead.appendChild(headerRow);
                    table.appendChild(thead);

                    const tbody = document.createElement('tbody');
                    table.appendChild(tbody);

                    appointments.forEach((appointment, index) => {
                        const url_client = `whatsapp_settings/getClientsWithRoleAndAppointments/${appointment.id_users_customer}`;
                        const startDate = formatDateTime(appointment.start_datetime);
                        const endDate = formatDateTime(appointment.end_datetime);

                        const url_service = `whatsapp_settings/getClientsWithRoleAndAppointmentsAndService/${appointment.id_services}`;
                        fetch(url_service)
                            .then(response => response.json())
                            .then(services => {
                                if (services.error || services.length === 0) {
                                    console.error('Erreur lors de la récupération du service.');
                                    linksContainer.textContent = 'Erreur lors de la récupération du service.';
                                    return;
                                }

                                fetch(url_client)
                                    .then(response => response.json())
                                    .then(clients => {
                                        if (clients.error || clients.length === 0) {
                                            console.error('Erreur lors de la récupération du client.');
                                            linksContainer.textContent = 'Erreur lors de la récupération du client.';
                                            return;
                                        }

                                        const client = clients[0];
                                        const message = `Bonjour, ${client.first_name} ${client.last_name}. Ceci est un rappel de votre rendez-vous du: ${startDate.date} de : ${startDate.time} À ${endDate.time} pour le service : ${services.name}`;
                                        const whatsappUrl = `https://web.whatsapp.com/send?phone=${client.phone_number}&text=${encodeURIComponent(message)}`;

                                        const row = document.createElement('tr');
                                        row.setAttribute('data-service-id', services.id);
                                        row.setAttribute('data-status', appointment.status.toLowerCase()); // Ajout de l'attribut statut
                                        row.setAttribute('data-date', startDate.date); // Ajout de l'attribut date

                                        const numberCell = document.createElement('td');
                                        numberCell.textContent = index + 1;
                                        row.appendChild(numberCell);

                                        const clientCell = document.createElement('td');
                                        clientCell.textContent = `${client.first_name} ${client.last_name}`;
                                        row.appendChild(clientCell);

                                        const phoneCell = document.createElement('td');
                                        phoneCell.textContent = client.phone_number;
                                        row.appendChild(phoneCell);

                                        const daterdvCell = document.createElement('td');
                                        daterdvCell.textContent = startDate.date;
                                        row.appendChild(daterdvCell);

                                        const heureCell = document.createElement('td');
                                        heureCell.textContent = 'De : ' + startDate.time + ' À ' + endDate.time;
                                        row.appendChild(heureCell);

                                        const servicesCell = document.createElement('td');
                                        servicesCell.textContent = services.name;
                                        row.appendChild(servicesCell);

                                        const statutCell = document.createElement('td');
                                        statutCell.textContent = appointment.status;
                                        row.appendChild(statutCell);

                                        const sendCell = document.createElement('td');
                                        const sendButton = document.createElement('button');
                                        sendButton.textContent = 'Envoyer';
                                        sendButton.classList.add('btn', 'btn-sm', 'btn-success');
                                        sendButton.addEventListener('click', function () {
                                            window.open(whatsappUrl, '_blank');
                                        });
                                        sendCell.appendChild(sendButton);
                                        row.appendChild(sendCell);

                                        const activateCell = document.createElement('td');
                                        const activateButton = document.createElement('button');
                                        activateButton.textContent = 'Activer';
                                        activateButton.classList.add('btn', 'btn-sm', 'btn-warning');
                                        activateButton.addEventListener('click', function () {
                                            // Logique d'activation
                                            console.log(`Activé: ${appointment.id}`);
                                        });
                                        activateCell.appendChild(activateButton);
                                        row.appendChild(activateCell);

                                        tbody.appendChild(row);
                                    })
                                    .catch(error => console.error('Erreur lors de la récupération des clients :', error));
                            })
                            .catch(error => console.error('Erreur lors de la récupération du service :', error));
                    });

                    linksContainer.appendChild(table);

                    // Écouteur d'événements pour le bouton de filtre
                    filterButton.addEventListener('click', function () {
                        const selectedService = serviceFilter.value;
                        const startDate = new Date(document.getElementById('startDateInput').value);
                        const endDate = new Date(document.getElementById('endDateInput').value);
                        const statusFilter = document.getElementById('statusFilter').value;

                        const rows = linksContainer.querySelectorAll('tbody tr');

                        rows.forEach(row => {
                            const serviceId = row.getAttribute('data-service-id');
                            const appointmentDate = new Date(row.getAttribute('data-date'));
                            const appointmentStatus = row.getAttribute('data-status'); // Récupérer le statut

                            // Vérifier si la ligne doit être affichée
                            const isServiceMatch = selectedService === 'all' || serviceId === selectedService;
                            const isDateMatch = (!isNaN(startDate) && !isNaN(endDate)) ? (appointmentDate >= startDate && appointmentDate <= endDate) : true;
                            const isStatusMatch = statusFilter === 'all' || appointmentStatus === statusFilter;

                            if (isServiceMatch && isDateMatch && isStatusMatch) {
                                row.style.display = '';
                            } else {
                                row.style.display = 'none';
                            }
                        });
                    });

                    // Écouteur d'événements pour le filtre par statut
                    statusFilterButton.addEventListener('click', function () {
                        const statusFilter = document.getElementById('statusFilter').value;
                        const rows = linksContainer.querySelectorAll('tbody tr');

                        rows.forEach(row => {
                            const appointmentStatus = row.getAttribute('data-status'); // Récupérer le statut
                            if (statusFilter === 'all' || appointmentStatus === statusFilter) {
                                row.style.display = '';
                            } else {
                                row.style.display = 'none';
                            }
                        });
                    });

                })
                .catch(error => console.error('Erreur lors de la récupération des rendez-vous :', error));
        });
    </script>
</div>

<?php end_section('content'); ?>

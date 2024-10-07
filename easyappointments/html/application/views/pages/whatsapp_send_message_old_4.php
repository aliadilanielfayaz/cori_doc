<?php extend('layouts/backend_layout'); ?>

<?php section('content'); ?>
<style>
    .search-bar {
        gap: 0; /* Supprime tout l'espacement entre les éléments */
        display: flex; /* Assure que le contenu utilise flexbox */
        justify-content: center; /* Centre le contenu horizontalement */
    }

    .btn-search {
        border-radius: 0 5px 5px 0; /* Pour que le bouton et l'input aient un effet de continuité */
        margin-left: -2px; /* Pour éviter une séparation visuelle due aux bordures */
    }

    .input-search {
        border-radius: 5px 0 0 5px; /* Arrondi du côté gauche de l'input */
    }
</style>

<div class="container-fluid backend-page" id="calendar-page">
    <div class="row" id="calendar-toolbar">
        <div id="calendar-filter" class="col-md-3">
            <div class="calendar-filter-items">
                <select id="select-filter-item" class="form-select col"
                    data-tippy-content="<?= lang('select_filter_item_hint') ?>" aria-label="Filter">
                    <option value="all">
                        <?= lang('filter_all') ?>
                    </option>
                    <optgroup label="<?= lang('filter_executant') ?>">
                        <option value="executant_1">
                            <?= lang('executant_1') ?>
                        </option>
                        <option value="executant_2">
                            <?= lang('executant_2') ?>
                        </option>
                        <option value="executant_3">
                            <?= lang('executant_3') ?>
                        </option>
                    </optgroup>
                    <optgroup label="<?= lang('filter_prestation') ?>">
                        <option value="prestation_1">
                            <?= lang('prestation_1') ?>
                        </option>
                        <option value="prestation_2">
                            <?= lang('prestation_2') ?>
                        </option>
                        <option value="prestation_3">
                            <?= lang('prestation_3') ?>
                        </option>
                    </optgroup>
                </select>
            </div>
        </div>

        <div id="calendar-actions" class="col-md-9">
            <div class="btn-group" role="group" aria-label="Calendar View">
                <div class="col-6 d-flex justify-content-center search-bar">
                    <input type="text" id="searchInput" class="form-control input-search" placeholder="Rechercher un client">
                    <button type="button" id="searchButton" class="btn btn-primary btn-search">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                

                <button type="button" class="btn btn-light" id="view-day"
                    data-tippy-content="<?= lang('view_day_hint') ?>">
                    <?= lang('Jour') ?>
                </button>
                <button type="button" class="btn btn-light" id="view-week"
                    data-tippy-content="<?= lang('view_week_hint') ?>">
                    <?= lang('Semaine') ?>
                </button>
                <button type="button" class="btn btn-light" id="view-month"
                    data-tippy-content="<?= lang('view_month_hint') ?>">
                    <?= lang('Mois') ?>
                </button>
            </div>


        </div>

    </div>
    <div id="whatsapp-send-message" class="row">
        <form>
            <fieldset>
                <div class="d-flex justify-content-between align-items-center border-bottom mb-4 py-2">
                    <div class="flex justify-center">
                        <h4 class="text-black-50 mb-0 fw-light">
                            <?= lang('whatsapp_send_message') ?>
                        </h4>
                    </div>
                    <div>
                        <a href="<?= site_url('customers') ?>" class="btn btn-outline-primary me-2">
                            <i class="fas fa-chevron-left me-2"></i>
                            <?= lang('back') ?>
                        </a>
                    </div>
                </div>
                <div class="row mb-4">

                    <div class="col-6 d-flex justify-content-end">
                        <button type="button" id="precedentButton" class="btn btn-primary me-2">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button type="button" id="suivantButton" class="btn btn-primary">
                            <i class="fas fa-chevron-right"></i>
                        </button>
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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const url = 'whatsapp_settings/getAppointments'; // URL pour récupérer les rendez-vous
            const linksContainer = document.getElementById('appointments-table-container');
            // const searchInput = document.getElementById('searchInput');
            // const searchButton = document.getElementById('searchButton');
            // const serviceFilter = document.getElementById('serviceFilter');
            // const filterButton = document.getElementById('filterButton');
            // const startDateInput = document.getElementById('startDateInput');
            // const endDateInput = document.getElementById('endDateInput');
            // const statusFilter = document.getElementById('statusFilter');
            // const statusFilterButton = document.getElementById('statusFilterButton');
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


                    // Écouteur d'événements pour le filtre par statut
                    // statusFilterButton.addEventListener('click', function () {
                    //     const statusFilter = document.getElementById('statusFilter').value;
                    //     const rows = linksContainer.querySelectorAll('tbody tr');

                    //     rows.forEach(row => {
                    //         const appointmentStatus = row.getAttribute('data-status'); // Récupérer le statut
                    //         if (statusFilter === 'all' || appointmentStatus === statusFilter) {
                    //             row.style.display = '';
                    //         } else {
                    //             row.style.display = 'none';
                    //         }
                    //     });
                    // });



                })
                .catch(error => console.error('Erreur lors de la récupération des rendez-vous :', error));
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const url = 'whatsapp_settings/getAppointments';
            const searchInput = document.getElementById('searchInput');
            const searchButton = document.getElementById('searchButton');

            // Écouteur d'événements pour la recherche par client ou par téléphone
            searchButton.addEventListener('click', function () {
                console.log("############################");
                console.log("Clique 9999999999999999");
                console.log("############################");
                const searchvalue = document.getElementById('searchInput').value;
                console.log(searchvalue);
                const rows = linksContainer.querySelectorAll('tbody tr');

                // rows.forEach(row => {
                //     const appointmentStatus = row.getAttribute('data-status'); // Récupérer le statut
                //     if (statusFilter === 'all' || appointmentStatus === statusFilter) {
                //         row.style.display = '';
                //     } else {
                //         row.style.display = 'none';
                //     }
                // });
            });
        });
    </script>



</div>

<!-- Page Components -->

<?php component('appointments_modal', [
    'available_services' => vars('available_services'),
    'appointment_status_options' => vars('appointment_status_options'),
    'timezones' => vars('timezones'),
    'require_first_name' => vars('require_first_name'),
    'require_last_name' => vars('require_last_name'),
    'require_email' => vars('require_email'),
    'require_phone_number' => vars('require_phone_number'),
    'require_address' => vars('require_address'),
    'require_city' => vars('require_city'),
    'require_zip_code' => vars('require_zip_code'),
    'require_notes' => vars('require_notes'),
]); ?>

<?php component('unavailabilities_modal', [
    'timezones' => vars('timezones'),
    'timezone' => vars('timezone'),
]); ?>

<?php component('working_plan_exceptions_modal'); ?>

<?php end_section('content'); ?>

<?php section('scripts'); ?>

<script src="<?= asset_url('assets/vendor/fullcalendar/index.global.min.js') ?>"></script>
<script src="<?= asset_url('assets/vendor/fullcalendar-moment/index.global.min.js') ?>"></script>
<script src="<?= asset_url('assets/vendor/jquery-jeditable/jquery.jeditable.min.js') ?>"></script>
<script src="<?= asset_url('assets/js/utils/date.js') ?>"></script>
<script src="<?= asset_url('assets/js/utils/message.js') ?>"></script>
<script src="<?= asset_url('assets/js/utils/validation.js') ?>"></script>
<script src="<?= asset_url('assets/js/utils/ui.js') ?>"></script>
<script src="<?= asset_url('assets/js/utils/url.js') ?>"></script>

<script src="<?= asset_url('assets/js/http/customers_http_client.js') ?>"></script>
<?php if (vars('calendar_view') === CALENDAR_VIEW_DEFAULT): ?>
<script src="<?= asset_url('assets/js/utils/calendar_sync.js') ?>"></script>
<script src="<?= asset_url('assets/js/http/google_http_client.js') ?>"></script>
<script src="<?= asset_url('assets/js/http/caldav_http_client.js') ?>"></script>
<?php endif; ?>
<script src="<?= asset_url('assets/js/pages/calendar.js') ?>"></script>

<?php end_section('scripts'); ?>
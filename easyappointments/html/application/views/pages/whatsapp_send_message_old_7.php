<?php extend('layouts/backend_layout'); ?>

<?php section('content'); ?>


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


                <button type="button" class="btn btn-light" data-tippy-content="<?= lang('view_day_hint') ?>">
                    <input type="text" style="border: 1px solid lightgray;" id="searchInput"
                        class="form-control input-search me-2" placeholder="Rechercher ">
                </button>

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

                    <div>
                        <a href="<?= site_url('customers') ?>" class="btn btn-outline-primary me-2">
                            <i class="fas fa-chevron-left me-2"></i>
                            <?= lang('back') ?>
                        </a>
                    </div>
                </div>
                <div class="row mb-4">

                    <div class="col-6 d-flex justify-content-start">
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

            // Fonction pour récupérer la date du jour
            function getCurrentDate() {
                const today = new Date();
                const year = today.getFullYear();
                const month = String(today.getMonth() + 1).padStart(2, '0'); // Mois entre 1 et 12
                const day = String(today.getDate()).padStart(2, '0'); // Jour du mois
                return `${year}-${month}-${day}`; // Format YYYY-MM-DD
            }
            // Appelle de la fonction getCurrentDate()
            const dateToday = getCurrentDate();


            function getCurrentWeekRange() {
                const today = new Date();

                // Obtenir le jour actuel (0 = dimanche, 1 = lundi, etc.)
                const dayOfWeek = today.getDay();
                const firstDayOfWeek = new Date(today); // Copie de la date actuelle
                const lastDayOfWeek = new Date(today);  // Copie de la date actuelle

                // Ajuster pour obtenir le lundi
                const diffToMonday = dayOfWeek === 0 ? 6 : dayOfWeek - 1; // Si dimanche (0), retourner à lundi (-6), sinon retourner au lundi correspondant
                firstDayOfWeek.setDate(today.getDate() - diffToMonday);

                // Ajuster pour obtenir le dimanche
                const diffToSunday = 7 - dayOfWeek;
                lastDayOfWeek.setDate(today.getDate() + diffToSunday);

                // Formater les dates au format YYYY-MM-DD
                const year = today.getFullYear();
                const formatDate = (date) => {
                    const year = date.getFullYear();
                    const month = String(date.getMonth() + 1).padStart(2, '0'); // Mois entre 1 et 12
                    const day = String(date.getDate()).padStart(2, '0'); // Jour du mois
                    return `${year}-${month}-${day}`;
                };

                return {
                    startOfWeek: formatDate(firstDayOfWeek),
                    endOfWeek: formatDate(lastDayOfWeek)
                };
            }

            const weekRange = getCurrentWeekRange();
            console.log("Début de la semaine :", weekRange.startOfWeek);
            console.log("Fin de la semaine :", weekRange.endOfWeek);


            function getCurrentMonthRange() {
                const today = new Date();

                // Date de début du mois en cours
                const firstDayOfMonth = new Date(today.getFullYear(), today.getMonth(), 1);

                // Date de fin du mois en cours
                const lastDayOfMonth = new Date(today.getFullYear(), today.getMonth() + 1, 0); // 0 correspond au dernier jour du mois précédent

                // Formater les dates au format YYYY-MM-DD
                const formatDate = (date) => {
                    const year = date.getFullYear();
                    const month = String(date.getMonth() + 1).padStart(2, '0'); // Mois entre 1 et 12
                    const day = String(date.getDate()).padStart(2, '0'); // Jour du mois
                    return `${year}-${month}-${day}`;
                };

                return {
                    startOfMonth: formatDate(firstDayOfMonth),
                    endOfMonth: formatDate(lastDayOfMonth)
                };
            }

            const monthRange = getCurrentMonthRange();
            console.log("Début du mois :", monthRange.startOfMonth);
            console.log("Fin du mois :", monthRange.endOfMonth);






            // URL pour récupérer les rendez-vous
            const url = 'whatsapp_settings/getAppointments';
            // URL pour récupérer les rendez-vous du jour
            const urlDay = `whatsapp_settings/getClientsWithRoleAndAppointmentsAndDays/${dateToday}`;
            // URL pour récupérer les rendez-vous de la semaine
            const urlWeek = `whatsapp_settings/getClientsWithRoleAndAppointmentsAndWeek/${weekRange.startOfWeek}/${weekRange.endOfWeek}`;
            // URL pour récupérer les rendez-vous du mois
            const urlMonth = `whatsapp_settings/getClientsWithRoleAndAppointmentsAndMonth/${monthRange.startOfMonth}/${monthRange.endOfMonth}`;

            const linksContainer = document.getElementById('appointments-table-container');

            const dayButton = document.getElementById('view-day');
            const weekButton = document.getElementById('view-week');
            const monthButton = document.getElementById('view-month');

            linksContainer.innerHTML = ''; // Vider le conteneur avant d'ajouter le tableau

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
            function loadAppointement(parm_url) {
                fetch(parm_url)
                    .then(response => response.json())
                    .then(appointments => {
                        if (appointments.error) {
                            linksContainer.textContent = 'Erreur lors de la récupération des rendez-vous.';
                            return;
                        }

                        const table = document.createElement('table');
                        table.classList.add('table', 'table-responsive', 'table-striped', 'table-bordered', 'table-sm', 'text-center');

                        const thead = document.createElement('thead');
                        const headerRow = document.createElement('tr');
                        ['Client', 'Jour', 'Heures', 'Service', 'Action'].forEach(text => {
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

                                            const clientCell = document.createElement('td');
                                            clientCell.textContent = `${client.first_name} ${client.last_name}`;
                                            row.appendChild(clientCell);

                                            const daterdvCell = document.createElement('td');
                                            daterdvCell.textContent = startDate.date;
                                            row.appendChild(daterdvCell);

                                            const heureCell = document.createElement('td');
                                            heureCell.textContent = 'De : ' + startDate.time + ' À ' + endDate.time;
                                            row.appendChild(heureCell);

                                            const servicesCell = document.createElement('td');
                                            servicesCell.textContent = services.name;
                                            row.appendChild(servicesCell);

                                            const sendCell = document.createElement('td');
                                            const sendButton = document.createElement('button');
                                            sendButton.textContent = 'Envoyer';
                                            sendButton.classList.add('btn', 'btn-sm', 'btn-success');
                                            sendButton.addEventListener('click', function () {
                                                window.open(whatsappUrl, '_blank');
                                            });
                                            sendCell.appendChild(sendButton);
                                            row.appendChild(sendCell);

                                            tbody.appendChild(row);
                                        })
                                        .catch(error => console.error('Erreur lors de la récupération des clients :', error));
                                })
                                .catch(error => console.error('Erreur lors de la récupération du service :', error));
                        });

                        linksContainer.appendChild(table);
                    })
                    .catch(error => console.error('Erreur lors de la récupération des rendez-vous :', error));
            }

            loadAppointement(url);

            // Ajouter des écouteurs d'événements aux boutons
            // Récupérer les rendez-vous du jour
            dayButton.addEventListener('click', function () {

                // Vider le conteneur avant d'ajouter le tableau
                linksContainer.innerHTML = '';

                loadAppointement(urlDay);
            });

            // Récupérer les rendez-vous de la semaine
            weekButton.addEventListener('click', function () {

                // Vider le conteneur avant d'ajouter le tableau
                linksContainer.innerHTML = '';

                loadAppointement(urlWeek);
            });

            // Récupérer les rendez-vous du mois
            monthButton.addEventListener('click', function () {

                // Vider le conteneur avant d'ajouter le tableau
                linksContainer.innerHTML = '';

                loadAppointement(urlMonth);
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
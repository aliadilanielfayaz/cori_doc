<?php extend('layouts/backend_layout'); ?>
<?php section('styles'); ?>
<link
  rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/tempus-dominus/6.0.0-beta3/css/tempus-dominus.min.css"
/>
<?php end_section('styles'); ?>

<?php section('content'); ?>

<div class="container-fluid backend-page" id="calendar-page">
  <div class="row" id="calendar-toolbar">
    <!-- Deuxième div avec les boutons du calendrier (Jour, Semaine, Mois) -->
    <div class="d-flex justify-content-end">
      <div id="calendar-actions" class="col-md-4">
        <div class="btn-group" role="group" aria-label="Calendar View">
          <button
            type="button"
            class="btn btn-light"
            id="view-recherche"
            data-tippy-content="<?= lang('Rechercher un rdv') ?>"
          >
            <i class="fas fa-search"></i>
          </button>

          <button
            type="button"
            class="btn btn-light"
            id="view-day"
            data-tippy-content="<?= lang('Les rdv d\'aujourd\'hui') ?>"
          >
            <?= lang('Aujourd\'hui') ?>
          </button>

          <button
            type="button"
            class="btn btn-light"
            id="view_tomorrow"
            data-tippy-content="<?= lang('Les rdvs de demain') ?>"
          >
            <?= lang('Demain') ?>
          </button>

          <button
            type="button"
            class="btn btn-light"
            id="view-date"
            data-tippy-content="<?= lang('Les rdvs par date') ?>"
          >
            <?= lang('Date') ?>
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Fenêtre modale pour la recherche -->
  <div
    class="modal fade"
    id="searchModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="searchModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="searchModalLabel">
            Rechercher un Rendez-vous
          </h5>
        </div>
        <div class="modal-body">
          <!-- Formulaire de recherche -->
          <form>
            <div class="form-group">
              <input
                type="text"
                class="form-control"
                id="search-term"
                placeholder="Recherche..."
              />
            </div>
            
            
          </form>
        </div>
        <div class="modal-footer">
          <button
            id="modal-dialog-annuler-recherche"
            type="button"
            class="btn btn-secondary"
            data-dismiss="modal"
          >
            Annuler
          </button>
          <button
            id="modal-dialog-save-recherche"
            type="button"
            class="btn btn-primary"
          >
            Rechercher
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Fenêtre modale Bootstrap -->
  <div
    class="modal fade"
    id="appointmentModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="appointmentModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="appointmentModalLabel">
            Nouveau Rendez-vous
          </h5>
          <button
            type="button"
            class="close"
            data-dismiss="modal"
            aria-label="Close"
          >
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <!-- Formulaire similaire à l'image -->
          <form>
            <div class="form-group">
              <label for="start-date">Date/heure de début</label>
              <div
                class="input-group"
                id="start-date-picker"
                data-td-target-input="nearest"
                data-td-target-toggle="nearest"
              >
                <input
                  type="text"
                  id="start-date"
                  class="form-control"
                  data-td-target="#start-date-picker"
                />
                <span
                  class="input-group-text"
                  data-td-target="#start-date-picker"
                  data-td-toggle="datetimepicker"
                >
                  <i class="fas fa-calendar"></i>
                </span>
              </div>
            </div>

            <div class="form-group">
              <label for="end-date">Date/heure de fin</label>
              <div
                class="input-group"
                id="end-date-picker"
                data-td-target-input="nearest"
                data-td-target-toggle="nearest"
              >
                <input
                  type="text"
                  id="end-date"
                  class="form-control"
                  data-td-target="#end-date-picker"
                />
                <span
                  class="input-group-text"
                  data-td-target="#end-date-picker"
                  data-td-toggle="datetimepicker"
                >
                  <i class="fas fa-calendar"></i>
                </span>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button
            id="modal-dialog-annuler-date"
            type="button"
            class="btn btn-secondary"
            data-dismiss="modal"
          >
            Annuler
          </button>
          <button type="button" class="btn btn-primary">Enregistrer</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    // Initialiser les sélecteurs de date/heure après le chargement du document
    document.addEventListener("DOMContentLoaded", function () {
      new tempusDominus.TempusDominus(
        document.getElementById("start-date-picker"),
        {
          display: {
            components: {
              calendar: true,
              clock: true,
            },
          },
        }
      );

      new tempusDominus.TempusDominus(
        document.getElementById("end-date-picker"),
        {
          display: {
            components: {
              calendar: true,
              clock: true,
            },
          },
        }
      );
    });
  </script>

  <script>
    // Ouvre le modal de recherche
    document
      .getElementById("view-recherche")
      .addEventListener("click", function () {
        // Utilise jQuery pour afficher la fenêtre modale
        $("#searchModal").modal("show");
      });
    document
      .getElementById("modal-dialog-annuler-recherche")
      .addEventListener("click", function () {
        // Cacher la modale en utilisant Bootstrap
        $("#searchModal").modal("hide");
      });

    document.getElementById("view-date").addEventListener("click", function () {
      // Cacher la modale en utilisant Bootstrap
      $("#appointmentModal").modal("show");
    });

    document
      .getElementById("modal-dialog-annuler-date")
      .addEventListener("click", function () {
        // Affiche la modale en utilisant Bootstrap
        $("#appointmentModal").modal("hide");
      });
  </script>

  <div id="whatsapp-send-message" class="row">
    <form>
      <fieldset>
        <div
          class="d-flex justify-content-between align-items-center border-bottom mb-4 py-2"
        >
          <div>
            <a
              href="<?= site_url('customers') ?>"
              class="btn btn-outline-primary me-2"
            >
              <i class="fas fa-chevron-left me-2"></i>
              <?= lang('back') ?>
            </a>
          </div>
        </div>
        <div class="row mb-4">
          <div class="col-6 d-flex justify-content-start">
            <button
              type="button"
              id="precedentButton"
              class="btn btn-primary me-2"
            >
              <i class="fas fa-chevron-left"></i>
            </button>
            <button type="button" id="suivantButton" class="btn btn-primary">
              <i class="fas fa-chevron-right"></i>
            </button>
          </div>
        </div>

        <div class="row">
          <div class="col-12">
            <div
              id="appointments-table-container"
              class="mb-3 d-flex justify-content-center"
            >
              <!-- Le tableau sera inséré ici -->
            </div>
          </div>
        </div>

        <?php slot('after_primary_appointment_fields'); ?>
      </fieldset>
    </form>
  </div>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      // Fonction pour formater la date et l'heure
      function formatDateTime(datetime) {
        const dateObj = new Date(datetime);
        const optionsDate = { year: "numeric", month: "long", day: "numeric" };
        const optionsTime = { hour: "2-digit", minute: "2-digit" };

        return {
          date: dateObj.toLocaleDateString("fr-FR", optionsDate),
          time: dateObj.toLocaleTimeString("fr-FR", optionsTime),
        };
      }

      // Fonction pour récupérer la date du jour
      function getCurrentDate() {
        const today = new Date();
        const year = today.getFullYear();
        const month = String(today.getMonth() + 1).padStart(2, "0"); // Mois entre 1 et 12
        const day = String(today.getDate()).padStart(2, "0"); // Jour du mois
        return `${year}-${month}-${day}`; // Format YYYY-MM-DD
      }
      // Appelle de la fonction getCurrentDate()
      const dateToday = getCurrentDate();

      // Fonction pour récupérer la date du lendemain
      function getTomorrowDate() {
        const today = new Date();
        today.setDate(today.getDate() + 1); // Ajouter 1 jour à la date actuelle
        const year = today.getFullYear();
        const month = String(today.getMonth() + 1).padStart(2, "0"); // Mois entre 1 et 12
        const day = String(today.getDate()).padStart(2, "0"); // Jour du mois
        return `${year}-${month}-${day}`; // Format YYYY-MM-DD
      }

      // Appel de la fonction getTomorrowDate()
      const dateTomorrow = getTomorrowDate();

      // URL pour récupérer les rendez-vous du jour
      const urlDay = `whatsapp_settings/getClientsWithRoleAndAppointmentsAndDays/${dateToday}`;

      // URL pour récupérer les rendez-vous du lendemain
      const urlTomorrow = `whatsapp_settings/getClientsWithRoleAndAppointmentsAndTomorrow/${dateTomorrow}`;

      const linksContainer = document.getElementById(
        "appointments-table-container"
      );

      const modalDialogAnnulerRechercheButton = document.getElementById(
        "modal-dialog-annuler-recherche"
      );
      const dayButton = document.getElementById("view-day");
      const tomorrowButton = document.getElementById("view_tomorrow");

      linksContainer.innerHTML = ""; // Vider le conteneur avant d'ajouter le tableau

      // Requête AJAX pour récupérer les rendez-vous
      function loadAppointement(parm_url) {
        fetch(parm_url)
          .then((response) => response.json())
          .then((appointments) => {
            if (appointments.error) {
              linksContainer.textContent =
                "Erreur lors de la récupération des rendez-vous.";
              return;
            }

            const table = document.createElement("table");
            table.classList.add(
              "table",
              "table-responsive",
              "table-striped",
              "table-bordered",
              "table-sm",
              "text-center"
            );

            const thead = document.createElement("thead");
            const headerRow = document.createElement("tr");
            ["Client", "Jour", "Heures", "Service", "Action"].forEach(
              (text) => {
                const th = document.createElement("th");
                th.textContent = text;
                headerRow.appendChild(th);
              }
            );
            thead.appendChild(headerRow);
            table.appendChild(thead);

            const tbody = document.createElement("tbody");
            table.appendChild(tbody);

            appointments.forEach((appointment, index) => {
              const url_client = `whatsapp_settings/getClientsWithRoleAndAppointments/${appointment.id_users_customer}`;
              const startDate = formatDateTime(appointment.start_datetime);
              const endDate = formatDateTime(appointment.end_datetime);

              const url_service = `whatsapp_settings/getClientsWithRoleAndAppointmentsAndService/${appointment.id_services}`;
              fetch(url_service)
                .then((response) => response.json())
                .then((services) => {
                  if (services.error || services.length === 0) {
                    console.error("Erreur lors de la récupération du service.");
                    linksContainer.textContent =
                      "Erreur lors de la récupération du service.";
                    return;
                  }

                  fetch(url_client)
                    .then((response) => response.json())
                    .then((clients) => {
                      if (clients.error || clients.length === 0) {
                        console.error(
                          "Erreur lors de la récupération du client."
                        );
                        linksContainer.textContent =
                          "Erreur lors de la récupération du client.";
                        return;
                      }

                      const client = clients[0];
                      const message = `Bonjour, ${client.first_name} ${client.last_name}. Ceci est un rappel de votre rendez-vous du: ${startDate.date} de : ${startDate.time} À ${endDate.time} pour le service : ${services.name}`;
                      const whatsappUrl = `https://web.whatsapp.com/send?phone=${
                        client.phone_number
                      }&text=${encodeURIComponent(message)}`;

                      const row = document.createElement("tr");
                      row.setAttribute("data-service-id", services.id);
                      row.setAttribute(
                        "data-status",
                        appointment.status.toLowerCase()
                      ); // Ajout de l'attribut statut
                      row.setAttribute("data-date", startDate.date); // Ajout de l'attribut date

                      const clientCell = document.createElement("td");
                      clientCell.textContent = `${client.first_name} ${client.last_name}`;
                      row.appendChild(clientCell);

                      const daterdvCell = document.createElement("td");
                      daterdvCell.textContent = startDate.date;
                      row.appendChild(daterdvCell);

                      const heureCell = document.createElement("td");
                      heureCell.textContent =
                        "De : " + startDate.time + " À " + endDate.time;
                      row.appendChild(heureCell);

                      const servicesCell = document.createElement("td");
                      servicesCell.textContent = services.name;
                      row.appendChild(servicesCell);

                      const sendCell = document.createElement("td");
                      const sendButton = document.createElement("button");
                      sendButton.textContent = "Envoyer";
                      sendButton.classList.add("btn", "btn-sm", "btn-success");
                      sendButton.addEventListener("click", function () {
                        window.open(whatsappUrl, "_blank");
                      });
                      sendCell.appendChild(sendButton);
                      row.appendChild(sendCell);

                      tbody.appendChild(row);
                    })
                    .catch((error) =>
                      console.error(
                        "Erreur lors de la récupération des clients :",
                        error
                      )
                    );
                })
                .catch((error) =>
                  console.error(
                    "Erreur lors de la récupération du service :",
                    error
                  )
                );
            });

            linksContainer.appendChild(table);
          })
          .catch((error) =>
            console.error(
              "Erreur lors de la récupération des rendez-vous :",
              error
            )
          );
      }

      loadAppointement(urlDay);

      // Ajouter des écouteurs d'événements aux boutons
      // Récupérer les rendez-vous du jour
      dayButton.addEventListener("click", function () {
        // Vider le conteneur avant d'ajouter le tableau
        linksContainer.innerHTML = "";

        loadAppointement(urlDay);
      });

      // Récupérer les rendez-vous du lendemain
      tomorrowButton.addEventListener("click", function () {
        // Vider le conteneur avant d'ajouter le tableau
        linksContainer.innerHTML = "";

        loadAppointement(urlTomorrow);
      });

      // Récupérer les rendez-vous du par date
      //   tomorrowButton.addEventListener("click", function () {
      //     // Vider le conteneur avant d'ajouter le tableau
      //     linksContainer.innerHTML = "";

      //     loadAppointement(urlTomorrow);
      //   });

      // Récupérer les rendez-vous de la recherche
      modalDialogAnnulerRechercheButton.addEventListener("click", function () {
        $("#searchModal").modal("show");
        console.log("####################");
      });
    });
  </script>
</div>

<!-- Page Components -->

<?php component('appointments_modal', [
    'available_services' =>
vars('available_services'), 'appointment_status_options' =>
vars('appointment_status_options'), 'timezones' => vars('timezones'),
'require_first_name' => vars('require_first_name'), 'require_last_name' =>
vars('require_last_name'), 'require_email' => vars('require_email'),
'require_phone_number' => vars('require_phone_number'), 'require_address' =>
vars('require_address'), 'require_city' => vars('require_city'),
'require_zip_code' => vars('require_zip_code'), 'require_notes' =>
vars('require_notes'), ]); ?>

<?php component('unavailabilities_modal', [
    'timezones' =>
vars('timezones'), 'timezone' => vars('timezone'), ]); ?>

<?php component('working_plan_exceptions_modal'); ?>

<?php end_section('content'); ?>

<?php section('scripts'); ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tempus-dominus/6.0.0-beta3/js/tempus-dominus.min.js"></script>

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

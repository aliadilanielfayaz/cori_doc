
// App.Pages.Whatsapp_settings = (function () {
//     const $saveSettings = $('#save-settings');
//     const $sendWhatsappSettings = $('#send-whatsapp-settings');

//     /**
//      * Check if the form has invalid values.
//      *
//      * @return {Boolean}
//      */
//     function isInvalid() {
//         try {
//             $('#whatsapp-settings .is-invalid').removeClass('is-invalid');

//             // Validate required fields.

//             let missingRequiredFields = false;

//             $('#whatsapp-settings .required').each((index, requiredField) => {
//                 const $requiredField = $(requiredField);

//                 if (!$requiredField.val()) {
//                     $requiredField.addClass('is-invalid');
//                     missingRequiredFields = true;
//                 }
//             });

//             if (missingRequiredFields) {
//                 throw new Error(lang('fields_are_required'));
//             }

//             return false;
//         } catch (error) {
//             App.Layouts.Backend.displayNotification(error.message);
//             return true;
//         }
//     }



//     function onSendMessageWhatsapp() {
//         console.log("#########################");

//         // URL du script PHP qui récupère les clients
//         const url = 'whatsapp_settings/getClientsWithRole'; // Modifie avec la méthode correcte du contrôleur

//         // Sélectionner le conteneur où le tableau sera ajouté
//         const linksContainer = document.getElementById('whatsapp-settings');
//         linksContainer.innerHTML = ''; // Vider le conteneur au cas où

//         // Faire une requête fetch pour récupérer les clients
//         fetch(url)
//             .then(response => response.json()) // Convertir la réponse en JSON
//             .then(clients => {
//                 console.log("Clients fetched: ", clients);
//                 // Vérifier s'il y a une erreur
//                 if (clients.error) {
//                     console.error(clients.error);
//                     linksContainer.textContent = 'Erreur lors de la récupération des clients.';
//                     return;
//                 }

//                 // Créer le tableau
//                 const table = document.createElement('table');
//                 table.classList.add('table', 'table-striped');

//                 // Créer l'en-tête du tableau
//                 const thead = document.createElement('thead');
//                 const headerRow = document.createElement('tr');

//                 // Colonne "No"
//                 const numberHeader = document.createElement('th');
//                 numberHeader.innerHTML = 'N<sup>o</sup>'; // Le "o" en exposant
//                 headerRow.appendChild(numberHeader);

//                 // Colonne "Client"
//                 const clientHeader = document.createElement('th');
//                 clientHeader.textContent = 'Client';
//                 headerRow.appendChild(clientHeader);

//                 // Colonne "Téléphone"
//                 const phoneHeader = document.createElement('th');
//                 phoneHeader.textContent = 'Téléphone';
//                 headerRow.appendChild(phoneHeader);

//                 // Colonne "Envoyer"
//                 const actionHeader = document.createElement('th');
//                 actionHeader.textContent = 'Action';
//                 headerRow.appendChild(actionHeader);

//                 thead.appendChild(headerRow);
//                 table.appendChild(thead);

//                 // Créer le corps du tableau
//                 const tbody = document.createElement('tbody');

//                 clients.forEach((client, index) => {
//                     const whatsappUrl = `https://web.whatsapp.com/send?phone=${client.phone_number}&text=${encodeURIComponent('Bonjour, voici un rappel de votre rendez-vous.')}`;

//                     // Créer une ligne pour chaque client
//                     const row = document.createElement('tr');

//                     // Colonne pour le numéro de ligne
//                     const numberCell = document.createElement('td');
//                     numberCell.textContent = index + 1; // Affiche le numéro de ligne automatiquement
//                     row.appendChild(numberCell);

//                     // Colonne pour le client (nom)
//                     const clientCell = document.createElement('td');
//                     clientCell.textContent = client.last_name + " " + client.first_name;
//                     row.appendChild(clientCell);

//                     // Colonne pour le téléphone
//                     const phoneCell = document.createElement('td');
//                     phoneCell.textContent = client.phone_number;
//                     row.appendChild(phoneCell);

//                     // Colonne pour le bouton "Envoyer"
//                     const actionCell = document.createElement('td');
//                     const sendButton = document.createElement('button');
//                     sendButton.textContent = 'Envoyer';
//                     sendButton.classList.add('btn', 'btn-success');
//                     sendButton.onclick = () => {
//                         window.open(whatsappUrl, '_blank');
//                     };
//                     actionCell.appendChild(sendButton);
//                     row.appendChild(actionCell);

//                     // Ajouter la ligne au corps du tableau
//                     tbody.appendChild(row);
//                 });

//                 // Ajouter le corps du tableau au tableau principal
//                 table.appendChild(tbody);

//                 // Ajouter le tableau au conteneur
//                 linksContainer.appendChild(table);
//             })
//             .catch(error => {
//                 console.error('Erreur  dans le try :', error);
//             });

//     }


//     /**
//      * Initialize the module.
//      */
//     function initialize() {

//         $sendWhatsappSettings.on('click', onSendMessageWhatsapp);
//         const whatsappSettings = vars('whatsapp-settings');
//     }

//     document.addEventListener('DOMContentLoaded', initialize);

//     return {};
// })();




// App.Pages.Whatsapp_settings = (function () {
//     function onSendMessageWhatsappAuto() {
//         const url_auto = 'whatsapp_settings/getClientsWithRole';
//         const whatsappApiUrl = 'https://graph.facebook.com/v20.0/417831894750102/messages';
//         const accessToken = 'EAAGRjAr5XWwBOz8zp9ViVsFE7FxmiZC7iHh4CZC4l8Fkj5H6WRuKPOztwcZAZA7plrU2VpM5EeDHRAucaUovQST3ZC8tOZAX3R1fKfBWdBhUNuMPcJTbHqwLEzOa3H1lWgIqGhx09zPp0DKHYOWcuNWmo4POuku5yyuh8RDKCdnCkYFjFr6nRJZAoMJ2ZC1pWtx6BM4HfRFzCjE2tFRqE8lTJPaa78gZD';

//         console.log("Fetching clients...");
//         fetch(url_auto)
//             .then(response => response.json())
//             .then(clients_auto => {
//                 console.log("Clients fetched: ", clients_auto);
//                 if (clients_auto.error) {
//                     console.error(clients_auto.error);
//                     return;
//                 }

//                 console.log("Les clients sont bien récupérés");

//                 clients_auto.forEach(client_auto => {
//                     if (!client_auto.phone_number) {
//                         console.error(`Client ${client_auto.last_name} n'a pas de numéro de téléphone.`);
//                         return;
//                     }

//                     const messageData = {
//                         messaging_product: 'whatsapp',
//                         to: client_auto.phone_number,
//                         type: 'template',
//                         template: {
//                             name: 'hello_world',
//                             language: { code: 'en_US' }
//                         }
//                     };

//                     fetch(whatsappApiUrl, {
//                         method: 'POST',
//                         headers: {
//                             'Authorization': `Bearer ${accessToken}`,
//                             'Content-Type': 'application/json'
//                         },
//                         body: JSON.stringify(messageData)
//                     })
//                     .then(response => {
//                         if (response.status === 401) {
//                             throw new Error("Unauthorized - Invalid token or expired");
//                         }
//                         return response.json();
//                     })
//                     .then(data => {
//                         if (data.error) {
//                             console.error(`Erreur lors de l'envoi au client ${client_auto.last_name}:`, data.error);
//                         } else {
//                             console.log(`Message envoyé au client ${client_auto.last_name}:`, data);
//                         }
//                     })
//                     .catch(error => {
//                         console.error(`Erreur lors de l'envoi au client ${client_auto.last_name}:`, error);
//                     });
//                 });
//             })
//             .catch(error => {
//                 console.error("Erreur lors de la récupération des clients:", error);
//             });
//     }

//     // Définir l'heure cible (par exemple, à la prochaine minute)
//     const now = new Date();
//     const targetTime = new Date();

//     // Si nous sommes déjà passés cette minute, définissons la minute pour le jour suivant
//     if (now.getMinutes() >= 24) {
//         targetTime.setDate(targetTime.getDate() + 1);
//     }

//     // Définir les heures et minutes cibles
//     targetTime.setHours(now.getHours(), 24, 0, 0); // Par exemple, 22 minutes

//     const timeout = targetTime - now;

//     console.log(`Attente jusqu'à ${targetTime} (${timeout} ms)`);

//     setTimeout(() => {
//         console.log("Exécution de la fonction à l'heure cible");
//         onSendMessageWhatsappAuto();
//         // Si tu souhaites que la fonction s'exécute régulièrement après cela
//         setInterval(onSendMessageWhatsappAuto, 5 * 60 * 1000);
//     }, timeout);

//     return {};
// })();



App.Pages.Whatsapp_settings = (function () {
    function onSendMessageWhatsappAuto() {

        const url_appointement = 'whatsapp_settings/getAppointments';

        const whatsappApiUrl = 'https://graph.facebook.com/v20.0/417831894750102/messages';
        const accessToken = 'EAAGRjAr5XWwBOz8zp9ViVsFE7FxmiZC7iHh4CZC4l8Fkj5H6WRuKPOztwcZAZA7plrU2VpM5EeDHRAucaUovQST3ZC8tOZAX3R1fKfBWdBhUNuMPcJTbHqwLEzOa3H1lWgIqGhx09zPp0DKHYOWcuNWmo4POuku5yyuh8RDKCdnCkYFjFr6nRJZAoMJ2ZC1pWtx6BM4HfRFzCjE2tFRqE8lTJPaa78gZD';

        fetch(url_appointement)
            .then(response => response.json())
            .then(appointement_autos => {
                console.log("appointement fetched: ", appointement_auto);
                if (appointement_autos.error) {
                    console.error(appointement_autos.error);
                    return;
                }

                console.log("Les appointement sont bien récupérés");

                appointement_autos.forEach((appointement_auto, index) => {
                    const url_client = `whatsapp_settings/getClientsWithRoleAndAppointments/${appointement_auto.id_users_customer}`;

                    // Formater les dates et heures
                    const startDate = formatDateTime(appointement_auto.start_datetime);
                    const endDate = formatDateTime(appointement_auto.end_datetime);

                    // pour chaque rendez-vous récupere le service associé
                    const url_service = `whatsapp_settings/getClientsWithRoleAndAppointmentsAndService/${appointement_auto.id_services}`;
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

                                const client_auto = clients[0]; // Supposons qu'il n'y ait qu'un seul client
                                const message = `Bonjour, ${client_auto.first_name} ${client_auto.last_name}. Ceci est un rappel de votre rendez-vous du: ${startDate.date} de : ${startDate.time} À ${endDate.time} pour le service : ${services.name}`;

                                if (!client_auto.phone_number) {
                                    console.error(`Client ${client_auto.last_name} n'a pas de numéro de téléphone.`);
                                    return;
                                }

                                const messageData = {
                                    messaging_product: 'whatsapp',
                                    to: client_auto.phone_number,
                                    type: 'template',
                                    template: {
                                        name: 'hello_world',
                                        language: { code: 'en_US' }
                                    }
                                };

                                fetch(whatsappApiUrl, {
                                    method: 'POST',
                                    headers: {
                                        'Authorization': `Bearer ${accessToken}`,
                                        'Content-Type': 'application/json'
                                    },
                                    body: JSON.stringify(messageData)
                                })
                                    .then(response => {
                                        if (response.status === 401) {
                                            throw new Error("Unauthorized - Invalid token or expired");
                                        }
                                        return response.json();
                                    })
                                    .then(data => {
                                        if (data.error) {
                                            console.error(`Erreur lors de l'envoi au client ${client_auto.last_name}:`, data.error);
                                        } else {
                                            console.log(`Message envoyé au client ${client_auto.last_name}:`, data);
                                        }
                                    })
                                    .catch(error => {
                                        console.error(`Erreur lors de l'envoi au client ${client_auto.last_name}:`, error);
                                    });
                        });
                    });
                });
            })
            .catch(error => {
                console.error("Erreur lors de la récupération des clients:", error);
            });
    }

    // Définir l'heure cible (par exemple, à la prochaine minute)
    const now = new Date();
    const targetTime = new Date();

    // Si nous sommes déjà passés cette minute, définissons la minute pour le jour suivant
    if (now.getMinutes() >= 36) {
        targetTime.setDate(targetTime.getDate() + 1);
    }

    // Définir les heures et minutes cibles
    targetTime.setHours(now.getHours(), 36, 0, 0); // Par exemple, 22 minutes

    const timeout = targetTime - now;

    console.log(`Attente jusqu'à ${targetTime} (${timeout} ms)`);

    setTimeout(() => {
        console.log("Exécution de la fonction à l'heure cible");
        onSendMessageWhatsappAuto();
        // Si tu souhaites que la fonction s'exécute régulièrement après cela
        setInterval(onSendMessageWhatsappAuto, 5 * 60 * 1000);
    }, timeout);

    return {};

})();


// App.Pages.Whatsapp_settings = (function () {
//     function onSendMessageWhatsappAuto() {

//         console.log("########### onSendMessageWhatsappAuto ##############");

//         const url_appointement = 'whatsapp_settings/getAppointments';

//         const whatsappApiUrl = 'https://graph.facebook.com/v20.0/417831894750102/messages';
//         const accessToken = 'EAAGRjAr5XWwBO8cYAt4mNtgPehitHQTP1NsbEVrhAlaQDfXrSiCuJBLNjdp2JfYfDuPApJQZARVxnzPvx5wJ56nCfMMsVogLB0zBvgMH6o9SY21IFTgV42totEHomMp0OdQyVtgIoAqbr49JgusSlVpZA61VWeZC1sv50ICi3hdMX5bUlzWjyqzXZBypfbWQO6jpZA15crhu7FPFcDrmf6pfXFaAZD';

//         fetch(url_appointement)
//             .then(response => response.json())
//             .then(appointement_autos => {
//                 console.log("appointement fetched: ", appointement_autos);
//                 if (appointement_autos.error) {
//                     console.error(appointement_autos.error);
//                     return;
//                 }
//                 console.log("########### appointement_autos ##############");

//                 appointement_autos.forEach((appointement_auto, index) => {
//                     const url_client = `whatsapp_settings/getClientsWithRoleAndAppointments/${appointement_auto.id_users_customer}`;

//                     const startDate = formatDateTime(appointement_auto.start_datetime);
//                     const endDate = formatDateTime(appointement_auto.end_datetime);

//                     const url_service = `whatsapp_settings/getClientsWithRoleAndAppointmentsAndService/${appointement_auto.id_services}`;
//                     fetch(url_service)
//                         .then(response => response.json())
//                         .then(services => {
//                             if (services.error || services.length === 0) {
//                                 console.error('Erreur lors de la récupération du service.');
//                                 return;
//                             }
//                             console.log("########### services ##############");

//                             fetch(url_client)
//                                 .then(response => response.json())
//                                 .then(clients => {
//                                     console.log("########### clients ##############");
//                                     if (clients.error || clients.length === 0) {
//                                         console.error('Erreur lors de la récupération du client.');
//                                         return;
//                                     }

//                                     const client_auto = clients[0];
//                                     const message = `Bonjour, ${client_auto.first_name} ${client_auto.last_name}. Ceci est un rappel de votre rendez-vous du: ${startDate.date} de : ${startDate.time} À ${endDate.time} pour le service : ${services.name}`;

//                                     if (!client_auto.phone_number) {
//                                         console.error(`Client ${client_auto.last_name} n'a pas de numéro de téléphone.`);
//                                         return;
//                                     }
//                                     console.log("#########################");
//                                     console.log(client_auto.phone_number);
//                                     console.log("#########################");
//                                     const messageData = {
//                                         messaging_product: 'whatsapp',
//                                         to: client_auto.phone_number,
//                                         type: 'template',
//                                         template: {
//                                             name: 'hello_world',
//                                             language: { code: 'en_US' }
//                                         }
//                                     };

//                                     fetch(whatsappApiUrl, {
//                                         method: 'POST',
//                                         headers: {
//                                             'Authorization': `Bearer ${accessToken}`,
//                                             'Content-Type': 'application/json'
//                                         },
//                                         body: JSON.stringify(messageData)
//                                     })
//                                     .then(response => {
//                                         if (response.status === 401) {
//                                             throw new Error("Unauthorized - Invalid token or expired");
//                                         }
//                                         return response.json();
//                                     })
//                                     .then(data => {
//                                         if (data.error) {
//                                             console.error(`Erreur lors de l'envoi au client ${client_auto.last_name}:`, data.error);
//                                         } else {
//                                             console.log(`Message envoyé au client ${client_auto.last_name}:`, data);
//                                         }
//                                     })
//                                     .catch(error => {
//                                         console.error(`Erreur lors de l'envoi au client ${client_auto.last_name}:`, error);
//                                     });
//                                 })
//                                 .catch(error => {
//                                     console.error("Erreur lors de la récupération des clients:", error);
//                                 });
//                         })
//                         .catch(error => {
//                             console.error('Erreur lors de la récupération du service:', error);
//                         });
//                 });
//             })
//             .catch(error => {
//                 console.error("Erreur lors de la récupération des rendez-vous:", error);
//             });
//     }

//     // Définir l'heure actuelle et l'heure cible (13h:15)
//     const now = new Date();
//     const targetTime = new Date();

//     // Définit l'heure cible à 13h:15
//     targetTime.setHours(13, 27, 0, 0); // 13h:15

//     // Si l'heure actuelle est déjà passée, on programme l'exécution pour le lendemain
//     if (now > targetTime) {
//         targetTime.setDate(targetTime.getDate() + 1);
//     }

//     // Calculer le délai en millisecondes avant d'exécuter la fonction
//     const timeout = targetTime - now;

//     console.log(`Attente jusqu'à ${targetTime} (${timeout} ms)`);

//     setTimeout(() => {
//         console.log("Exécution de la fonction à l'heure cible");
//         onSendMessageWhatsappAuto();
//         // Répète l'exécution toutes les 24 heures (86400000 ms)
//         setInterval(onSendMessageWhatsappAuto, 24 * 60 * 60 * 1000);
//     }, timeout);

//     return {};

// })();


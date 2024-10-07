// ########################## bloc 01


// App.Pages.Whatsapp_settings = (function () {
//     function onSendMessageWhatsappAuto() {
//         console.log("Les appointement sont bien récupérés");
//         const url_appointement = 'whatsapp_settings/getAppointments';

//         const whatsappApiUrl = 'https://graph.facebook.com/v20.0/417831894750102/messages';
//         const accessToken = 'EAAGRjAr5XWwBOz8zp9ViVsFE7FxmiZC7iHh4CZC4l8Fkj5H6WRuKPOztwcZAZA7plrU2VpM5EeDHRAucaUovQST3ZC8tOZAX3R1fKfBWdBhUNuMPcJTbHqwLEzOa3H1lWgIqGhx09zPp0DKHYOWcuNWmo4POuku5yyuh8RDKCdnCkYFjFr6nRJZAoMJ2ZC1pWtx6BM4HfRFzCjE2tFRqE8lTJPaa78gZD';

//         fetch(url_appointement)
//             .then(response => response.json())
//             .then(appointement_autos => {
//                 console.log("appointement fetched: ", appointement_auto);
//                 if (appointement_autos.error) {
//                     console.error(appointement_autos.error);
//                     return;
//                 }

//                 console.log("Les appointement sont bien récupérés");

//                 appointement_autos.forEach((appointement_auto, index) => {
//                     const url_client = `whatsapp_settings/getClientsWithRoleAndAppointments/${appointement_auto.id_users_customer}`;

//                     // Formater les dates et heures
//                     const startDate = formatDateTime(appointement_auto.start_datetime);
//                     const endDate = formatDateTime(appointement_auto.end_datetime);

//                     // pour chaque rendez-vous récupere le service associé
//                     const url_service = `whatsapp_settings/getClientsWithRoleAndAppointmentsAndService/${appointement_auto.id_services}`;
//                     fetch(url_service)
//                         .then(response => response.json())
//                         .then(services => {
//                             if (services.error || services.length === 0) {
//                                 console.error('Erreur lors de la récupération du service.');
//                                 linksContainer.textContent = 'Erreur lors de la récupération du service.';
//                                 return;
//                             }

//                             // pour chaque rendez-vous récupère le client associé
//                             fetch(url_client)
//                             .then(response => response.json())
//                             .then(clients => {
//                                 if (clients.error || clients.length === 0) {
//                                     console.error('Erreur lors de la récupération du client.');
//                                     linksContainer.textContent = 'Erreur lors de la récupération du client.';
//                                     return;
//                                 }

//                                 const client_auto = clients[0]; // Supposons qu'il n'y ait qu'un seul client
//                                 const message = `Bonjour, ${client_auto.first_name} ${client_auto.last_name}. Ceci est un rappel de votre rendez-vous du: ${startDate.date} de : ${startDate.time} À ${endDate.time} pour le service : ${services.name}`;

//                                 if (!client_auto.phone_number) {
//                                     console.error(`Client ${client_auto.last_name} n'a pas de numéro de téléphone.`);
//                                     return;
//                                 }

//                                 const messageData = {
//                                     messaging_product: 'whatsapp',
//                                     to: client_auto.phone_number,
//                                     type: 'template',
//                                     template: {
//                                         name: 'hello_world',
//                                         language: { code: 'en_US' }
//                                     }
//                                 };

//                                 fetch(whatsappApiUrl, {
//                                     method: 'POST',
//                                     headers: {
//                                         'Authorization': `Bearer ${accessToken}`,
//                                         'Content-Type': 'application/json'
//                                     },
//                                     body: JSON.stringify(messageData)
//                                 })
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
//                         });
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
//     if (now.getMinutes() >= 36) {
//         targetTime.setDate(targetTime.getDate() + 1);
//     }

//     // Définir les heures et minutes cibles
//     targetTime.setHours(now.getHours(), 36, 0, 0); // Par exemple, 22 minutes

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







// ########################## bloc 02








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

//     console.log(`Attente 22 jusqu'à ${targetTime} (${timeout} ms)`);

//     setTimeout(() => {
//         console.log("Exécution de la fonction à l'heure cible");
//         onSendMessageWhatsappAuto();
//         // Répète l'exécution toutes les 24 heures (86400000 ms)
//         setInterval(onSendMessageWhatsappAuto, 24 * 60 * 60 * 1000);
//     }, timeout);

//     return {};

// })();









// ########################## bloc 03


App.Pages.Whatsapp_settings = (function () {
    // Fonction pour formater la date et l'heure
    function formatDateTime(dateTimeString) {
        const date = new Date(dateTimeString);

        if (isNaN(date.getTime())) {
            throw new Error("Date invalide fournie");
        }

        // Formater la date en 'DD/MM/YYYY'
        const formattedDate = date.toLocaleDateString('fr-FR');

        // Formater l'heure en 'HH:MM'
        const formattedTime = date.toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' });

        return {
            date: formattedDate,
            time: formattedTime
        };
    }

    async function onSendMessageWhatsappAuto() {
        console.log("########### onSendMessageWhatsappAuto ##############");

        const url_appointement = 'page/whatsapp_settings/getAppointments';
        const whatsappApiUrl = 'https://graph.facebook.com/v20.0/417831894750102/messages';
        const accessToken = 'EAAGRjAr5XWwBO738zo4G2QNYYBS7DHAbWzXJTtcav3pzo6EkR6opWiZCBCIsT1ZBKXIoZAn8JsNrEPqhen0ZCv4875CLmnNIHPRdAHnkdfNhiy7B1ftAwdMDgRZCZB0yjEwvDq1ZCkZANn4TzRWyRfgOz2xZBpQw12xnqaaQu0ZCRaOzbOC8Mn1o5qWvKKNHmIwPhiVPSWk2TRZCuZAH0PFA2QfmHS0U690ZD';

        try {
            const response = await fetch(url_appointement);
            if (!response.ok) throw new Error(`Erreur HTTP: ${response.status}`);
            const appointement_autos = await response.json();

            console.log("appointement fetched: ", appointement_autos);

            if (appointement_autos.error) {
                console.error(appointement_autos.error);
                return;
            }

            for (const appointement_auto of appointement_autos) {
                const url_client = `whatsapp_settings/getClientsWithRoleAndAppointments/${appointement_auto.id_users_customer}`;
                const startDate = formatDateTime(appointement_auto.start_datetime);
                const endDate = formatDateTime(appointement_auto.end_datetime);
                const url_service = `whatsapp_settings/getClientsWithRoleAndAppointmentsAndService/${appointement_auto.id_services}`;

                try {
                    const serviceResponse = await fetch(url_service);
                    if (!serviceResponse.ok) throw new Error(`Erreur HTTP: ${serviceResponse.status}`);
                    const services = await serviceResponse.json();

                    if (services.error || services.length === 0) {
                        console.error('Erreur lors de la récupération du service.');
                        continue;
                    }

                    const clientResponse = await fetch(url_client);
                    if (!clientResponse.ok) throw new Error(`Erreur HTTP: ${clientResponse.status}`);
                    const clients = await clientResponse.json();

                    if (clients.error || clients.length === 0) {
                        console.error('Erreur lors de la récupération du client.');
                        continue;
                    }

                    const client_auto = clients[0];

                    if (!client_auto.phone_number) {
                        console.error(`Client ${client_auto.last_name} n'a pas de numéro de téléphone.`);
                        continue;
                    }

                    // Message personnalisé à envoyer
                    const customMessage = `Bonjour, ${client_auto.first_name} ${client_auto.last_name}. Ceci est un rappel de votre rendez-vous du ${startDate.date} de ${startDate.time} à ${endDate.time} pour le service ${services.name}.`;

                    const messagePayload = {
                        messaging_product: 'whatsapp',
                        to: client_auto.phone_number,
                        type: 'template',
                        template: {
                            name: 'hello_world',
                            language: { code: 'en_US' }
                        }
                        
                    };

                    try {
                        const messageResponse = await fetch(whatsappApiUrl, {
                            method: 'POST',
                            headers: {
                                'Authorization': `Bearer ${accessToken}`,
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify(messagePayload)
                        });

                        if (messageResponse.status === 401) {
                            throw new Error("Unauthorized - Invalid token or expired");
                        }

                        const responseData = await messageResponse.json();

                        if (responseData.error) {
                            console.error(`Erreur lors de l'envoi au client ${client_auto.last_name}:`, responseData.error);
                        } else {
                            console.log(`Message envoyé au client ${client_auto.last_name}:`, responseData);
                        }
                    } catch (error) {
                        console.error(`Erreur lors de l'envoi au client ${client_auto.last_name}:`, error);
                    }
                } catch (error) {
                    console.error('Erreur lors de la récupération du service ou des clients:', error);
                }
            }
        } catch (error) {
            console.error("Erreur lors de la récupération des rendez-vous:", error);
        }
    }

    // Exécuter la fonction initialement
    onSendMessageWhatsappAuto();

    // Répéter l'exécution de la fonction toutes les 3 minutes (180 000 ms)
    setInterval(onSendMessageWhatsappAuto, 180000); // 3 minutes

    return {};
})();


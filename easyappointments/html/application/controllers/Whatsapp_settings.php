<?php defined('BASEPATH') or exit('No direct script access allowed');

/* ----------------------------------------------------------------------------
 * Easy!Appointments - Online Appointment Scheduler
 *
 * @package     EasyAppointments
 * @author      A.Tselegidis <alextselegidis@gmail.com>
 * @copyright   Copyright (c) Alex Tselegidis
 * @license     https://opensource.org/licenses/GPL-3.0 - GPLv3
 * @link        https://easyappointments.org
 * @since       v1.5.0
 * ---------------------------------------------------------------------------- */

/**
 * Google Analytics settings controller.
 *
 * Handles Google Analytics settings related operations.
 *
 * @package Controllers
 */
class Whatsapp_settings extends EA_Controller
{
    /**
     * Whatsapp_settings constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('settings_model');
        $this->load->model('users_model');
        $this->load->model('appointments_model');
        $this->load->model('services_model');

        $this->load->library('accounts');
    }

    /**
     * Render the settings page.
     */
    public function index(): void
    {   

       

        session(['dest_url' => site_url('whatsapp_settings')]);

        $user_id = session('user_id');

        if (cannot('view', PRIV_SYSTEM_SETTINGS)) {
            if ($user_id) {
                abort(403, 'Forbidden');
            }

            redirect('login');

            return;
        }

        $role_slug = session('role_slug');

        script_vars([
            'user_id' => $user_id,
            'role_slug' => $role_slug,
            'whatsapp_settings' => $this->settings_model->get('name like "whatsapp_%"'),
        ]);

        html_vars([
            'page_title' => lang('whatsapp'),
            'active_menu' => PRIV_SYSTEM_SETTINGS,
            'user_display_name' => $this->accounts->get_user_display_name($user_id),
        ]);

        $this->load->view('pages/whatsapp_settings');
    }

    /**
     * Save general settings.
     */
    public function save(): void
    {
        try {
            if (cannot('edit', PRIV_SYSTEM_SETTINGS)) {
                throw new RuntimeException('You do not have the required permissions for this task.');
            }

            $settings = request('whatsapp', []);

            foreach ($settings as $setting) {
                $existing_setting = $this->settings_model
                    ->query()
                    ->where('name', $setting['name'])
                    ->get()
                    ->row_array();

                if (!empty($existing_setting)) {
                    $setting['id'] = $existing_setting['id'];
                }

                $this->settings_model->save($setting);
            }

            response();
        } catch (Throwable $e) {
            json_exception($e);
        }
    }



    /**
     * Récupère les clients dans la table "ea_users" dont "id_roles = 3 ".
     */

    public function getClientsWithRole() {
        try {
            $clients = $this->users_model
                ->query()
                ->where('id_roles', 3)
                ->get()
                ->result_array(); // Utilise result_array pour retourner plusieurs clients
    
            if (!empty($clients)) {
                // Envoyer les résultats au JavaScript sous forme de JSON
                echo json_encode($clients);
            } else {
                // Si aucun client n'est trouvé
                echo json_encode([]);
            }
    
        } catch (Exception $e) {
            // Utilise json_exception pour envoyer un message d'erreur au format JSON
            json_exception($e);
        }
    }

    public function getClientsWithRoleAndAppointments($id_users_customer) {
        try {
            $clients = $this->users_model
                ->query()
                ->where('id_roles', 3)
                ->where('id', $id_users_customer)
                ->get()
                ->result_array(); // Utilise result_array pour retourner plusieurs appointments
    
            if (!empty($clients)) {
                // Envoyer les résultats au JavaScript sous forme de JSON
                echo json_encode($clients);
            } else {
                // Si aucun appointments n'est trouvé
                echo json_encode([]);
            }
    
        } catch (Exception $e) {
            // Utilise json_exception pour envoyer un message d'erreur au format JSON
            json_exception($e);
        }
    }


    public function getClientsWithRoleAndAppointmentsAndService($id_service) {
        try {
            // Requête pour récupérer le service correspondant à l'ID fourni
            $service = $this->services_model
                ->query()
                ->where('id', 1)
                ->get()
                ->row_array(); // Utiliser row_array pour obtenir un seul résultat
            
            if (!empty($service)) {
                // Si un service est trouvé, le renvoyer en JSON
                echo json_encode($service);
            } else {
                // Si aucun service n'est trouvé
                echo json_encode([]);
            }
    
        } catch (Exception $e) {
            // En cas d'erreur, renvoyer un message d'erreur au format JSON
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    // public function getClientsWithRoleAndAppointmentsAndRecherche($search) {
    //     try {
    //         // Requête pour récupérer les rdv par mot de recherche
    //         $service = $this->services_model
    //             ->query()
    //             ->where('id', 1)
    //             ->get()
    //             ->row_array(); // Utiliser row_array pour obtenir un seul résultat
            
    //         // if (!empty($service)) {
    //         //     // Si un service est trouvé, le renvoyer en JSON
    //         //     echo json_encode($service);
    //         // } else {
    //         //     // Si aucun service n'est trouvé
    //         //     echo json_encode([]);
    //         // }
    
    //     } catch (Exception $e) {
    //         // En cas d'erreur, renvoyer un message d'erreur au format JSON
    //         echo json_encode(['error' => $e->getMessage()]);
    //     }
    // }
    
    
    public function getClientsWithRoleAndAppointmentsAndDays($date_to_days) {
        try {
            // Utiliser la fonction DATE() pour extraire uniquement la date de start_datetime
            $appointments = $this->appointments_model
                ->query()
                ->where("DATE(start_datetime)", $date_to_days) // Comparer la date extraite avec celle passée en paramètre
                ->get()
                ->result_array();
    
            if (!empty($appointments)) {
                // Envoyer les résultats au JavaScript sous forme de JSON
                echo json_encode($appointments);
            } else {
                // Si aucun rendez-vous n'est trouvé
                echo json_encode([]);
            }
    
        } catch (Exception $e) {
            // Utilise json_exception pour envoyer un message d'erreur au format JSON
            json_exception($e);
        }
    }

    
    
    public function getClientsWithRoleAndAppointmentsAndTomorrow($dateTomorrow) {
        try {
            // Utiliser la fonction DATE() pour extraire uniquement la date de start_datetime
            $appointments = $this->appointments_model
                ->query()
                ->where("DATE(start_datetime)", $dateTomorrow) // Comparer la date extraite avec celle passée en paramètre
                ->get()
                ->result_array();
    
            if (!empty($appointments)) {
                // Envoyer les résultats au JavaScript sous forme de JSON
                echo json_encode($appointments);
            } else {
                // Si aucun rendez-vous n'est trouvé
                echo json_encode([]);
            }
    
        } catch (Exception $e) {
            // Utilise json_exception pour envoyer un message d'erreur au format JSON
            json_exception($e);
        }
    }
    
    
    public function getClientsWithRoleAndAppointmentsAndWeek($startOfWeek, $endOfWeek) {
        try {
            // Utiliser la méthode BETWEEN pour sélectionner les rendez-vous entre les deux dates
            $appointments = $this->appointments_model
                ->query()
                ->where("DATE(start_datetime) >=", $startOfWeek) // Comparer avec la date de début de la semaine
                ->where("DATE(start_datetime) <=", $endOfWeek)   // Comparer avec la date de fin de la semaine
                ->get()
                ->result_array();
        
            if (!empty($appointments)) {
                // Envoyer les résultats au JavaScript sous forme de JSON
                echo json_encode($appointments);
            } else {
                // Si aucun rendez-vous n'est trouvé
                echo json_encode([]);
            }
        } catch (Exception $e) {
            // Utilise json_exception pour envoyer un message d'erreur au format JSON
            json_exception($e);
        }
    }
    

    public function getClientsWithRoleAndAppointmentsAndDate($startDate) {
        try {
            // Utiliser la fonction DATE() pour extraire uniquement la date de start_datetime
            $appointments = $this->appointments_model
                ->query()
                ->where("DATE(start_datetime)", $startDate) // Comparer la date extraite avec celle passée en paramètre
                ->get()
                ->result_array();
    
            if (!empty($appointments)) {
                // Envoyer les résultats au JavaScript sous forme de JSON
                echo json_encode($appointments);
            } else {
                // Si aucun rendez-vous n'est trouvé
                echo json_encode([]);
            }
    
        } catch (Exception $e) {
            // Utilise json_exception pour envoyer un message d'erreur au format JSON
            json_exception($e);
        }
    }

    public function getClientsWithRoleAndAppointmentsAndDates($startDateTime, $endDateTime) {
        try {
            // Utiliser la méthode BETWEEN pour sélectionner les rendez-vous entre les deux dates
            $appointments = $this->appointments_model
                ->query()
                ->where("DATE(start_datetime) >=", $startDateTime) // Comparer avec la date de début de la semaine
                ->where("DATE(start_datetime) <=", $endDateTime)   // Comparer avec la date de fin de la semaine
                ->get()
                ->result_array();
        
            if (!empty($appointments)) {
                // Envoyer les résultats au JavaScript sous forme de JSON
                echo json_encode($appointments);
            } else {
                // Si aucun rendez-vous n'est trouvé
                echo json_encode([]);
            }
        } catch (Exception $e) {
            // Utilise json_exception pour envoyer un message d'erreur au format JSON
            json_exception($e);
        }
    }

  
    

    public function getClientsWithRoleAndAppointmentsAndMonth($startOfMonth, $endOfMonth) {
        try {
            // Utiliser la méthode BETWEEN pour sélectionner les rendez-vous entre les deux dates
            $appointments = $this->appointments_model
                ->query()
                ->where("DATE(start_datetime) >=", $startOfMonth) // Comparer avec la date de début de la semaine
                ->where("DATE(start_datetime) <=", $endOfMonth)   // Comparer avec la date de fin de la semaine
                ->get()
                ->result_array();
        
            if (!empty($appointments)) {
                // Envoyer les résultats au JavaScript sous forme de JSON
                echo json_encode($appointments);
            } else {
                // Si aucun rendez-vous n'est trouvé
                echo json_encode([]);
            }
        } catch (Exception $e) {
            // Utilise json_exception pour envoyer un message d'erreur au format JSON
            json_exception($e);
        }
    }
    
    


    /**
     * Récupère les rendez-vous du client reçu en paramettre ".
     */
    
    // public function getClientWithAppointments($id_client) {
    //         try {
    //             // Construire la requête avec une jointure pour un client spécifique
    //             $client = $this->db->select('ea_users.id, ea_users.first_name, ea_users.last_name, ea_users.phone_number, ea_appointments.appointment_date')
    //                 ->from('ea_users')
    //                 ->join('ea_appointments', 'ea_appointments.id_users_customer = ea_users.id', 'left')
    //                 ->where('ea_users.id_role', 3) // Filtrer les clients
    //                 ->where('ea_users.id', $id_client) // Filtrer par l'ID du client
    //                 ->get()
    //                 ->row_array(); // Retourner un seul résultat
        
    //             // Renvoyer les résultats sous forme de JSON
    //             echo json_encode($client);
    //         } catch (Exception $e) {
    //             echo json_encode(['error' => $e->getMessage()]);
    //         }
    // }

    public function getAppointments() {
        try {
            $appointments = $this->appointments_model 
                ->query()
                ->get()
                ->result_array(); 
    
            if (!empty($appointments)) {
                // Envoyer les résultats au JavaScript sous forme de JSON
                echo json_encode($appointments);
            } else {
                // Si aucun appointment n'est trouvé
                echo json_encode([]);
            }
    
        } catch (Exception $e) {
            // Utilise json_exception pour envoyer un message d'erreur au format JSON
            json_exception($e);
        }
    }
    
}

<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Google Analytics settings controller.
 *
 * Handles Google Analytics settings related operations.
 *
 * @package Controllers
 */


 class Whatsapp_send_message extends EA_Controller
{
    /**
     * Whatsapp_settings constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('settings_model');
        $this->load->model('users_model');

        $this->load->library('accounts');
    }

    /**
     * Render the settings page.
     */
    public function index(): void
    {   

       

        session(['dest_url' => site_url('whatsapp_send_message')]);

        $user_id = session('user_id');

        if (cannot('view', PRIV_SYSTEM_SETTINGS)) {
            if ($user_id) {
                abort(403, 'Forbidden');
            }

            redirect('login');

            return;
        }

        $role_slug = session('role_slug');

        // script_vars([
        //     'user_id' => $user_id,
        //     'role_slug' => $role_slug,
        //     'whatsapp_settings' => $this->settings_model->get('name like "whatsapp_%"'),
        // ]);

        html_vars([
            'page_title' => lang('whatsapp_send_message'),
            'active_menu' => PRIV_SYSTEM_SETTINGS,
            'user_display_name' => $this->accounts->get_user_display_name($user_id),
        ]);

        $this->load->view('pages/whatsapp_send_message');
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
    
}
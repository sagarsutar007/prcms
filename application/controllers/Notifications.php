<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notifications extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Notification_model', 'notification');
		$this->load->model('Candidates_model', 'candidate');
		
	}

    public function isValidUser($value='')
	{
		if (!$this->session->has_userdata('id') && ($this->session->userdata('type') != "admin" || $this->session->userdata('type') != "business unit")) {
			echo "<h1>Forbidden!!!</h1>"; exit();
		}
	}

	public function index()
	{
		if($this->session->userdata('id') && $this->session->userdata('type') == 'admin'){
            if (isset($_GET['type']) && $_GET['type'] == "sms") {
                $type = 'sms';
                $data['title'] = 'Sms Delivery Reports';
            } else {
                $type = 'email';
                $data['title'] = 'Email Delivery Reports';
            }

            $data['records'] = $this->notification->getLogs($type);

            $this->load->view('app/notifications', $data);
        }
	}
    

    public function ajaxView($value='')
	{
		$this->isValidUser();
		if (empty($value)){ echo "<h1> Forbidden! </h1>"; exit(); }
		$data['record'] = $this->notification->get($value);
		echo $this->load->view('app/ajax/view-notification', $data, TRUE);
	}
}

/* End of file Notifications.php */
/* Location: ./application/controllers/Notifications.php */
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require 'vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

class Qrcodes extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Users_model', 'user_model');
		$this->load->model('Business_units_model', 'business_model');
        
	}

	public function isValidUser($value='')
	{
		if (!$this->session->has_userdata('id') && $this->session->userdata('type') != "admin") {
			redirect('logout');
		}
	}

	public function index()
	{
        $this->isValidUser();
        $data['title'] = "QR Codes";
        $this->load->library('ciqrcode');

        if($this->session->userdata('type') == 'business unit'){
            $data['companies'] = $this->business_model->getUserCompanies($this->session->userdata('id'), 'business unit');
            foreach ($data['companies'] as $key => $com) {
                if (!file_exists('./assets/admin/img/qrcodes/client-'.$com['id'].'-signup.png')) {
                    $params['data'] = base_url('client-signup?com_id='.$com['id']);
                    $params['level'] = 'H';
                    $params['size'] = 10;
                    $params['savename'] = FCPATH.'assets/admin/img/qrcodes/client-'.$com['id'].'-signup.png';
                    $this->ciqrcode->generate($params);
                }
        
                if (!file_exists('./assets/admin/img/qrcodes/candidate-'.$com['id'].'-signup.png')) {
                    $params['data'] = base_url('candidate-signup?com_id='.$com['id']);
                    $params['level'] = 'H';
                    $params['size'] = 10;
                    $params['savename'] = FCPATH.'assets/admin/img/qrcodes/candidate-'.$com['id'].'-signup.png';
                    $this->ciqrcode->generate($params);
                }
            }
        }

        if (!file_exists('./assets/admin/img/qrcodes/candidate-login.png')) {
            $params['data'] = "https://candidate.simrangroups.com";
            $params['level'] = 'H';
            $params['size'] = 10;
            $params['savename'] = FCPATH.'assets/admin/img/qrcodes/candidate-login.png';
            $this->ciqrcode->generate($params);
        }

        if (!file_exists('./assets/admin/img/qrcodes/client-login.png')) {
            $params['data'] = base_url('client-login');
            $params['level'] = 'H';
            $params['size'] = 10;
            $params['savename'] = FCPATH.'assets/admin/img/qrcodes/client-login.png';
            $this->ciqrcode->generate($params);
        }

        if (!file_exists('./assets/admin/img/qrcodes/business-login.png')) {
            $params['data'] = base_url('business-login');
            $params['level'] = 'H';
            $params['size'] = 10;
            $params['savename'] = FCPATH.'assets/admin/img/qrcodes/business-login.png';
            $this->ciqrcode->generate($params);
        }

        if (!file_exists('./assets/admin/img/qrcodes/client-signup.png')) {
            $params['data'] = base_url('client-signup');
            $params['level'] = 'H';
            $params['size'] = 10;
            $params['savename'] = FCPATH.'assets/admin/img/qrcodes/client-signup.png';
            $this->ciqrcode->generate($params);
        }

        if (!file_exists('./assets/admin/img/qrcodes/candidate-signup.png')) {
            $params['data'] = base_url('candidate-signup');
            $params['level'] = 'H';
            $params['size'] = 10;
            $params['savename'] = FCPATH.'assets/admin/img/qrcodes/candidate-signup.png';
            $this->ciqrcode->generate($params);
        }

        $this->load->view('app/qr-codes', $data);
    }

    public function generateQrPdf($value='') {
        
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);

        if ($value=='candidate-login') {
            $qrCodeName = "Candidate Login";
            $qrCodePath = 'assets/admin/img/qrcodes/candidate-login.png';
        } else if ($value=='client-login') {
            $qrCodeName = "Client Login";
            $qrCodePath = 'assets/admin/img/qrcodes/candidate-login.png';
        } else if ($value=='business-login') {
            $qrCodeName = "Business Unit Login";
            $qrCodePath = 'assets/admin/img/qrcodes/business-login.png';
        } else if ($value=='client-signup') {
            $qrCodeName = "Client Signup";
            if(isset($_GET['com_id'])){
                $qrCodePath = 'assets/admin/img/qrcodes/client-'.$_GET['com_id'].'-signup.png';
            } else {
                $qrCodePath = 'assets/admin/img/qrcodes/client-signup.png';
            }
        } else {
            $qrCodeName = "Candidate Signup";
            if(isset($_GET['com_id'])){
                $qrCodePath = 'assets/admin/img/qrcodes/candidate-'.$_GET['com_id'].'-signup.png';
            } else {
                $qrCodePath = 'assets/admin/img/qrcodes/candidate-signup.png';
            }
        }
        
        $html = '<html><body>';
        $html .= '<h1 align="center">' . $qrCodeName . '</h1>';
        $html .= '<div style="text-align:center;"><img src="' . base_url($qrCodePath) . '"></div>';
        $html .= '</body></html>';

        // echo $html; exit();
        
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        
        $dompdf->stream('qr_code.pdf');
    }
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Legal extends CI_Controller 
{

    public function __construct()
    {
        parent::__construct();
  
        if (!$this->session->userdata('isLogIn')) 
        redirect('shareholder');

        $this->load->model(array(
            'shareholder/documents'
        ));

    }

    public function index()
    {
        $data['title']   = display('legal_doc');
        $data['documents'] = $this->documents->getDocuments('legal');
        $data['content'] = $this->load->view("shareholder/pages/company_valuation", $data, true);
        $this->load->view("shareholder/layout/main_wrapper", $data);
    }

}
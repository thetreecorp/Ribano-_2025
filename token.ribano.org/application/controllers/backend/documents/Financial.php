<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Financial extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        
        if (!$this->session->userdata('isAdmin')) 
        redirect('logout');
        
        if (!$this->session->userdata('isLogin') 
            && !$this->session->userdata('isAdmin'))
            redirect('admin');

        $this->load->model(array(
            'common_model',
            'backend/documents' 
        ));

        $globdata['coininfo'] = $this->common_model->get_coin_info();
        $this->load->vars($globdata);
    }

    public function index()
    {
        $data['title']   = display('financial_doc');
        $data['userrole'] = $this->common_model->getMenuSingelRoleInfo(13);
        $data['level']   = "financial";
        $data['documents'] = $this->documents->getDocuments('financial');
        $data['content'] = $this->load->view("backend/documents/list", $data, true);
        $this->load->view("backend/layout/main_wrapper", $data);
    }

    public function form()
    {
        $data['title']   = display('financial_doc');

        $this->form_validation->set_rules('document_title',display('document_title'),'required|xss_clean');
        $this->form_validation->set_rules('year',display('year'),'required|xss_clean');
        $this->form_validation->set_rules('level',display('level'),'required|xss_clean');

        if($this->form_validation->run()){

            $document_title = $this->input->post('document_title',TRUE);
            $form_year      = $this->input->post('year',TRUE);
            $level          = $this->input->post('level',TRUE);
            
            //upload
            $uploadimg = $this->upload_lib->do_upload(
                'upload/documents/',
                'document_cover'
            );
            // if uploaded then resize 
            if ($uploadimg !== false && $uploadimg != null) {
                $this->upload_lib->do_resize(
                    $uploadimg, 
                    400,
                    270
                );
            }
            //if not uploaded
            if($uploadimg !== false && $uploadimg != null)
            {
                $wheredata = array(
                    'title' =>$document_title,
                    'year'  =>$form_year,
                    'level' =>$level
                );
                $check  = $this->documents->checkExistsDoc($wheredata);
                if($check->num_rows()){
                    $this->session->set_flashdata('exception',display('document_all_ready_exist'));
                }
                else{
                    //upload
                    $uploaddoc = $this->upload_lib->do_upload(
                        'upload/documents/',
                        'upload_document'
                    );
                    //if not uploaded
                    if($uploaddoc !== false && $uploaddoc != null)
                    {
                        $documentdata = array(
                            'title'         =>$document_title,
                            'year'          =>$form_year,
                            'upload_file'   =>$uploaddoc,
                            'thumbali'      =>$uploadimg,
                            'level'         =>$level
                        );
                        $this->documents->addDocuments($documentdata);

                        $this->session->set_flashdata('message',display('document_added_successfully'));
                    }
                    else{
                        if ($this->session->flashdata('exception') == null) {
                            $this->session->set_flashdata('exception', display('you_did_not_upload_any_file'));
                        }
                    }
                    
                    redirect('backend/documents/financial/form');
                }

            }
            else{
                if ($this->session->flashdata('exception') == null) {
                    $this->session->set_flashdata('exception', display('you_did_not_upload_any_file'));
                }
            }
        }

        $data['current_year'] = date('Y');
        $data['level']   = display('financial');

        $data['content'] = $this->load->view("backend/documents/form", $data, true);
        $this->load->view("backend/layout/main_wrapper", $data);
    }

    public function delete($id="")
    {
        $this->documents->deleteDocuments($id);
        $this->session->set_flashdata('exception',display('delete_successfully'));
        redirect('backend/documents/financial');
    }

}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Language extends CI_Controller {

    private $table  = "language";
    private $phrase = "phrase";

    public function __construct()
    {
        parent::__construct();  
        $this->load->database();
        $this->load->dbforge(); 
        $this->load->helper('language');
        
        if (!$this->session->userdata('isAdmin')) 
        redirect('logout');

        if (!$this->session->userdata('isLogIn') 
            && !$this->session->userdata('isAdmin')
        ) 
        redirect('admin');
        $this->load->model('common_model'); 
    } 

    public function index()
    {
        $data['title']    = display('language_list');
        $data['userrole'] = $this->common_model->getMenuSingelRoleInfo(31);
        $data['languages']    = $this->languages();
        $data['content']      = $this->load->view('backend/language/main',$data,true); 
        $this->load->view('backend/layout/main_wrapper', $data);
    }

    public function phrase()
    {
        $this->load->library('pagination');
        #------------------#
        $data['title']     = display('phrase_list'); 
        #
        #pagination starts
        #
        $config["base_url"]       = base_url('backend/setting/language/phrase/'); 
        $config["total_rows"]     = $this->db->count_all('language'); 
        $config["per_page"]       = 25;
        $config["uri_segment"]    = 5; 
        $config["num_links"]      = 5;  
        /* This Application Must Be Used With BootStrap 3 * */
        $config['full_tag_open']  = "<ul class='pagination col-xs pull-right m-0'>";
        $config['full_tag_close'] = "</ul>";
        $config['num_tag_open']   = '<li>';
        $config['num_tag_close']  = '</li>';
        $config['cur_tag_open']   = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close']  = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open']  = "<li>";
        $config['next_tag_close'] = "</li>";
        $config['prev_tag_open']  = "<li>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open']  = "<li>";
        $config['last_tagl_close'] = "</li>"; 
        /* ends of bootstrap */
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
        $data["phrases"] = $this->phrases($config["per_page"], $page); 
        $data["links"] = $this->pagination->create_links(); 
        #
        #pagination ends
        # 
        $data['languages']    = $this->languages();
        $data['content']      = $this->load->view('backend/language/phrase',$data,true);
        $this->load->view('backend/layout/main_wrapper', $data);
    }
 

    public function languages()
    { 
        if ($this->db->table_exists($this->table)) { 

                $fields = $this->db->field_data($this->table);

                $i = 1;
                foreach ($fields as $field)
                {  
                    if ($i++ > 2)
                    $result[$field->name] = ucfirst($field->name);
                }

                if (!empty($result)) return $result;
 

        } else {
            return false; 
        }
    }


    public function addLanguage()
    { 
        $language = preg_replace('/[^a-zA-Z0-9_]/', '', $this->input->post('language',true));
        $language = strtolower($language);

        if (!empty($language)) {
            if (!$this->db->field_exists($language, $this->table)) {
                $this->dbforge->add_column($this->table, [
                    $language => [
                        'type' => 'TEXT'
                    ]
                ]); 
                $this->session->set_flashdata('message', display('language_added_successfully'));
                redirect('backend/setting/language');
            } 
        } else {
            $this->session->set_flashdata('exception', display('please_try_again'));
        }
        redirect('backend/setting/language');
    }


    public function editPhrase($language = null)
    { 

        $this->load->library('pagination');
        #------------------#
        $data['title']     = display('edit_phrase');
        $data['module']    = "dashboard";
        $data['language']  = $language;
        $data['page']      = "language/phrase_edit";
        #
        #pagination starts
        #
        $config["base_url"]       = base_url('backend/setting/language/editPhrase/'. $language); 
        $config["total_rows"]     = $this->db->count_all('language'); 
        $config["per_page"]       = 25;
        $config["uri_segment"]    = 6; 
        $config["num_links"]      = 6;  
        /* This Application Must Be Used With BootStrap 3 * */
        $config['full_tag_open']  = "<ul class='pagination col-xs pull-right m-0'>";
        $config['full_tag_close'] = "</ul>";
        $config['num_tag_open']   = '<li>';
        $config['num_tag_close']  = '</li>';
        $config['cur_tag_open']   = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close']  = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open']  = "<li>";
        $config['next_tag_close'] = "</li>";
        $config['prev_tag_open']  = "<li>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open']  = "<li>";
        $config['last_tagl_close'] = "</li>"; 
        /* ends of bootstrap */
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(6)) ? $this->uri->segment(6) : 0;
        $data["phrases"] = $this->phrases($config["per_page"], $page); 
        $data["links"] = $this->pagination->create_links(); 
        #
        #pagination ends
        #

        $data['search_result'] = "";
        $data['search_lang_id'] = "";
        if($this->session->flashdata('search_lang_id')!=null){
            $data['search_lang_id'] = $search_lang_id = $this->session->flashdata('search_lang_id');
            $data['search_result']  = $this->db->select('*')->from('language')->where('id',$search_lang_id)->get()->row();
        }
        
        $data['content']  = $this->load->view('backend/language/phrase_edit', $data, true); 
        $this->load->view('backend/layout/main_wrapper', $data);

    }

    public function addPhrase() {  

        $lang = $this->input->post('phrase',TRUE); 

        if (sizeof($lang) > 0) {

            if ($this->db->table_exists($this->table)) {

                if ($this->db->field_exists($this->phrase, $this->table)) {

                    foreach ($lang as $value) {

                        $value = preg_replace('/[^a-zA-Z0-9_]/', '', $value);
                        $value = strtolower($value);

                        if (!empty($value)) {
                            $num_rows = $this->db->get_where($this->table,[$this->phrase => $value])->num_rows();

                            if ($num_rows == 0) { 
                                $this->db->insert($this->table,[$this->phrase => $value]); 
                                $this->session->set_flashdata('message', display('phrase_added_successfully'));
                            } else {
                                $this->session->set_flashdata('exception', display('phrase_already_exists'));
                            }
                        }   
                    }  

                    redirect('backend/setting/language/phrase');
                }  

            }
        } 

        $this->session->set_flashdata('exception', display('please_try_again'));
        redirect('backend/setting/language/phrase');
    }
 
    public function phrases($offset=null, $limit=null)
    {
        if ($this->db->table_exists($this->table)) {

            if ($this->db->field_exists($this->phrase, $this->table)) {

                return $this->db->order_by($this->phrase,'asc')
                    ->limit($offset, $limit)
                    ->get($this->table)
                    ->result();

            }  

        } 

        return false;
    }


    public function addLebel() { 
        $language = $this->input->post('language', true);
        $phrase   = $this->input->post('phrase', true);
        $lang     = $this->input->post('lang', true);

        if (!empty($language)) {

            if ($this->db->table_exists($this->table)) {

                if ($this->db->field_exists($language, $this->table)) {

                    if (sizeof($phrase) > 0)
                    for ($i = 0; $i < sizeof($phrase); $i++) {
                        $this->db->where($this->phrase, $phrase[$i])
                            ->set($language,$lang[$i])
                            ->update($this->table); 

                    }
                    $this->create_and_write();
                    $this->session->set_flashdata('message', display('label_added_successfully'));
                    redirect('backend/setting/language/editPhrase/'.$language);

                }  

            }
        } 

        $this->session->set_flashdata('exception', display('please_try_again'));
        redirect('backend/setting/language/editPhrase/'.$language);
    }

    private function create_and_write()
    {
        $this->db->select('*');
        $this->db->from('language');
        $query = $this->db->get();
        $result= $query->result();
        $cache_file = './assets/js/language.json';
        $newarray = [];
        foreach ($result as $key => $value) {
            $newarray = array_merge($newarray,array($value->phrase => $value));
        }

        $languageList = json_encode($newarray);

        file_put_contents($cache_file,$languageList);
    }

    public function search($segment="")
    {
        $this->form_validation->set_rules('search_box','Search box','required|trim|xss_clean|max_length[200]');
        if($this->form_validation->run()){

            $search_box = $this->input->post('search_box',TRUE);

            $languagedata = $this->db->list_fields('language');
            $search       = 0;

            foreach ($languagedata as $key => $value) {
                if($key==0){
                    continue;
                }
                
                $search_result = $this->db->select('id')->from('language')->where($value,$search_box)->get()->row();

                if($search_result){
                    $search = $search_result->id;
                    break;
                }
            }

            if($search!=0){

                $this->session->set_flashdata('search_lang_id', $search);
                $this->session->set_flashdata('message', "We find your searching language");

            }
            else{
                $this->session->set_flashdata('exception', "Sorry, we couldn't find and language for '".$search_box."'");
            }

        }
        else{
            $this->session->set_flashdata('exception', validation_errors());
        }
        redirect("backend/setting/language/editPhrase/".$segment);
    }

}



 
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
    protected $LANGUAGE_ID;

    public function __construct()
    {
        parent::__construct();

        $this->load->model(array(
            'website/web_model',
            'common_model',
            'payment_model',

        ));

        $this->load->helper(array('cookie'));

        $lang = $this->input->cookie('language_id', true);
        if (!empty($lang)) {
            $this->LANGUAGE_ID = $lang;
        } else {
            $settinglan = $this->db->select('language')->from('setting')->get()->row();
            $laninfo    = $this->db->query("SELECT id FROM `web_language` WHERE `language_name` LIKE '%" . $settinglan->language . "%'")->row();
            $this->LANGUAGE_ID = $laninfo->id;
        }

        $globdata['languageinfo'] = $this->db->select('language_name')->from('web_language')->where('id', $this->LANGUAGE_ID)->get()->row();

        $globdata['languageId']   = $this->LANGUAGE_ID;
        $globdata['web_language'] = $this->web_model->webLanguage();
        $globdata['social_link']  = $this->web_model->socialLink();
        $globdata['category']     = $this->web_model->categoryList();
        $globdata['subcategory']  = $this->web_model->childcategoryList();
        $globdata['stoinfo']      = $this->common_model->get_coin_info();
        $globdata['testimonial']  = $this->db->select('*')
            ->from('web_article')
            ->where('data_key', 'testimonial')
            ->get()
            ->result();

        $globdata['footercat']    = $this->db->select('*')
            ->from('web_category')
            ->where('menu !=', 0)
            ->get()
            ->result();

        $result = $this->db->select('*')->from('setting')->get()->row();
        date_default_timezone_set(@$result->time_zone);
        $nowtime      = date("Y-m-d H:i:s");

        $coinreleasetimedata    = $this->web_model->coin_release_time($nowtime);
        $coinrelease            = $coinreleasetimedata->row();

        $globdata['flipdata']       = $coinrelease;

        $this->load->vars($globdata);
    }

    public function index()
    {
        $data['title'] = "";

        $getdata = array(
            'data_key'  => 'page_content',
            'cat_id'    => 11,
            'table_key' => 'article_data'
        );
        $data['articlehome'] = !empty($this->web_model->getArticleSingelWebData($getdata, $this->LANGUAGE_ID)) ? $this->web_model->getArticleSingelWebData($getdata, $this->LANGUAGE_ID) : $this->web_model->getArticleSingelWebData($getdata, 1);
        //Article Data script End

        $data['level1'] = !empty($this->web_model->articleHeadLine($this->LANGUAGE_ID, 1)) ? $this->web_model->articleHeadLine($this->LANGUAGE_ID, 1) : $this->web_model->articleHeadLine(1, 1);
        $data['level2'] = !empty($this->web_model->articleHeadLine($this->LANGUAGE_ID, 2)) ? $this->web_model->articleHeadLine($this->LANGUAGE_ID, 2) : $this->web_model->articleHeadLine(1, 2);
        $data['level3'] = !empty($this->web_model->articleHeadLine($this->LANGUAGE_ID, 3)) ? $this->web_model->articleHeadLine($this->LANGUAGE_ID, 3) : $this->web_model->articleHeadLine(1, 3);
        $data['level4'] = !empty($this->web_model->articleHeadLine($this->LANGUAGE_ID, 4)) ? $this->web_model->articleHeadLine($this->LANGUAGE_ID, 4) : $this->web_model->articleHeadLine(1, 4);
        $data['level5'] = !empty($this->web_model->articleHeadLine($this->LANGUAGE_ID, 5)) ? $this->web_model->articleHeadLine($this->LANGUAGE_ID, 5) : $this->web_model->articleHeadLine(1, 5);
        $data['level6'] = !empty($this->web_model->articleHeadLine($this->LANGUAGE_ID, 6)) ? $this->web_model->articleHeadLine($this->LANGUAGE_ID, 6) : $this->web_model->articleHeadLine(1, 6);
        $data['level7'] = !empty($this->web_model->articleHeadLine($this->LANGUAGE_ID, 7)) ? $this->web_model->articleHeadLine($this->LANGUAGE_ID, 7) : $this->web_model->articleHeadLine(1, 7);
        $data['level8'] = !empty($this->web_model->articleHeadLine($this->LANGUAGE_ID, 8)) ? $this->web_model->articleHeadLine($this->LANGUAGE_ID, 8) : $this->web_model->articleHeadLine(1, 8);
        $data['level9'] = !empty($this->web_model->articleHeadLine($this->LANGUAGE_ID, 9)) ? $this->web_model->articleHeadLine($this->LANGUAGE_ID, 9) : $this->web_model->articleHeadLine(1, 9);
        //HeadLine Data script End

        $getdata = array(
            'data_key'  => 'about_coin',
            'cat_id'    => NULL,
            'table_key' => 'about_coin'
        );
        $data['aboutcoin'] = !empty($this->web_model->getArticleMultipleWebData($getdata, $this->LANGUAGE_ID)) ? $this->web_model->getArticleMultipleWebData($getdata, $this->LANGUAGE_ID) : $this->web_model->getArticleMultipleWebData($getdata, 1);
        //About Coin Data script end

        $getdata = array(
            'data_key'  => 'page_content',
            'cat_id'    => 2,
            'table_key' => 'article_data'
        );
        $data['articleabout'] = !empty($this->web_model->getArticleSingelWebData($getdata, $this->LANGUAGE_ID)) ? $this->web_model->getArticleSingelWebData($getdata, $this->LANGUAGE_ID) : $this->web_model->getArticleSingelWebData($getdata, 1);
        //About Category Data script end

        $getdata = array(
            'data_key'  => 'roadmap_article',
            'cat_id'    => 3,
            'table_key' => 'roadmap_article'
        );
        $data['roadmaparticle'] = !empty($this->web_model->getArticleMultipleWebData($getdata, $this->LANGUAGE_ID)) ? $this->web_model->getArticleMultipleWebData($getdata, $this->LANGUAGE_ID) : $this->web_model->getArticleMultipleWebData($getdata, 1);
        //Road Map Data Script end


        $data['securepack'] = $this->web_model->getPackageInformation('secured');
        //Secure Package Data Script End
        $data['guranteedpack'] = $this->web_model->getPackageInformation('guaranteed');
        //Granteed Package Data Script

        $data['legeldocuments'] = $this->db->select('*')->from('dbt_documents')->get()->result();
        //Legal Documents Information



        $data['teamleadership'] = !empty($this->web_model->getWebArticleData('member_data', 1)) ? $this->web_model->getWebArticleData('member_data', 1) : "";
        //Team Leadership Data Script End
        $data['teammemeber'] = !empty($this->web_model->getWebArticleData('member_data', 2)) ? $this->web_model->getWebArticleData('member_data', 2) : "";
        //Team Member Data Script End

        $getdata = array(
            'data_key'  => 'faq_data',
            'cat_id'    => 1,
            'table_key' => 'faq_data'
        );
        $data['askquestionsregular'] = !empty($this->web_model->getArticleMultipleWebData($getdata, $this->LANGUAGE_ID)) ? $this->web_model->getArticleMultipleWebData($getdata, $this->LANGUAGE_ID) : $this->web_model->getArticleMultipleWebData($getdata, 1);
        $getdata = array(
            'data_key'  => 'faq_data',
            'cat_id'    => 2,
            'table_key' => 'faq_data'
        );
        $data['askquestionsclient']  = !empty($this->web_model->getArticleMultipleWebData($getdata, $this->LANGUAGE_ID)) ? $this->web_model->getArticleMultipleWebData($getdata, $this->LANGUAGE_ID) : $this->web_model->getArticleMultipleWebData($getdata, 1);
        $getdata = array(
            'data_key'  => 'faq_data',
            'cat_id'    => 3,
            'table_key' => 'faq_data'
        );
        $data['askquestionstrend']   = !empty($this->web_model->getArticleMultipleWebData($getdata, $this->LANGUAGE_ID)) ? $this->web_model->getArticleMultipleWebData($getdata, $this->LANGUAGE_ID) : $this->web_model->getArticleMultipleWebData($getdata, 1);
        //Frequently Asked Questions Data Script End

        $data['blog'] = $this->getRecentThreeNews();
        //Last Post Three News Data Script End

        $data['rcoin_info']   = $this->web_model->release_coin_info();




        $this->load->view('website/header', $data);
        $this->load->view('website/index', $data);
        $this->load->view('website/footer', $data);
    }

    public function blog()
    {

        $slug1 = $this->uri->segment(1);
        $slug2 = $this->uri->segment(2);
        $slug3 = $this->uri->segment(3);

        $data['title']              = $this->uri->segment(1);

        //Last Post Three News Data
        $data['recentblog']         = $this->getRecentThreeNews();

        if ($slug2 == "" || $slug2 == NULL || is_numeric($slug2)) {

            $where_add  = $this->web_model->catidBySlug('blog')->cat_id;

            /******************************
             * Pagination Start
             ******************************/
            $config["base_url"]         = base_url('blog');
            $config["total_rows"]       = $this->db->get_where('web_article', array('data_key' => "blog_news"))->num_rows();
            $config["per_page"]         = 6;
            $config["uri_segment"]      = 2;
            $config["last_link"]        = "Last";
            $config["first_link"]       = "First";
            $config['next_link']        = '&#8702;';
            $config['prev_link']        = '&#8701;';
            $config['full_tag_open']    = "<ul class='pagination'>";
            $config['full_tag_close']   = "</ul>";
            $config['num_tag_open']     = '<li>';
            $config['num_tag_close']    = '</li>';
            $config['cur_tag_open']     = "<li class='disabled'><li class='active'><a href='#'>";
            $config['cur_tag_close']    = "<span class='sr-only'></span></a></li>";
            $config['next_tag_open']    = "<li>";
            $config['next_tag_close']   = "</li>";
            $config['prev_tag_open']    = "<li>";
            $config['prev_tagl_close']  = "</li>";
            $config['first_tag_open']   = "<li>";
            $config['first_tagl_close'] = "</li>";
            $config['last_tag_open']    = "<li>";
            $config['last_tagl_close']  = "</li>";
            /* ends of bootstrap */
            $this->pagination->initialize($config);
            $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
            //Get Blog Data

            $data['blog']               = $this->getAllNews();
            $data["links"]              = $this->pagination->create_links();
            /******************************
             * Pagination ends
             ******************************/

            $data['advertisement']  = $this->web_model->advertisement($where_add);
            $data['blogcat']        = $this->web_model->blogCatListBySlug('blog');
            $data['content']        = $this->load->view("website/sidebar", $data, true);


            $this->load->view('website/header', $data);
            $this->load->view('website/blog', $data);
            $this->load->view('website/footer', $data);
        } elseif (($slug2 != "" || !is_numeric($slug2)) && ($slug3 == "" || $slug3 == NULL)) {

            @$where_add  = $this->web_model->catidBySlug('blog')->cat_id;

            //Slug Category blog
            $cat_id     = $this->web_model->catidBySlug($slug2)->cat_id;
            if (!$cat_id) {
                redirect(base_url('blog'));
            }
            /******************************
             * Pagination Start
             ******************************/
            $config["base_url"]         = base_url('blog/' . $slug2);
            $config["total_rows"]       = $this->db->get_where('web_article', array('data_key' => "blog_news", 'cat_id' => $cat_id))->num_rows();
            $config["per_page"]         = 6;
            $config["uri_segment"]      = 3;
            $config["last_link"]        = "Last";
            $config["first_link"]       = "First";
            $config['next_link']        = '&#8702;';
            $config['prev_link']        = '&#8701;';
            $config['full_tag_open']    = "<ul class='pagination'>";
            $config['full_tag_close']   = "</ul>";
            $config['num_tag_open']     = '<li>';
            $config['num_tag_close']    = '</li>';
            $config['cur_tag_open']     = "<li class='disabled'><li class='active'><a href='#'>";
            $config['cur_tag_close']    = "<span class='sr-only'></span></a></li>";
            $config['next_tag_open']    = "<li>";
            $config['next_tag_close']   = "</li>";
            $config['prev_tag_open']    = "<li>";
            $config['prev_tagl_close']  = "</li>";
            $config['first_tag_open']   = "<li>";
            $config['first_tagl_close'] = "</li>";
            $config['last_tag_open']    = "<li>";
            $config['last_tagl_close']  = "</li>";
            /* ends of bootstrap */
            $this->pagination->initialize($config);
            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $data['blog']               = $this->getByCategoryNews($cat_id);
            $data["links"]              = $this->pagination->create_links();
            /******************************
             * Pagination ends
             ******************************/

            $data['advertisement']      = $this->web_model->advertisement(@$where_add);
            @$data['blogcat']           = $this->web_model->blogCatListBySlug('blog');
            $data['cat_info']           = $this->web_model->cat_info($slug1);
            $data['content']            = $this->load->view("website/sidebar", $data, true);


            $this->load->view('website/header', $data);
            $this->load->view('website/blog', $data);
            $this->load->view('website/footer', $data);
        } elseif ($slug3 == "" || $slug3 == NULL || is_numeric($slug3)) {

            @$where_add  = $this->web_model->catidBySlug('blog')->cat_id;

            //Slug Category blog
            $cat_id     = $this->web_model->catidBySlug($slug2)->cat_id;
            if (!$cat_id) {
                redirect(base_url('blog'));
            }
            /******************************
             * Pagination Start
             ******************************/
            $config["base_url"]         = base_url('blog/' . $slug2);
            $config["total_rows"]       = $this->db->get_where('web_article', array('data_key' => "blog_news", 'cat_id' => $cat_id))->num_rows();
            $config["per_page"]         = 6;
            $config["uri_segment"]      = 3;
            $config["last_link"]        = "Last";
            $config["first_link"]       = "First";
            $config['next_link']        = '&#8702;';
            $config['prev_link']        = '&#8701;';
            $config['full_tag_open']    = "<ul class='pagination'>";
            $config['full_tag_close']   = "</ul>";
            $config['num_tag_open']     = '<li>';
            $config['num_tag_close']    = '</li>';
            $config['cur_tag_open']     = "<li class='disabled'><li class='active'><a href='#'>";
            $config['cur_tag_close']    = "<span class='sr-only'></span></a></li>";
            $config['next_tag_open']    = "<li>";
            $config['next_tag_close']   = "</li>";
            $config['prev_tag_open']    = "<li>";
            $config['prev_tagl_close']  = "</li>";
            $config['first_tag_open']   = "<li>";
            $config['first_tagl_close'] = "</li>";
            $config['last_tag_open']    = "<li>";
            $config['last_tagl_close']  = "</li>";
            /* ends of bootstrap */
            $this->pagination->initialize($config);
            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $data['blog']               = $this->getByCategoryNews($cat_id);
            $data["links"]              = $this->pagination->create_links();
            /******************************
             * Pagination ends
             ******************************/

            $data['advertisement']      = $this->web_model->advertisement(@$where_add);
            @$data['blogcat']           = $this->web_model->blogCatListBySlug('blog');
            $data['cat_info']           = $this->web_model->cat_info($slug1);
            $data['content']            = $this->load->view("website/sidebar", $data, true);


            $this->load->view('website/header', $data);
            $this->load->view('website/blog', $data);
            $this->load->view('website/footer', $data);
        } elseif ($slug3 != "" || !is_numeric($slug3)) {
            //Slug Category blog detail

            $where_add = $this->web_model->catidBySlug('blog')->cat_id;

            $data['advertisement']  = $this->web_model->advertisement($where_add);
            @$data['blogcat']           = $this->web_model->blogCatListBySlug('blog');
            $data['blog']           = $this->getBlogDetails($slug3);
            $data['content']        = $this->load->view("website/sidebar", $data, true);


            $this->load->view('website/header', $data);
            $this->load->view('website/blogdetails', $data);
            $this->load->view('website/footer', $data);
        }
    }

    private function getRecentThreeNews()
    {
        $getdata     = array('data_key' => 'blog_news');
        $recentnews  = $this->web_model->getsingelblogNews($getdata, $this->LANGUAGE_ID);

        return $recentnews;
    }

    private function getAllNews()
    {
        $getdata     = array('data_key' => 'blog_news');
        $allnews     = $this->web_model->getAllblogNews($getdata, $this->LANGUAGE_ID);

        return $allnews;
    }

    private function getByCategoryNews($cat_id = "")
    {
        $getdata = array(
            'data_key'  => 'blog_news',
            'table_key' => 'blog_news',
            'cat_id'    => $cat_id
        );

        $allnews = $this->web_model->getNewsByCategory($getdata, $this->LANGUAGE_ID);

        return $allnews;
    }

    private function getBlogDetails($slug = "")
    {
        $getdata = array(
            'data_key'  => 'blog_news',
            'slug'      => $slug
        );

        $allnews = $this->web_model->blogDetails($getdata, $this->LANGUAGE_ID);

        return $allnews;
    }

    public function register()
    {
        $data['title'] = "Register";

        if ($this->session->userdata('isLogIn'))
            redirect(base_url());


        //Load Cookie For Store Referral ID
        $this->load->helper(array('cookie', 'url'));
        $ref = $this->input->get('ref', false);

        if (isset($ref) && ($ref != "")) {
            $user_id = $this->db->select('user_id')->where('user_id', $ref)->get('dbt_user')->row();
            if ($user_id) {
                set_cookie('referral_id', $ref, 86400 * 30);
            } else {
                $this->session->set_flashdata('exception', "Referral ID is invalid");
                redirect("register");
            }
        }


        //Load Helper For [user_id] Generate
        $this->load->helper('string');

        //Set Rules From validation
        $this->form_validation->set_rules('rf_name', display('firstname'), 'required|max_length[50]|trim|xss_clean');
        $this->form_validation->set_rules('remail', display('email'), "required|valid_email|max_length[100]|trim|xss_clean");
        $this->form_validation->set_rules('rusername', display('username'), "required|is_unique[dbt_user.username]|max_length[100]|trim|xss_clean|alpha_numeric");
        $this->form_validation->set_rules('rpass', display('password'), 'required|min_length[8]|max_length[32]|matches[rr_pass]|trim|xss_clean|callback_valid_password');
        $this->form_validation->set_rules('rr_pass', 'Confirm Password', 'trim|xss_clean');
        $this->form_validation->set_rules('raccept_terms', display('accept_terms_privacy'), 'required|trim|xss_clean');

        //From Validation Check
        if ($this->form_validation->run()) {

            if (!$this->input->valid_ip($this->input->ip_address())) {
                $this->session->set_flashdata('exception',  "Invalid IP address");
                redirect("register");
            }

            //Generate User Id
            $userid = strtoupper(random_string('alnum', 6));

            while ($this->web_model->checkUseridExist($userid)) {
                $userid = strtoupper(random_string('alnum', 6));
            }

            if ($this->web_model->checkEmailExist($this->input->post('remail', TRUE))) {

                if ($this->web_model->accountStatusCheck($this->input->post('remail', TRUE)) == 0) {
                    $this->session->set_flashdata('exception',  "Please activate your account");
                    redirect("login");
                } elseif ($this->web_model->accountStatusCheck($this->input->post('remail', TRUE)) == 1) {
                    $this->session->set_flashdata('exception',  "Already regsister!!!");
                    redirect("login");
                } elseif ($this->web_model->accountStatusCheck($this->input->post('remail', TRUE)) == 2) {
                    $this->session->set_flashdata('exception',  "This account is now pending");
                    redirect("login");
                } elseif ($this->web_model->accountStatusCheck($this->input->post('remail', TRUE)) == 2) {
                    $this->session->set_flashdata('exception',  "This account is suspend");
                    redirect("register");
                }
            }

            $dlanguage = $this->db->select('language')->get('setting')->row();

            $data = [
                'first_name'    => $this->input->post('rf_name', TRUE),
                'last_name'     => $this->input->post('rl_name', TRUE),
                'username'      => $this->input->post('rusername', TRUE),
                'referral_id'   => $this->input->cookie('referral_id', TRUE),
                'language'      => $dlanguage->language,
                'user_id'       => $userid,
                'email'         => $this->input->post('remail', TRUE),
                'password'      => md5($this->input->post('rpass', TRUE)),
                'password_reset_token' => md5($userid),
                'status'        => 0,
                'ip'            => $this->input->ip_address()
            ];

            if ($this->web_model->registerUser($data)) {

                $verifyinfosms      = $this->db->select('sign_up')->from('sms_email_send_setup')->where('method', 'sms')->get()->row();
                $verifyinfoemail    = $this->db->select('sign_up')->from('sms_email_send_setup')->where('method', 'email')->get()->row();

                if (!empty($verifyinfosms->sign_up) || !empty($verifyinfoemail->sign_up)) {
                    $this->session->set_userdata(array('issignverify' => true, 'issignverifyid' => $userid));
                    redirect("signup-verify");
                } else {
                    $this->db->where('user_id', $userid)->set('status', 1)->update('dbt_user');
                    $this->session->set_flashdata('message', 'Account Create Successfully.');
                    redirect("login");
                }
            }
        }

        $this->load->view('website/header', $data);
        $this->load->view('website/login', $data);
        $this->load->view('website/footer', $data);
    }

    public function valid_password($rpass = '')
    {
        $rpass = trim($rpass);
        $regex_lowercase = '/[a-z]/';
        $regex_uppercase = '/[A-Z]/';
        $regex_number = '/[0-9]/';
        $regex_special = '/[!@#$%^&*()\-_=+{};:,<.>§~]/';

        if (preg_match_all($regex_lowercase, $rpass) < 1) {
            $this->form_validation->set_message('valid_password', 'The {field} field must be at least one lowercase letter.');
            return FALSE;
        }
        if (preg_match_all($regex_uppercase, $rpass) < 1) {
            $this->form_validation->set_message('valid_password', 'The {field} field must be at least one uppercase letter.');
            return FALSE;
        }
        if (preg_match_all($regex_special, $rpass) < 1) {
            $this->form_validation->set_message('valid_password', 'The {field} field must have at least one special character.' . ' ' . htmlentities('!@#$%^&*()\-_=+{};:,<.>§~'));
            return FALSE;
        }
        if (preg_match_all($regex_number, $rpass) < 1) {
            $this->form_validation->set_message('valid_password', 'The {field} field must have at least one number.');
            return FALSE;
        }
        return TRUE;
    }

    public function signup_verify()
    {
        if (!$this->session->userdata('issignverify')) {
            redirect('login');
        }
        $data['title'] = "Sign up Verify";

        $this->form_validation->set_rules('verifymedia', 'Verify Media', 'required|xss_clean');
        $verifymedia = $this->input->post('verifymedia', TRUE);
        if ($verifymedia == 'sms') {
            $this->form_validation->set_rules('phonenumber', 'Phone Number', 'required|xss_clean');
        }

        if ($this->form_validation->run()) {

            $user_id  = $this->session->userdata('issignverifyid');
            $userinfo = $this->db->select('*')->from('dbt_user')->where('user_id', $user_id)->get()->row();

            if ($verifymedia == 'sms') {

                $varify_code = $this->randomID();
                $this->db->where('user_id', $user_id)->set('smsauth', $varify_code)->update('dbt_user');

                $this->load->library('sms_lib');

                $template = array(
                    'code' => $varify_code
                );
                $userphone = $this->input->post('phonenumber', TRUE);

                if ($userphone) {

                    $checkphoneno = $this->db->select('user_id')->from('dbt_user')->where('phone', $userphone)->get()->row();

                    if ($checkphoneno && $checkphoneno->user_id != $user_id) {
                        $this->session->set_flashdata('exception', "This phone number has been used");
                        redirect("signup-verify");
                    } else if ($checkphoneno && $checkphoneno->user_id == $user_id) {
                        $code_send = $this->sms_lib->send(array(
                            'to'       => $userphone,
                            'template' => 'Verification Code is %code% ',
                            'template_config' => $template,
                        ));
                    } else {
                        $this->db->where('user_id', $user_id)->set('phone', $userphone)->update('dbt_user');
                        $code_send = $this->sms_lib->send(array(
                            'to'       => $userphone,
                            'template' => 'Verification Code is %code% ',
                            'template_config' => $template,
                        ));
                    }
                } else {
                    $this->session->set_flashdata('exception', "There is no Phone number!!!");
                }

                //delete session for not access sign up verify page
                $this->session->unset_userdata('issignverify');
                $this->session->unset_userdata('issignverifyid');

                $sData = array('isverifyLogin' => true, 'isverifyId' => $user_id, 'isverifyMedia' => 'signupsmsauth');
                $this->session->set_userdata($sData);
                redirect('shareholder/login_verify');
            } else {

                $appSetting = $this->common_model->get_setting();

                $data['title']      = $appSetting->title;
                $data['to']         = $userinfo->email;
                $data['subject']    = 'Account Activation';
                $data['message']    = "<br><b>Your account was created successfully, Please click on the link below to activate your account. </b><br> <a target='_blank' href='" . base_url('home/activate_account/') . md5($user_id) . "'>" . base_url('home/activate_account/') . md5($user_id) . "</a>";

                if (@$this->common_model->send_email($data)) {

                    //delete session for not access sign up verify page
                    $this->session->unset_userdata('issignverify');
                    $this->session->unset_userdata('issignverifyid');

                    $this->session->set_flashdata('message', display('account_create_active_link'));
                    redirect("login");
                } else {
                    $this->session->set_flashdata('message', "Email not configured in server. Please contact with adminstration to activate account.");
                    redirect("signup-verify");
                }
            }
        }

        $data['verifyinfosms']      = $this->db->select('sign_up')->from('sms_email_send_setup')->where('method', 'sms')->get()->row();
        $data['verifyinfoemail']    = $this->db->select('sign_up')->from('sms_email_send_setup')->where('method', 'email')->get()->row();


        $this->load->view('website/header', $data);
        $this->load->view('website/signupverify', $data);
        $this->load->view('website/footer', $data);
    }

    public function login()
    {
        //check user previous login
        if ($this->session->userdata('isLogIn'))
            redirect(base_url('shareholder/home'));

        $data['title']      = $this->uri->segment(1);

        //Set Rules From validation
        $this->form_validation->set_rules('luseremail', display('email'), 'required|max_length[100]|trim|xss_clean');
        $this->form_validation->set_rules('lpassword', display('password'), 'required|max_length[32]|trim|xss_clean');

        //From Validation Check
        if ($this->form_validation->run()) {
            $date           = new DateTime();
            $access_time    = $date->format('Y-m-d H:i:s');
            $email          = $this->input->post('luseremail', TRUE);
            $password       = md5($this->input->post('lpassword', TRUE));

            $data['user'] = (object)$userData = array(
                'email'      => $email,
                'password'   => $password
            );

            if ($this->web_model->checkEmailExist($email)) {

                $user_status = $this->web_model->accountStatusCheck($email);

                if ($user_status == 0) {
                    $user = $this->db->select('user_id')->from('dbt_user')->where('email', $email)->where('password', $password)->get()->row();
                    if (!empty($user)) {
                        $this->session->set_flashdata('exception',  "Please activate your account");
                        $this->session->set_userdata(array('issignverify' => true, 'issignverifyid' => $user->user_id));
                        redirect("signup-verify");
                    } else {
                        $this->session->set_flashdata('exception',  "Please activate your account");
                        redirect("login");
                    }
                } elseif ($user_status == 2) {
                    $this->session->set_flashdata('exception',  "This account is now pending");
                    redirect("login");
                } elseif ($user_status == 3) {
                    $this->session->set_flashdata('exception',  "This account is suspend");
                    redirect("login");
                } elseif ($user_status == 1) {

                    $user = $this->web_model->loginCheckUser($userData);

                    if ($user) {

                        $query = $this->db->select('googleauth,smsauth')->from('dbt_user')->where('user_id',  $user->user_id)->get()->row();

                        if ($query->googleauth != '') {

                            $sData = array('isverifyLogin' => true, 'isverifyId' => $user->user_id, 'isverifyMedia' => 'googleauth');
                            $this->session->set_userdata($sData);
                            redirect('shareholder/login_verify');
                        } else if ($query->smsauth != '') {

                            $varify_code = $this->randomID();
                            $this->db->where('user_id', $user->user_id)->set('smsauth', $varify_code)->update('dbt_user');

                            $this->load->library('sms_lib');

                            $template = array(
                                'code'      => $varify_code
                            );

                            if ($user->phone) {
                                $code_send = $this->sms_lib->send(array(
                                    'to'       => $user->phone,
                                    'template' => 'Verification Code is %code% ',
                                    'template_config' => $template,
                                ));
                            } else {
                                $this->session->set_flashdata('exception', "There is no Phone number!!!");
                            }
                            $sData = array('isverifyLogin' => true, 'isverifyId' => $user->user_id, 'isverifyMedia' => 'smsauth');
                            $this->session->set_userdata($sData);
                            redirect('shareholder/login_verify');
                        } else {

                            $user_agent = array(
                                'device'     => $this->agent->browser(),
                                'browser'    => $this->agent->browser() . ' V-' . $this->agent->version(),
                                'platform'   => $this->agent->platform()
                            );


                            $sData = array(
                                'isLogIn'     => true,
                                'id'          => $user->id,
                                'user_id'     => $user->user_id,
                                'fullname'    => $user->first_name . ' ' . $user->last_name,
                                'email'       => $user->email,
                                'image'       => $user->image
                            );
                            $logData = array(
                                'log_type'     => 'login',
                                'access_time'  => $access_time,
                                'user_agent'   => json_encode($user_agent),
                                'user_id'      => $user->user_id,
                                'ip'           => $this->input->ip_address()
                            );

                            //Store data to session, log & Login
                            $this->session->set_userdata($sData);
                            $this->web_model->storeUserLogData($logData);
                            redirect(base_url('shareholder/home'));
                        }
                    } else {
                        $this->session->set_flashdata('exception', display('incorrect_email_password'));
                        redirect(base_url('login'));
                    }
                } else {
                    $this->session->set_flashdata('exception', "Something wrong !!!");
                    redirect(base_url('login'));
                }
            } else {
                $this->session->set_flashdata('exception', 'Invalid Login Information');
                redirect('login');
            }
        }


        $this->load->view('website/header', $data);
        $this->load->view('website/login', $data);
        $this->load->view('website/footer', $data);
    }

    public function email_check($email, $user_id)
    {

        $emailExists = $this->db->select('*')
            ->where('email', $email)
            ->where_not_in('user_id', $user_id)
            ->get('dbt_user')
            ->num_rows();

        if ($emailExists > 0) {
            $this->form_validation->set_message('email', 'The {field} is already registered.');
            return false;
        } else {
            return true;
        }
    }


    public function edit_profile()
    {

        if (!$this->session->userdata('isLogIn'))
            redirect(base_url());


        $data['title']      = $this->uri->segment(1);


        $user_id = $this->session->userdata('user_id');

        $this->form_validation->set_rules('first_name', 'First Name', 'required|max_length[50]|xss_clean');
        $this->form_validation->set_rules('email', 'Email Address', "required|valid_email|max_length[100]|callback_email_check[$user_id]|xss_clean");
        $this->form_validation->set_rules('phone', 'Phone', "max_length[100]|is_unique[dbt_user.phone]|xss_clean");
        $this->form_validation->set_rules('password', 'Password', 'required|max_length[32]|xss_clean');

        if ($this->form_validation->run()) {

            $user   = $this->web_model->retriveUserInfo();

            if ($user->password != md5($this->input->post('password', TRUE))) {
                $this->session->set_flashdata('exception',  "password missmatch");
                redirect("home/edit_profile");
            }
            //set config 
            $config = [
                'upload_path'      => './upload/user/',
                'allowed_types'    => 'gif|jpg|png|jpeg',
                'overwrite'        => false,
                'maintain_ratio'   => true,
                'encrypt_name'     => true,
                'remove_spaces'    => true,
                'file_ext_tolower' => true
            ];
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('image')) {
                $data = $this->upload->data();
                $image = $config['upload_path'] . $data['file_name'];

                $config['image_library']  = 'gd2';
                $config['source_image']   = $image;
                $config['create_thumb']   = false;
                $config['encrypt_name'] = TRUE;
                $config['width']          = 115;
                $config['height']         = 90;
                $this->load->library('image_lib', $config);
                $this->image_lib->resize();
                $this->session->set_flashdata('message', display("image_upload_successfully"));
            }
            /*-----------------------------------*/
            $data['user'] = (object)$userData = array(
                'user_id'   => $user_id,
                'first_name'   => $this->input->post('first_name', TRUE),
                'last_name'    => $this->input->post('last_name', TRUE),
                'email'       => $this->input->post('email', TRUE),
                'phone'       => $this->input->post('phone', TRUE),
                'bio'       => $this->input->post('bio', true),
                'image'       => (!empty($image) ? $image : $this->input->post('old_image', TRUE))
            );

            if (empty($userData['image'])) {
                $this->session->set_flashdata('exception', $this->upload->display_errors());
            }

            if ($this->web_model->updateUser($userData)) {
                $this->session->set_userdata(array(
                    'fullname'   => $this->input->post('first_name', TRUE) . ' ' . $this->input->post('last_name', TRUE),
                    'email'       => $this->input->post('email', TRUE),
                    'image'       => (!empty($image) ? $image : $this->input->post('old_image', TRUE))
                ));
                $this->session->set_flashdata('message', display('update_successfully'));
            } else {
                $this->session->set_flashdata('exception',  display('please_try_again'));
            }
            redirect("home/edit_profile");
        }


        $data['user']   = $this->web_model->retriveUserInfo();

        $this->load->view('website/header', $data);
        $this->load->view('website/edit_profile', $data);
        $this->load->view('website/footer', $data);
    }



    public function change_password()
    {

        $data['title'] = "Password Change";

        $this->form_validation->set_rules('old_pass', display('enter_old_password'), 'required|xss_clean');
        $this->form_validation->set_rules('new_pass', display('enter_new_password'), 'required|max_length[32]|matches[confirm_pass]|trim|xss_clean');
        $this->form_validation->set_rules('confirm_pass', display('enter_confirm_password'), 'required|max_length[32]|trim|xss_clean');

        if ($this->form_validation->run()) {
            $oldpass = MD5($this->input->post('old_pass', TRUE));

            $new_pass['password'] = MD5($this->input->post('new_pass', TRUE));

            $query = $this->db->select('password')
                ->from('dbt_user')
                ->where('user_id', $this->session->userdata('user_id'))
                ->where('password', $oldpass)
                ->get()
                ->num_rows();

            if ($query > 0) {

                $this->db->where('user_id', $this->session->userdata('user_id'))
                    ->update('dbt_user', $new_pass);

                $this->session->set_flashdata('message', display('password_change_successfull'));
                redirect('home/change_password');
            } else {
                $this->session->set_flashdata('exception', display('old_password_is_wrong'));
                redirect('home/change_password');
            }
        }


        $this->load->view('website/header', $data);
        $this->load->view('website/change_password', $data);
        $this->load->view('website/footer', $data);
    }

    public function forgotPassword()
    {
        //Set Rules From validation
        $this->form_validation->set_rules('email', display('email'), 'required|xss_clean|valid_email|max_length[50]');

        //From Validation Check
        if ($this->form_validation->run()) {

            $email = $this->input->post('email', TRUE);

            $checkemail = $this->db->select('*')
                ->where('MD5(email)', md5($email))
                ->get('dbt_user')
                ->num_rows();

            if ($checkemail <= 0) {
                echo json_encode(array('status' => 0, 'message' => display('sorry_this_email_does_not_match_check_spieling_and_try_again')));
                exit();
            }

            $userdata = array(
                'email'       => $this->input->post('email', TRUE),
            );

            $varify_code = $this->randomID();

            /******************************
             *  Email Verify
             ******************************/
            $appSetting = $this->common_model->get_setting();

            $post = array(
                'title'             => $appSetting->title,
                'subject'           => 'Password Reset Verification!',
                'to'                => $this->input->post('email', TRUE),
                'message'           => 'The Verification Code is <h1>' . $varify_code . '</h1>'
            );

            //Send Mail Password Reset Verification
            $send = $this->common_model->send_email($post);

            if (isset($send)) {

                $varify_data = array(
                    'ip_address'    => $this->input->ip_address(),
                    'user_id'       => $this->session->userdata('user_id'),
                    'session_id'    => $this->session->userdata('isLogIn'),
                    'verify_code'   => $varify_code,
                    'data'          => json_encode($userdata)
                );

                $this->db->insert('dbt_verify', $varify_data);
                $id = $this->db->insert_id();

                $this->session->set_flashdata('resetpermission', 'permited');
                $this->session->set_flashdata('message', display('password_reset_code_send_check_your_email'));
                echo json_encode(array('status' => 1, 'message' => ''));
                exit();
            }
        } else {
            echo json_encode(array('status' => 0, 'message' => validation_errors()));
            exit();
        }
    }

    public function resetPassword()
    {
        $data['title'] = "Reset Password";

        $code = $this->input->post('verificationcode', TRUE);
        $rpass = $this->input->post('rpass', TRUE);

        //Set Rules From validation
        $this->form_validation->set_rules('verificationcode', display('enter_verify_code'), 'required|xss_clean');
        $this->form_validation->set_rules('rpass', display('password'), 'required|trim|min_length[8]|max_length[32]|matches[confirmpassword]|xss_clean|callback_valid_password');
        $this->form_validation->set_rules('confirmpassword', "Confirm Password", 'trim|xss_clean');

        //From Validation Check
        if ($this->form_validation->run()) {

            $chkdata = $this->db->select('*')
                ->from('dbt_verify')
                ->where('verify_code', $code)
                ->where('status', 1)
                ->get()
                ->row();

            if ($chkdata != NULL) {
                $p_data = ((array) json_decode($chkdata->data));
                $password   = array('password' => md5($rpass));
                $status     = array('status'   => 0);

                $this->db->where('verify_code', $code)
                    ->update('dbt_verify', $status);

                $this->db->where('email', $p_data['email'])
                    ->update('dbt_user', $password);

                $this->session->set_flashdata('message', display('update_successfully'));
                redirect('login');
            } else {
                $this->session->set_flashdata('exception', display('wrong_try_activation'));
                redirect('resetPassword');
            }
        }

        $this->load->view('website/header', $data);
        $this->load->view('website/passwordreset', $data);
        $this->load->view('website/footer', $data);
    }

    public function activate_account($activecode = NULL)
    {


        if ($activecode != NULL || $activecode != '') {

            $user = $this->web_model->passwordtokenCheck($activecode);

            if ($user->status == 1) {
                $this->session->set_flashdata('message', "This account already activated");
                redirect("login");
            } elseif ($user->status == 2) {
                $this->session->set_flashdata('message', "This account is now pending");
                redirect("login");
            } elseif ($user->status == 3) {
                $this->session->set_flashdata('exception',  "This account is suspend");
                redirect("login");
            } elseif ($user->status == 0) {
                $this->web_model->activeUserAccount($activecode);
                $this->session->set_flashdata('message', display('active_account'));
                redirect("login");
            } else {
                $this->session->set_flashdata('exception', "Something wrong !!!");
                redirect(base_url('login'));
            }
        } else {
            $this->session->set_flashdata('exception', display('wrong_try_activation'));
            redirect("login");
        }
    }

    public function send()
    {
        $this->form_validation->set_rules('name', 'Your Name', 'required|trim|max_length[50]|alpha_numeric_spaces');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|max_length[30]|valid_email');
        $this->form_validation->set_rules('subject', 'Subject', 'required|trim|max_length[50]|alpha_numeric_spaces');
        $this->form_validation->set_rules('comment', 'Comment', 'required|trim|max_length[250]|alpha_numeric_spaces');

        if ($this->form_validation->run()) {
            $message = array('name' => $this->input->post('name', TRUE), 'comment' => $this->input->post('comment', TRUE));
            $message = json_encode($message);
            $insertdata = array(
                'sender_id'   => $this->input->post('email', TRUE),
                'reciver_id'  => 'admin',
                'subject'     => $this->input->post('subject', TRUE),
                'messege'     => $message,
                'date_time'   => date('Y-m-d H:i:s'),
                'status'      => 1
            );

            if ($this->db->insert("dbt_messenger", $insertdata)) {

                $this->session->set_flashdata('message', "Your Comment Send successfully!");
            } else {
                $this->session->set_flashdata('exception', "Sorry Not Send Your Request! Please Try Again!");
            }
        } else {
            $this->session->set_flashdata('exception', validation_errors());
        }

        redirect(base_url('#contact'));
    }


    //Ajax Subscription Action
    public function subscribe()
    {
        $data = array();
        $data['email'] =  $this->input->post('subscribe_email', TRUE);

        if ($this->web_model->subscribe($data)) {
            $this->session->set_flashdata('message', display('save_successfully'));
        } else {
            $this->session->set_flashdata('exception',  display('please_try_again'));
        }
    }

    //Ajax Language Change
    public function langChange()
    {
        $newdata = array(
            'lang'  => $this->input->post('lang', TRUE)
        );

        $user_id = $this->session->userdata('user_id');
        if ($user_id != "") {
            $data['language'] = $this->input->post('lang', TRUE);
            $this->db->where('user_id', $user_id);
            $this->db->update('dbt_user', $data);
        } else {
            $this->session->set_userdata($newdata);
        }
    }


    /******************************
     * Language Set For User
     ******************************/
    public function langSet()
    {

        $lang = "";
        $user_id = $this->session->userdata('user_id');
        if ($user_id != "") {
            $ulang = $this->db->select('language')->where('user_id', $user_id)->get('dbt_user')->row();
            if ($ulang->language != 'english') {
                $lang = 'french';
                $newdata = array(
                    'lang'  => 'french'
                );
                $this->session->set_userdata($newdata);
            } else {
                $lang = 'english';
                $newdata = array(
                    'lang'  => 'french'
                );
                $this->session->set_userdata($newdata);
            }
        } else {
            $alang = $this->db->select('language')->get('setting')->row();
            if ($alang->language == 'french') {
                $lang = 'french';
                $newdata = array(
                    'lang'  => 'french'
                );
                $this->session->set_userdata($newdata);
            } else {
                if ($this->session->lang == 'french') {
                    $lang = 'french';
                } else {
                    $lang = 'english';
                }
            }
        }

        return $lang;
    }

    public function randomID($mode = 2, $len = 6)
    {
        $result = "";
        if ($mode == 1) :
            $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        elseif ($mode == 2) :
            $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        elseif ($mode == 3) :
            $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        elseif ($mode == 4) :
            $chars = "0123456789";
        endif;

        $charArray = str_split($chars);
        for ($i = 0; $i < $len; $i++) {
            $randItem = array_rand($charArray);
            $result .= "" . $charArray[$randItem];
        }
        return $result;
    }
}
<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Upload_lib
{
    // To load this model
    function do_upload($upload_path = null, $field_name = null) {
        if (empty($_FILES[$field_name]['name'])) {
            return null;
        } else {
            //-----------------------------
            $ci =& get_instance();
            $ci->load->helper('url');  

            //folder upload
            $file_path = $upload_path;
            if (!is_dir($file_path))
                mkdir($file_path, 0755,true);
            //ends of folder upload 

            //set config 
            $config = [
                'upload_path'      => $file_path,
                'allowed_types'    => 'gif|jpg|png|jpeg|ico|pdf', 
                'overwrite'        => false,
                'max_size'         => '2048',
                'maintain_ratio'   => true,
                'encrypt_name'     => true,
                'remove_spaces'    => true,
                'file_ext_tolower' => true 
            ]; 
            $ci->load->library('upload', $config);
            ini_set('memory_limit', '-1');
            if (!$ci->upload->do_upload($field_name)) {
                $ci->session->set_flashdata('exception', $ci->upload->display_errors()); 
                return false;
            } else {
                $file = $ci->upload->data();
                return $file_path.$file['file_name'];
            }
        }
    }   

    public function do_resize($file_path = null, $width = null, $height = null) {
        $ci =& get_instance();
        $ci->load->library('image_lib');
        $config = [
            'image_library'  => 'gd2',
            'source_image'   => $file_path,
            'create_thumb'   => false,
            'maintain_ratio' => false,
            'width'          => $width,
            'height'         => $height,
        ]; 
        $ci->image_lib->initialize($config);
        $ci->image_lib->resize();
    }

}


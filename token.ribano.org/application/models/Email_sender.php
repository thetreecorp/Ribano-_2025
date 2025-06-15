<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Email_sender extends CI_Model {


	public function send($data)
	{

        $email = $this->db->select('*')->from('email_sms_gateway')->where('es_id', 2)->get()->row();

        $url = $email->host;
        $apikey = $email->api;

        $post = array(
        	'from' 				=> $data['from'],
        	'fromName' 			=> $data['fromName'],
        	'apikey' 			=> $apikey,
        	'subject' 			=> $data['subject'],
        	'to' 				=> $data['to'] ,
        	'bodyHtml' 			=> $data['message'] ,
        	'bodyText' 			=> 'Text Body',
        	'isTransactional' 	=> false);
        
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $post,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
            CURLOPT_SSL_VERIFYPEER => false
        ));
        
        return $result = curl_exec ($ch);
        curl_close ($ch);
	}
	

}
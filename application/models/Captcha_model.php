<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Captcha_model extends CI_Model {
    public function validation_captcha($response){
        $secret_key = $this->config->item('secretkey');
        $ch = curl_init('https://www.google.com/recaptcha/api/siteverify');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array(
            'secret' => $secret_key,
            'response' => $response
        )));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($response);
        if($result->success){
            if($result->success === true){
                $out = [
                    'status' => true,
                ];
            } else {
                $out = [
                    'status' => false,
                    'msg' => 'Captcha is not valid'
                ];
            }
        } else {
            //sudah di pastikan bot
            $out = [
                'status' => false,
                'msg' => 'Captcha is required'
            ];
        }
        return $out;
    }
}
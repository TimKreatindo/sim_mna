<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Mail_model extends CI_Model {
    public function send_mail($data = null){
        $host = $this->config->item('smtp_host');
        $user = $this->config->item('smtp_user');
        $pass = $this->config->item('smtp_pass');
        $port = $this->config->item('smtp_port');

        if($data['type'] == 'verify'){
            $subject = 'Verifikasi Akun Email';
            $message = $this->verify_message($data);
        } else if($data['type'] == 'forgot_password'){
            $subject = 'Reset Password';
            $message = $this->password_message($data);
        }

        $config = [
            'protocol' => 'smtp',
            'smtp_host' => $host,
            'smtp_user' => $user,
            'smtp_pass' => $pass,
            'smtp_port' => $port,
            'smtp_crypto' => 'tls',
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'newline'   => "\r\n"
        ];

        $this->email->initialize($config);

        $this->email->from('message@kreatindo.com', 'Logbook MNA');
        $this->email->to($data['email']);
        $this->email->subject($subject);
        $this->email->message($message);
        
        if($this->email->send()){
            return true;
        } else {
            return false;
        }
        die;
        
    }


    private function verify_message($data){
        $message = '
        <!DOCTYPE HTML PUBLIC "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <html xmlns="http://www.w3.org/1999/xhtml">

            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <meta name="x-apple-disable-message-reformatting">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <style>
                    #image-logo {
                        -ms-interpolation-mode: bicubic;
                        display: inline-block !important;
                        height: auto;
                        width: 100%;
                        max-width: 72px;
                    }

                    #heading {
                        font-family: Comfortaa, sans-serif;
                        font-size: 14px;
                        text-align: center;
                    }

                    #main-table {
                        max-width: 400px;
                        min-width: 300px;
                        word-wrap: break-word;
                        word-break: break-word;
                        border: 1px solid #0c0d0d;
                        background-color: #f2f2f2;
                        color: #0c0d0d;
                    }

                    #button {
                        background-color: #7747FF;
                        padding: 10px 15px;
                        border: none;
                        color: #f2f2f2;
                    }

                    .body-content p {
                        font-size: 11px;
                    }

                    .footer {
                        background-color: #48bec7;
                    }

                    @media screen and (max-width: 520px) {
                        #main-table {
                            width: 100% !important;
                        }
                    }
                </style>
            </head>

            <body>

                <div align="center">
                    <table id="main-table">
                        <tr>
                            <td>
                                <table>
                                    <tr>
                                        <td>
                                            <table>
                                                <tr>
                                                    <td width="15%">
                                                        <img align="center" src="https://i.ibb.co.com/1Yf3zz5H/Logo-Polije.png"
                                                            id="image-logo" />
                                                    </td>
                                                    <td>
                                                        <h4 id="heading">
                                                            Politeknik Negeri Jember <br>
                                                            Logbook MNA
                                                        </h4>
                                                    </td>
                                                </tr>
                                            </table>

                                            <hr>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="body-content">
                                            <div style="font-family: Arial, "Helvetica Neue", Helvetica, sans-serif">
                                                <p>Halo, '.$data['name'].'.</p>
                                                <p>Terima kasih telah mendaftar di Logbook MNA!
                                                    <br>
                                                    Untuk menyelesaikan proses pendaftaran dan mengaktifkan akun Anda, silakan klik
                                                    tombol di bawah ini:
                                                </p>
                                                <br>
                                                <div style="text-align: center;">
                                                    <a href="'.$data['link'].'" target="_blank" class="v-button" style="text-decoration: none; "
                                                        id="button">
                                                        Verifikasi
                                                    </a>
                                                </div>
                                                <br>
                                                <p>Jika Anda mengalami masalah dengan tautan di atas, Anda dapat menyalin dan
                                                    menempelkan URL berikut di browser Anda:
                                                    <br>
                                                    <a href="'.$data['link'].'" target="_blank" rel="noopener">
                                                        '.$data['link'].'
                                                    </a>
                                                </p>
                                                <p>
                                                    Jika Anda tidak merasa mendaftar di Logbook MNA, Anda dapat
                                                    mengabaikan email ini. <br>
                                                    Terima kasih. <br><br><br><br><br>
                                                    Tim Logbook MNA
                                                </p>
                                            </div>
                                        </td>
                                    </tr>

                                </table>

                            </td>

                        </tr>
                    </table>
                </div>
            </body>

            </html>
        ';
        return $message;
    }

    private function password_message($data){
        $message = '
        <!DOCTYPE HTML PUBLIC "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <html xmlns="http://www.w3.org/1999/xhtml">

            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <meta name="x-apple-disable-message-reformatting">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <style>
                    #image-logo {
                        -ms-interpolation-mode: bicubic;
                        display: inline-block !important;
                        height: auto;
                        width: 100%;
                        max-width: 72px;
                    }

                    #heading {
                        font-family: Comfortaa, sans-serif;
                        font-size: 14px;
                        text-align: center;
                    }

                    #main-table {
                        max-width: 400px;
                        min-width: 300px;
                        word-wrap: break-word;
                        word-break: break-word;
                        border: 1px solid #0c0d0d;
                        background-color: #f2f2f2;
                        color: #0c0d0d;
                    }

                    #button {
                        background-color: #7747FF;
                        padding: 10px 15px;
                        border: none;
                        color: #f2f2f2;
                    }

                    .body-content p {
                        font-size: 11px;
                    }

                    .footer {
                        background-color: #48bec7;
                    }

                    @media screen and (max-width: 520px) {
                        #main-table {
                            width: 100% !important;
                        }
                    }
                </style>
            </head>

            <body>

                <div align="center">
                    <table id="main-table">
                        <tr>
                            <td>
                                <table>
                                    <tr>
                                        <td>
                                            <table>
                                                <tr>
                                                    <td width="15%">
                                                        <img align="center" src="https://i.ibb.co.com/1Yf3zz5H/Logo-Polije.png"
                                                            id="image-logo" />
                                                    </td>
                                                    <td>
                                                        <h4 id="heading">
                                                            Politeknik Negeri Jember <br>
                                                            Logbook MNA
                                                        </h4>
                                                    </td>
                                                </tr>
                                            </table>

                                            <hr>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="body-content">
                                            <div style="font-family: Arial, "Helvetica Neue", Helvetica, sans-serif">
                                                <p>Halo, '.$data['name'].'.</p>
                                                <p>
                                                    Kami menerima permintaan untuk mereset kata sandi akun anda. untuk login kembali, harap gunakan kata sandi berikut:
                                                </p>
                                                <br>
                                                <div style="text-align: center;">
                                                   <h4>'.$data['new_pass'].'</h4>
                                                </div>
                                                <br>
                                                <p>
                                                    Jangan berikan kata sandi ini kepada siapapun, termasuk tim Logbook MNA. <br>
                                                <p>
                                                    Terima kasih. <br><br><br><br><br>
                                                    Tim Logbook MNA
                                                </p>
                                            </div>
                                        </td>
                                    </tr>

                                </table>

                            </td>

                        </tr>
                    </table>
                </div>
            </body>

            </html>
        ';
        return $message;
    }
}
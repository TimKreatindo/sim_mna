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
        width: 15%;
        max-width: 72px;
    }

    #heading {
        font-family: Comfortaa, sans-serif;
        font-size: 19px;
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
        background-color: #8bd3dd;
        padding: 5px 10px;
        border: 1px solid #0c0d0d;
        color: #0c0d0d;
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
                                <div style="text-align: center;">
                                    <img align="center" src="https://i.ibb.co.com/qp1dVnL/logo.png" id="image-logo" />
                                    <h4 id="heading">Keluarga Alumni Universitas Jember</h4>
                                </div>

                                <hr>
                                <div style="font-family: IBM Plex Mono, monospace">
                                    <p>Halo, ' . $data['name'] . '.</p>
                                    <p>Silahkan klik tombol dibawah ini untuk memverifikasi alamat email anda. Hal ini
                                        di perlukan untuk mengonfirmasi kepemilikan akun email.</p>
                                    <br>
                                    <div style="text-align: center;">
                                        <a href="' . $data['link'] . '" target="_blank" class="v-button"
                                            style="text-decoration: none; " id="button">
                                            Verifikasi
                                        </a>
                                    </div>
                                    <br>
                                    <p>Jika Anda mengalami masalah, coba salin dan tempel URL berikut ke browser Anda:
                                        <br>
                                        <a href="' . $data['link'] . '" target="_blank" rel="noopener">
                                            ' . $data['link'] . '
                                        </a>
                                    </p>
                                    <br>
                                    <p>
                                        Tautan ini hanya berlaku 1 hari s/d ' . $exp_token . '. Jika sudah kadaluarsa,
                                        harap hubungi admin untuk mendapatkan tautan baru.
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
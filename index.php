<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Recaptcha İletişim Formu</title>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<style media="screen">
.container{
  padding-top: 150px;
}
  .col-md-6,.col-md-12{
    margin-bottom: 15px;
  }
</style>
</head>
<body>
  <div class="container">
    <form action="" method="post">
      <div class="row">
        <div class="col-md-6">
          <input class="form-control" type="text" name="adsoyad" placeholder="Adı Soyadı"/>
        </div>
        <div class="col-md-6">
          <input class="form-control" type="text" name="eposta" placeholder="Eposta"/>
        </div>
        <div class="col-md-6">
          <input class="form-control" type="text" name="konu" placeholder="Konu"/>
        </div>
        <div class="col-md-6">
          <input class="form-control" type="text" name="telefon" placeholder="Telefon"/>
        </div>
        <div class="col-md-12">
          <textarea class="form-control" name="mesaj" placeholder="Mesaj"></textarea>
        </div>
        <div class="col-md-12 mb-30">
          <div class="g-recaptcha" data-sitekey="6LdE4uoUAAAAAG7Cebvxl9HSrWDdEtAWspF08tHr"></div>
        </div>
        <div class="col-md-12 text-center-md-max mb-30">
          <button type="submit" name="gonder" class="btn btn-size-2 btn-primary">Gonder</button>
        </div>
      </div>
    </form>
    <?php
      error_reporting(0);
      include 'class.phpmailer.php';
      include 'class.smtp.php';

      if (isset($_POST['gonder'])) {
        $secretKey = "6LdE4uoUAAAAAO4kKULlbRBFnt5VMET_Yw44ioeL";
        $responseKey = $_POST['g-recaptcha-response'];
        $UserIP = $_SERVER['REMOTE_ADDR'];
        $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$responseKey&remoteip=$UserIP";

        $response = file_get_contents($url);
        $response = json_decode($response);

        if ($response->success){
          $mail = new PHPMailer();
          $mail->IsSMTP();
          $mail->Host     = "mail.aliyasar.com.tr";
          $mail->SMTPAuth = true;
          $mail->Username = "deneme@aliyasar.com.tr";
          $mail->Password = "@1D*1c$4G";
          $mail->CharSet = 'UTF-8';
          $mail->Port   = "587";
          $mail->From     = "deneme@aliyasar.com.tr";
          $mail->Fromname = "İletişim Formundan Gelen Mail";
          $mail->AddAddress("aliyasarcomtr@gmail.com");
          $mail->Subject  =  $_POST['konu'];
          $mail->IsHTML(true);
          $mail->Body     =  '
              <table>
                  <tr>
                      <td style="border:1px solid #ddd;padding:5px">"Adı Soyadı"</td>
                      <td style="border:1px solid #ddd;padding:5px">'.urldecode($_POST['adsoyad']).'</td>
                  </tr>
                  <tr>
                      <td style="border:1px solid #ddd;padding:5px">"E-posta adresi"</td>
                      <td style="border:1px solid #ddd;padding:5px">'.urldecode($_POST['eposta']).'</td>
                  </tr>
                  <tr>
                      <td style="border:1px solid #ddd;padding:5px">"Telefon"</td>
                      <td style="border:1px solid #ddd;padding:5px">'.urldecode($_POST['telefon']).'</td>
                  </tr>
                  <tr>
                      <td style="border:1px solid #ddd;padding:5px">Konu</td>
                      <td style="border:1px solid #ddd;padding:5px">'.urldecode($_POST['konu']).'</td>
                  </tr>
                  <tr>
                      <td style="border:1px solid #ddd;padding:5px">Mesaj</td>
                      <td style="border:1px solid #ddd;padding:5px">'.urldecode($_POST['mesaj']).'</td>
                  </tr>
              </table>
          ';
          if (!$mail->Send()) {
            echo "Mesajınız Gönderilemedi!" . $mail->ErrorInfo;
            exit;
          }
          echo "Mesajınız Gönderildi!";
        }else{
          echo "Doğrulamayı Geçemediniz!";
        }
      }
    ?>
  </div>
</body>
</html>

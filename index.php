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
          <input class="form-control" type="text" name="Name" placeholder="Name"/>
        </div>
        <div class="col-md-6">
          <input class="form-control" type="text" name="Email" placeholder="Email"/>
        </div>
        <div class="col-md-6">
          <input class="form-control" type="text" name="Subject" placeholder="Subject"/>
        </div>
        <div class="col-md-6">
          <input class="form-control" type="text" name="Phone" placeholder="Phone"/>
        </div>
        <div class="col-md-12">
          <textarea class="form-control" name="Message" placeholder="Message"></textarea>
        </div>
        <div class="col-md-12 mb-30">
          <div class="g-recaptcha" data-sitekey="6LdE4uoUAAAAAG7Cebvxl9HSrWDdEtAWspF08tHr"></div>
        </div>
        <div class="col-md-12 text-center-md-max mb-30">
          <button type="submit" name="Send" class="btn btn-size-2 btn-primary">Send</button>
        </div>
      </div>
    </form>
    <?php
      error_reporting(0);
      include 'class.phpmailer.php';
      include 'class.smtp.php';

      if (isset($_POST['Send'])) {
        $secretKey = "6LdE4uoUAAAAAO4kKULlbRBFnt5VMET_Yw44ioeL";
        $responseKey = $_POST['g-recaptcha-response'];
        $UserIP = $_SERVER['REMOTE_ADDR'];
        $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$responseKey&remoteip=$UserIP";

        $response = file_get_contents($url);
        $response = json_decode($response);

        if ($response->success){
          $mail = new PHPMailer();
          $mail->IsSMTP();
          $mail->Host     = "mail.site.com";
          $mail->SMTPAuth = true;
          $mail->Username = "email address";
          $mail->Password = "password";
          $mail->CharSet = 'UTF-8';
          $mail->Port   = "587";
          $mail->From     = "email address";
          $mail->Fromname = "who mail";
          $mail->AddAddress("send mail adres");
          $mail->Subject  =  $_POST['subject'];
          $mail->IsHTML(true);
          $mail->Body     =  '
              <table>
                  <tr>
                      <td style="border:1px solid #ddd;padding:5px">Name</td>
                      <td style="border:1px solid #ddd;padding:5px">'.urldecode($_POST['Name']).'</td>
                  </tr>
                  <tr>
                      <td style="border:1px solid #ddd;padding:5px">Email</td>
                      <td style="border:1px solid #ddd;padding:5px">'.urldecode($_POST['Email']).'</td>
                  </tr>
                  <tr>
                      <td style="border:1px solid #ddd;padding:5px">Phone</td>
                      <td style="border:1px solid #ddd;padding:5px">'.urldecode($_POST['Phone']).'</td>
                  </tr>
                  <tr>
                      <td style="border:1px solid #ddd;padding:5px">Subject</td>
                      <td style="border:1px solid #ddd;padding:5px">'.urldecode($_POST['Subject']).'</td>
                  </tr>
                  <tr>
                      <td style="border:1px solid #ddd;padding:5px">Message</td>
                      <td style="border:1px solid #ddd;padding:5px">'.urldecode($_POST['Message']).'</td>
                  </tr>
              </table>
          ';
          if (!$mail->Send()) {
            echo "Your message could not be sent!" . $mail->ErrorInfo;
            exit;
          }
          echo "Your message has been sent!";
        }else{
          echo "You Didn't Pass Verification!";
        }
      }
    ?>
  </div>
</body>
</html>

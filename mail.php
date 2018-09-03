<?php 

              /* Email */

              /*$actual_link = "http://".$_SERVER['HTTP_HOST']."/active.php?key=" . $verificationCode;

              /*$admin_email = "smccape@gmail.com";
              $admin_email = "dev@dchain.com";
              $subject = "dChain GET: Cuenta Creada";
              $headers = "MIME-Version: 1.0\\r\ ";
              $headers .= "Content-type: text/html; charset=iso-8859-1\\r\ ";
              $headers .= "From: ".$admin_email;
              $comment = " Hola ".$USERNAME.",\n\n tu cuenta fue creada. Tu contraseña es ".$_POST['password'].". Has click en el siguiente enlase. <a href='" . $actual_link . "'>Click</a>";
              /*$send = mail($email, "$subject", $comment, $headers);*/

              /*include("mailjet/src/Mailjet/php-mailjet-v3-simple.class.php");

              $apiKey = '16ecb7873995588027a5cef50f59b719';
              $secretKey = '06e6276f1fe3249498c103b601869f58';

              $mj = new Mailjet($apiKey, $secretKey);
              if (isset($_POST['submitUser'])) {

                  function sendEmail($email, $subject, $comment, $admin_email) {
                      // Create a new Object
                      $mj = new Mailjet();
                      $params = array(
                          "method" => "POST",
                          "from" => "{$admin_email}",
                          "to" => "{$email}",
                          "subject" => "{$subject}",
                          "text" => "{$comment}"
                      );
                      $result = $mj->sendEmail($params);
                      if ($mj->_response_code == 200) {
                          //echo "success - email sent";
                          print '<script type="text/javascript">';
                          print 'alert("email successfully sent!")';
                          print '</script>';
                      } elseif ($mj->_response_code == 400) {
                          //echo "error - " . $mj->_response_code;
                          print '<script type="text/javascript">';
                          print 'alert("Bad Request! One or more arguments are missing or maybe mispelling.")';
                          print '</script>';
                      } elseif ($mj->_response_code == 401) {
                          //echo "error - " . $mj->_response_code;
                          print '<script type="text/javascript">';
                          print 'alert("Unauthorized! You have specified an incorrect ApiKey or username/password couple.")';
                          print '</script>';
                      } elseif ($mj->_response_code == 404) {
                          //echo "error - " . $mj->_response_code;
                          print '<script type="text/javascript">';
                          print 'alert("Not Found! The method your are trying to reach don\'t exists.")';
                          print '</script>';
                      } elseif ($mj->_response_code == 405) {
                          //echo "error - " . $mj->_response_code;
                          print '<script type="text/javascript">';
                          print 'alert("Method Not Allowed! You made a POST request instead of GET, or the reverse.")';
                          print '</script>';
                      } else {
                          print '<script type="text/javascript">';
                          print 'alert(" Internal Server Error! Status returned when an unknow error occurs")';
                          print '</script>';
                      }

                      return $result;
                  }

                  sendEmail($email, $subject, $comment, $admin_email);*/
              /*}*/

?>
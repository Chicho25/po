<?php
    ob_start();
    session_start();
    $pay="class='active'";
    $payusers="class='active'";

    include("include/config.php");
    include("include/defs.php");
    include("header.php");

    if(!isset($_SESSION['USER_ID']) || $_SESSION['USER_ROLE'] != 1 && $_SESSION['USER_ROLE'] != 4)
     {
          header("Location: index.php");
          exit;
     }

     if (isset($_POST['submitPayUser'])) {
           $array_mov_bank = array("id_average_user"=>$_POST['id_pay_average'],
                                    "id_user"=>$_POST['id_pay_user'],
                                    "amount_paid"=>$_POST['amount_paid'],
                                    "stat"=>1,//pago ususario
                                    "messaje"=>$_POST['messaje'],
                                    "id_user_reg"=>$_SESSION['USER_ID'],
                                    "data_time"=>date("Y-m-d H:i:s"));

            $nId = InsertRec("pay_user_central", $array_mov_bank);

            $obtener_monto_usuario = GetRecords("select * from average_users where id_user = '".$_POST['id_pay_user']."'");
            $acumulado_pagar = $obtener_monto_usuario[0]['amount_pay'];
            $restante = $acumulado_pagar - $_POST['amount_paid'];
            UpdateRec("average_users", "id_user =".$_POST['id_pay_user'], array("amount_pay"=>$restante));

            if($nId > 0)
            {

            if(isset($_FILES['photo']) && $_FILES['photo']['tmp_name'] != "")
                {
                $target_dir = "pay_user_central/";
                $target_file = $target_dir . basename($_FILES["photo"]["name"]);
                $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
                $filename = $target_dir . $nId.".".$imageFileType;
                $filenameThumb = $target_dir . $nId."_thumb.".$imageFileType;
                if (move_uploaded_file($_FILES["photo"]["tmp_name"], $filename))
                    {
                    makeThumbnailsWithGivenWidthHeight($target_dir, $imageFileType, $nId, 100, 100);

                    UpdateRec("pay_user_central", "id = ".$nId, array("attached" => $filenameThumb));
                    }
                }
            }
     }

     if (isset($_POST['submitPayAcumulate'])) {
        $array_mov_bank = array("id_average_user"=>$_POST['id_pay_average'],
                                 "id_user"=>$_POST['id_pay_user'],
                                 "amount_paid"=>$_POST['amount_paid'],
                                 "stat"=>2,//pago central
                                 "messaje"=>$_POST['messaje'],
                                 "id_user_reg"=>$_SESSION['USER_ID'],
                                 "data_time"=>date("Y-m-d H:i:s"));

         $nId = InsertRec("pay_user_central", $array_mov_bank);

         $obtener_monto_usuario = GetRecords("select * from average_users where id_user = '".$_POST['id_pay_user']."'");
         $acumulado_pagar = $obtener_monto_usuario[0]['amount_accumulated'];
         $restante = $acumulado_pagar - $_POST['amount_paid'];
         UpdateRec("average_users", "id_user =".$_POST['id_pay_user'], array("amount_accumulated"=>$restante));

         if($nId > 0)
         {

         if(isset($_FILES['photo']) && $_FILES['photo']['tmp_name'] != "")
             {
             $target_dir = "pay_user_central/";
             $target_file = $target_dir . basename($_FILES["photo"]["name"]);
             $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
             $filename = $target_dir . $nId.".".$imageFileType;
             $filenameThumb = $target_dir . $nId."_thumb.".$imageFileType;
             if (move_uploaded_file($_FILES["photo"]["tmp_name"], $filename))
                 {
                 makeThumbnailsWithGivenWidthHeight($target_dir, $imageFileType, $nId, 100, 100);

                 UpdateRec("pay_user_central", "id = ".$nId, array("attached" => $filenameThumb));
                 }
             }
         }
     }

           $arrUser = GetRecords("select
                                    au.id,
                                    au.id_user, 
                                    au.amount_accumulated, 
                                    au.amount_pay, 
                                    u.name, 
                                    u.last_name, 
                                    u.credit
                                  from average_users au inner join users u on u.id = au.id_user");

?>
	<section id="content">
          <section class="vbox">
            <section class="scrollable padder">
              <section class="panel panel-default">
                <header class="panel-heading">
                  <span class="h4">Pagos a Usuario</span>
                </header>
                <div class="panel-body">
                  <?php
                        if(isset($message) && $message !=""){
                            echo $message;
                          }
                  ?>

                    <div class="table-responsive">
                        <table class="table table-striped b-t b-light" data-ride="datatables">
                          <thead>
                            <tr>
                              <th>USUARIO</th>
                              <th>CREDITO</th>
                              <th>MONTO ACUMULADO $</th>
                              <th>MONTO A PAGAR AL USUARIO $</th>
                              <th>PAGAR ACUMULADO</th>
                              <th>PAGAR USUARIO</th>
                              <th>VER PAGOS</th>
                            </tr>
                          </thead>
                          <tbody>
                          <?PHP
                            $i=1;
                            foreach ($arrUser as $key => $value) { ?>
                          <tr>
                              <td class="tbdata"> <?php echo $value['name'].' '.$value['last_name']; ?> </td>
                              <td class="tbdata"> <?php echo number_format($value['credit'], 2, ',', '.');?> $</td>
                              <td class="tbdata"> <?php echo number_format($value['amount_accumulated'], 2, ',', '.');?> $</td>
                              <td class="tbdata"> <?php echo number_format($value['amount_pay'], 2, ',', '.');?> $</td>
                              <td>
                              <?php if ($value['amount_accumulated']==0) {
                                  # code...
                              }else{ ?>
                                <a href="modal-pay-acumulate.php?id=<?php echo $value['id']?>" title="PAGAR ACUMULADO" data-toggle="ajaxModal" class="btn btn-sm btn-icon btn-primary"><i class="fa fa-dollar"></i></a>
                              <?php } ?>
                              </td>
                              <td>
                              <?php if ($value['amount_pay']==0) {
                                  # code...
                              }else{ ?>
                                <a href="modal-pay-users.php?id=<?php echo $value['id']?>" title="PAGAR AL USUARIO" data-toggle="ajaxModal" class="btn btn-sm btn-icon btn-primary"><i class="fa fa-dollar"></i></a>
                              <?php } ?>
                              </td>
                              <td>
                                <a href="modal-detail-pay-users.php?id=<?php echo $value['id']?>" title="VER PAGOS" data-toggle="ajaxModal" class="btn btn-sm btn-icon btn-primary"><i class="glyphicon glyphicon-eye-open"></i></a>
                              </td>
                          </tr>
                          <?php
                            $i++;
                          }
                          ?>
                          </tbody>
                        </table>
                    </div>
                </div>
              </section>
            </section>
        </section>
    </section>
<?php
	include("footer.php");
?>

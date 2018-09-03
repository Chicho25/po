<?php
  ob_start();
  session_start();
  $hideLeft = true;
  include("include/config.php");
  include("include/defs.php");
  $loggdUType = current_user_type();

  include("header.php");

  if(!isset($_SESSION['USER_ID']))
     {
          header("Location: index.php");
          exit;
     }

     if(isset($_POST['submitValueDollar'])){

       $arrVal = array(
                     "value_dollar" => $_POST['new_amount'],
                     "id_user" => $_SESSION['USER_ID'],
                     "stat" => 1
                    );

     $nId = InsertRec("value_dollar", $arrVal);

       $message = '<div class="alert alert-success">
                   <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                     <strong>Taza Actual Modificada</strong>
                   </div>';

     }

     if(isset($_POST['deleteDetail'])){

       $monto_a_sumar = $_POST["remaining"] + $_POST['amount'];

       $arrTrans = array("remaining"=>$monto_a_sumar);

       UpdateRec("transaction", "id = ".$_POST['id_transaction'], $arrTrans);

       MySQLQuery("DELETE FROM main_pay WHERE id = '".$_POST['id_pay']."'");

       $message = '<div class="alert alert-success">
                   <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                     <strong>Detalle de pago Borrado</strong>
                   </div>';

     }

     if(isset($_POST['submitTransaction'])) {

       if(isset($_POST['stat'])){
         $stat = $_POST['stat'];
       }else{
         $stat = $_POST['stat_hidden'];
       }

       $arrTrans = array("id_customer"=>$_POST['customer'],
                         "amount"=>$_POST['get_amount'],
                         "amount_transfer"=>$_POST['amount_transfer'],
                         "remaining"=>$_POST['amount_transfer'],
                         "messaje"=>$_POST['messaje'],
                         "stat"=>$stat);

        UpdateRec("transaction", "id = ".$_POST['id'], $arrTrans);

        $message = '<div class="alert alert-success">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                      <strong>Transacciòn Actualizada</strong>
                    </div>';

     }

     if(isset($_POST['submitPay'])){

       $arrPay = array("id_transaction"=>$_POST['id_transaction'],
                        "id_user"=>$_SESSION['USER_ID'],
                        "amount_paid"=>$_POST['amount_transfer'],
                        "messaje"=>$_POST['messaje'],
                        "stat"=>1,
                        "id_bank"=>$_POST['bank']);

       $nId = InsertRec("main_pay", $arrPay);

       if($nId > 0)
       {

           if(isset($_FILES['photo']) && $_FILES['photo']['tmp_name'] != "")
           {
               $target_dir = "attached_invoice/";
               $target_file = $target_dir . basename($_FILES["photo"]["name"]);
               $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
               $filename = $target_dir . $nId.".".$imageFileType;
               $filenameThumb = $target_dir . $nId."_thumb.".$imageFileType;
               if (move_uploaded_file($_FILES["photo"]["tmp_name"], $filename))
               {
                   /*makeThumbnailsWithGivenWidthHeight($target_dir, $imageFileType, $nId, 100, 100);*/

                   UpdateRec("main_pay", "id = ".$nId, array("attached" => $filenameThumb));
               }
           }

       $amount_remaining = $_POST['remaining'] - $_POST['amount_transfer'];
         $stat = 2;
       if($amount_remaining == 0){
         $stat = 3;
       }

       UpdateRec("transaction", "id = ".$_POST['id_transaction'], array("remaining" => $amount_remaining,
                                                                        "stat" => $stat));

       $message = '<div class="alert alert-success">
                   <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                     <strong>Pago Registrado</strong>
                   </div>';

          }

     }

    $where = "where (1=1)";

     if(isset($_POST['name']) && $_POST['name'] != "")
     {
        $where.=" and  customer.name LIKE '%".$_POST['name']."%'";
        $name = $_POST['name'];
     }
     if(isset($_POST['lname']) && $_POST['lname'] != "")
     {
        $where.=" and  customer.last_name LIKE '%".$_POST['lname']."%'";
        $lname = $_POST['lname'];
     }
     if(isset($_POST['date_from']) && $_POST['date_from'] != "")
     {
        $where.=" and  transaction.date_time >= '".$_POST['date_from']."'";
        $date_from = $_POST['date_from'];
     }
     if(isset($_POST['date_to']) && $_POST['date_to'] != "")
     {
        $where.=" and transaction.date_time <= '".$_POST['date_to']." 23:59:59"."'";
        $date_to = $_POST['date_to'];
     }


      $arrTrans = GetRecords("SELECT
                              transaction.id,
                              transaction.date_time,
                              transaction.amount,
                              transaction.amount_transfer,
                              transaction.stat,
                              transaction.messaje,
                              transaction.remaining,
                              customer.id as id_customer,
                              customer.name,
                              customer.last_name,
                              customer.phone,
                              type_transaction.name as name_type_transaction,
                              case transaction.stat
                              when 1 then 'Pendiente por Pago'
                              when 2 then 'Abonada'
                              when 3 then 'Pagada'
                              when 4 then 'Anulada'
                              end as transaction_status
                              FROM transaction inner join customer on transaction.id_customer = customer.id
                              				         inner join type_transaction on transaction.id_type_transaction = type_transaction.id
                              $where
                              and transaction.stat in(1, 2)");

 ?>

 <section id="content">
         <section class="vbox">
           <section class="scrollable padder">
             <section class="panel panel-default">
               <header class="panel-heading">
                  <span class="h4">Principal</span>
               </header>
               <div class="panel-body">
                 <?php
                       if(isset($message) && $message !=""){
                           echo $message;
                         }
                 ?>
                 <div class="row">
                  <div class="col-sm-12">
                    <div class="panel b-a">
                      <div class="row m-n">
                        <div class="col-md-3 b-b b-r">
                          <?php
                          $arrUser = GetRecords("SELECT * from value_dollar order by id desc limit 1");
                          $id = $arrUser[0]['id'];
                          $value = $arrUser[0]['value_dollar'];?>
                          <a href="modal-taza-actual.php?id=<?php echo $id;?>" title="Cambiar la taza actual" data-toggle="ajaxModal" class="block padder-v hover">
                            <span class="i-s i-s-2x pull-left m-r-sm">
                              <i class="i i-hexagon2 i-s-base text-success hover-rotate"></i>
                              <i class="fa fa-usd i-1x text-white"></i>
                            </span>
                                <span class="clear">
                                <span class="h3 block m-t-xs text-success"><?php echo number_format($value, 2, ',', '.');?> Bs</span>
                                <small class="text-muted text-u-c">Taza Actual de Cambio</small>
                                </span>
                          </a>
                        </div>
                        <div class="col-md-3 b-b b-r">
                          <a href="#" class="block padder-v hover">
                            <span class="i-s i-s-2x pull-left m-r-sm">
                              <i class="i i-hexagon2 i-s-base text-danger-lt hover-rotate"></i>
                              <i class="fa fa-money i-sm text-white"></i>
                            </span>
                            <span class="clear">
                              <?php
                              $arrSum = GetRecords("SELECT sum(remaining) as sum_remaining from transaction where stat in(1, 2)");

                              $sum = $arrSum[0]['sum_remaining']/$value;?>

                              <span class="h3 block m-t-xs text-danger"><?php echo number_format($sum, 2, ',', '.'); ?> $</span>
                              <small class="text-muted text-u-c">Monto Pendiente Pago en $</small>
                            </span>
                          </a>
                        </div>
                        <div class="col-md-3 b-b b-r">
                          <a href="#" class="block padder-v hover">
                            <span class="i-s i-s-2x pull-left m-r-sm">
                              <i class="i i-hexagon2 i-s-base text-danger-lt hover-rotate"></i>
                              <i class="fa fa-money i-sm text-white"></i>
                            </span>
                            <span class="clear">
                              <?php
                              $arrSum = GetRecords("SELECT sum(remaining) as sum_remaining from transaction where stat in(1, 2)");

                              $sum = $arrSum[0]['sum_remaining'];?>

                              <span class="h3 block m-t-xs text-danger"><?php echo number_format($sum, 2, ',', '.'); ?> Bs</span>
                              <small class="text-muted text-u-c">Monto Pendiente Pago en Bs</small>
                            </span>
                          </a>
                        </div>
                        <div class="col-md-3 b-b">
                          <a href="#" class="block padder-v hover">
                            <span class="i-s i-s-2x pull-left m-r-sm">
                              <i class="i i-hexagon2 i-s-base text-primary hover-rotate"></i>
                              <i class="i i-users2 i-sm text-white"></i>
                            </span>
                            <span class="clear">
                              <?php $arrCus = GetRecords("SELECT count(*) as con_customer from customer where stat = 1");

                                    $cust = $arrCus[0]['con_customer'];?>
                              <span class="h3 block m-t-xs text-primary"><?php echo $cust; ?></span>
                              <small class="text-muted text-u-c">Total Clientes</small>
                            </span>
                          </a>
                        </div>
                        <div class="col-md-3 b-b b-r">
                          <a href="#" class="block padder-v hover">
                            <span class="i-s i-s-2x pull-left m-r-sm">
                              <i class="i i-hexagon2 i-s-base text-warning hover-rotate"></i>
                              <i class="glyphicon glyphicon-warning-sign i-sm text-white"></i>
                            </span>
                            <span class="clear">
                              <?php $arrCon = GetRecords("SELECT count(*) as con_trans from transaction where stat in(1, 2)");

                                    $con = $arrCon[0]['con_trans'];?>
                              <span class="h3 block m-t-xs text-warning"><?php echo $con; ?> <span class="text-sm"></span></span>
                              <small class="text-muted text-u-c">Total Transacciones Pendientes</small>
                            </span>
                          </a>
                        </div>
                        <div class="col-md-3 b-b b-r">
                          <a href="#" class="block padder-v hover">
                            <span class="i-s i-s-2x pull-left m-r-sm">
                              <i class="i i-hexagon2 i-s-base text-warning hover-rotate"></i>
                              <i class="glyphicon glyphicon-warning-sign i-sm text-white"></i>
                            </span>
                            <span class="clear">
                              <?php $arrCon = GetRecords("SELECT count(*) as con_trans from transaction");

                                    $con = $arrCon[0]['con_trans'];?>
                              <span class="h3 block m-t-xs text-warning"><?php echo $con; ?> <span class="text-sm"></span></span>
                              <small class="text-muted text-u-c">Total Transacciones</small>
                            </span>
                          </a>
                        </div>
                        <div class="col-md-3 b-b b-r">
                          <a href="#" class="block padder-v hover">
                            <span class="i-s i-s-2x pull-left m-r-sm">
                              <i class="i i-hexagon2 i-s-base text-warning hover-rotate"></i>
                              <i class="glyphicon glyphicon-warning-sign i-sm text-white"></i>
                            </span>
                            <span class="clear">
                              <?php $arrCon = GetRecords("SELECT count(*) as con_trans from transaction where date_time >= '".date("Y-m-d")."' and date_time <= '".date("Y-m-d")." 23:59:59"."'");

                                    $con = $arrCon[0]['con_trans'];?>
                              <span class="h3 block m-t-xs text-warning"><?php echo $con; ?> <span class="text-sm"></span></span>
                              <small class="text-muted text-u-c">Total Transacciones Hoy</small>
                            </span>
                          </a>
                        </div>
                        <div class="col-md-3 b-b b-r">
                          <a href="#" class="block padder-v hover">
                            <span class="i-s i-s-2x pull-left m-r-sm">
                              <i class="i i-hexagon2 i-s-base text-warning hover-rotate"></i>
                              <i class="glyphicon glyphicon-warning-sign i-sm text-white"></i>
                            </span>
                            <span class="clear">
                              <?php $arrCon = GetRecords("SELECT count(*) as con_trans from transaction where stat in(3)");

                                    $con = $arrCon[0]['con_trans'];?>
                              <span class="h3 block m-t-xs text-warning"><?php echo $con; ?> <span class="text-sm"></span></span>
                              <small class="text-muted text-u-c">Total Transacciones Pagadas</small>
                            </span>
                          </a>
                        </div>

                      </div>
                      <form method="post" action="" novalidate>
                        <div class="row wrapper">
                          <div class="col-sm-2 m-b-xs">
                            <div class="input-group">
                              <input type="text" autocomplete="off" class="input-s input-sm form-control" value="<?php if(isset($name)){ echo $name;}?>" name="name" placeholder="Nombre">
                            </div>
                          </div>
                          <div class="col-sm-2 m-b-xs">
                            <div class="input-group">
                              <input type="text" autocomplete="off" class="input-s input-sm form-control" value="<?php if(isset($lname)){ echo $lname;}?>" name="lname" placeholder="Apellido">
                            </div>
                          </div>
                          <div class="col-sm-2 m-b-xs">
                            <div class="input-group">
                              <input type="text" autocomplete="off" class="input-sm input-s datepicker-input form-control datepicker" id="datepicker" value="<?php if(isset($date_from)){ echo $date_from;}?>" name="date_from" placeholder="Fecha Desde">
                            </div>
                          </div>
                          <div class="col-sm-2 m-b-xs">
                            <div class="input-group">
                              <input type="text" autocomplete="off" class="input-sm input-s datepicker-input form-control datepicker" id="datepicker1" value="<?php if(isset($date_to)){ echo $date_to;}?>" name="date_to" placeholder="Fecha Hasta">
                            </div>
                          </div>
                          <div class="col-sm-3 m-b-xs">
                            <div class="input-group">
                              <span class="input-group-btn padder "><button type="submit" class="btn btn-sm btn-default">Buscar</button></span>
                            </div>
                          </div>
                        </div>
                      </form>
                      <div class="table-responsive">
                          <table class="table table-striped b-t b-light" data-ride="datatables">
                            <thead>
                              <tr>
                                <th>FECHA</th>
                                <th>CLIENTE</th>
                                <th>TIPO DE TRANSACCIÒN</th>
                                <th>MONTO RECIBIDO</th>
                                <th>MONTO A TRANSFERIR</th>
                                <th>RESTANTE</th>
                                <th>ESTADO</th>
                                <th>PAGAR</th>
                                <th>VER PAGOS</th>
                                <th>EDITAR</th>
                              </tr>
                            </thead>
                            <tbody>
                            <?PHP
                              $i=1;
                              foreach ($arrTrans as $key => $value) { ?>
                            <tr>
                                <td class="tbdata"> <?php echo $value['date_time']?> </td>
                                <td class="tbdata">
                                  <a href="modal-customer.php?id=<?php echo $value['id_customer']?>" title="Ver usuario" data-toggle="ajaxModal"><?php echo $value['name'].' '.$value['last_name']?></a>
                                </td>
                                <td class="tbdata"> <?php echo $value['name_type_transaction']?> </td>
                                <td class="tbdata"> <?php echo number_format($value['amount'], 2, ',', '.')?> $</td>
                                <td class="tbdata"> <?php echo number_format($value['amount_transfer'], 2, ',', '.')?> Bs</td>
                                <td class="tbdata"> <?php echo number_format($value['remaining'], 2, ',', '.')?> Bs</td>
                                <td class="tbdata"> <?php echo $value['transaction_status']?> </td>
                                <td>
                                  <?php if($value['stat']==3 || $value['stat']==4){
                                        }else{ ?>
                                  <a href="modal-pay.php?id_transaction=<?php echo $value['id']?>&remaining=<?php echo $value['remaining']?>" title="Agregar una nota" data-toggle="ajaxModal" class="btn btn-sm btn-icon btn-primary"><i class="fa fa-usd"></i></a>
                                <?php } ?>
                                </td>
                                <td>
                                  <a href="modal-detail-pay.php?id=<?php echo $value['id']?>&remaining=<?php echo $value['remaining']?>" title="Agregar una nota" data-toggle="ajaxModal" class="btn btn-sm btn-icon btn-primary"><i class="glyphicon glyphicon-eye-open"></i></a>
                                </td>
                                <td>
                                  <a href="modal-edit-transaction.php?id=<?php echo $value['id']?>" title="Agregar una nota" data-toggle="ajaxModal" class="btn btn-sm btn-icon btn-primary"><i class="fa fa-edit (alias)"></i></a>
                                </td>
                            </tr>
                            <?php $i++; } ?>
                            </tbody>
                          </table>
                        </div>
                    </div>
                  </div>
                </div>
               </div>
             </section>
           </section>
       </section>
   </section>
<?php include("footer.php"); ?>

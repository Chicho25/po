<?php
    ob_start();
    session_start();
    $pay="class='active'";
    $registerPayCus="class='active'";

    include("include/config.php");
    include("include/defs.php");

    include("header.php");

    if(!isset($_SESSION['USER_ID']) || $_SESSION['USER_ROLE'] != 1)
     {
          header("Location: index.php");
          exit;
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
     if(isset($_POST['master_stat']) && $_POST['master_stat'] != "")
     {
        $where.=" and transaction.stat = '".$_POST['master_stat']."'";
        $master_stat = $_POST['master_stat'];
     }


      $arrUser = GetRecords("SELECT
                              transaction.id,
                              transaction.date_time,
                              transaction.amount,
                              transaction.amount_transfer,
                              transaction.stat,
                              transaction.messaje,
                              transaction.paidout,
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
                              $where");

?>
	<section id="content">
          <section class="vbox">
            <section class="scrollable padder">
              <section class="panel panel-default">
                <header class="panel-heading">
                  <span class="h4">Ver Transacciones</span>
                </header>
                <div class="panel-body">
                  <?php
                        if(isset($message) && $message !=""){
                            echo $message;
                          }
                  ?>
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
                            <select class="chosen-select form-control" name="master_stat">
                              <option value="">Seleccionar estado</option>
                              <?PHP
                                  $arrKindMeetings = GetRecords("Select * from master_stat where stat = 1");
                                  foreach ($arrKindMeetings as $key => $value) {
                                    $kinId = $value['id'];
                                    $kinDesc = $value['name'];

                                  ?>
                                  <option value="<?php echo $kinId?>" <?php if(isset($master_stat) && $master_stat==$kinId){ echo "selected";} ?>><?php echo $kinDesc?></option>
                                  <?php
                                  }
                                  ?>
                            </select>
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
                              <th>PAGADO</th>
                              <th>ESTADO</th>
                              <th>PAGAR</th>
                              <th>VER PAGOS</th>
                              <th>EDITAR</th>
                            </tr>
                          </thead>
                          <tbody>
                          <?PHP
                            $i=1;
                            foreach ($arrUser as $key => $value) { ?>
                          <tr>
                              <td class="tbdata"> <?php echo $value['date_time']?> </td>
                              <td class="tbdata">
                                <a href="modal-customer.php?id=<?php echo $value['id_customer']?>" title="Ver usuario" data-toggle="ajaxModal"><?php echo $value['name'].' '.$value['last_name']?></a>
                              </td>
                              <td class="tbdata"> <?php echo $value['name_type_transaction']?> </td>
                              <td class="tbdata"> <?php echo number_format($value['amount'], 2, ',', '.')?> $</td>
                              <td class="tbdata"> <?php echo number_format($value['amount_transfer'], 2, ',', '.')?> Bs</td>
                              <td class="tbdata"> <?php echo number_format($value['paidout'], 2, ',', '.')?> Bs</td>
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

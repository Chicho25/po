<?php
    include("include/config.php");
    include("include/defs.php");

    $arrUser = GetRecords("SELECT
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
                            where
                            transaction.id = '".$_GET['id']."'");

    $arrDetailPay = GetRecords("SELECT
                                bank.name,
                                main_pay.date_time,
                                main_pay.amount_paid,
                                main_pay.messaje,
                                main_pay.stat,
                                main_pay.id,
                                main_pay.attached
                                FROM main_pay inner join bank on main_pay.id_bank = bank.id
                                where
                                main_pay.id_transaction = '".$_GET['id']."'");

?>

<div class="modal-dialog" style="width:80%;">
  <div class="modal-content">
  	<form role="form" class="form-horizontal" id="role-form"  method="post" action="" enctype="multipart/form-data">

	    <div class="modal-header">
	      <button type="button" class="close" data-dismiss="modal">&times;</button>
	      <h4 class="modal-title">Detalle de Pago</h4>
	    </div>
	    <div class="modal-body">
	      <div class="row">
		      <div class="form form-horizontal">
            <input type="hidden" name="id_transaction" value="<?php echo $_GET['id_transaction'];?>">
            <div class="table-responsive" style="padding:10px;">
                <table class="table table-striped b-t b-light">
                  <thead>
                    <tr>
                      <th>FECHA</th>
                      <th>CLIENTE</th>
                      <th>MONTO RECIBIDO</th>
                      <th>MONTO A TRANSFERIR</th>
                      <th>RESTANTE</th>
                      <th>ESTADO</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?PHP
                    $i=1;
                    foreach ($arrUser as $key => $value) { ?>
                  <tr>
                      <td class="tbdata"> <?php echo $value['date_time']?> </td>
                      <td class="tbdata"> <?php echo $value['name'].' '.$value['last_name']?> </td>
                      <td class="tbdata"> <?php echo number_format($value['amount'], 2, ',', '.')?> $ </td>
                      <td class="tbdata"> <?php echo number_format($value['amount_transfer'], 2, ',', '.')?> Bs</td>
                      <td class="tbdata"> <?php echo number_format($value['remaining'], 2, ',', '.')?> Bs</td>
                      <td class="tbdata"> <?php echo $value['transaction_status']?> </td>
                  </tr>
                  <?php
                    $i++;
                  }
                  ?>
                  </tbody>
                  <?php  ?>
                </table>
                <table class="table table-striped b-t b-light">
                  <thead>
                    <tr>
                      <th>FECHA</th>
                      <th>MONTO PAGADO</th>
                      <th>MENSAJE</th>
                      <th>ADJUNTO</th>
                      <th>BANCO</th>
                      <th>BORRAR</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?PHP
                    $i=1;
                    $monto_total = 0;
                    foreach ($arrDetailPay as $key => $value) { ?>
                  <tr>
                      <td class="tbdata"> <?php echo $value['date_time']?> </td>
                      <td class="tbdata"> <?php echo number_format($value['amount_paid'], 2, ',', '.')?> Bs</td>
                      <td class="tbdata"> <?php echo $value['messaje']?> </td>
                      <td class="tbdata"><?php
      				      	if(isset($value['attached']) && $value['attached'] != "") { ?>
      				      		<a href="download.php?file=<?php echo $value['attached']?>" class="text-info">
                          <img src="<?php echo str_replace("_thumb", "", $value['attached'])?>" alt="" width="30">
                        </a>
      				      	<?php } ?>
                      </td>
                      <td class="tbdata"> <?php echo $value['name']?> </td>
                      <td class="tbdata">
                        <form class="" action="" method="post">
                          <input type="hidden" name="id_transaction" value="<?php echo $_GET['id'];?>">
                          <input type="hidden" name="id_pay" value="<?php echo $value['id']; ?>">
                          <input type="hidden" name="amount" value="<?php echo $value['amount_paid']; ?>">
                          <input type="hidden" name="remaining" value="<?php echo $_GET['remaining']; ?>">
                          <?php if($arrUser[0]['stat']==3 || $arrUser[0]['stat']==4){
                                }else{ ?>
                          <button class="btn btn-sm btn-icon btn-default" name="deleteDetail"><i class="fa fa-trash-o"></i></button>
                          <?php } ?>
                        </form>
                      </td>
                  </tr>
                  <?php
                    $i++;
                    $monto_total +=$value['amount_paid'];
                  }
                  ?>
                  <tr>
                      <td class="tbdata"><b>Total Pagado --></b></td>
                      <td class="tbdata"> <?php echo number_format($monto_total, 2, ',', '.'); ?> Bs</td>
                      <td class="tbdata">  </td>
                      <td class="tbdata">  </td>
                      <td class="tbdata">  </td>
                      <td class="tbdata">  </td>
                  </tr>
                  </tbody>
                </table>
            </div>
			     </div>
			  </div>
      </div>
	    <div class="modal-footer">
	      <a href="#" class="btn btn-default" data-dismiss="modal">Cerrar</a>
      </div>
    </form>
  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

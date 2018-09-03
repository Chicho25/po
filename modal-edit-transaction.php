<?php

    include("include/config.php");
    include("include/defs.php");

    if(isset($_GET['id'])){

    $arrUser = GetRecords("SELECT
                            transaction.id,
                            transaction.date_time,
                            transaction.amount,
                            transaction.amount_transfer,
                            transaction.stat as stat_transaction,
                            transaction.messaje,
                            transaction.remaining,
                            transaction.price_dollar,
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
                            end as transaction_status,
                            users.name as name_user,
                            users.last_name as last_name_user
                            FROM transaction inner join customer on transaction.id_customer = customer.id
                                             inner join type_transaction on transaction.id_type_transaction = type_transaction.id
                                             inner join users on users.id = transaction.id_user_register
                            where
                            transaction.id = '".$_GET['id']."'");

       }
?>

<div class="modal-dialog">
  <div class="modal-content">
  	<form role="form" class="form-horizontal" id="role-form"  method="post" action="" enctype="multipart/form-data">

	    <div class="modal-header">
	      <button type="button" class="close" data-dismiss="modal">&times;</button>
	      <h4 class="modal-title">Editar Transacciòn </h4>
	    </div>
	    <div class="modal-body">
	      <div class="row">
		      <div class="form form-horizontal">
            <input type="hidden" name="id" value="<?php echo $_GET['id'];?>">
			      <div class="form-group required">
              <label class="col-lg-3 text-right control-label">Fecha de Registro</label>
              <div class="col-lg-7">
                <input type="text" readonly class="form-control" value="<?php echo $arrUser[0]['date_time']; ?>">
              </div>
            </div>
            <div class="form-group required">
              <label class="col-lg-3 text-right control-label">Cliente</label>
              <div class="col-lg-7">
                <select class="chosen-select form-control" name="customer" required="required"<?php
                  if($arrUser[0]['stat_transaction']== 3 || $arrUser[0]['stat_transaction']== 4 || $arrUser[0]['stat_transaction']== 2){ echo "disabled";} ?>>
                  <?PHP
                      $arrKindMeetings = GetRecords("Select * from customer where stat = 1");
                      foreach ($arrKindMeetings as $key => $value) {
                        $kinId = $value['id'];
                        $kinName = $value['name'];
                        $kinLastName = $value['last_name'];
                        $phone = $value['phone'];
                      ?>
                      <option value="<?php echo $kinId?>" <?php if($arrUser[0]['id_customer']==$kinId){ echo "selected";}?>><?php echo $kinName.' '.$kinLastName.' '.$phone;?></option>
                      <?php
                      }
                      ?>
                </select>
              </div>
            </div>
            <script type="text/javascript">
              function amount(){
                var value_dollar = <?php echo $arrUser[0]['price_dollar'];?>;
                var get_amount = document.getElementById("amount_get").value;
                document.getElementById("amount_transfer").value = get_amount * value_dollar;
              }
            </script>
            <div class="form-group required">
              <label class="col-lg-3 text-right control-label">Monto Recibido</label>
              <div class="col-lg-7">
                <input  id="amount_get" onkeyup="amount()" type="number" <?php if($arrUser[0]['stat_transaction']== 3 || $arrUser[0]['stat_transaction']== 4 || $arrUser[0]['stat_transaction']== 2){ echo "readonly";} ?> class="form-control" name="get_amount" value="<?php echo $arrUser[0]['amount']; ?>">
              </div>
            </div>
            <div class="form-group required">
              <label class="col-lg-3 text-right control-label">Monto a transferir</label>
              <div class="col-lg-7">
                <input id="amount_transfer" type="number" <?php if($arrUser[0]['stat_transaction']== 3 || $arrUser[0]['stat_transaction']== 4 || $arrUser[0]['stat_transaction']== 2){ echo "readonly";} ?> class="form-control" name="amount_transfer" value="<?php echo $arrUser[0]['amount_transfer']; ?>">
              </div>
            </div>
            <div class="form-group required">
              <label class="col-lg-3 text-right control-label">Estado</label>
              <div class="col-lg-7">
                <select class="chosen-select form-control" name="roll" required="required" disabled>
                  <option value="">Seleccionar</option>
                  <?PHP
                      $arrKindMeetings = GetRecords("Select * from master_stat where stat = 1");
                      foreach ($arrKindMeetings as $key => $value) {
                        $kinId = $value['id'];
                        $kinDesc = $value['name'];
                      ?>
                      <option value="<?php echo $kinId?>" <?php if(isset($arrUser[0]['stat_transaction']) && $arrUser[0]['stat_transaction']==$kinId){ echo "selected";} ?>><?php echo $kinDesc?></option>
                      <?php
                      }
                      ?>
                </select>
              </div>
            </div>
            <div class="form-group required">
              <label class="col-lg-3 text-right control-label">Precio del dolar en ese momento</label>
              <div class="col-lg-7">
                <input type="text" readonly class="form-control" name="" value="<?php echo $arrUser[0]['price_dollar']; ?>">
              </div>
            </div>
            <div class="form-group required">
              <label class="col-lg-3 text-right control-label">Mensaje</label>
              <div class="col-lg-7">
                <textarea name="messaje" <?php if($arrUser[0]['stat_transaction']== 3 || $arrUser[0]['stat_transaction']== 4){ echo "readonly";} ?> class="form-control" rows="8" cols="80"><?php echo $arrUser[0]['messaje']; ?></textarea>
              </div>
            </div>
            <div class="form-group required">
			        <label class="col-lg-3 text-right control-label">Usuario que Registro</label>
			        <div class="col-lg-7">
                <input type="text" readonly class="form-control" readonly value="<?php echo $arrUser[0]['name_user'].' '.$arrUser[0]['last_name_user']; ?>">
			        </div>
			      </div>
            <div class="form-group">
              <label class="col-sm-3 text-right control-label">Anular</label>
                <div class="col-sm-7">
                  <?php if($arrUser[0]['stat_transaction']== 3){ echo "<span style='color:green;'>Pagada</span>"; ?>
                      <input type="hidden" value="3" name="stat">
                  <?php }elseif($arrUser[0]['stat_transaction']== 4){ echo "<span style='color:red;'>Anulada</span>"; ?>
                      <input type="hidden" value="4" name="stat">
                  <?php }else{ ?>
                  <label class="switch">
                    <input type="checkbox" value="4" name="stat">
                    <span></span>
                  </label>
                  <input type="hidden" value="<?php echo $arrUser[0]['stat_transaction']; ?>" name="stat_hidden">
                  <?php } ?>
                </div>
            </div>
			     </div>
			  </div>
    </div>
	    <div class="modal-footer">
	      <a href="#" class="btn btn-default" data-dismiss="modal">Cerrar</a>
        <?php if($arrUser[0]['stat_transaction']== 3 || $arrUser[0]['stat_transaction']== 4){ }else{ ?>
	      <button type="submit" name="submitTransaction" class="btn btn-primary">Ok</button>
        <?php } ?>
	    </div>
    </form>
  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

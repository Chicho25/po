<?php

    include("include/config.php");
    include("include/defs.php");

    if(isset($_GET['id'])){

    $arrTransfer = GetRecords("SELECT
                            *
                            FROM transaction 
                            where
                            id = '".$_GET['id']."'");

       }
?>

<div class="modal-dialog">
  <div class="modal-content">
  	<form role="form" class="form-horizontal" id="role-form" action="#" enctype="multipart/form-data">

	    <div class="modal-header">
	      <button type="button" class="close" data-dismiss="modal">&times;</button>
	      <h4 class="modal-title">Ver Detalle de la Transacciòn </h4>
	    </div>
	    <div class="modal-body">
	      <div class="row">
		      <div class="form form-horizontal">
            <input type="hidden" name="id" value="<?php echo $_GET['id'];?>">
			      <div class="form-group required">
                            <label class="col-lg-4 text-right control-label font-bold">Tipo de Transacción</label>
                            <div class="col-lg-7">
                              <select class="chosen-select form-control" disabled name="type_transaction" required="required">
                                <option value="">Seleccionar</option>
                                <?PHP
                                    $arrKindMeetings = GetRecords("Select * from type_transaction");
                                    foreach ($arrKindMeetings as $key => $value) {
                                      $kinId = $value['id'];
                                      $kinDesc = $value['name'];
                                    ?>
                                    <option value="<?php echo $kinId?>" <?php if($arrTransfer[0]['id_type_transaction'] == $kinId){ echo 'selected';} ?>><?php echo $kinDesc?></option>
                                    <?php
                                    }
                                    ?>
                              </select>
                            </div>
                          </div>
                          <div class="form-group required">
                            <label class="col-lg-4 text-right control-label font-bold">Cliente</label>
                            <div class="col-lg-7">
                              <select class="form-control" name="customer" disabled required="required" id="customers">
                                <option value="">Seleccionar</option>
                                <?PHP
                                    $arrKindMeetings = GetRecords("Select * from customer where stat = 1");
                                    foreach ($arrKindMeetings as $key => $value) {
                                      $kinId = $value['id'];
                                      $kinName = $value['name'];
                                      $kinLastName = $value['last_name'];
                                      $phone = $value['phone'];
                                    ?>
                                    <option value="<?php echo $kinId?>" <?php if($arrTransfer[0]['id_customer'] == $kinId){ echo 'selected';} ?> ><?php echo $kinName.' '.$kinLastName.' '.$phone;?></option>
                                    <?php
                                    }
                                    ?>
                              </select>
                            </div>
                          </div>
                          <div class="form-group required">
                            <label class="col-lg-4 text-right control-label font-bold">Cuenta a Pagar</label>
                            <div class="col-lg-7">
                            <select class="chosen-select form-control" disabled name="type_transaction" required="required">
                                <option value="">Seleccionar</option>
                                <?PHP
                                    $arrKindMeetings = GetRecords("Select * from acount_customer");
                                    foreach ($arrKindMeetings as $key => $value) {
                                      $kinId = $value['id'];
                                      $kinDesc = $value['number_acount'];
                                    ?>
                                    <option value="<?php echo $kinId?>" <?php if($arrTransfer[0]['id_acount_bank'] == $kinId){ echo 'selected';} ?>><?php echo $kinDesc?></option>
                                    <?php
                                    }
                                    ?>
                              </select>
                            </div>
                          </div>
                          <div class="form-group required">
                            <label class="col-lg-4 text-right control-label font-bold">Tipo de Moneda</label>
                            <div class="col-lg-7">
                              <select class="form-control" name="type_coin" disabled required="required" id="type_coin">
                                <option value="">Seleccionar</option>
                                <?PHP
                                    $arrKindMeetings = GetRecords("select 
                                                                      id,
                                                                      name, 
                                                                      (select 
                                                                          value_bolivar 
                                                                      from 
                                                                      value_coin 
                                                                      where 
                                                                      id_type_coin = tc.id 
                                                                      and 
                                                                      id = (select max(id) from value_coin where id_type_coin = tc.id)) as value_bolivar
                                                                  from 
                                                                  type_coin tc");
                                    foreach ($arrKindMeetings as $key => $value) {
                                      $kinId = $value['id'];
                                      $kinName = $value['name'];
                                      $amount = $value['value_bolivar'];
                                    ?>
                                    <option value="<?php echo $kinId?>" <?php if($arrTransfer[0]['id_type_coin'] == $kinId){ echo 'selected';} ?> ><?php echo $kinName.' // '.number_format($amount, 2, ',', '.');?></option>
                                    <?php
                                    }
                                    ?>
                              </select>
                            </div>
                          </div>
                          <div class="form-group required">
                            <label class="col-lg-4 text-right control-label font-bold">Taza de Cambio</label>
                            <div class="col-lg-7">
                              <input type="number" autocomplete="off" class="form-control" readonly value="<?php echo $arrTransfer[0]['taza_actual']; ?>">
                            </div>
                          </div>
                          <div class="form-group required">
                            <label class="col-lg-4 text-right control-label font-bold">Monto Recibido</label>
                            <div class="col-lg-7">
                              <input type="number" class="form-control" readonly value="<?php echo $arrTransfer[0]['amount']; ?>">
                            </div>
                          </div>
                          <div class="form-group required">
                            <label class="col-lg-4 text-right control-label font-bold">Monto a transferir Bs.S</label>
                            <div class="col-lg-7">
                              <input type="number" class="form-control" readonly value="<?php echo $arrTransfer[0]['amount_transfer']; ?>" >
                            </div>
                          </div>
                          <div class="form-group">
                              <label class="col-lg-4 text-right control-label font-bold">Mensaje</label>
                              <div class="col-lg-7">
                                  <textarea class="form-control" placeholder="Mensaje" name="message" rows="8" cols="80" readonly><?php echo $arrTransfer[0]['messaje']; ?></textarea>
                              </div>
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

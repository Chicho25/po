<?php
    include("include/config.php");
    include("include/defs.php");

    $monto_maximo = Getrecords("SELECT * FROM transaction WHERE id ='".$_GET['id']."'");
    foreach ($monto_maximo as $key => $value) {
            $monto_pagar = $value['amount_transfer'];
            $monto_pagado = $value['paidout'];
            $id_customer = $value['id_customer'];
            $id_user = $value['id_user_register'];
            $acount_bank = $value['id_acount_bank'];
      }
      $monto_maximo = $monto_pagar - $monto_pagado;

?>

<div class="modal-dialog">
  <div class="modal-content">
  	<form role="form" class="form-horizontal" id="role-form"  method="post" action="" enctype="multipart/form-data">

	    <div class="modal-header">
	      <button type="button" class="close" data-dismiss="modal">&times;</button>
	      <h4 class="modal-title">Pago a transacciòn</h4>
	    </div>
	    <div class="modal-body">
	      <div class="row">
		      <div class="form form-horizontal">
            <input type="hidden" name="id_transaction" value="<?php echo $_GET['id'];?>">
            <input type="hidden" name="id_user" value="<?php echo $id_user;?>">
            <div class="form-group required">
              <label class="col-lg-3 text-right control-label">Cliente</label>
              <div class="col-lg-7">
                <select class="chosen-select form-control" name="id_customer" required="required" disabled>
                  <option value="">Seleccionar</option>
                  <?PHP
                      $arrKindMeetings = GetRecords("Select * from customer");
                      foreach ($arrKindMeetings as $key => $value) {
                        $kinId = $value['id'];
                        $kinDesc = $value['name'].' '.$value['last_name'];
                        $selected = $id_customer;
                      ?>
                      <option value="<?php echo $kinId?>" <?php if(isset($selected) && $selected==$kinId){ echo "selected";} ?>><?php echo $kinDesc?></option>
                      <?php
                      }
                      ?>
                </select>
                <input type="hidden" name="id_customer" value="<?php echo $id_customer; ?>">
              </div>
            </div>
            <div class="form-group required">
              <label class="col-lg-3 text-right control-label">Banco Cliente</label>
              <div class="col-lg-7">
                <select class="chosen-select form-control" name="id_count_bank" required="required" disabled>
                  <?php
                  $cuentas = GetRecords("SELECT 
                                          ac.id,
                                          ac.number_acount, 
                                          bc.name  
                                        FROM 
                                          acount_customer ac inner join bank_customer bc on ac.id_bank_customer = bc.id
                                        WHERE 
                                        ac.id_customer = '".$id_customer."'
                                        and 
                                        ac.id = '".$acount_bank."'
                                        and 
                                        ac.stat = 1");
                  foreach ($cuentas as $key => $value) {
                  echo '<option value="'.$value['id'].'">'.$value['name'].' // '.$value['number_acount'].'</option>';
                  }
                  ?>
                </select>
                <input type="hidden" name="id_count_bank" value="<?php echo $acount_bank; ?>">
              </div>
            </div>
            <div class="form-group required">
              <label class="col-lg-3 text-right control-label">Banco a Debitar</label>
              <div class="col-lg-7">
                <select class="chosen-select form-control" name="mov_bank" required="required">
                <option value="">Seleccionar</option>
                  <?php
                  $cuentas = GetRecords("select 
                                            sum(mb.amount) as monto,
                                            (select 
                                                sum(amount)
                                              from 
                                                mov_bank 
                                              where 
                                                type_mov in(1) 
                                              and 
                                              id_acount = ab.id) as monto_debitado,
                                            b.name, 
                                            ab.number_acount, 
                                            ab.id
                                          from 
                                            mov_bank mb inner join type_mov tm on mb.type_mov = tm.id
                                            inner join bank b on mb.id_bank = b.id
                                            inner join acount_bank ab on ab.id = mb.id_acount
                                          where 
                                            mb.type_mov in(2)
                                          group by 
                                          b.name, 
                                          ab.number_acount");
                  foreach ($cuentas as $key => $value) {
                  $monto_total = $value['monto'] - $value['monto_debitado'];
                  if ($monto_total <= 0) {
                     continue;
                  }
                  echo '<option value="'.$value['id'].'">'.$value['name'].' // '.$value['number_acount'].' // '.number_format($monto_total, 2, ',', '.').' Bs.</option>';
                  }
                  ?>
                </select>
              </div>
            </div>
            <div class="form-group ">
              <label class="col-lg-3 text-right control-label">Monto Maximo</label>
              <div class="col-lg-7" style="color:red; font-size:18px;">
                <?php echo number_format($monto_maximo, 2, ',', '.');?>
              </div>
            </div>
            <div class="form-group required">
              <label class="col-lg-3 text-right control-label">Monto a Transferir</label>
              <div class="col-lg-7">
                <input type="number" autocomplete="off" step="any" class="form-control" max="<?php echo $monto_maximo;?>" name="amount_paid" value="">
              </div>
            </div>
            <div class="form-group ">
              <label class="col-lg-3 text-right control-label">Mensaje</label>
              <div class="col-lg-7">
                <textarea name="messaje" class="form-control" rows="8" cols="80"></textarea>
              </div>
            </div>
            <div class="form-group ">
              <label class="col-lg-3 text-right control-label">Abjunto</label>
              <div class="col-lg-7">
                <input type="file" name="photo" style="display: block;" onchange="readURL(this);">
              </div>
            </div>
            <div class="form-group ">
              <label class="col-lg-3 text-right control-label">Imagen</label>
                <div class="col-lg-7" style="width:204px;
                                              height:154px;
                                              background-color: #cccccc;
                                              border: solid 2px gray;">
                    <img id="img" src="#" style='width:204px; height:154px; display: none;' alt="your image" />
                </div>
            </div>
			     </div>
			  </div>
    </div>
	    <div class="modal-footer">
	      <a href="#" class="btn btn-default" data-dismiss="modal">Cerrar</a>
        <?php if ($monto_maximo==0) {
          
        }else{ ?>  
	      <button type="submit" name="submitPay" class="btn btn-primary">Ok</button>
        <?php } ?>
      </div>
    </form>
  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<script type="text/javascript">
  function readURL(input) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function (e) {
              $('#img').show().attr('src', e.target.result);
          }
          reader.readAsDataURL(input.files[0]);
      }
  }
</script>

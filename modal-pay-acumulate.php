<?php
    include("include/config.php");
    include("include/defs.php");

    $monto_maximo = Getrecords("select
                                    au.id,
                                    au.id_user, 
                                    au.amount_accumulated, 
                                    au.amount_pay, 
                                    u.name, 
                                    u.last_name, 
                                    u.credit
                                from average_users au inner join users u on u.id = au.id_user
                                where 
                                au.id ='".$_GET['id']."'");

                                foreach ($monto_maximo as $key => $value) {
                                        $monto_pagar = $value['amount_accumulated'];
                                        $usuario = $value['name'].' '.$value['last_name'];
                                        $id_usuario = $value['id_user'];
                                }

?>

<div class="modal-dialog">
  <div class="modal-content">
  	<form role="form" class="form-horizontal" id="role-form"  method="post" action="" enctype="multipart/form-data">

	    <div class="modal-header">
	      <button type="button" class="close" data-dismiss="modal">&times;</button>
	      <h4 class="modal-title">Monto Acumulado</h4>
	    </div>
	    <div class="modal-body">
	      <div class="row">
		      <div class="form form-horizontal">
              <input type="hidden" name="id_pay_user" value="<?php echo $id_usuario;?>">
              <input type="hidden" name="id_pay_average" value="<?php echo $_GET['id'];?>">
            <div class="form-group required">
              <label class="col-lg-3 text-right control-label">Usuario</label>
              <div class="col-lg-7">
                <?php echo $usuario; ?>
              </div>
            </div>

            <div class="form-group ">
              <label class="col-lg-3 text-right control-label">Monto Maximo</label>
              <div class="col-lg-7" style="color:red; font-size:18px;">
                <?php echo number_format($monto_pagar, 2, ',', '.');?> $
              </div>
            </div>
            <div class="form-group required">
              <label class="col-lg-3 text-right control-label">Monto a Pagar</label>
              <div class="col-lg-7">
                <input type="number" autocomplete="off" step="any" class="form-control" max="<?php echo $monto_pagar;?>" name="amount_paid" value="">
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
	      <button type="submit" name="submitPayAcumulate" class="btn btn-primary">Ok</button>
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

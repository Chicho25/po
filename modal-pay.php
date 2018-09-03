<?php
    include("include/config.php");
    include("include/defs.php");
?>

<div class="modal-dialog">
  <div class="modal-content">
  	<form role="form" class="form-horizontal" id="role-form"  method="post" action="" enctype="multipart/form-data">

	    <div class="modal-header">
	      <button type="button" class="close" data-dismiss="modal">&times;</button>
	      <h4 class="modal-title">Pago a transacciòn </h4>
	    </div>
	    <div class="modal-body">
	      <div class="row">
		      <div class="form form-horizontal">
            <input type="hidden" name="id_transaction" value="<?php echo $_GET['id_transaction'];?>">
            <input type="hidden" name="remaining" value="<?php echo $_GET['remaining'];?>">
            <div class="form-group required">
              <label class="col-lg-3 text-right control-label">Banco</label>
              <div class="col-lg-7">
                <select class="chosen-select form-control" name="bank" required="required">
                  <option value="">Seleccionar</option>
                  <?PHP
                      $arrKindMeetings = GetRecords("Select * from bank where stat = 1");
                      foreach ($arrKindMeetings as $key => $value) {
                        $kinId = $value['id'];
                        $kinDesc = $value['name'];
                      ?>
                      <option value="<?php echo $kinId?>" <?php if(isset($id_roll_user) && $id_roll_user==$kinId){ echo "selected";} ?>><?php echo $kinDesc?></option>
                      <?php
                      }
                      ?>
                </select>
              </div>
            </div>
            <div class="form-group ">
              <label class="col-lg-3 text-right control-label">Monto Maximo</label>
              <div class="col-lg-7" style="color:red; font-size:18px;">
                <?php echo number_format($_GET['remaining'], 2, ',', '.');?>
              </div>
            </div>
            <div class="form-group required">
              <label class="col-lg-3 text-right control-label">Monto a Transferir</label>
              <div class="col-lg-7">
                <input type="number" autocomplete="off" class="form-control" max="<?php echo $_GET['remaining'];?>" name="amount_transfer" value="">
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
        <?php if($_GET['remaining']==0){}else{ ?>
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

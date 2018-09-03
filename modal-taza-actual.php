<?php

    include("include/config.php");
    include("include/defs.php");

    if(isset($_GET['id'])){

    $arrUser = GetRecords("SELECT * from value_dollar where id = '".$_GET['id']."'");
    $value = $arrUser[0]['value_dollar'];
       }
?>

<div class="modal-dialog">
  <div class="modal-content">
  	<form role="form" class="form-horizontal" id="role-form"  method="post" action="" enctype="multipart/form-data">

	    <div class="modal-header">
	      <button type="button" class="close" data-dismiss="modal">&times;</button>
	      <h4 class="modal-title">Cambiar taza de cambio </h4>
	    </div>
	    <div class="modal-body">
	      <div class="row">
		      <div class="form form-horizontal">
            <input type="hidden" name="id" value="<?php echo $_GET['id'];?>">
			      <div class="form-group">
              <label class="col-lg-3 text-right control-label">Monto Actual</label>
              <div class="col-lg-7">
                <input type="text" readonly class="form-control" name="value_dollar" value="<?php echo number_format($value, 2, ',', '.'); ?>">
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-3 text-right control-label">Nuevo Monto</label>
              <div class="col-lg-7">
                <input type="number" class="form-control" name="new_amount" value="">
              </div>
            </div>
			      </div>
			  </div>
    </div>
	    <div class="modal-footer">
	      <a href="#" class="btn btn-default" data-dismiss="modal">Cerrar</a>
	      <button type="submit" name="submitValueDollar" class="btn btn-primary">Ok</button>
	    </div>
    </form>
  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

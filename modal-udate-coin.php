<?php
    include("include/config.php");
    include("include/defs.php");
?>

<div class="modal-dialog">
  <div class="modal-content">
  	<form role="form" method="post" class="form-horizontal" id="role-form" action="">
	    <div class="modal-header">
	      <button type="button" class="close" data-dismiss="modal">&times;</button>
	      <h4 class="modal-title">Taza diaria </h4>
	    </div>
	    <div class="modal-body">
	      <div class="row">
		    <div class="form form-horizontal">
			    <div class="form-group">
                    <label class="col-lg-4 text-right control-label">Nuevo Valor</label>
                    <div class="col-lg-8" style="">
                    <input type="number" step="any" class="form-control" style="width:250px;" name="value_bolivar">
                    <input type="hidden" name="id_type_coin" value="<?php echo $_GET['id_type_coin']; ?>">
                    </div>
                </div>
		    </div>
	      </div>
	    <div class="modal-footer">
	      <a href="#" class="btn btn-default" data-dismiss="modal">Cerrar</a>
          <button type="submit" name="submitUpdateCoin" class="btn btn-primary">Enviar</button>
	    </div>
    </form>
  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
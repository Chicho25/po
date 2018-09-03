
<?php   include("include/config.php");
        include("include/defs.php"); 
        $registros_country = Getrecords("SELECT * FROM bank WHERE id = '".$_GET['id']."'");
        ?>
<div class="modal-dialog">
  <div class="modal-content">
  	<form role="form" class="form-horizontal" id="role-form"  method="post" action="" enctype="multipart/form-data">
	    <div class="modal-header">
	      <button type="button" class="close" data-dismiss="modal">&times;</button>
	      <h4 class="modal-title">Modificar Banco </h4>
	    </div>
	    <div class="modal-body">
	      <div class="row">
		      <div class="form form-horizontal">
			    <div class="form-group">
                    <label class="col-lg-3 text-right control-label">Banco</label>
                    <div class="col-lg-7">
                        <input type="text" class="form-control" name="bank" value="<?php echo $registros_country[0]['name']; ?>" placeholder="Pais">
                        <input type="hidden" class="form-control" name="id_bank" value="<?php echo $registros_country[0]['id']; ?>">
                    </div>
                </div>
			</div>
		</div>
        <div class="form-group">
                <label class="col-sm-3 text-right control-label">Estado</label>
                <div class="col-sm-7">
                  <label class="switch">
                    <input type="checkbox" <?php if($registros_country[0]['stat']==1){ echo 'checked';} ?> value="1" name="stat">
                    <span></span>
                  </label>
                </div>
        </div>
	    <div class="modal-footer">
	      <a href="#" class="btn btn-default" data-dismiss="modal">Cerrar</a>
	      <button type="submit" name="submitEditBank" class="btn btn-primary">Ok</button>
	    </div>
    </form>
  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
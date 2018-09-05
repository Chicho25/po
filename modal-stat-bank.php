<?php
    include("include/config.php");
    include("include/defs.php");
?>

<div class="modal-dialog">
  <div class="modal-content">
  	<form role="form" class="form-horizontal" id="role-form" action="#">
	    <div class="modal-header">
	      <button type="button" class="close" data-dismiss="modal">&times;</button>
	      <h4 class="modal-title">Status de los Bancos </h4>
	    </div>
	    <div class="modal-body">
	      <div class="row">
		    <div class="form form-horizontal">

            <?php $taza = GetRecords("select * from bank where stat = 1"); ?>
            
            <?php foreach ($taza as $key => $value) { ?>
			<div class="form-group">
                <div class="col-lg-12" style="margin-top:6px; text-align: center; font-size:20px">
                   <b><?php echo $value['name']?></b>
                </div>
            </div>
            <?php } ?> 
		</div>
	  </div>
    </div>
	    <div class="modal-footer">
	      <a href="#" class="btn btn-default" data-dismiss="modal">Cerrar</a>
	    </div>
    </form>
  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

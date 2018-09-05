<?php
    include("include/config.php");
    include("include/defs.php");
?>

<div class="modal-dialog">
  <div class="modal-content">
  	<form role="form" class="form-horizontal" id="role-form" action="#">
	    <div class="modal-header">
	      <button type="button" class="close" data-dismiss="modal">&times;</button>
	      <h4 class="modal-title">Taza diaria </h4>
	    </div>
	    <div class="modal-body">
	      <div class="row">
		    <div class="form form-horizontal">

            <?php $taza = GetRecords("select 
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
                                        type_coin tc"); ?>
            
            <?php foreach ($taza as $key => $value) { ?>
			<div class="form-group">
                <label class="col-lg-6 text-right control-label"><?php echo $value['name']?></label>
                <div class="col-lg-6" style="margin-top:6px;">
                   <b><?php echo number_format($value['value_bolivar'], 2, ',', '.'); ?></b>
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

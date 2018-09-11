<?php
    ob_start();
    session_start();
    include("include/config.php");
    include("include/defs.php");


    $arrmyProfile = GetRecords("select 
                              sum(mb.amount) as total_bs, 
                              (sum(mb.amount)/mb.price_for_dollar) as total_interno, 
                              (sum(mb.amount)/mb.price_sales) as total_precio_venta,
                              (sum(mb.amount)/mb.price_sales) - (sum(mb.amount)/mb.price_for_dollar) as ganancia_total,
                              (((sum(mb.amount)/mb.price_sales) - (sum(mb.amount)/mb.price_for_dollar)) * 60 / 100) as ganancia_centra, 
                              (((sum(mb.amount)/mb.price_sales) - (sum(mb.amount)/mb.price_for_dollar)) * 20 / 100) as ganancia_usuario, 
                              (((sum(mb.amount)/mb.price_sales) - (sum(mb.amount)/mb.price_for_dollar)) * 20 / 100) as ganancia_sistemas, 
                              u.name, 
                              u.last_name, 
                              u.credit, 
                              mb.price_for_dollar as precio_compra, 
                              mb.price_sales as precio_venta
                          from mov_bank mb inner join users u on mb.id_user = u.id
                          where 
                          mb.stat = 1
                          and 
                          mb.id_user = '".$_SESSION['USER_ID']."'
                          group by 
                              u.name, 
                              u.last_name, 
                              u.credit, 
                              mb.price_for_dollar, 
                              mb.price_sales");

?>

<<div class="modal-dialog">
  <div class="modal-content">
  	<form role="form" class="form-horizontal" id="role-form" action="#">
	    <div class="modal-header">
	      <button type="button" class="close" data-dismiss="modal">&times;</button>
	      <h4 class="modal-title">Mi Perfil</h4>
	    </div>
	    <div class="modal-body">
	      <div class="row">
		    <div class="form form-horizontal">
                <div class="form-group">
                    <label class="col-lg-6 text-right control-label">Credito: </label>
                    <div class="col-lg-6" style="margin-top:6px;">
                    <b><?php echo number_format($arrmyProfile[0]['credit'], 2, ',', '.'); ?></b>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-6 text-right control-label">Acumulado: </label>
                    <div class="col-lg-6" style="margin-top:6px;">
                    <b>
                      <?php 
                        $total_acumulado = 0;
                        foreach ($arrmyProfile as $key => $value) {
                          $total_acumulado += $value['ganancia_total'];
                      } ?>
                      <?php echo number_format($total_acumulado, 2, ',', '.'); ?>
                    </b>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-6 text-right control-label">Restante: </label>
                    <div class="col-lg-6" style="margin-top:6px;">
                    <?php $restante = $arrmyProfile[0]['credit'] - $total_acumulado; ?>
                    <b><?php echo number_format($restante, 2, ',', '.'); ?></b>
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

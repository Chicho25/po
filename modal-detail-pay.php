<?php
    include("include/config.php");
    include("include/defs.php");

    $arrUser = GetRecords("select
                            mp.id, 
                            mp.amount_paid, 
                            mp.messaje, 
                            mp.attached, 
                            mp.time_data,
                            cu.name, 
                            cu.last_name, 
                            u.name as usuario_nombre, 
                            u.last_name as apellido_nombre, 
                            bc.name as nombre_banco, 
                            ac.number_acount
                            from 
                              main_pay mp inner join customer cu on mp.id_customer = cu.id
                                          inner join users u on u.id = mp.id_user
                                          inner join bank_customer bc on bc.id = mp.id_bank
                                          inner join acount_customer ac on ac.id = mp.id_count_bank
                            where 
                            mp.id_transaction = '".$_GET['id']."'");

?>

<div class="modal-dialog" style="width:80%;">
  <div class="modal-content">
  	<form role="form" class="form-horizontal" id="role-form"  method="post" action="" enctype="multipart/form-data">

	    <div class="modal-header">
	      <button type="button" class="close" data-dismiss="modal">&times;</button>
	      <h4 class="modal-title">Pagos</h4>
	    </div>
	    <div class="modal-body">
	      <div class="row">
		      <div class="form form-horizontal">
            <input type="hidden" name="id_transaction" value="<?php echo $_GET['id_transaction'];?>">
            <div class="table-responsive" style="padding:10px;">
                
                <table class="table table-striped b-t b-light">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>FECHA</th>
                      <th>CLIENTE</th>
                      <th>USUARIO</th>
                      <th>MONTO PAGADO</th>
                      <th>MENSAJE</th>
                      <th>BANCO</th>
                      <th>RECIBO</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?PHP
                    $i=1;
                    foreach ($arrUser as $key => $value) { ?>
                  <tr>
                      <td class="tbdata"> <?php echo $value['id']?> </td>
                      <td class="tbdata"> <?php echo $value['time_data']?> </td>
                      <td class="tbdata"> <?php echo $value['name'].' '.$value['last_name']?> </td>
                      <td class="tbdata">  <?php echo $value['usuario_nombre'].' '.$value['apellido_nombre']?> </td>
                      <td class="tbdata"> <?php echo number_format($value['amount_paid'], 2, ',', '.')?> Bs</td>
                      <td class="tbdata"> <?php echo $value['messaje']?></td>
                      <td class="tbdata"> <?php echo $value['nombre_banco'].' // '.$value['number_acount']?> </td>
                      <td class="tbdata"> <img src="<?php echo $value['attached']?>" width="50" > </td>
                  </tr>
                  <?php
                    $i++;
                  }
                  ?>
                  </tbody>
                </table>
                
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

<?php
    include("include/config.php");
    include("include/defs.php");

    $arrUser = GetRecords("select
                            u.name, 
                            u.last_name, 
                            pu.id,
                            pu.amount_paid, 
                            pu.data_time, 
                            pu.messaje, 
                            pu.attached, 
                            case
                            when pu.stat = 1 then 'Pago Usuario'
                            when pu.stat = 2 then 'Pago Central'
                            end as stat
                            from 
                            pay_user_central pu inner join users u on pu.id_user = u.id
                            where 
                            pu.id_average_user = '".$_GET['id']."'");

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
                      <th>USUARIO</th>
                      <th>MONTO PAGADO</th>
                      <th>MENSAJE</th>
                      <th>TIPO</th>
                      <th>ADJUNTO</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?PHP
                    $i=1;
                    foreach ($arrUser as $key => $value) { ?>
                  <tr>
                      <td class="tbdata"> <?php echo $value['id']?> </td>
                      <td class="tbdata"> <?php echo $value['data_time']?> </td>
                      <td class="tbdata"> <?php echo $value['name'].' '.$value['last_name']?> </td>
                      <td class="tbdata"> <?php echo number_format($value['amount_paid'], 2, ',', '.')?> Bs</td>
                      <td class="tbdata"> <?php echo $value['messaje']?></td>
                      <td class="tbdata"> <?php echo $value['stat']?></td>
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

<?php
    include("include/config.php");
    include("include/defs.php");

    $arrBank = GetRecords("SELECT
                            ac.id,
                            ac.id_customer, 
                            ac.number_acount,
                            bc.name,
                            ac.descriptions, 
                            ac.type_acount 
                           FROM acount_customer ac INNER JOIN bank_customer bc on ac.id_bank_customer = bc.id
                           WHERE 
                           ac.id_customer = '".$_GET['id']."'
                           and 
                           ac.stat = 1"); 

?>

<div class="modal-dialog">
  <div class="modal-content">
  	<form role="form" class="form-horizontal" id="role-form"  method="post" action="" enctype="multipart/form-data">

	    <div class="modal-header">
	      <button type="button" class="close" data-dismiss="modal">&times;</button>
	      <h4 class="modal-title">Datos del Cliente </h4>
	    </div>
	    <div class="modal-body">
	      <div class="row">
		    <div class="form form-horizontal">
            <input type="hidden" name="id" value="<?php echo $_GET['id'];?>">

                <table class="table table-striped b-t b-light" data-ride="datatables">
                    <thead>
                    <tr>
                        <th>BANCO</th>
                        <th>NUMERO DE CUENTA</th>
                        <th>TIPO</th>
                        <th>DESCRIPCION</th>
                        <th>ELIMINAR</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?PHP
                    $i=1;
                    foreach ($arrBank as $key => $value) { ?>
                    <tr>
                        <td class="tbdata"> <?php echo $value['name']?> </td>
                        <td class="tbdata"> <?php echo $value['number_acount']?> </td>
                        <td class="tbdata"> <?php if($value['type_acount']==1){ echo 'Ahorro'; }else{ echo 'Corriente'; }?> </td>
                        <td class="tbdata"> <?php echo $value['descriptions']?> </td>
                        <td>
                            <!--<a href="edit-bank.php?id=<?php echo $value['id']?>" data-dismiss="modal" data-toggle="ajaxModal"  title="Editar" class="btn btn-sm btn-icon btn-primary"><i class="glyphicon glyphicon-edit"></i></a>-->
                            <form action="" method="post">
                                <button name="eliminar" class="btn btn-sm btn-icon btn-danger"><i class="glyphicon glyphicon-trash"></i></button>
                                <input type="hidden" value="<?php echo $value['id']?>" name="id_customer_acount">
                            </form>
                        </td>
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
	    <div class="modal-footer">
	      <a href="#" class="btn btn-default" data-dismiss="modal">Cerrar</a>
	    </div>
    </form>
  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

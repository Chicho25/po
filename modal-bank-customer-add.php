<?php
    include("include/config.php");
    include("include/defs.php"); ?>
<div class="modal-dialog">
  <div class="modal-content">
  	<form role="form" class="form-horizontal" id="role-form"  method="post" action="">
	    <div class="modal-header">
	      <button type="button" class="close" data-dismiss="modal">&times;</button>
	      <h4 class="modal-title">Crear Cuenta Bancaria al cliente </h4>
	    </div>
	    <div class="modal-body">
	      <div class="row">
		      <div class="form form-horizontal">
              <input type="hidden" name="id_customer" value="<?php echo $_GET['id']; ?>">
                <div class="form-group ">
                <label class="col-lg-3 text-right control-label">Banco</label>
                <div class="col-lg-7">
                    <select class="chosen-select form-control" name="id_bank_customer" required="required">
                        <option value="">Seleccionar</option>
                        <?PHP
                            $arrKindMeetings = GetRecords("Select * from bank_customer where stat = 1");
                            foreach ($arrKindMeetings as $key => $value) {
                                $kinId = $value['id'];
                                $kinDesc = $value['name'];
                            ?>
                            <option value="<?php echo $kinId?>"><?php echo $kinDesc?></option>
                            <?php } ?>
                    </select>
                </div>
                </div>
                <div class="form-group ">
                <label class="col-lg-3 text-right control-label">Tipo de Cuenta</label>
                <div class="col-lg-7">
                        <select class="chosen-select form-control" name="type_acount" required="required">
                            <option value="">Seleccionar</option>
                            <option value="1">Ahorro</option>
                            <option value="2">Corriente</option>
                        </select>
                </div>
                </div>
                <div class="form-group ">
                <label class="col-lg-3 text-right control-label">Numero de cuenta</label>
                <div class="col-lg-7">
                    <input type="text" class="form-control" placeholder="Cedula" name="number_acount" data-required="true">
                </div>
                </div>
                <div class="form-group ">
                <label class="col-lg-3 text-right control-label">Descripcion de la cuenta</label>
                <div class="col-lg-7">
                <textarea class="form-control" placeholder="Descripcion de la cuenta" name="descriptions" data-required="true"></textarea>
                </div>
                </div>

            </div>
        </div>
        <div class="modal-footer">
	      <a href="#" class="btn btn-default" data-dismiss="modal">Cerrar</a>
	      <button type="submit" name="submitCreateBank" class="btn btn-primary">Ok</button>
	    </div>
    </form>
  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

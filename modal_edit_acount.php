<?php   include("include/config.php");
        include("include/defs.php"); 
        $edit_acount = Getrecords("SELECT * FROM acount_bank WHERE id = '".$_GET['id']."'");
        ?>
<div class="modal-dialog">
  <div class="modal-content">
  	<form role="form" class="form-horizontal" id="role-form"  method="post" action="" enctype="multipart/form-data">
	    <div class="modal-header">
	      <button type="button" class="close" data-dismiss="modal">&times;</button>
	      <h4 class="modal-title">Modificar Cuenta de Banco </h4>
	    </div>
	    <div class="modal-body">
	      <div class="row">
		      <div class="form form-horizontal">
                <div class="form-group">
                  <label class="col-lg-3 text-right control-label">Banco</label>
                    <div class="col-lg-7">
                        <select class="chosen-select form-control" name="id_bank">
                            <option value="">Seleccionar</option>
                            <?PHP
                            $arrKindMeetings = GetRecords("Select * from bank where stat = 1");
                            foreach ($arrKindMeetings as $key => $value) {
                                $kinId = $value['id'];
                                $kinDesc = $value['name'];
                                $id_bank_get = $edit_acount[0]['id_bank'];
                            ?>
                            <option value="<?php echo $kinId?>" <?php if($id_bank_get == $kinId){ echo 'selected';} ?> ><?php echo $kinDesc?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 text-right control-label">Numero de Cuenta</label>
                    <div class="col-lg-7">
                        <input type="text" class="form-control" name="acount_bank" value="<?php echo $edit_acount[0]['number_acount']; ?>" placeholder="Pais">
                        <input type="hidden" class="form-control" name="id_count_bank" value="<?php echo $edit_acount[0]['id']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 text-right control-label">Descripcion</label>
                    <div class="col-lg-7">
                        <textarea class="form-control" name="descriptions" rows="8"><?php echo $edit_acount[0]['descriptions']; ?></textarea>
                    </div>
                </div>
			</div>
		</div>
        <div class="form-group">
                <label class="col-sm-3 text-right control-label">Estado</label>
                <div class="col-sm-7">
                  <label class="switch">
                    <input type="checkbox" <?php if($edit_acount[0]['stat']==1){ echo 'checked';} ?> value="1" name="stat">
                    <span></span>
                  </label>
                </div>
        </div>
	    <div class="modal-footer">
	      <a href="#" class="btn btn-default" data-dismiss="modal">Cerrar</a>
	      <button type="submit" name="submitEditAcount" class="btn btn-primary">Ok</button>
	    </div>
    </form>
  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
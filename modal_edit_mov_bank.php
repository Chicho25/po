<?php   include("include/config.php");
        include("include/defs.php");

        $edit_mov_bank = Getrecords("SELECT
                                     mb.id,
                                     mb.id_acount,
                                     b.id as bank,
                                     mb.stat,
                                     mb.amount,
                                     mb.descriptions,
                                     mb.image,
                                     mb.id_user_reg,
                                     mb.data_time,
                                     tm.id as type_mov, 
                                     u.name, 
                                     u.last_name, 
                                     mb.amount_sales, 
                                     mb.price_for_dollar, 
                                     mb.price_sales
                                   from mov_bank mb inner join bank b on mb.id_bank = b.id
                                                    inner join acount_bank ab on mb.id_acount = ab.id
                                                    inner join type_mov tm on mb.type_mov = tm.id
                                                    inner join users u on mb.id_user_reg = u.id
                                   WHERE
                                   mb.id = '".$_GET['id']."'");?>

<div class="modal-dialog" style="width:900px;">
  <div class="modal-content">
  	<form role="form" class="form-horizontal" id="role-form"  method="post" action="" enctype="multipart/form-data">
	    <div class="modal-header">
	      <button type="button" class="close" data-dismiss="modal">&times;</button>
	      <h4 class="modal-title">Modificar Movimiento Bancario </h4>
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
                            $arrKindMeetings = GetRecords("Select * from bank where id = '".$edit_mov_bank[0]['bank']."'");
                            foreach ($arrKindMeetings as $key => $value) {
                                $kinId = $value['id'];
                                $kinDesc = $value['name'];
                                $id_bank_get = $edit_mov_bank[0]['bank'];
                            ?>
                            <option value="<?php echo $kinId?>" <?php if($id_bank_get == $kinId){ echo 'selected';} ?> ><?php echo $kinDesc?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                  <label class="col-lg-3 text-right control-label">Cuenta</label>
                    <div class="col-lg-7">
                        <select class="chosen-select form-control" name="id_bank">
                            <option value="">Seleccionar</option>
                            <?PHP
                            $arrKindMeetings = GetRecords("Select * from acount_bank where id = '".$edit_mov_bank[0]['id_acount']."'");
                            foreach ($arrKindMeetings as $key => $value) {
                                $kinId = $value['id'];
                                $kinDesc = $value['number_acount'];
                                $id_bank_get = $edit_mov_bank[0]['id_acount'];
                            ?>
                            <option value="<?php echo $kinId?>" <?php if($id_bank_get == $kinId){ echo 'selected';} ?> ><?php echo $kinDesc?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                  <label class="col-lg-3 text-right control-label">Movimiento</label>
                    <div class="col-lg-7">
                        <select class="chosen-select form-control" name="id_bank">
                            <option value="">Seleccionar</option>
                            <?PHP
                            $arrKindMeetings = GetRecords("Select * from type_mov where id = '".$edit_mov_bank[0]['type_mov']."'");
                            foreach ($arrKindMeetings as $key => $value) {
                                $kinId = $value['id'];
                                $kinDesc = $value['name'];
                                $id_bank_get = $edit_mov_bank[0]['type_mov'];
                            ?>
                            <option value="<?php echo $kinId?>" <?php if($id_bank_get == $kinId){ echo 'selected';} ?> ><?php echo $kinDesc?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 text-right control-label">Monto</label>
                    <div class="col-lg-7">
                        <input id="monto" class="form-control" step="any" name="amount" value="<?php echo $edit_mov_bank[0]['amount']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 text-right control-label">Cantidad Vendida $</label>
                    <div class="col-lg-7">
                        <input id="cantidad_vendida" class="form-control" step="any" name="amount_sales" value="<?php echo $edit_mov_bank[0]['amount_sales']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 text-right control-label">Precio Por Unidad de Compra BsS</label>
                    <div class="col-lg-7">
                        <input id="precio_dolar" class="form-control" onkeyup="total_bolivares()" step="any" name="price_for_dollar" value="<?php echo $edit_mov_bank[0]['price_for_dollar']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 text-right control-label">Precio Por Unidad de Venta BsS</label>
                    <div class="col-lg-7">
                        <input class="form-control" id="precio_venta" onkeyup="total_bolivares()" step="any" name="precio_venta" value="<?php echo $edit_mov_bank[0]['price_sales']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 text-right control-label">Descripcion</label>
                    <div class="col-lg-7">
                        <textarea class="form-control" name="descriptions" rows="8"><?php echo $edit_mov_bank[0]['descriptions']; ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 text-right control-label">Imagen</label>
                    <div class="col-lg-7">
                        <img src="<?php echo $edit_mov_bank[0]['image']; ?>" alt="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 text-right control-label">Usuario</label>
                    <div class="col-lg-7">
                        <input class="form-control" name="descriptions" value="<?php echo $edit_mov_bank[0]['name'].' '.$edit_mov_bank[0]['last_name']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 text-right control-label">Fecha de Registro</label>
                    <div class="col-lg-7">
                      <input class="form-control" name="amount" value="<?php echo $edit_mov_bank[0]['data_time']; ?>">
                    </div>
                </div>
  			</div>
  		</div>
      <div class="form-group">
        <label class="col-sm-3 text-right control-label">Estado</label>
        <div class="col-sm-7">
          <label class="switch">
            <input type="checkbox" <?php if($edit_mov_bank[0]['stat']==1){ echo 'checked';} ?> value="1" name="stat">
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
<script type="text/javascript">
      function total_bolivares(){
        var cantidad_vemdida = document.querySelector("#cantidad_vendida").value;
        var precio_dolar = document.querySelector("#precio_dolar").value;
        document.querySelector("#monto").value = cantidad_vemdida * precio_dolar;
      }
</script>

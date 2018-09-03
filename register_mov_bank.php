<?php
    ob_start();
    session_start();
    $mantenimientoclass="class='active'";
    $addAcount="class='active'";

    include("include/config.php");
    include("include/defs.php");

    include("header.php");

    if(!isset($_SESSION['USER_ID']) || $_SESSION['USER_ROLE'] != 1)
     {
          header("Location: index.php");
          exit;
     }
     $message="";

     if (isset($_POST['bank_name'])) {
       
      $arrVal = array(
        "name" => $_POST['bank_name'],
        "id_user_reg" => $_SESSION['USER_ID'],
        "stat" => 1,
        "data_time" => date("Y-m-d H:i:s")
       );

      $nId = InsertRec("bank", $arrVal);

      $message = '<div class="alert alert-success">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Banco Creado</strong>
                  </div>';

     }

    if(isset($_POST['submitAcount']))
     {
            $arrVal = array(
                          "id_bank" => $_POST['bank'],
                          "number_acount" => $_POST['number_acount'],
                          "descriptions" => $_POST['descriptions'],
                          "stat" => 1,
                          "id_user_reg" => $_SESSION['USER_ID'],
                          "data_time" => date("Y-m-d H:i:s")
                         );

          $nId = InsertRec("acount_bank", $arrVal);

          $message = '<div class="alert alert-success">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>Cuneta Creado</strong>
                        </div>';

    }
?>
	<section id="content">
          <section class="vbox">
            <section class="scrollable padder">

              <div class="row">
                <div class="col-sm-12">
                	<form class="form-horizontal" data-validate="parsley" method="post"   enctype="multipart/form-data">
                      <section class="panel panel-default">
                        <header class="panel-heading">
                          <span class="h4">Registro de Movimiento Bancario</span>
                        </header>
                        <div class="panel-body">
                          <?php
                                if($message !="")
                                    echo $message;
                          ?>
                          <div class="form-group required">
                            <label class="col-lg-4 text-right control-label font-bold">Seleccionar Banco</label>
                            <div class="col-lg-4">
                                <select class="chosen-select form-control" name="bank" required="required">
                                        <option value="">Seleccionar</option>
                                        <?PHP
                                        $arrKindMeetings = GetRecords("Select * from bank where stat = 1");
                                        foreach ($arrKindMeetings as $key => $value) {
                                        $kinId = $value['id'];
                                        $kinDesc = $value['name'];
                                        ?>
                                        <option value="<?php echo $kinId?>"><?php echo $kinDesc?></option>
                                        <?php
                                        }
                                        ?>
                                </select>
                            </div>
                            <div class="col-lg-4">
                            <a href="modal-add-bank.php" title="Agregar Banco" data-toggle="ajaxModal" class="btn btn-sm btn-icon btn-primary"><i class="glyphicon glyphicon-plus"></i></a>
                            </div>
                          </div>
                          <div class="form-group required">
                            <label class="col-lg-4 text-right control-label font-bold">Seleccionar Cuenta</label>
                            <div class="col-lg-4">
                            <select class="chosen-select form-control" name="bank" required="required">
                                        <option value="">Seleccionar</option>
                                        <?PHP
                                        $arrKindMeetings = GetRecords("Select * from bank where stat = 1");
                                        foreach ($arrKindMeetings as $key => $value) {
                                        $kinId = $value['id'];
                                        $kinDesc = $value['name'];
                                        ?>
                                        <option value="<?php echo $kinId?>"><?php echo $kinDesc?></option>
                                        <?php
                                        }
                                        ?>
                                </select>
                            </div>
                          </div>
                          <div class="form-group required">
                            <label class="col-lg-4 text-right control-label font-bold">Tipo de Movimiento</label>
                            <div class="col-lg-4">
                            <select class="chosen-select form-control" name="bank" required="required">
                                        <option value="">Seleccionar</option>
                                        <?PHP
                                        $arrKindMeetings = GetRecords("Select * from bank where stat = 1");
                                        foreach ($arrKindMeetings as $key => $value) {
                                        $kinId = $value['id'];
                                        $kinDesc = $value['name'];
                                        ?>
                                        <option value="<?php echo $kinId?>"><?php echo $kinDesc?></option>
                                        <?php
                                        }
                                        ?>
                                </select>
                            </div>
                          </div>
                          <div class="form-group required">
                            <label class="col-lg-4 text-right control-label font-bold">Monto</label>
                            <div class="col-lg-4">
                              <input type="text" class="form-control" placeholder="Monto" name="mount" data-required="true">
                            </div>
                          </div>
                          <div class="form-group required">
                            <label class="col-lg-4 text-right control-label font-bold">Descripcion</label>
                            <div class="col-lg-4">
                              <textarea class="form-control" rows="8" placeholder="Descripcion y detalles" name="descriptions" data-required="true"></textarea>
                            </div>
                          </div>
                        </div>
                        <footer class="panel-footer text-right bg-light lter">
                          <button type="submit" name="submitAcount" class="btn btn-primary btn-s-xs">Registrar</button>
                        </footer>
                      </section>
                    </form>
                  </div>
              </div>
            </section>
        </section>
    </section>
<?php
	include("footer.php");
?>

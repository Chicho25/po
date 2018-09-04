<?php
    ob_start();
    session_start();
    $bankclass="class='active'";
    $addMov="class='active'";

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

    if(isset($_POST['submitMov']))
     {
            $arrVal = array(
                          "id_bank" => $_POST['bank'],
                          "id_acount" => $_POST['acount_bank'],
                          "type_mov" => $_POST['type_mov'],
                          "amount"=> $_POST['mount'],
                          "descriptions" => $_POST['descriptions'],
                          "stat" => 1,
                          "id_user_reg" => $_SESSION['USER_ID'],
                          "data_time" => date("Y-m-d H:i:s")
                         );

          $nId = InsertRec("mov_bank", $arrVal);

          if(isset($_FILES['photo']) && $_FILES['photo']['tmp_name'] != "")
          {
              $target_dir = "mov_image/";
              $target_file = $target_dir . basename($_FILES["photo"]["name"]);
              $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
              $filename = $target_dir . $nId.".".$imageFileType;
              $filenameThumb = $target_dir . $nId."_thumb.".$imageFileType;
              if (move_uploaded_file($_FILES["photo"]["tmp_name"], $filename))
              {
                  makeThumbnailsWithGivenWidthHeight($target_dir, $imageFileType, $nId, 600, 400);

                  UpdateRec("mov_bank", "id = ".$nId, array("image" => $filenameThumb));
              }
          }

          $message = '<div class="alert alert-success">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>Movimiento Bancario Registrado</strong>
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
                                <select id="banco" class="form-control" name="bank" required="required">
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
                              <select id="cuenta" class="form-control" name="acount_bank" required="required">

                              </select>
                            </div>
                          </div>
                          <div class="form-group required">
                            <label class="col-lg-4 text-right control-label font-bold">Tipo de Movimiento</label>
                            <div class="col-lg-4">
                            <select class="chosen-select form-control" name="type_mov" required="required">
                                        <option value="">Seleccionar</option>
                                        <?PHP
                                        $arrKindMeetings = GetRecords("Select * from type_mov where stat = 1");
                                        foreach ($arrKindMeetings as $key => $value) {
                                        $kinId = $value['id'];
                                        $kinDesc = $value['name'];
                                        ?>
                                        <option value="<?php echo $kinId?>"><?php echo $kinDesc?></option>
                                        <?php } ?>
                                </select>
                            </div>
                          </div>
                          <div class="form-group required">
                            <label class="col-lg-4 text-right control-label font-bold">Monto</label>
                            <div class="col-lg-4">
                              <input type="number" step="any" class="form-control" placeholder="Monto" name="mount" data-required="true">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-lg-4 text-right control-label font-bold">Imagen</label>
                            <div class="col-lg-4">
                                <div style="width:204px;
                                            height:154px;
                                            background-color: #cccccc;
                                            border: solid 2px gray;
                                            margin: 5px;">
                                    <img id="img" src="#" style='width:200px; height:150px;display: none;' alt="your image" />
                                </div>
                                <label class="btn yellow btn-default">
                                  Cargar Foto <input type="file" accept="image/*" name="photo" style="display: none;" onchange="readURL(this);">
                                </label>
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
                          <button type="submit" name="submitMov" class="btn btn-primary btn-s-xs">Registrar</button>
                        </footer>
                      </section>
                    </form>
                  </div>
              </div>
            </section>
        </section>
    </section>
    <script>
        $(document).ready(function(){
            $("#banco").on('change', function () {
                $("#banco option:selected").each(function () {
                    elegido=$(this).val();
                    $.post("carga_dependiente.php", { elegido: elegido }, function(data){
                        $("#cuenta").html(data);
                    });
                });
            });
          });
    </script>
    <script type="text/javascript">
      function readURL(input) {

          if (input.files && input.files[0]) {
              var reader = new FileReader();
              reader.onload = function (e) {
                  $('#img').show().attr('src', e.target.result);
              }
              reader.readAsDataURL(input.files[0]);
          }
      }
    </script>
<?php
	include("footer.php");
?>

<?php
    ob_start();
    session_start();
    $custclass="class='active'";
    $registerCntclass="class='active'";

    include("include/config.php");
    include("include/defs.php");

    include("header.php");

    if(!isset($_SESSION['USER_ID']) || $_SESSION['USER_ROLE'] == 4)
     {
          header("Location: index.php");
          exit;
     }
     $message="";

    if(isset($_POST['submitCustomer']))
     {
        $FIRSTNAME = $_POST['name'];
        $LASTNAME = $_POST['lastname'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $location = $_POST['location'];

        $ifUserExist = RecCount("customer", "phone = '".$phone."' or email = '".$email."'");
        if($ifUserExist > 0)
        {
          $message = '<div class="alert alert-danger">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                          <strong>El telefono o correo electronico ya existe, Verificar!</strong>
                        </div>';
        }
        else
        {
            $arrVal = array(
                          "name" => $FIRSTNAME,
                          "last_name" => $LASTNAME,
                          "email" => $email,
                          "phone" => $phone,
                          "stat" => 1,
                          "id_reside_country" => $location,
                          "id_user_create" => $_SESSION['USER_ID']
                         );

          $nId = InsertRec("customer", $arrVal);

          if($nId > 0)
          {
            $message = '<div class="alert alert-success">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                          <strong>Cliente Registrado</strong>
                        </div>';

              if(isset($_FILES['photo']) && $_FILES['photo']['tmp_name'] != "")
              {
                  $target_dir = "image_users/";
                  $target_file = $target_dir . basename($_FILES["photo"]["name"]);
                  $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
                  $filename = $target_dir . $nId.".".$imageFileType;
                  $filenameThumb = $target_dir . $nId."_thumb.".$imageFileType;
                  if (move_uploaded_file($_FILES["photo"]["tmp_name"], $filename))
                  {
                      makeThumbnailsWithGivenWidthHeight($target_dir, $imageFileType, $nId, 100, 100);

                      UpdateRec("customer", "id = ".$nId, array("image" => $filenameThumb));
                  }
                }
              }

              $arrVal = array(
                "id_customer" => $nId,
                "id_bank_customer" => $_POST['id_bank_customer'],
                "number_acount" => $_POST['number_acount'],
                "descriptions" => $_POST['descriptions'],
                "type_acount" => $_POST['type_acount'],
                "id_user_reg" => $_SESSION['USER_ID'],
                "data_time" => date("Y-m-d H:i:s"), 
                "stat" => 1
               );

               $nId = InsertRec("acount_customer", $arrVal);

          }
     }
?>
	<section id="content">
          <section class="vbox">
            <section class="scrollable padder">

              <div class="row">
                <div class="col-sm-12">
                	<form class="form-horizontal" data-validate="parsley" method="post" enctype="multipart/form-data">
                      <section class="panel panel-default">
                        <header class="panel-heading">
                          <span class="h4">Registro de Cliente</span>
                        </header>
                        <div class="panel-body">
                          <?php
                                if(isset($message) && $message !=""){
                                    echo $message;
                                  }
                          ?>
                          <div class="form-group required">
                            <label class="col-lg-4 text-right control-label font-bold">Nombre</label>
                            <div class="col-lg-4">
                              <input type="text" class="form-control" placeholder="Nombre" name="name" data-required="true">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-lg-4 text-right control-label font-bold">Apellido</label>
                            <div class="col-lg-4">
                              <input type="text" class="form-control" placeholder="Apellido" name="lastname" data-required="true">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-lg-4 text-right control-label font-bold">Email</label>
                            <div class="col-lg-4">
                              <input type="email" class="form-control" placeholder="Correo Electronico" name="email" data-required="true">
                            </div>
                          </div>
                          <div class="form-group required">
                            <label class="col-lg-4 text-right control-label font-bold">Telefono</label>
                            <div class="col-lg-4">
                              <input type="number" class="form-control" placeholder="Telefono" name="phone" data-required="true">
                            </div>
                          </div>
                          <div class="form-group required">
                            <label class="col-lg-4 text-right control-label font-bold">Cedula</label>
                            <div class="col-lg-4">
                              <input type="text" class="form-control" placeholder="Cedula" name="identifications" data-required="true">
                            </div>
                          </div>
                          <div class="form-group required">
                              <label class="col-lg-4 text-right control-label"><b>País</b></label>
                              <div class="col-lg-4">
                                  <select class="chosen-select form-control" name="location" required="required">
                                    <option value="">Seleccionar</option>
                                    <?PHP
                                        $arrKindMeetings = GetRecords("Select * from country where stat = 1");
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
                                  Cargar Foto <input type="file" name="photo" style="display: none;" onchange="readURL(this);">
                                </label>
                            </div>
                          </div>
                          <hr>
                          <div class="form-group required">
                              <label class="col-lg-4 text-right control-label"><b>Banco</b></label>
                              <div class="col-lg-4">
                                  <select class="chosen-select form-control" name="id_bank_customer" required="required">
                                    <option value="">Seleccionar</option>
                                    <?PHP
                                        $arrKindMeetings = GetRecords("Select * from bank_customer where stat = 1");
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
                              <label class="col-lg-4 text-right control-label"><b>Tipo de cuenta</b></label>
                              <div class="col-lg-4">
                                  <select class="chosen-select form-control" name="type_acount" required="required">
                                    <option value="">Seleccionar</option>
                                    <option value="1">Ahorro</option>
                                    <option value="2">Corriente</option>
                                  </select>
                              </div>
                          </div>
                          <div class="form-group required">
                            <label class="col-lg-4 text-right control-label font-bold">Numero de cuenta</label>
                            <div class="col-lg-4">
                              <input type="text" class="form-control" placeholder="Cedula" name="number_acount" data-required="true">
                            </div>
                          </div>
                          <div class="form-group required">
                            <label class="col-lg-4 text-right control-label font-bold">Descripcion de la cuenta</label>
                            <div class="col-lg-4">
                              <textarea class="form-control" placeholder="Descripcion de la cuenta" name="descriptions" data-required="true"></textarea>
                            </div>
                          </div>
                        </div>
                        <footer class="panel-footer text-right bg-light lter">
                          <button type="submit" name="submitCustomer" class="btn btn-primary btn-s-xs">Registrar Cliente</button>
                        </footer>
                      </section>
                    </form>
                  </div>
              </div>
            </section>
        </section>
    </section>
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

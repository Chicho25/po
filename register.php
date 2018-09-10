<?php
    ob_start();
    session_start();
    $userclass="class='active'";
    $registerclass="class='active'";

    include("include/config.php");
    include("include/defs.php");

    include("header.php");

    if(!isset($_SESSION['USER_ID']) || $_SESSION['USER_ROLE'] != 1)
     {
          header("Location: index.php");
          exit;
     }
     $message="";

     if (isset($_POST['country'])) {
       
      $arrVal = array(
        "name" => $_POST['country'],
        "id_user_reg" => $_SESSION['USER_ID'],
        "stat" => 1,
        "data_time" => date("Y-m-d H:i:s")
       );

      $nId = InsertRec("country", $arrVal);

      $message = '<div class="alert alert-success">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Pais Creado</strong>
                  </div>';

     }

    if(isset($_POST['submitUser']))
     {
        $USERNAME = $_POST['username'];
        $FIRSTNAME = $_POST['name'];
        $LASTNAME = $_POST['lastname'];
        $password = encryptIt($_POST['password']);
        $usertype = $_POST['usertype'];
        $email = $_POST['email'];
        $location = $_POST['location'];
        $credit = $_POST['credit'];
        $referred = $_POST['referred'];
        $ifUserExist = RecCount("users", "user = '".$USERNAME."' or email = '".$email."'");
        if($ifUserExist > 0)
        {
          $message = '<div class="alert alert-danger">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                          <strong>El nombre de usuario o correo electronico ya existe, intente con otro!</strong>
                        </div>';
        }
        else
        {
            $arrVal = array(
                          "user" => $USERNAME,
                          "name" => $FIRSTNAME,
                          "last_name" => $LASTNAME,
                          "password" => $password,
                          "email" => $email,
                          "id_roll_user" => $usertype,
                          "stat" => 1,
                          "location" => $location, 
                          "id_user_reg" => $_SESSION['USER_ID'],
                          "credit" => $credit, 
                          "referred" => $referred
                         );

          $nId = InsertRec("users", $arrVal);

          if($nId > 0)
          {

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

                      UpdateRec("users", "id = ".$nId, array("image" => $filenameThumb));
                  }
              }

              $message = '<div class="alert alert-success">
                          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>Usuario Creado</strong>
                          </div>';
              }
          }
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
                          <span class="h4">Registro de usuario</span>
                        </header>
                        <div class="panel-body">
                          <?php
                                if($message !="")
                                    echo $message;
                          ?>
                          <div class="form-group required">
                            <label class="col-lg-4 text-right control-label font-bold">Nombre de usuario</label>
                            <div class="col-lg-4">
                              <input type="text" class="form-control" autocomplete="off" placeholder="Nombre de usuario" name="username" data-required="true">
                            </div>
                          </div>
                          <div class="form-group required">
                            <label class="col-lg-4 text-right control-label font-bold">Nombre</label>
                            <div class="col-lg-4">
                              <input type="text" class="form-control" autocomplete="off" placeholder="Nombre" name="name" data-required="true">
                            </div>
                          </div>
                          <div class="form-group required">
                            <label class="col-lg-4 text-right control-label font-bold">Apellido</label>
                            <div class="col-lg-4">
                              <input type="text" class="form-control" autocomplete="off" placeholder="Apellido" name="lastname" data-required="true">
                            </div>
                          </div>
                          <div class="form-group required">
                            <label class="col-lg-4 text-right control-label font-bold">Password</label>
                            <div class="col-lg-4">
                              <input type="password" class="form-control" placeholder="Password" name="password" data-required="true">
                            </div>
                          </div>
                          <div class="form-group required">
                            <label class="col-lg-4 text-right control-label font-bold">Email</label>
                            <div class="col-lg-4">
                              <input type="email" autocomplete="off" class="form-control" placeholder="Email" name="email" data-required="true">
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
                              <label class="col-lg-4 text-right control-label font-bold">Rol de usuario</label>
                              <div class="col-lg-4">
                                  <select class="chosen-select form-control" name="usertype" required="required" onChange="porcentaje(this.value);">
                                    <option value="">Seleccionar</option>
                                    <?PHP
                                    $arrKindMeetings = GetRecords("Select * from type_user where stat = 1  and id not in(1)");
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
                          <div class="form-group" id="porcentaje_tag" style="display:none">
                            <label class="col-lg-4 text-right control-label font-bold">Credito</label>
                            <div class="col-lg-4">
                              <input type="text" class="form-control" placeholder="Credito para este usuario" name="credit" autocomplete="off">
                            </div>
                          </div>
                          <div class="form-group" id="porcentaje_tag_ref" style="display:none">
                              <label class="col-lg-4 text-right control-label font-bold">Referido</label>
                              <div class="col-lg-4">
                                  <select class="chosen-select form-control" name="referred">
                                    <option value="">Seleccionar</option>
                                    <?PHP
                                    $arrKindMeetings = GetRecords("Select * from users where stat = 1  and id_roll_user not in(1)");
                                    foreach ($arrKindMeetings as $key => $value) {
                                      $kinId = $value['id'];
                                      $kinDesc = $value['name'].' '.$value['last_name'];
                                    ?>
                                    <option value="<?php echo $kinId?>"><?php echo $kinDesc?></option>
                                    <?php
                                    }
                                    ?>
                                  </select>
                              </div>
                          </div>
                          <div class="form-group required">
                              <label class="col-lg-4 text-right control-label"><b>País</b></label>
                              <div class="col-lg-4">
                                  <select class="chosen-select form-control" name="location" required="required"  onChange="getOptionsData(this.value, 'regionbycountry', 'region');">
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
                              <div class="col-lg-1">
                                <a href="modal-add-country.php" title="Agregar un Pais" data-toggle="ajaxModal" class="btn btn-sm btn-icon btn-primary"><i class="glyphicon glyphicon-plus"></i></a>
                              </div>
                          </div>

                        </div>
                        <footer class="panel-footer text-right bg-light lter">
                          <button type="submit" name="submitUser" class="btn btn-primary btn-s-xs">Registrar</button>
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

    function porcentaje(valor){
      if (valor == 3) {
      document.querySelector("#porcentaje_tag").style.display = "block";
      document.querySelector("#porcentaje_tag_ref").style.display = "block";
      }else{
        document.querySelector("#porcentaje_tag").style.display = "none";
      }
    }

  </script>
<?php
	include("footer.php");
?>

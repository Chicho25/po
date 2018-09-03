<?php
    ob_start();
    session_start();
    $userclass="class='active'";
    $userlistclass="class='active'";

    include("include/config.php");
    include("include/defs.php");

    include("header.php");

    if(!isset($_SESSION['USER_ID']) || $_SESSION['USER_ROLE'] != 1)
     {
          header("Location: index.php");
          exit;
     }

     if(isset($_POST['submitUsuario'])){

       if(isset($_POST['stat'])){ $stat = 1; }else{ $stat = 0; }

       $arrUser = array("user"=>$_POST['user'],
                        "name"=>$_POST['name'],
                        "last_name"=>$_POST['last_name'],
                        "id_roll_user"=>$_POST['roll'],
                        "password"=>encryptIt($_POST['pass']),
                        "stat"=>$stat,
                        "location"=>$_POST['location_edit'],
                        "email"=>$_POST['email'], 
                        "percentage"=>$_POST['percentage'], 
                        "referred"=>$_POST['referred']);

       UpdateRec("users", "id = ".$_POST['id'], $arrUser);

       $message = '<div class="alert alert-success">
                   <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                     <strong>Usuario Modificado</strong>
                   </div>';
     }

    $where = "where (1=1)";

     if(isset($_POST['name']) && $_POST['name'] != "")
     {
        $where.=" and  users.name LIKE '%".$_POST['name']."%'";
        $name = $_POST['name'];
     }
     if(isset($_POST['lname']) && $_POST['lname'] != "")
     {
        $where.=" and  users.last_name LIKE '%".$_POST['lname']."%'";
        $lname = $_POST['lname'];
     }
     if(isset($_POST['user']) && $_POST['user'] != "")
     {
        $where.=" and  users.user LIKE '%".$_POST['user']."%'";
        $user = $_POST['user'];
     }
     if(isset($_POST['location']) && $_POST['location'] != "")
     {
        $where.=" and users.location = '".$_POST['location']."'";
        $location = $_POST['location'];
     }


      $arrUser = GetRecords("SELECT users.*,
                                    type_user.name as name_type_user,
                                    country.name as LOCATION
                             from users
                             inner join type_user on type_user.id = users.id_roll_user
                             inner join country on country.id = users.location
                             $where
                             order by users.id");

?>
	<section id="content">
          <section class="vbox">
            <section class="scrollable padder">
              <section class="panel panel-default">
                <header class="panel-heading">
                          <span class="h4">Lista de Usuarios</span>
                </header>
                <div class="panel-body">
                  <?php
                        if(isset($message) && $message !=""){
                            echo $message;
                          }
                  ?>
                    <form method="post" action="" novalidate>
                      <div class="row wrapper">
                        <div class="col-sm-2 m-b-xs">
                          <div class="input-group">
                            <input type="text" class="input-s input-sm form-control" value="<?php if(isset($name)){ echo $name;}?>" name="name" placeholder="Nombre">
                          </div>
                        </div>
                        <div class="col-sm-2 m-b-xs">
                          <div class="input-group">
                            <input type="text" class="input-s input-sm form-control" value="<?php if(isset($lname)){ echo $lname;}?>" name="lname" placeholder="Apellido">
                          </div>
                        </div>
                        <div class="col-sm-2 m-b-xs">
                          <div class="input-group">
                            <input type="text" class="input-s input-sm form-control" value="<?php if(isset($user)){ echo $user;}?>" name="user" placeholder="Usuario">
                          </div>
                        </div>
                        <div class="col-sm-3 m-b-xs">
                          <div class="input-group">
                            <select class="chosen-select form-control" name="location">
                              <option value="">Seleccionar</option>
                              <?PHP
                                  $arrKindMeetings = GetRecords("Select * from country where stat = 1");
                                  foreach ($arrKindMeetings as $key => $value) {
                                    $kinId = $value['id'];
                                    $kinDesc = $value['name'];

                                  ?>
                                  <option value="<?php echo $kinId?>" <?php if(isset($location) && $location==$kinId){ echo "selected";} ?>><?php echo $kinDesc?></option>
                                  <?php
                                  }
                                  ?>
                            </select>
                            <span class="input-group-btn padder "><button type="submit" class="btn btn-sm btn-default">Buscar</button></span>
                          </div>
                        </div>
                      </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-striped b-t b-light" data-ride="datatables">
                          <thead>
                            <tr>
                              <th>NOMBRE</th>
                              <th>APELLIDO</th>
                              <th>EMAIL</th>
                              <th>TIPO DE USUARIO</th>
                              <th>LOCALIDAD</th>
                              <th>PORCENTAJE</th>
                              <th>ESTATUS</th>
                              <th>EDITAR</th>
                            </tr>
                          </thead>
                          <tbody>
                          <?PHP
                            $i=1;
                            foreach ($arrUser as $key => $value) {

                              $status = ($value['stat'] == 1) ? 'Activo' : 'Inactivo';
                            ?>
                          <tr>
                              <td class="tbdata"> <?php echo $value['name']?> </td>
                              <td class="tbdata"> <?php echo $value['last_name']?> </td>
                              <td class="tbdata"> <?php echo $value['email']?> </td>
                              <td class="tbdata"> <?php echo $value['name_type_user']?> </td>
                              <td class="tbdata"> <?php echo $value['LOCATION']?> </td>
                              <td class="tbdata"> <?php echo $value['percentage']?> </td>
                              <td class="tbdata"> <?php echo $status?> </td>
                              <td>
                                <a href="modal-usuario.php?id=<?php echo $value['id']?>" title="Agregar una nota" data-toggle="ajaxModal" class="btn btn-sm btn-icon btn-primary"><i class="fa fa-edit (alias)"></i></a>
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
              </section>
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

<?php
    ob_start();
    session_start();
    $custclass="class='active'";
    $editCntclass="class='active'";

    include("include/config.php");
    include("include/defs.php");

    include("header.php");

    if(!isset($_SESSION['USER_ID']) || $_SESSION['USER_ROLE'] != 1)
     {
          header("Location: index.php");
          exit;
     }

     if (isset($_POST['submitCreateBank'])) {

      $arrVal = array(
        "id_customer" => $_POST['id_customer'],
        "id_bank_customer" => $_POST['id_bank_customer'],
        "number_acount" => $_POST['number_acount'],
        "descriptions" => $_POST['descriptions'],
        "type_acount" => $_POST['type_acount'],
        "id_user_reg" => $_SESSION['USER_ID'],
        "data_time" => date("Y-m-d H:i:s"), 
        "stat" => 1
       );

       $nId = InsertRec("acount_customer", $arrVal);

       $message = '<div class="alert alert-success">
       <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
         <strong>Cuenta Creada</strong>
       </div>';

     }

     if(isset($_POST['eliminar'])){

      $arrBankCus = array("stat" => 2);

      UpdateRec("acount_customer", "id = ".$_POST['id_customer_acount'], $arrBankCus);

      $message = '<div class="alert alert-danger">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Cuenta eliminada</strong>
                  </div>';

     }

     if(isset($_POST['submitUsuario'])){

       if(isset($_POST['stat'])){ $stat = 1; }else{ $stat = 0; }

       $arrUser = array("name" => $_POST['name_edit'],
                         "last_name" => $_POST['last_name_edit'],
                         "email" => $_POST['email_edit'],
                         "phone" => $_POST['phone_edit'],
                         "stat" => $stat,
                         "id_reside_country" => $_POST['location_edit']);

       UpdateRec("customer", "id = ".$_POST['id'], $arrUser);

       $message = '<div class="alert alert-success">
                   <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                     <strong>Cliente Modificado</strong>
                   </div>';
     }

    $where = "where (1=1)";

     if(isset($_POST['name']) && $_POST['name'] != "")
     {
        $where.=" and  customer.name LIKE '%".$_POST['name']."%'";
        $name = $_POST['name'];
     }
     if(isset($_POST['lname']) && $_POST['lname'] != "")
     {
        $where.=" and  customer.last_name LIKE '%".$_POST['lname']."%'";
        $lname = $_POST['lname'];
     }
     if(isset($_POST['phone']) && $_POST['phone'] != "")
     {
        $where.=" and  customer.phone LIKE '%".$_POST['phone']."%'";
        $user = $_POST['phone'];
     }
     if(isset($_POST['location']) && $_POST['location'] != "")
     {
        $where.=" and customer.id_reside_country = '".$_POST['location']."'";
        $location = $_POST['location'];
     }


      $arrUser = GetRecords("SELECT customer.*,
                                    country.name as LOCATION
                             from customer
                             inner join country on country.id = customer.id_reside_country
                             $where
                             order by customer.id");

?>
	<section id="content">
          <section class="vbox">
            <section class="scrollable padder">
              <section class="panel panel-default">
                <header class="panel-heading">
                          <span class="h4">Lista de Clientes</span>
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
                            <input type="text" class="input-s input-sm form-control" value="<?php if(isset($user)){ echo $user;}?>" name="phone" placeholder="Teléfono">
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
                              <th>TELÉFONO</th>
                              <th>LOCALIDAD</th>
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
                              <td class="tbdata"> <?php echo $value['phone']?> </td>
                              <td class="tbdata"> <?php echo $value['LOCATION']?> </td>
                              <td class="tbdata"> <?php echo $status?> </td>
                              <td>
                                <a href="modal-customer.php?id=<?php echo $value['id']?>" title="Editar Cliente" data-toggle="ajaxModal" class="btn btn-sm btn-icon btn-primary"><i class="fa fa-edit (alias)"></i></a>
                                <a href="modal-bank-customer.php?id=<?php echo $value['id']?>" title="Ver Bancos" data-toggle="ajaxModal" class="btn btn-sm btn-icon btn-primary"><i class="fa fa-bank"></i></a>
                                <a href="modal-bank-customer-add.php?id=<?php echo $value['id']?>" title="Agregar Bancos" data-toggle="ajaxModal" class="btn btn-sm btn-icon btn-primary"><i class="fa fa-plus"></i></a>
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

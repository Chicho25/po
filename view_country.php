<?php
    ob_start();
    session_start();
    $mantenimientoclass="class='active'";
    $editCountry="class='active'";

    include("include/config.php");
    include("include/defs.php");

    include("header.php");

    if(!isset($_SESSION['USER_ID']) || $_SESSION['USER_ROLE'] != 1)
     {
          header("Location: index.php");
          exit;
     }

     

     if(isset($_POST['submitEditCountry'])){

       if(isset($_POST['stat'])){ $stat = 1; }else{ $stat = 0; }

       $arrUser = array("stat"=>$stat,
                        "name"=>$_POST['country']);

       UpdateRec("country", "id = ".$_POST['id_country'], $arrUser);

       $message = '<div class="alert alert-success">
                   <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                     <strong>Pais Modificado</strong>
                   </div>';
     }

    $where = "where (1=1) ";

     if(isset($_POST['name']) && $_POST['name'] != "")
     {
        $where.=" and  name LIKE '%".$_POST['name']."%'";
        $name = $_POST['name'];
     }


      $arrUser = GetRecords("SELECT *
                             from country
                             $where
                             order by id");

?>
	<section id="content">
          <section class="vbox">
            <section class="scrollable padder">
              <section class="panel panel-default">
                <header class="panel-heading">
                          <span class="h4">Lista de Paises</span>
                </header>
                <div class="panel-body">
                  <?php
                        if(isset($message) && $message !=""){
                            echo $message;
                          }
                  ?>
                    <div class="table-responsive">
                        <table class="table table-striped b-t b-light" data-ride="datatables">
                          <thead>
                            <tr>
                              <th>ID</th>
                              <th>PAIS</th>
                              <th>FECHA DE REGISTRO</th>
                              <th>STAT</th>
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
                              <td class="tbdata"> <?php echo $value['id']?> </td>
                              <td class="tbdata"> <?php echo $value['name']?> </td>
                              <td class="tbdata"> <?php echo $value['data_time']?> </td>
                              <td class="tbdata"> <?php echo $status?> </td>
                              <td>
                                <a href="modal_edit_country.php?id=<?php echo $value['id']?>" title="Editar Pais" data-toggle="ajaxModal" class="btn btn-sm btn-icon btn-primary"><i class="fa fa-edit (alias)"></i></a>
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
<?php
	include("footer.php");
?>

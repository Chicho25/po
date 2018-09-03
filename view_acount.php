<?php
    ob_start();
    session_start();
    $mantenimientoclass="class='active'";
    $editAcount="class='active'";

    include("include/config.php");
    include("include/defs.php");

    include("header.php");

    if(!isset($_SESSION['USER_ID']) || $_SESSION['USER_ROLE'] != 1)
     {
          header("Location: index.php");
          exit;
     }

     if(isset($_POST['submitEditAcount'])){

       if(isset($_POST['stat'])){ $stat = 1; }else{ $stat = 0; }

       $arrUser = array("stat"=>$stat,
                        "number_acount"=>$_POST['acount_bank'], 
                        "id_bank"=>$_POST['id_bank'], 
                        "descriptions" => $_POST['descriptions']
                        );

       UpdateRec("acount_bank", "id = ".$_POST['id_count_bank'], $arrUser);

       $message = '<div class="alert alert-success">
                   <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                     <strong>Cuenta Modificada</strong>
                   </div>';
     }

      $where = "where (1=1) ";

      $arrUser = GetRecords("SELECT 
                             ab.id, 
                             ab.number_acount, 
                             ab.data_time, 
                             ab.stat, 
                             b.name
                             from acount_bank ab inner join bank b on ab.id_bank = b.id  
                             $where
                             order by ab.id");

?>
	<section id="content">
          <section class="vbox">
            <section class="scrollable padder">
              <section class="panel panel-default">
                <header class="panel-heading">
                          <span class="h4">Lista de Cuentas</span>
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
                              <th>BANCO</th>
                              <th>NUMERO DE CUENTA</th>
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
                              <td class="tbdata"> <?php echo $value['number_acount']?> </td>
                              <td class="tbdata"> <?php echo $value['data_time']?> </td>
                              <td class="tbdata"> <?php echo $status?> </td>
                              <td>
                                <a href="modal_edit_acount.php?id=<?php echo $value['id']?>" title="Editar Cuenta" data-toggle="ajaxModal" class="btn btn-sm btn-icon btn-primary"><i class="fa fa-edit (alias)"></i></a>
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

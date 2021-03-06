<?php
    ob_start();
    session_start();
    $mantenimientoclass="class='active'";
    $classcountry="class='active'";

    include("include/config.php");
    include("include/defs.php");

    include("header.php");

    if(!isset($_SESSION['USER_ID']) || $_SESSION['USER_ROLE'] != 1)
     {
          header("Location: index.php");
          exit;
     }
     $message="";

    if(isset($_POST['submitCountry']))
     {
            $arrVal = array(
                          "name" => $_POST['name_country'],
                          "stat" => 1,
                          "id_user_reg" => $_SESSION['USER_ID'],
                          "data_time" => date("Y-m-d H:i:s")
                         );

          $nId = InsertRec("country", $arrVal);

          $message = '<div class="alert alert-success">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Pais Registrado</strong>
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
                          <span class="h4">Registro de Pais</span>
                        </header>
                        <div class="panel-body">
                          <?php
                                if($message !="")
                                    echo $message;
                          ?>
                          <div class="form-group required">
                            <label class="col-lg-4 text-right control-label font-bold">Nombre del Pais</label>
                            <div class="col-lg-4">
                              <input type="text" class="form-control" autocomplete="off" placeholder="Nombre del Pais" name="name_country" data-required="true">
                            </div>
                          </div>
                          
                        </div>
                        <footer class="panel-footer text-right bg-light lter">
                          <button type="submit" name="submitCountry" class="btn btn-primary btn-s-xs">Registrar</button>
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

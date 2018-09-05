<?php
    ob_start();
    session_start();
    $transaction="class='active'";
    $registertransaction="class='active'";

    include("include/config.php");
    include("include/defs.php");

    include("header.php");

    if(!isset($_SESSION['USER_ID']) || $_SESSION['USER_ROLE'] != 1)
     {
          header("Location: index.php");
          exit;
     }
     $message="";

    if(isset($_POST['submitTransaction']))
     {

            $arrVal = array(
                          "id_type_transaction" => $_POST['type_transaction'],
                          "id_customer" => $_POST['customer'],
                          "id_user_register" => $_SESSION['USER_ID'],
                          "amount" => $_POST['amount_get'],
                          "id_type_coin" => $_POST['type_coin'],
                          "price_dollar" => $_POST['price_dollar'],
                          "messaje" => $_POST['message'],
                          "stat" => 1,
                          "amount_transfer" => $_POST['amount_transfer'],
                          "remaining" => $_POST['amount_transfer']
                         );

          $nId = InsertRec("transaction", $arrVal);

          if($nId > 0)
          {
              $message = '<div class="alert alert-success">
                          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>Transaccion Registrada</strong>
                          </div>';
          }
      } ?>
	<section id="content">
          <section class="vbox">
            <section class="scrollable padder">

              <div class="row">
                <div class="col-sm-12">
                	<form class="form-horizontal" data-validate="parsley" method="post"   enctype="multipart/form-data">
                      <section class="panel panel-default">
                        <header class="panel-heading">
                          <span class="h4">Registro de Transacción</span>
                        </header>
                        <div class="panel-body">
                          <?php
                                if($message !="")
                                    echo $message;
                          ?>

                          <div class="form-group required">
                            <label class="col-lg-4 text-right control-label font-bold">Precio del dolar</label>
                            <div class="col-lg-4">
                             
                              <input type="text" readonly class="form-control" value="" placeholder="Monto Recibido" name="price_dollar" data-required="true">
                            </div>
                          </div>
                          <div class="form-group required">
                            <label class="col-lg-4 text-right control-label font-bold">Tipo de Transacción</label>
                            <div class="col-lg-4">
                              <select class="chosen-select form-control" name="type_transaction" required="required"  onChange="getOptionsData(this.value, 'regionbycountry', 'region');">
                                <option value="">Seleccionar</option>
                                <?PHP
                                    $arrKindMeetings = GetRecords("Select * from type_transaction where stat = 1");
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
                            <label class="col-lg-4 text-right control-label font-bold">Cliente</label>
                            <div class="col-lg-4">
                              <select class="chosen-select form-control" name="customer" required="required"  onChange="getOptionsData(this.value, 'regionbycountry', 'region');">
                                <option value="">Seleccionar</option>
                                <?PHP
                                    $arrKindMeetings = GetRecords("Select * from customer where stat = 1");
                                    foreach ($arrKindMeetings as $key => $value) {
                                      $kinId = $value['id'];
                                      $kinName = $value['name'];
                                      $kinLastName = $value['last_name'];
                                      $phone = $value['phone'];
                                    ?>
                                    <option value="<?php echo $kinId?>"><?php echo $kinName.' '.$kinLastName.' '.$phone;?></option>
                                    <?php
                                    }
                                    ?>
                              </select>
                            </div>
                          </div>
                          <div class="form-group required">
                            <label class="col-lg-4 text-right control-label font-bold">Tipo de Moneda</label>
                            <div class="col-lg-4">
                              <select class="chosen-select form-control" name="type_coin" required="required"  onChange="getOptionsData(this.value, 'regionbycountry', 'region');">
                                <option value="">Seleccionar</option>
                                <?PHP
                                    $arrKindMeetings = GetRecords("Select * from type_coin where stat = 1");
                                    foreach ($arrKindMeetings as $key => $value) {
                                      $kinId = $value['id'];
                                      $kinName = $value['name'];
                                    ?>
                                    <option value="<?php echo $kinId?>"><?php echo $kinName;?></option>
                                    <?php
                                    }
                                    ?>
                              </select>
                            </div>
                          </div>
                          <script type="text/javascript">
                          function amount(){
                            var value_dollar = <?php echo $arrUser[0]['value_dollar'];?>;
                            var get_amount = document.getElementById("amount_get").value;
                            document.getElementById("amount_transfer").value = get_amount * value_dollar;
                          }
                          </script>
                          <div class="form-group required">
                            <label class="col-lg-4 text-right control-label font-bold">Monto Recibido</label>
                            <div class="col-lg-4">
                              <input type="number" autocomplete="off" class="form-control" id="amount_get" onkeyup="amount()" placeholder="Monto Recibido" name="amount_get" data-required="true">
                            </div>
                          </div>
                          <div class="form-group required">
                            <label class="col-lg-4 text-right control-label font-bold">Monto a transferir</label>
                            <div class="col-lg-4">
                              <input type="number" class="form-control" id="amount_transfer" placeholder="Monto a transferir" name="amount_transfer" data-required="true">
                            </div>
                          </div>
                          <div class="form-group">
                              <label class="col-lg-4 text-right control-label font-bold">Mensaje</label>
                              <div class="col-lg-4">
                                  <textarea class="form-control" placeholder="Mensaje" name="message" rows="8" cols="80"></textarea>
                              </div>
                          </div>
                        </div>
                        <footer class="panel-footer text-right bg-light lter">
                          <button type="submit" name="submitTransaction" class="btn btn-primary btn-s-xs">Registrar</button>
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

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
                          "id_acount_bank" => $_POST['acount_bank'],
                          "id_user_register" => $_SESSION['USER_ID'],
                          "amount" => $_POST['amount_get'],
                          "id_type_coin" => $_POST['type_coin'],
                          "taza_actual" => $_POST['taza_actual'],
                          "messaje" => $_POST['message'],
                          "stat" => 1,
                          "amount_transfer" => $_POST['amount_transfer'], 
                          "time_data" => date("Y-m-d H:i:s")
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
                              <select class="form-control" name="customer" required="required" id="customers">
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
                            <label class="col-lg-4 text-right control-label font-bold">Cuenta a Pagar</label>
                            <div class="col-lg-4">
                              <select class="form-control" name="acount_bank" required="required" id="acount_bank">
                                
                              </select>
                            </div>
                          </div>
                          <div class="form-group required">
                            <label class="col-lg-4 text-right control-label font-bold">Tipo de Moneda</label>
                            <div class="col-lg-4">
                              <select class="form-control" name="type_coin" required="required" id="type_coin">
                                <option value="">Seleccionar</option>
                                <?PHP
                                    $arrKindMeetings = GetRecords("select 
                                                                      id,
                                                                      name, 
                                                                      (select 
                                                                          value_bolivar 
                                                                      from 
                                                                      value_coin 
                                                                      where 
                                                                      id_type_coin = tc.id 
                                                                      and 
                                                                      id = (select max(id) from value_coin where id_type_coin = tc.id)) as value_bolivar
                                                                  from 
                                                                  type_coin tc");
                                    foreach ($arrKindMeetings as $key => $value) {
                                      $kinId = $value['id'];
                                      $kinName = $value['name'];
                                      $amount = $value['value_bolivar'];
                                    ?>
                                    <option value="<?php echo $kinId?>"><?php echo $kinName.' // '.number_format($amount, 2, ',', '.');?></option>
                                    <?php
                                    }
                                    ?>
                              </select>
                            </div>
                          </div>

                          <div class="form-group required">
                            <label class="col-lg-4 text-right control-label font-bold">Monto Recibido</label>
                            <div class="col-lg-4">
                              <div id="monto_cambio">
                                    
                              </div>
                              <input type="number" autocomplete="off" class="form-control" id="amount_get" onkeyup="amount()" placeholder="Monto Recibido" name="amount_get" data-required="true">
                            </div>
                          </div>
                          <div class="form-group required">
                            <label class="col-lg-4 text-right control-label font-bold">Monto a transferir Bs.S</label>
                            <div class="col-lg-4">
                              <input type="number" step="any" class="form-control" id="amount_transfer" readonly placeholder="Monto a transferir"  name="amount_transfer" data-required="true">
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
    <script>
        $(document).ready(function(){
            $("#customers").on('change', function () {
                $("#customers option:selected").each(function () {
                  customer=$(this).val();
                    $.post("carga_dependiente.php", { customer: customer }, function(data){
                        $("#acount_bank").html(data);
                    });
                });
            });
          });

          $(document).ready(function(){
            $("#type_coin").on('change', function () {
                $("#type_coin option:selected").each(function () {
                  type_coin=$(this).val();
                    $.post("carga_dependiente.php", { type_coin: type_coin }, function(data){
                        $("#monto_cambio").html(data);
                    });
                });
            });
          });

          function amount(){
            var monto = document.querySelector("#amount_get").value;
            var taza_actual = document.querySelector("#taza_actual").value; 
            
            document.querySelector("#amount_transfer").value = (taza_actual * monto);
          }

    </script>
<?php
	include("footer.php");
?>

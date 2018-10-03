<?php
  ob_start();
  session_start();
  $hideLeft = true;
  include("include/config.php");
  include("include/defs.php");
  $loggdUType = current_user_type();

  include("header.php");

  if(!isset($_SESSION['USER_ID']))
     {
          header("Location: index.php");
          exit;
     }

     if(isset($_POST['submitUpdateCoin'])) {

        $arrPay = array("id_type_coin"=>$_POST['id_type_coin'],
                        "value_bolivar"=>$_POST['value_bolivar'],
                        "id_user_reg"=>$_SESSION['USER_ID'],
                        "stat"=>1,
                        "date_time"=>date("Y-m-d H:i:s"));

       $nId = InsertRec("value_coin", $arrPay);

        $message = '<div class="alert alert-success">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                      <strong>Taza Actualizada</strong>
                    </div>';

     }

 ?>

 <section id="content">
         <section class="vbox">
           <section class="scrollable padder">
             <section class="panel panel-default">
               <header class="panel-heading">
                  <span class="h4">Cambio de Taza</span>
               </header>
               <div class="panel-body">
                 <?php
                       if(isset($message) && $message !=""){
                           echo $message;
                         }
                 ?>
                 <div class="row">
                  <div class="col-sm-12">
                    <div class="panel b-a">
                      <div class="row m-n">
                        <?php $taza = GetRecords("select
                                                    name,
                                                    id,
                                                    (select
                                                        value_bolivar
                                                    from
                                                    value_coin
                                                    where
                                                    id_type_coin = tc.id
                                                    and
                                                    id = (select max(id) from value_coin where id_type_coin = tc.id)) as value_bolivar
                                                from
                                                type_coin tc"); ?>

                        <?php foreach ($taza as $key => $value) { ?>
                        <div class="col-md-3 b-b b-r">
                          <a href="modal-udate-coin.php?id_type_coin=<?php echo $value['id']; ?>" data-toggle="ajaxModal" class="block padder-v hover">
                            <span class="i-s i-s-2x pull-left m-r-sm">
                              <i class="i i-hexagon2 i-s-base text-danger-lt hover-rotate"></i>
                              <i class="fa fa-money i-sm text-white"></i>
                            </span>
                            <span class="clear">
                              <span class="h3 block m-t-xs text-danger"><?php echo number_format($value['value_bolivar'], 2, ',', '.'); ?> BsS.</span>
                              <small class="text-muted text-u-c"><?php echo $value['name']; ?></small>
                            </span>
                          </a>
                        </div>
                        <?php } ?>
                      </div>
                    </div>
                    <hr>
                  </div>
                </div>
               </div>
             </section>
           </section>
       </section>
   </section>
<?php  include("footer.php"); ?>

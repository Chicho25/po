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

  $precio_actual_dolar = GetRecords("select
                                      price_for_dollar,
                                      price_sales
                                      from
                                      mov_bank
                                      where
                                      id = (select
                                          max(id)
                                          from
                                          mov_bank
                                          where
                                          type_mov = 2)");

 ?>

 <section id="content">
         <section class="vbox">
           <section class="scrollable padder">
             <section class="panel panel-default">
               <header class="panel-heading">
                  <span class="h4">Principal</span>
               </header>
               <div class="panel-body">
               <?php  ?>
                 <?php
                       if(isset($message) && $message !=""){
                           echo $message;
                         }
                 ?>
                 <div class="row">
                  <div class="col-sm-12">
                    <div class="panel b-a">
                      <div class="row m-n">
                        <div class="col-md-3 b-b b-r">
                          <?php
                          $arrUser = GetRecords("select count(*) as total_trans from transaction where stat = 1");

                          $value = $arrUser[0]['total_trans'];?>
                          <a href="#" title="" class="block padder-v hover">
                            <span class="i-s i-s-2x pull-left m-r-sm">
                              <i class="i i-hexagon2 i-s-base text-success hover-rotate"></i>
                              <i class="fa fa-usd i-1x text-white"></i>
                            </span>
                                <span class="clear">
                                <span class="h3 block m-t-xs text-success"><?php echo $value?></span>
                                <small class="text-muted text-u-c">Transacciones Pendientes</small>
                                </span>
                          </a>
                        </div>
                        <div class="col-md-3 b-b b-r">
                          <a href="#" class="block padder-v hover">
                            <span class="i-s i-s-2x pull-left m-r-sm">
                              <i class="i i-hexagon2 i-s-base text-danger-lt hover-rotate"></i>
                              <i class="fa fa-money i-sm text-white"></i>
                            </span>
                            <span class="clear">
                              <?php
                              $arrSum = GetRecords("select sum(amount_transfer) as total_trans_bss from transaction where stat = 1");

                              $sum = $arrSum[0]['total_trans_bss']/$precio_actual_dolar[0]['price_sales'];?>

                              <span class="h3 block m-t-xs text-danger"><?php echo number_format($sum, 2, ',', '.'); ?> $</span>
                              <small class="text-muted text-u-c">Pendiente en $</small>
                            </span>
                          </a>
                        </div>
                        <div class="col-md-3 b-b b-r">
                          <a href="#" class="block padder-v hover">
                            <span class="i-s i-s-2x pull-left m-r-sm">
                              <i class="i i-hexagon2 i-s-base text-danger-lt hover-rotate"></i>
                              <i class="fa fa-money i-sm text-white"></i>
                            </span>
                            <span class="clear">
                              <?php
                              $arrSum = GetRecords("select sum(amount_transfer) as total_trans_bss from transaction where stat = 1");

                              $sum = $arrSum[0]['total_trans_bss'];?>

                              <span class="h3 block m-t-xs text-danger"><?php echo number_format($sum, 2, ',', '.'); ?> Bs</span>
                              <small class="text-muted text-u-c">Pendiente en BsS</small>
                            </span>
                          </a>
                        </div>
                        <div class="col-md-3 b-b">
                          <a href="#" class="block padder-v hover">
                            <span class="i-s i-s-2x pull-left m-r-sm">
                              <i class="i i-hexagon2 i-s-base text-primary hover-rotate"></i>
                              <i class="i i-users2 i-sm text-white"></i>
                            </span>
                            <span class="clear">
                              <?php $arrCus = GetRecords("SELECT count(*) as users from users where stat = 1");
                                    $user = $arrCus[0]['users'];?>
                              <span class="h3 block m-t-xs text-primary"><?php echo $user; ?></span>
                              <small class="text-muted text-u-c">Total Usuarios</small>
                            </span>
                          </a>
                        </div>
                        <div class="col-md-3 b-b b-r">
                          <a href="#" class="block padder-v hover">
                            <span class="i-s i-s-2x pull-left m-r-sm">
                              <i class="i i-hexagon2 i-s-base text-primary hover-rotate"></i>
                              <i class="i i-users2 i-sm text-white"></i>
                            </span>
                            <span class="clear">
                              <?php $arrCus = GetRecords("SELECT count(*) as con_customer from customer where stat = 1");

                                    $cust = $arrCus[0]['con_customer'];?>
                              <span class="h3 block m-t-xs text-primary"><?php echo $cust; ?></span>
                              <small class="text-muted text-u-c">Total Clientes</small>
                            </span>
                          </a>
                        </div>
                        <div class="col-md-3 b-b b-r">
                          <a href="#" class="block padder-v hover">
                            <span class="i-s i-s-2x pull-left m-r-sm">
                              <i class="i i-hexagon2 i-s-base text-warning hover-rotate"></i>
                              <i class="glyphicon glyphicon-warning-sign i-sm text-white"></i>
                            </span>
                            <span class="clear">
                              <?php $arrCon = GetRecords("select count(*) as total_trans from transaction where stat = 2");

                                    $con = $arrCon[0]['total_trans'];?>
                              <span class="h3 block m-t-xs text-warning"><?php echo $con; ?> <span class="text-sm"></span></span>
                              <small class="text-muted text-u-c">Transacciones Abonadas</small>
                            </span>
                          </a>
                        </div>
                        <div class="col-md-3 b-b b-r">
                          <a href="#" class="block padder-v hover">
                            <span class="i-s i-s-2x pull-left m-r-sm">
                              <i class="i i-hexagon2 i-s-base text-warning hover-rotate"></i>
                              <i class="glyphicon glyphicon-warning-sign i-sm text-white"></i>
                            </span>
                            <span class="clear">
                              <?php $arrCon = GetRecords("select sum(amount_transfer) as total_trans_bss from transaction where stat = 2");

                                    $con = $arrCon[0]['total_trans_bss']/$precio_actual_dolar[0]['price_sales'];?>
                              <span class="h3 block m-t-xs text-warning"><?php echo number_format($con, 2, ',', '.'); ?> <span class="text-sm"></span></span>
                              <small class="text-muted text-u-c">Total Abonadas $</small>
                            </span>
                          </a>
                        </div>
                        <div class="col-md-3 b-b b-r">
                          <a href="#" class="block padder-v hover">
                            <span class="i-s i-s-2x pull-left m-r-sm">
                              <i class="i i-hexagon2 i-s-base text-warning hover-rotate"></i>
                              <i class="glyphicon glyphicon-warning-sign i-sm text-white"></i>
                            </span>
                            <span class="clear">
                              <?php $arrCon = GetRecords("select sum(amount_transfer) as total_trans_bss from transaction where stat = 2");

                                    $con = $arrCon[0]['total_trans_bss'];?>
                              <span class="h3 block m-t-xs text-warning"><?php echo number_format($con, 2, ',', '.'); ?> <span class="text-sm"></span></span>
                              <small class="text-muted text-u-c">Total Abonadas BsS</small>
                            </span>
                          </a>
                        </div>
                        <div class="col-md-3 b-b b-r">
                          <a href="#" class="block padder-v hover">
                            <span class="i-s i-s-2x pull-left m-r-sm">
                              <i class="i i-hexagon2 i-s-base text-warning hover-rotate"></i>
                              <i class="glyphicon glyphicon-warning-sign i-sm text-white"></i>
                            </span>
                            <span class="clear">
                              <?php $arrCon = GetRecords("select count(*) as hoy from transaction where time_data >= CURDATE()");
                                    $con = $arrCon[0]['hoy'];?>
                              <span class="h3 block m-t-xs text-warning"><?php echo $con; ?> <span class="text-sm"></span></span>
                              <small class="text-muted text-u-c">Total Transacciones Hoy</small>
                            </span>
                          </a>
                        </div>
                        <div class="col-md-3 b-b b-r">
                          <a href="#" class="block padder-v hover">
                            <span class="i-s i-s-2x pull-left m-r-sm">
                              <i class="i i-hexagon2 i-s-base text-primary hover-rotate"></i>
                              <i class="glyphicon glyphicon-globe i-sm text-white"></i>
                            </span>
                            <span class="clear">
                              <?php $arrCon = GetRecords("SELECT count(*) as refered from users where stat = 2 and referred <> 0");

                                    $refered = $arrCon[0]['refered'];?>
                              <span class="h3 block m-t-xs text-primary"><?php echo $refered; ?> <span class="text-sm"></span></span>
                              <small class="text-muted text-u-c">Referidos</small>
                            </span>
                          </a>
                        </div>
                        <div class="col-md-3 b-b b-r">
                          <a href="#" class="block padder-v hover">
                            <span class="i-s i-s-2x pull-left m-r-sm">
                              <i class="i i-hexagon2 i-s-base text-primary hover-rotate"></i>
                              <i class="glyphicon glyphicon-globe i-sm text-white"></i>
                            </span>
                            <span class="clear">
                              <?php $arrCon = GetRecords("select sum(amount_pay) as pago_usuario from average_users where id_user not in(1,2)");

                                    $pago_usuario = $arrCon[0]['pago_usuario'];?>
                              <span class="h3 block m-t-xs text-primary"><?php echo number_format($pago_usuario, 2, ',', '.'); ?> <span class="text-sm"></span></span>
                              <small class="text-muted text-u-c">Pentiente Pago a Usuario</small>
                            </span>
                          </a>
                        </div>
                        <div class="col-md-3 b-b b-r">
                          <a href="#" class="block padder-v hover">
                            <span class="i-s i-s-2x pull-left m-r-sm">
                              <i class="i i-hexagon2 i-s-base text-primary hover-rotate"></i>
                              <i class="glyphicon glyphicon-globe i-sm text-white"></i>
                            </span>
                            <span class="clear">
                              <?php $arrCon = GetRecords("select sum(amount_accumulated) as pago_central from average_users where id_user not in(1,2)");

                                    $pago_central = $arrCon[0]['pago_central'];?>
                              <span class="h3 block m-t-xs text-primary"><?php echo number_format($pago_central, 2, ',', '.'); ?> <span class="text-sm"></span></span>
                              <small class="text-muted text-u-c">Pendiente Pago a Central</small>
                            </span>
                          </a>
                        </div>
                        <div class="col-md-3 b-b b-r">
                          <a href="#" class="block padder-v hover">
                            <span class="i-s i-s-2x pull-left m-r-sm">
                              <i class="i i-hexagon2 i-s-base text-primary hover-rotate"></i>
                              <i class="glyphicon glyphicon-globe i-sm text-white"></i>
                            </span>
                            <span class="clear">
                              <?php $arrCon = GetRecords("select sum(amount_pay) as pago_sistema from average_users where id_user in(1)");

                                    $pago_sistema = $arrCon[0]['pago_sistema'];?>
                              <span class="h3 block m-t-xs text-primary"><?php echo number_format($pago_sistema, 2, ',', '.'); ?> <span class="text-sm"></span></span>
                              <small class="text-muted text-u-c">Pendiente Pago a Sistema</small>
                            </span>
                          </a>
                        </div>
                        <div class="col-md-3 b-b b-r">
                          <a href="#" class="block padder-v hover">
                            <span class="i-s i-s-2x pull-left m-r-sm">
                              <i class="i i-hexagon2 i-s-base text-primary hover-rotate"></i>
                              <i class="glyphicon glyphicon-globe i-sm text-white"></i>
                            </span>
                            <span class="clear">
                              <?php $arrCon = GetRecords("select sum(amount_pay) as ganancia_central from average_users where id_user in(2)");

                                    $ganancia_central = $arrCon[0]['ganancia_central'];?>
                              <span class="h3 block m-t-xs text-primary"><?php echo number_format($ganancia_central, 2, ',', '.'); ?> <span class="text-sm"></span></span>
                              <small class="text-muted text-u-c">Ganancia Central</small>
                            </span>
                          </a>
                        </div>

                      </div>
                      <!--
                      <form method="post" action="" novalidate>
                        <div class="row wrapper">
                          <div class="col-sm-2 m-b-xs">
                            <div class="input-group">
                              <input type="text" autocomplete="off" class="input-s input-sm form-control" value="<?php if(isset($name)){ echo $name;}?>" name="name" placeholder="Nombre">
                            </div>
                          </div>
                          <div class="col-sm-2 m-b-xs">
                            <div class="input-group">
                              <input type="text" autocomplete="off" class="input-s input-sm form-control" value="<?php if(isset($lname)){ echo $lname;}?>" name="lname" placeholder="Apellido">
                            </div>
                          </div>
                          <div class="col-sm-2 m-b-xs">
                            <div class="input-group">
                              <input type="text" autocomplete="off" class="input-sm input-s datepicker-input form-control datepicker" id="datepicker" value="<?php if(isset($date_from)){ echo $date_from;}?>" name="date_from" placeholder="Fecha Desde">
                            </div>
                          </div>
                          <div class="col-sm-2 m-b-xs">
                            <div class="input-group">
                              <input type="text" autocomplete="off" class="input-sm input-s datepicker-input form-control datepicker" id="datepicker1" value="<?php if(isset($date_to)){ echo $date_to;}?>" name="date_to" placeholder="Fecha Hasta">
                            </div>
                          </div>
                          <div class="col-sm-3 m-b-xs">
                            <div class="input-group">
                              <span class="input-group-btn padder "><button type="submit" class="btn btn-sm btn-default">Buscar</button></span>
                            </div>
                          </div>
                        </div>
                      </form>-->

                    </div>
                    <hr>
                    <script type="text/javascript">
                  $(function () {
                     $('#container').highcharts({
                         chart: {
                             type: 'column'
                         },
                         title: {
                             text: 'Resumen de Transacciones Por Pais'
                         },
                         subtitle: {
                             text: ''
                         },
                         xAxis: {
                             type: 'category',
                             labels: {
                                 rotation: -45,
                                 style: {
                                     fontSize: '13px',
                                     fontFamily: 'Verdana, sans-serif'
                                 }
                             }
                         },
                         yAxis: {
                             min: 0,
                             title: {
                                 text: 'Monto Generado Por Pais'
                             }
                         },
                         legend: {
                             enabled: false
                         },
                         tooltip: {
                             pointFormat: 'Monto Generado : <b>{point.y:.1f} </b>'
                         },
                         series: [{
                             name: 'Population',
                             <?php $paises = GetRecords("select c.name,
                                                                count(*) as cantidad,
                                                                sum(amount_transfer) as bss
                                                                from transaction t inner join users u on t.id_user_register = u.id
                                                                                   inner join country c on u.location = c.id
                                                                                   where
                                                                                   t.stat not in(4,3)
                                                                                   group by c.name"); ?>
                             data: [
                               <?php foreach($paises as $key => $value): ?>
                                      ['<?php echo $value['name']; ?>', <?php echo number_format($value['bss']/$precio_actual_dolar[0]['price_sales'], 2, ',', '.'); ?>],
                               <?php endforeach; ?>
                                      ['', 0]
                             ],
                             dataLabels: {
                                 enabled: true,
                                 rotation: -90,
                                 color: '#FFFFFF',
                                 align: 'right',
                                 format: '{point.y:.1f}', // one decimal
                                 y: 10, // 10 pixels down from the top
                                 style: {
                                     fontSize: '13px',
                                     fontFamily: 'Verdana, sans-serif'
                                 }
                             }
                         }]
                     });
                  });
                    </script>

                    <script type="text/javascript">
                    /*$(function () {
                    $('#container5').highcharts({
                        title: {
                            text: 'Linea de tiempo por año',
                            x: -20 //center
                        },
                        subtitle: {
                            text: 'Planet Online',
                            x: -20
                        },
                        xAxis: {
                            categories: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun',
                                'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic']
                        },
                        yAxis: {
                            title: {
                                text: 'Cantidad'
                            },
                            plotLines: [{
                                value: 0,
                                width: 1,
                                color: '#808080'
                            }]
                        },
                        tooltip: {
                            valueSuffix: ''
                        },
                        legend: {
                            layout: 'vertical',
                            align: 'right',
                            verticalAlign: 'middle',
                            borderWidth: 0
                        },
                        series: [{
                            name: 'Transacciones ',
                            <?php /*$ingresos = GetRecords("select
                                                          (select count(*) from crm_entry where MONTH(date_form) = 01 ) as ene,
                                                          (select count(*) from crm_entry where MONTH(date_form) = 02 ) as feb,
                                                          (select count(*) from crm_entry where MONTH(date_form) = 03 ) as mar,
                                                          (select count(*) from crm_entry where MONTH(date_form) = 04 ) as abr,
                                                          (select count(*) from crm_entry where MONTH(date_form) = 05 ) as may,
                                                          (select count(*) from crm_entry where MONTH(date_form) = 06 ) as jun,
                                                          (select count(*) from crm_entry where MONTH(date_form) = 07 ) as jul,
                                                          (select count(*) from crm_entry where MONTH(date_form) = 08 ) as ago,
                                                          (select count(*) from crm_entry where MONTH(date_form) = 09 ) as sep,
                                                          (select count(*) from crm_entry where MONTH(date_form) = 010 ) as oct,
                                                          (select count(*) from crm_entry where MONTH(date_form) = 011 ) as nov,
                                                          (select count(*) from crm_entry where MONTH(date_form) = 012 ) as dic ");*/ ?>

                            <?php /*foreach($ingresos as $key => $value){  ?>
                            data: [30, 50, 40,
                            90, 100, 111,
                            100, 60, 200,
                            70, 80, 200]
                            <?php /*}*/ ?>
                        }]
                    });
                    });*/ ?>
                    </script>
                    <script src="po_grafict/js/highcharts.js"></script>
                    <script src="po_grafict/js/modules/exporting.js"></script>
                    <div id="container" style="min-width: 300px; height: 400px; margin: 0 auto;"></div>
                    <div id="container5" style="min-width: 300px; height: 400px; margin: 0 auto;"></div>
                  </div>
                </div>
                 <?php ?>
               </div>
             </section>
           </section>
       </section>
   </section>
<?php  include("footer.php"); ?>

<?php
    ob_start();
    session_start();
    $pay="class='active'";
    $historychangepay="class='active'";

    include("include/config.php");
    include("include/defs.php");
    include("header.php");

    if(!isset($_SESSION['USER_ID']) || $_SESSION['USER_ROLE'] != 1 && $_SESSION['USER_ROLE'] != 4)
     {
          header("Location: index.php");
          exit;
     }

     $where = "where (1=1)";

      $arrUser = GetRecords("select 
                                    sum(mb.amount) as total_bs, 
                                    (sum(mb.amount)/mb.price_for_dollar) as total_interno, 
                                    (sum(mb.amount)/mb.price_sales) as total_precio_venta,
                                    (sum(mb.amount)/mb.price_sales) - (sum(mb.amount)/mb.price_for_dollar) as ganancia_total,
                                    (((sum(mb.amount)/mb.price_sales) - (sum(mb.amount)/mb.price_for_dollar)) * 60 / 100) as ganancia_centra, 
                                    (((sum(mb.amount)/mb.price_sales) - (sum(mb.amount)/mb.price_for_dollar)) * 20 / 100) as ganancia_usuario, 
                                    (((sum(mb.amount)/mb.price_sales) - (sum(mb.amount)/mb.price_for_dollar)) * 20 / 100) as ganancia_sistemas, 
                                    u.name, 
                                    u.last_name, 
                                    u.credit, 
                                    mb.price_for_dollar as precio_compra, 
                                    mb.price_sales as precio_venta
                                from mov_bank mb inner join users u on mb.id_user = u.id
                                where 
                                mb.stat = 1
                                group by 
                                    u.name, 
                                    u.last_name, 
                                    u.credit, 
                                    mb.price_for_dollar, 
                                    mb.price_sales");

?>
	<section id="content">
          <section class="vbox">
            <section class="scrollable padder">
              <section class="panel panel-default">
                <header class="panel-heading">
                  <span class="h4">Ver Transacciones</span>
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
                              <th>USUARIO</th>
                              <th>MONTO</th>
                              <th>MONTO INTERNO</th>
                              <th>MONTO DE VENTA</th>
                              <th>GANANCIA</th>
                              <th>G. CENTRAL</th>
                              <th>G. USUARIO</th>
                              <th>G. SISTEMA</th>
                              <th>PRECIO $ COMPRA</th>
                              <th>PRECIO $ VENTA</th>
                            </tr>
                          </thead>
                          <tbody>
                          <?PHP

                            $total_bs = 0;
                            $total_interno = 0;
                            $total_venta = 0;
                            $total_ganancia_total = 0;
                            $total_ganancia_central = 0;
                            $total_ganancia_user = 0;
                            $total_ganancia_sistemas = 0;

                            foreach ($arrUser as $key => $value) { ?>
                          <tr>
                              <td class="tbdata"> <?php echo $value['name'].' '.$value['last_name']?> </td>
                              <td class="tbdata"> <?php echo number_format($value['total_bs'], 2, ',', '.')?> BsS</td>
                              <td class="tbdata"> <?php echo number_format($value['total_interno'], 2, ',', '.')?> $</td>
                              <td class="tbdata"> <?php echo number_format($value['total_precio_venta'], 2, ',', '.')?> $</td>
                              <td class="tbdata"> <?php echo number_format($value['ganancia_total'], 2, ',', '.')?> $</td>
                              <td class="tbdata"> <?php echo number_format($value['ganancia_centra'], 2, ',', '.')?> $</td>
                              <td class="tbdata"> <?php echo number_format($value['ganancia_usuario'], 2, ',', '.')?> $</td>
                              <td class="tbdata"> <?php echo number_format($value['ganancia_sistemas'], 2, ',', '.')?> $</td>
                              <td class="tbdata"> <?php echo number_format($value['precio_compra'], 2, ',', '.')?> BsS</td>
                              <td class="tbdata"> <?php echo number_format($value['precio_venta'], 2, ',', '.')?> BsS</td>
                          </tr>
                          <?php

                                    $total_bs += $value['total_bs'];
                                    $total_interno += $value['total_interno'];
                                    $total_venta += $value['total_precio_venta'];
                                    $total_ganancia_total += $value['ganancia_total'];
                                    $total_ganancia_central += $value['ganancia_centra'];
                                    $total_ganancia_user += $value['ganancia_usuario'];
                                    $total_ganancia_sistemas += $value['ganancia_sistemas'];
                            
                          }
                          ?>
                          </tbody>
                          <tr>
                              <td class="tbdata"><b>Totales:</b>  </td>
                              <td class="tbdata"> <b><?php echo number_format($total_bs, 2, ',', '.')?> BsS</b></td>
                              <td class="tbdata"> <b><?php echo number_format($total_interno, 2, ',', '.')?> $</b></td>
                              <td class="tbdata"> <b><?php echo number_format($total_venta, 2, ',', '.')?> $</b></td>
                              <td class="tbdata"> <b><?php echo number_format($total_ganancia_total, 2, ',', '.')?> $</b></td>
                              <td class="tbdata"> <b><?php echo number_format($total_ganancia_central, 2, ',', '.')?> $</b></td>
                              <td class="tbdata"> <b><?php echo number_format($total_ganancia_user, 2, ',', '.')?> $</b></td>
                              <td class="tbdata"> <b><?php echo number_format($total_ganancia_sistemas, 2, ',', '.')?> $</b></td>
                              <td class="tbdata"> </td>
                              <td class="tbdata"> </td>
                          </tr>
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

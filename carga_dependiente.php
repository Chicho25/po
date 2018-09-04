<?php 

include("include/config.php");
include("include/defs.php");

    if (isset($_POST['elegido'])) {

        $cuentas = GetRecords("SELECT * FROM acount_bank 
                               WHERE 
                               id_bank = '".$_POST['elegido']."'");
     echo '<option value="">Seleccionar</option>';
    foreach ($cuentas as $key => $value) {
     echo '<option value="'.$value['id'].'">'.$value['number_acount'].' // '.$value['descriptions'].'</option>';
    }
}    

?> 
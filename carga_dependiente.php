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

if (isset($_POST['customer'])) {

    $cuentas = GetRecords("SELECT
                            ac.id,
                            ac.number_acount,
                            ac.descriptions,
                            bc.name
                          FROM
                            acount_customer ac inner join bank_customer bc on ac.id_bank_customer = bc.id
                           WHERE
                           ac.id_customer = '".$_POST['customer']."'
                           and
                           ac.stat = 1");
    echo '<option value="">Seleccionar</option>';
    foreach ($cuentas as $key => $value) {
    echo '<option value="'.$value['id'].'">'.$value['name'].' / '.$value['descriptions'].' / '.$value['number_acount'].'</option>';
    }
}

if (isset($_POST['type_coin'])) {

    $cuentas = GetRecords("select
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
                            type_coin tc
                            where
                            id = '".$_POST['type_coin']."'");

    foreach ($cuentas as $key => $value) {
    echo '<input type="hidden" id="taza_actual" name="taza_actual" value="'.$value['value_bolivar'].'">';
    }
}

?>

<?php
include("include/config.php");
include("include/defs.php");

$arrUser = GetRecords("SELECT users.*,
                              type_user.name as name_type_user,
                              country.name as LOCATION
                       from users
                       inner join type_user on type_user.id = users.id_roll_user
                       inner join country on country.id = users.location
                       order by users.id");

/*$conexion = mysqli_connect("localhost", "root", "", "bt");
$sql = $conexion -> query("select * from users ");

$array = array();

foreach ($sql as $key => $value) {
      /*$array[] = $value; tradicional*/
      /* framework directo en el json */
      /*$nombre = $value["user"];
}
echo $nombre;*/

echo json_encode($arrUser); ?>

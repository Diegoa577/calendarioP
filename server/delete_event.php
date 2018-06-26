<?php
require('lib.php');

$con = new ConectorBD();

$response['conexion'] = $con->initConexion('evaluacion');

if ($response['conexion']=='OK') {


$datos= $_POST['id'];

  if ($con->eliminarRegistro('eventos', "id=$datos")) {
    $response['eliminar']='OK';
  }else $response['eliminar']='No se pudo eliminar';

}

$phpArray = array ($response['conexion'], $response['eliminar']);
echo json_encode($phpArray);

$con->cerrarConexion();



 ?>

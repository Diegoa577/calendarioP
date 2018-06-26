<?php
require('lib.php');

$con = new ConectorBD();

$response['conexion'] = $con->initConexion('evaluacion');

if ($response['conexion']=='OK') {

  $id= $_POST['id'];
  $datos['start'] = "'".$_POST['start_date']."'";
  $datos['end'] = "'".$_POST['end_date']."'";
  $datos['start_hour'] = "'".$_POST['start_hour']."'";
  $datos['end_hour'] = "'".$_POST['end_hour']."'";



  $response['valor']= "'".$_POST['start_date']."'";
  if ($con->actualizarRegistro('eventos', $datos,"id=$id")) {
    $response['actualizar']='OK';
  }else $response['actualizar']="No se pudo actualizar";

}

$phpArray = array ($response['conexion'], $response['actualizar'],$response['valor']);
echo json_encode($phpArray);

$con->cerrarConexion();



 ?>

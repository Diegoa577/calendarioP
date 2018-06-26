<?php
require('lib.php');

$con = new ConectorBD();

$response['conexion'] = $con->initConexion('evaluacion');

if ($response['conexion']=='OK') {
  $resultado_consulta = $con->consultar(['usuarios'],
  ['email', 'pass'], 'WHERE email="'.$_POST['user'].'"');

  if ($resultado_consulta->num_rows != 0) {
    $fila = $resultado_consulta->fetch_assoc();
    if (password_verify($_POST['password'], $fila['pass'])) {
    $response['acceso'] = 'concedido';
    session_start();
    $_SESSION['username']=$fila['email'];
  }else $response['acceso'] = 'rechazado';
}else $response['acceso'] = 'rechazados';
}
$phpArray = array ($response['conexion'], $response['acceso']);
echo json_encode($phpArray);

$con->cerrarConexion();



 ?>

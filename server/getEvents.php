<?php
require('lib.php');
session_start();

if (isset($_SESSION['username'])) {

$con = new ConectorBD();

$response['msg'] = $con->initConexion('evaluacion');

if ($response['msg']=='OK') {

  $resultado = $con->consultar(['eventos'], ['*'], 'WHERE email="'.$_SESSION['username'].'"');

  if ($resultado->num_rows != 0) {
      $i=0;
      while ($fila = $resultado->fetch_assoc()) {
        $response['eventos'][$i]['id']=$fila['id'];
        $response['eventos'][$i]['title']=$fila['title'];
        $response['eventos'][$i]['start']=$fila['start'];
        $response['eventos'][$i]['end']=$fila['end'];
        $response['eventos'][$i]['allDay']=$fila['allDay'];
        $response['eventos'][$i]['start_hour']=$fila['start_hour'];
        $response['eventos'][$i]['end_hour']=$fila['end_hour'];
        $i++;
  };
} else {
$response['eventos'] = 'rechazado';
};
};
}else {
  $response['msg'] = "No se ha iniciado una sesión";
};
$phpArray = array ($response['msg'], $response['eventos']);
echo json_encode($phpArray);

$con->cerrarConexion();




 ?>

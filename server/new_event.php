<?php
require('lib.php');
session_start();

if (isset($_SESSION['username'])) {
$con = new ConectorBD();

$response['msg'] = $con->initConexion('evaluacion');

if ($response['msg']=='OK') {

    $datos['email'] = $_SESSION['username'];
    $datos['title'] = $_POST['titulo'];
    $datos['start'] = $_POST['start_date'];
    $datos['end'] = $_POST['end_date'];
    $datos['allDay'] = $_POST['allDay'];
    $datos['start_hour'] = $_POST['start_hour'];
    $datos['end_hour'] = $_POST['end_hour'];



  if ($con->insertData('eventos', $datos)) {
    $response['agregar']='OK';
  } else {
    $response['agregar']='No se pudo agregar';
  };
};

};
$phpArray = array ($response['msg'], $response['agregar']);
echo json_encode($phpArray);

$con->cerrarConexion();



 ?>

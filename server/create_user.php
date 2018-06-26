<?php
require('lib.php');

$con = new ConectorBD();

if ($con->initConexion('evaluacion')=='OK') {
  $i = 0;
do {
  if ($i == 0) {
    $datos['email'] = "prueba4@example.com";
    $datos['pass'] = password_hash("123456",PASSWORD_DEFAULT);
    $datos['nombre'] = "Daniel";
    $datos['apellido'] = "Js";
    $datos['fecha'] = date("1982-06-03");
    $i++;
  } else if ($i == 1) {
    $datos['email'] = "prueba1@example.com";
    $datos['pass'] = password_hash("123456",PASSWORD_DEFAULT);
    $datos['nombre'] = "Daniela";
    $datos['apellido'] = "Js";
    $datos['fecha'] = date("1992-06-03");
    $i++;
  } else if ($i == 2) {
    $datos['email'] = "prueba2@example.com";
    $datos['pass'] = password_hash("123456789",PASSWORD_DEFAULT);
    $datos['nombre'] = "David";
    $datos['apellido'] = "Js";
    $datos['fecha'] = date("2012-06-03");
    $i++;
  };


  if ($con->insertData('usuarios', $datos)) {
    echo "Se insertaron los datos correctamente";
  }else echo "Se ha producido un error en la inserción";
} while ($i <= 2);


  $con->cerrarConexion();

}else {
  echo "Se presentó un error en la conexión";
}




 ?>

<?php

class ConectorBD
{
  private $host = 'localhost';
  private $user = 'nextu';
  private $password = '123456';
  private $conexion;

  function initConexion($nombre_db){
    $this->conexion = new mysqli($this->host, $this->user, $this->password, $nombre_db);
    if ($this->conexion->connect_error) {
      return "Error:" . $this->conexion->connect_error;
    }else {
      return "OK";
    }
  }

  function newTable($nombre_tbl, $campos){
    $sql = 'CREATE TABLE '.$nombre_tbl.' (';
    $length_array = count($campos);
    $i = 1;
    foreach ($campos as $key => $value) {
      $sql .= $key.' '.$value;
      if ($i!= $length_array) {
        $sql .= ', ';
      }else {
        $sql .= ');';
      }
      $i++;
    }
    return $this->ejecutarQuery($sql);
  }

  function ejecutarQuery($query){
    return $this->conexion->query($query);
  }

  function cerrarConexion(){
    $this->conexion->close();
  }

  function insertData($tabla, $data){
    $sql = 'INSERT INTO '.$tabla.' (';
    $i = 1;
    foreach ($data as $key => $value) {
      $sql .= $key;
      if ($i<count($data)) {
        $sql .= ', ';
      }else $sql .= ')';
      $i++;
    }
    //imprime valoes del elemento asociativo
    $sql .= ' VALUES (';
    $i = 1;
    foreach ($data as $key => $value) {
      $sql .= "'".$value."'";
      if ($i<count($data)) {
        $sql .= ', ';
      }else $sql .= ');';
      $i++;
    }

    return $this->ejecutarQuery($sql);

  }
  function getConexion(){
    return $this->conexion;
  }

  function consultar($tablas, $campos, $condicion = ""){
    $sql = "SELECT ";
    //recorre el alegro
    $hola =  array_keys($campos);
    $ultima_key = end($hola); //linea error
    foreach ($campos as $key => $value) {
      $sql .= $value;
      //si es diferente de la ultima
      if ($key!=$ultima_key) {
        $sql.=", ";
      }else $sql .=" FROM ";
    }
//para el arrelgo tablas
$hola1= array_keys($tablas);
    $ultima_key = end($hola1);  //linea error
    foreach ($tablas as $key => $value) {
      $sql .= $value;
      if ($key!=$ultima_key) {
        $sql.=", ";
      }else $sql .= " ";
    }
//si hay condicion
    if ($condicion == "") {
      $sql .= ";";
    }else {
      $sql .= $condicion.";";
    }

    return $this->ejecutarQuery($sql);
  }

  function eliminarRegistro($tabla, $condicion){
    $sql = 'DELETE FROM '.$tabla. ' WHERE '.$condicion.';';

  return $this->ejecutarQuery($sql);
  }

  function actualizarRegistro($tabla, $data, $condicion){
    $sql = 'UPDATE '.$tabla.' SET ';
    $i=1;
    foreach ($data as $key => $value) {
      $sql .= $key.'='.$value;
      if ($i<sizeof($data)) {
        $sql .= ', ';
      }else $sql .= ' WHERE '.$condicion.';';
      $i++;
    }
    return $this->ejecutarQuery($sql);
  }

}
 ?>

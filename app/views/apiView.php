<?php

class apiView {

    public function response($data, $status = 200) { //data es mi objeto json
        header("Content-Type: application/json");
        header("HTTP/1.1 " . $status . " " . $this->_requestStatus($status));//llama al metodo de abajo
       // convierte los datos a un formato json
        echo json_encode($data);
    }

    private function _requestStatus($code){
        $status = array(
          200 => "OK",//ESTE
          201 => "Created", //ESTE
          400 => "Bad request",//ESTE
          401 => "Unauthorized",//PARA EL TOKEN
          404 => "Not found",//ESTE
        );
        return (isset($status[$code])) ? $status[$code] : $status[500]; //esto es un if
      }
  
}

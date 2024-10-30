<?php

    $descripcion  = $DATOS['descripcion'] ?? '';

    if (count(array_filter([$descripcion])) < 1) {
        $estatusRespuesta = 400; 
        $mensajeRespuesta = "Datos incompletos";
    } else {

        $sql = "SELECT descripcion FROM servicios WHERE descripcion = trim('$descripcion') LIMIT 1";
        
        $VERIFICAR = SQL($sql);

        if(CAN_REG($VERIFICAR) > 0) {
            $estatusRespuesta = 409; 
            $mensajeRespuesta = "Este servicio ya existe";
        } else {


            $sql = "INSERT INTO servicios SET descripcion = '$descripcion'";
            
            $INSERTAR = SQL($sql);

            if ($INSERTAR > 0) {
                $estatusRespuesta = 201; 

                $datosRespuesta = [
                    "id" => $INSERTAR, // $INSERTAR contiene el id del ultimo registro isertado (lastInsertId)
                    "descripcion" => $descripcion,
                    "mensaje" => "Servicio creado exitosamente"
                ];
                $mensajeRespuesta = "Servicio creado exitosamente";
            } else {
                $estatusRespuesta = 500; 
                $mensajeRespuesta = "Error al crear el servicio";
            }
        }
    }
?>

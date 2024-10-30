<?php
    $condicion = ($idRegistro > 0) ? " AND id_usuario = $idRegistro" : '';

    $sql = "SELECT id_usuario, nombre, tipo, correo FROM usuarios WHERE 1 = 1 
                                                                    AND tipo = 'cliente' $condicion";
        
    $USUARIOS = SQL($sql);

    if ($USUARIOS > 0) {
        if(CAN_REG($USUARIOS) > 0) {
            $datosRespuesta = $USUARIOS;
        } else {
            $mensajeRespuesta = "Usuario no encontrado";
        }
    } else {
        $mensajeRespuesta = "Error al consultar los usuarios";
    }
    
?>

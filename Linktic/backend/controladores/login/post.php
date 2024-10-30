<?php

    $correo     = $DATOS['correo'] ?? '';
    $contrasena = $DATOS['contrasena'] ?? '';

    if (count(array_filter([$contrasena, $correo])) < 2) {
        $mensajeRespuesta = "Datos incompletos";
    } else {
        

        $sql = "SELECT id_usuario, nombre, tipo, contrasena, correo FROM usuarios WHERE correo = trim('$correo') LIMIT 1";
        
        $USUARIO = SQL($sql);

        if(CAN_REG($USUARIO) > 0) {
            if (password_verify($contrasena, $USUARIO[0] -> contrasena)) {

                
                @session_start();
                $_SESSION['idUsuario']      = $USUARIO[0] -> id_usuario;
                $_SESSION['tipoUsuario']    = $USUARIO[0] -> tipo;
                $_SESSION['correoUsuario']  = $USUARIO[0] -> correo;
                $_SESSION['nombreUsuario']  = $USUARIO[0] -> nombre;
                $mensajeRespuesta = "Sesión iniciada";
                $datosRespuesta = [
                    [
                        "id_usuario" => $_SESSION['idUsuario'], 
                        "nombre" => $_SESSION['nombreUsuario'],
                        "tipo" => $_SESSION['tipoUsuario'],
                        "correo" => $_SESSION['correoUsuario'],
                        "mensaje" => "Sesión iniciada"
                    ]
                ];
            } else {
                $mensajeRespuesta = "Correo o contraseña incorrectos";
            }
        } else {
            $mensajeRespuesta = "Correo o contraseña incorrectos";
        }
    }
?>

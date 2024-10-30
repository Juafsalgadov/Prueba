<?php

    if($_SESSION['tipoUsuario'] == 'administrador') { 
        $idUsuario       = $DATOS['idUsuario'] ?? '';
        $idAdministrador = $_SESSION['idUsuario'];
    } else {
        $idUsuario       = $_SESSION['idUsuario'];
        $idAdministrador = 'NULL';
    }
    
    $fecha       = $DATOS['fecha'] ?? '';
    $idServicio  = $DATOS['idServicio'] ?? '';

    if (count(array_filter([$fecha, $idServicio, $idUsuario])) < 3) {
        $mensajeRespuesta = "Datos incompletos";
    } else {

        $sql = "SELECT id_servicio FROM detalles_reserva 
                                INNER JOIN reservas AS R USING(id_reserva)
                                        WHERE id_servicio = $idServicio 
                                            AND fecha_inicio = '$fecha' 
                                            AND R.estado = 'pendiente' LIMIT 1";
        
        $VERIFICAR = SQL($sql);

        if(CAN_REG($VERIFICAR) > 0) {
            $mensajeRespuesta = "Este servicio ya está reservado para el dia correspondiente";
        } else {
            $sql = "SELECT 
                        EXISTS(SELECT 1 FROM usuarios WHERE id_usuario = $idUsuario AND tipo = 'cliente') AS usuario,
                        EXISTS(SELECT 1 FROM servicios WHERE id_servicio = $idServicio) AS servicio";
            $VERIFICAR = SQL($sql);
            $usuarioExiste  = $VERIFICAR[0] -> usuario;
            $servicioExiste = $VERIFICAR[0] -> servicio;

            if($usuarioExiste == 0) {

                $mensajeRespuesta = "El cliente a asignar no se encuentra registrado";

            } elseif($servicioExiste == 0) {

                $mensajeRespuesta = "El servicio a asignar no se encuentra registrado";

            } else {

                $sql = "INSERT INTO reservas 
                                    SET id_usuario = '$idUsuario', 
                                        id_administrador = '$idAdministrador', 
                                        fecha_inicio = '$fecha'";
                
                $RESERVA = SQL($sql);

                if ($RESERVA > 0) {

                    $idReserva = $RESERVA;

                    $sql = "INSERT INTO detalles_reserva 
                                    SET id_reserva = '$idReserva', 
                                        id_servicio = '$idServicio'";
                
                    $DETALLES_RESERVA = SQL($sql);
                    $detalles = [
                        "id_detalle_reserva" => $DETALLES_RESERVA,
                        "id_reserva" => $idReserva,
                        "id_servicio" => $idServicio
                    ];

                    $mensajeRespuesta = [
                        "id_reserva" => $idReserva,
                        "id_usuario" => $idUsuario,
                        "id_administrador" => $idAdministrador,
                        "fecha_inicio" => $fecha,
                        "estado" => 'pendiente',
                        "mensaje" => "Reserva creada exitosamente",
                        "detalles_reserva" => $detalles
                    ];
                } else {
                    $mensajeRespuesta = "Error";
                }
            }
        }
    }
?>

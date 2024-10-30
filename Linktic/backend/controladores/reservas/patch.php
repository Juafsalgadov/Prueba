<?php

    $idReserva      = $idRegistro;
    $nuevoEstado    = $DATOS['estado'] ?? '';
    $idUsuario      = $_SESSION['idUsuario'];

    if(in_array($nuevoEstado, array('cancelada', 'ejecutada'))) {

        $relacionUsuario = ($_SESSION['tipoUsuario'] == 'administrador') ? '' : " AND id_usuario = $idUsuario";

        if (count(array_filter([$idReserva, $nuevoEstado])) < 2) {
            $mensajeRespuesta = "Datos incompletos";
        } else {
            $sql = "SELECT estado FROM reservas WHERE id_reserva = $idReserva $relacionUsuario";
            $RESERVA = SQL($sql);

            if (CAN_REG($RESERVA) == 0) {
                $mensajeRespuesta = "Reserva no encontrada o pertenece a otro usuario";
            } else {

                $estadoReserva = $RESERVA[0] -> estado;
                if($estadoReserva <> 'pendiente') {
                    $mensajeRespuesta = "ESta reserva no puede ser $nuevoEstado porque ya está '$estadoReserva'";
                    
                } else {
                    $sql = "UPDATE reservas 
                                SET estado = '$nuevoEstado' 
                                WHERE id_reserva = $idReserva";
                            
                    $RESERVA = SQL($sql);

                    if ($RESERVA) {
                                $mensajeRespuesta = "Reserva $nuevoEstado exitosamente";
                    } else {
                                $mensajeRespuesta = "Error al actualizar la reserva";
                    }
                }
            }
        }
    } else {
        $mensajeRespuesta = "Estado de reserva no valido";
    }

?>

<?php

$relacionUsuario = '';
if ($_SESSION['tipoUsuario'] == 'administrador') { 
    $idUsuario       = $DATOS['idUsuario'] ?? '';
    $idAdministrador = $_SESSION['idUsuario'];
} else {
    $idUsuario       = $_SESSION['idUsuario'];
    $idAdministrador = 'NULL';
    $relacionUsuario = " AND id_usuario = $idUsuario";
}

$idReserva      = $DATOS['idReserva'] ?? null;
$fecha          = $DATOS['fecha'] ?? '';
$idServicio     = $DATOS['idServicio'] ?? '';
$idDetalle      = $DATOS['idDetalleReserva'] ?? '';

if (empty($idReserva) || count(array_filter([$fecha, $idServicio, $idUsuario, $idDetalle])) < 4) {
    $mensajeRespuesta = "Datos incompletos";
} else {
    $sql = "SELECT 1 FROM reservas WHERE id_reserva = $idReserva $relacionUsuario";
    $VERIFICAR = SQL($sql);

    if (CAN_REG($VERIFICAR) == 0) {
        $mensajeRespuesta = "Reserva no encontrada";
    } else {
        $sql = "SELECT id_servicio FROM detalles_reserva 
                            INNER JOIN reservas AS R USING(id_reserva)
                                WHERE id_servicio = $idServicio 
                                    AND fecha_inicio = '$fecha' 
                                    AND R.estado = 'pendiente' 
                                    AND R.id_reserva != $idReserva LIMIT 1";
        
        $VERIFICAR = SQL($sql);

        if (CAN_REG($VERIFICAR) > 0) {
            $mensajeRespuesta = "Este servicio ya está reservado para el día seleccionado";
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
                $sql = "UPDATE reservas 
                            SET id_usuario = '$idUsuario', 
                                fecha_inicio = '$fecha' 
                            WHERE id_reserva = $idReserva";
                
                $RESERVA = SQL($sql);

                if ($RESERVA) {

                    $sql = "UPDATE detalles_reserva 
                                    SET id_servicio = '$idServicio' WHERE id_detalle_reserva = $idDetalle";
                
                    $DETALLES_RESERVA = SQL($sql);
                    $mensajeRespuesta = "Reserva actualizada exitosamente";
                } else {
                    $mensajeRespuesta = "Error al actualizar la reserva";
                }
            }
        }
    }
}


?>

<?php
    $tipoUsuario = $_SESSION['tipoUsuario'];
    $idUsuario   = $_SESSION['idUsuario'];

        $fecha      = $_GET['fecha'] ?? '';
        $fechaDesde = $_GET['fechaDesde'] ?? '';
        $fechaHasta = $_GET['fechaHasta'] ?? '';

        $condicionFechas = ' >= CURDATE()';

        if (!empty($fecha)) {
            if ($fecha === 'hoy') {
                $condicionFechas = " = CURDATE()";
            } else {
                $condicionFechas = " = '$fecha'";
            }
        } else {

            if (!empty($fechaDesde)) {
                $condicionFechas = " >= '$fechaDesde'"; 
            }

            if (!empty($fechaHasta)) {
                if (!empty($condicionFechas)) {
                    $condicionFechas .= " AND ";
                }
                $condicionFechas .= "fecha_inicio <= '$fechaHasta'"; 
            }
        }

        $condicionFechas = "AND fecha_inicio $condicionFechas";
    $condicion = ($tipoUsuario == 'cliente') ? " AND id_usuario = $idUsuario" : '';
    $condicion .= ($idRegistro > 0) ? " AND id_reserva = $idRegistro" : '';
    $sql = "SELECT id_reserva, id_usuario, id_administrador, fecha_inicio, R.estado, nombre AS cliente, descripcion AS servicio, id_servicio, id_detalle_reserva, 
                                        IF(DATE(fecha_inicio) = CURDATE(), 
                                            'HOY', DATE_FORMAT(fecha_inicio, '%W, %d-%m-%Y')) AS fecha
                                    FROM reservas AS R
                                INNER JOIN usuarios USING(id_usuario) 
                                INNER JOIN detalles_reserva USING(id_reserva) 
                                INNER JOIN servicios USING(id_servicio)
                            WHERE 
                                1 = 1 AND R.estado = 'pendiente' 
                                $condicionFechas 
                                $condicion 
                            ORDER BY fecha_inicio";
        
    $RESERVAS = SQL($sql);

    if ($RESERVAS > 0) {
        if(CAN_REG($RESERVAS) > 0) {
            $datosRespuesta = $RESERVAS;

        } else {
            $mensajeRespuesta = "Reserva no encontrada";
        }
    } else {
        $mensajeRespuesta = "Error al consultar los reservas";
    }
    
?>

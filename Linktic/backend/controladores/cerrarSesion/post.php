<?php
    @session_start();
    @session_unset();
    @session_destroy();
    $mensajeRespuesta = "Sesión cerrada";
?>

<?php
    @session_start();
    header("Content-Type: application/json");

    require_once '../funciones.php';
    $metodo = $_SERVER['REQUEST_METHOD'];
    $url = $_SERVER['REQUEST_URI'];
    $url = strtok($url, '?');
    $url = explode('/', trim($url, '/'));

        
    if (count($url) < 3 || $url[1] !== 'api') {
        $estatusRespuesta = (404);    
        echo json_encode(["mensaje" => "Recurso no encontradoR"]);
        exit;
    }

    $entidad = strtolower($url[2]); 


    if($entidad !== 'login') {
        if(!isset($_SESSION['idUsuario'])) {
            $estatusRespuesta = (401);
            echo json_encode(['error' => 'Primero debe iniciar sesión']);
            exit();
        }
    }
    $idRegistro = $url[3] ?? 0;
    $rutaControlador = '../controladores/' . strtolower($entidad) . '/' . strtolower($metodo) . '.php';
    if (file_exists($rutaControlador)) {
        $DATOS = json_decode(file_get_contents("php://input"), true);
        include $rutaControlador;
    } else {
        $mensajeRespuesta = "Recurso no encontrado";
    }
    if(isset($datosRespuesta)) {
        $respuesta["datos"] = $datosRespuesta;
    }
    echo json_encode($respuesta);
    http_response_code($estatusRespuesta); 
?>

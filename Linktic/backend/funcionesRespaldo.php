<?php 

    function SQL($VPsql){
        require("pdo.php");
        try {
            $VFresultado = $VGconexion -> prepare((($VPsql)));
            $ejecutar = $VFresultado -> execute();
            if($ejecutar) {
                $retorno = $VFresultado->fetchAll(); 
                if(count($retorno) == 0) {
                    $ultimoId = $VGconexion -> lastInsertId();
                    $retorno = ($ultimoId == 0) ? $retorno : $ultimoId;
                }
                
                return $retorno;
            }
            return $ejecutar;
       
        } catch (PDOException $e) {
                $mensajeRespuesta = $e->getMessage();
            http_response_code(500);
            echo json_encode(['error' => $mensajeRespuesta]);
            exit();
        }
    }


    function CAN_REG($VPreg){
        return count($VPreg);
    }

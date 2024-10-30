<?php 

    function SQL($VPsql){
        require("pdo.php");
        try {
            $VFresultado = $VGconexion -> prepare((($VPsql)));
            $ejecutar = $VFresultado -> execute();
            if($ejecutar) {
                if (strpos(trim($VPsql), 'SELECT') === 0) {
                    return $VFresultado->fetchAll(); 
                }
                if (strpos(trim($VPsql), 'INSERT') === 0) {
                    return $VGconexion->lastInsertId();
                }
                $retorno = array($VFresultado->rowCount());
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

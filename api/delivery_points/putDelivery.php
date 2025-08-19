<?php 

    header('Content-Type: application/json; charset=UTF-8');

    require_once('../controllers/PointsController.php');

    if($_SERVER['REQUEST_METHOD'] == 'PUT'){
        $data = json_decode(file_get_contents("php://input"), true);

        if(!$data){
            echo json_encode([
                "success" => false,
                "message" => "No se han recibido datos"
            ]);
            exit;
        }
        $id = trim($data["id"] ?? '');
        $id_ruta = trim($data["id_ruta"] ?? '');
        $direccion = trim($data["direccion"] ?? '');
        $orden = trim($data["orden"] ?? '');
        $entregado = trim($data["entregado"] ?? '');

        if(empty($id)) $errores[] = "El nombre del chofer es obligatorio";
        if(empty($id_ruta)) $errores[] = "El id_ruta es obligatorio";
        if(empty($direccion)) $errores[] = "La direccion de la ruta es obligatorio";
        if(empty($orden)) $errores[] = "La orden es obligatorio";
        if(empty($entregado)) $errores[] = "La entrega es obligatorio";

        if(!empty($errores)){
            header('HTTP/1.1 400 Bad Request');
            echo json_encode([
                "success" => false,
                "message" => "Errores en los datos",
                "errors" => $errores
            ]);
            exit;
        } 
    
        $result = PointsController::update_delivery($id, $id_ruta, $direccion, $orden, $entregado);
        header('HTTP/1.1 201 Punto de entrega actualizado correctamente');
        echo json_encode([
            "Insertado" => $result,
            "message" => "Punto de entrega actualizado correctamente"
        ]);
        exit;
    }




?>
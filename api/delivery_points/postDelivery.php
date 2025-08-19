<?php 

    header('Content-Type: application/json; charset=UTF-8');

    require_once('../controllers/PointsController.php');

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $data = json_decode(file_get_contents("php://input"), true);

        if(!$data){
            echo json_encode([
                "success" => false,
                "message" => "No se han recibido datos"
            ]);
            exit;
        }

        $id_ruta = (int)$data["id_ruta"] ?? 0;;
        $direccion = trim($data["direccion"] ?? '');
        $orden = (int)$data["orden"] ?? '';
        $entregado = trim($data["entregado"] ?? '');

        if(empty($id_ruta)) $errores[] = "El id de la ruta es obligatorio";
        if(empty($direccion)) $errores[] = "La direccion de la ruta es obligatorio";
        if(empty($orden)) $errores[] = "El orden de la ruta es obligatorio";
        if(empty($entregado)) $errores[] = "La entrega de la ruta es obligatorio";

        if(!empty($errores)){
            header('HTTP/1.1 400 Bad Request');
            echo json_encode([
                "success" => false,
                "message" => "Errores en los datos",
                "errors" => $errores
            ]);
            exit;
        } 
    
        $result = PointsController::create_delivery($id_ruta, $direccion, $orden, $entregado);
        header('HTTP/1.1 201 Punto de entrega creada correctamente');
        echo json_encode([
            "Insertado" => $result,
            "message" => "Punto de entrega creada correctamente"
        ]);
        exit;
    }




?>
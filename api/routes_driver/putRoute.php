<?php 

    header('Content-Type: application/json; charset=UTF-8');

    require_once('../controllers/RoutesController.php');

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
        $nombre = trim($data["nombre"] ?? '');
        $id_chofer = trim($data["id_chofer"] ?? '');
        $fecha = trim($data["fecha"] ?? '');

        if(empty($id)) $errores[] = "El id del chofer es obligatorio";
        if(empty($nombre)) $errores[] = "El nombre del chofer es obligatorio";
        if(empty($id_chofer)) $errores[] = "El id del chofer es obligatorio";
        if(empty($fecha)) $errores[] = "fecha es obligatorio";

        if(!empty($errores)){
            header('HTTP/1.1 400 Bad Request');
            echo json_encode([
                "success" => false,
                "message" => "Errores en los datos",
                "errors" => $errores
            ]);
            exit;
        } 
    
        $result = RoutesController::update_route($id, $nombre, $fecha ,$id_chofer);
        header('HTTP/1.1 201 Chofer actualizado correctamente');
        echo json_encode([
            "Insertado" => $result,
            "message" => "Chofer actualizado correctamente"
        ]);
        exit;
    }




?>
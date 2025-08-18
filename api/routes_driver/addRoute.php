<?php 

    header('Content-Type: application/json; charset=UTF-8');

    require_once('../../includes/routes.class.php');

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $data = json_decode(file_get_contents("php://input"), true);

        if(!$data){
            echo json_encode([
                "success" => false,
                "message" => "No se han recibido datos"
            ]);
            exit;
        }

        $nombre = trim($data["nombre"] ?? '');
        $id_chofer = (int)$data["id_chofer"] ?? 0;

        if(empty($nombre)) $errores[] = "El nombre de la ruta es obligatorio";
        if(empty($id_chofer)) $errores[] = "El id del chofer es obligatorio";

        if(!empty($errores)){
            header('HTTP/1.1 400 Bad Request');
            echo json_encode([
                "success" => false,
                "message" => "Errores en los datos",
                "errors" => $errores
            ]);
            exit;
        } 
    
        $result = Routes::create_route($nombre, $id_chofer);
        header('HTTP/1.1 201 Ruta creada correctamente');
        echo json_encode([
            "Insertado" => $result,
            "message" => "Ruta creada correctamente"
        ]);
        exit;
    }




?>
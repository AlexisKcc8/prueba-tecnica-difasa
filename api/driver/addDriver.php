<?php 

    header('Content-Type: application/json; charset=UTF-8');

    require_once('../../includes/drivers.class.php');

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
        $telefono = trim($data["telefono"] ?? '');

        if(empty($nombre)) $errores[] = "El nombre del chofer es obligatorio";
        if(empty($telefono)) $errores[] = "El telefono del chofer es obligatorio";

        if(!empty($errores)){
            header('HTTP/1.1 400 Bad Request');
            echo json_encode([
                "success" => false,
                "message" => "Errores en los datos",
                "errors" => $errores
            ]);
            exit;
        } 
    
        $result = Driver::create_driver($nombre, $telefono);
        header('HTTP/1.1 201 Chofer creado correctamente');
        echo json_encode([
            "Insertado" => $result,
            "message" => "Chofer creado correctamente"
        ]);
        exit;
    }




?>
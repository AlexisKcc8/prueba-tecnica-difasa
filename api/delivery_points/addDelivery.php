<?php 

    header('Content-Type: application/json; charset=UTF-8');

    require_once('../../includes/delivery_points.class.php');

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
        $dirrecion =  $nombre = trim($data["dirrecion"] ?? '');
        $orden =  $nombre = (int)$data["orden"] ?? '';
        $entregado =  $nombre = trim($data["entregado"] ?? '');

        if(empty($id_ruta)) $errores[] = "El id de la ruta es obligatorio";
        if(empty($dirrecion)) $errores[] = "La dirrecion de la ruta es obligatorio";
        if(empty($dirrecion)) $errores[] = "La dirrecion de la ruta es obligatorio";
        if(empty($dirrecion)) $errores[] = "La dirrecion de la ruta es obligatorio";

        if(!empty($errores)){
            header('HTTP/1.1 400 Bad Request');
            echo json_encode([
                "success" => false,
                "message" => "Errores en los datos",
                "errors" => $errores
            ]);
            exit;
        } 
    
        $result = DeliveryPoints::create_delivery($id_ruta, $dirrecion, $orden, $entregado);
        header('HTTP/1.1 201 Punto de entrega creada correctamente');
        echo json_encode([
            "Insertado" => $result,
            "message" => "Punto de entrega creada correctamente"
        ]);
        exit;
    }




?>
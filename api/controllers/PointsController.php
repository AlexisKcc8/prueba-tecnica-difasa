<?php
    require_once('../../includes/database.class.php');

    class PointsController{
        public static function create_delivery($id_ruta, $direccion, $orden, $entregado){
            $database = new Database();
            $conn = $database->getConnection();

            $stmt = $conn->prepare('INSERT INTO puntos_entrega(id_ruta, direccion, orden, entregado) VALUES(:id_ruta, :direccion, :orden, :entregado)');
            $stmt->bindParam(':id_ruta',$id_ruta , PDO::PARAM_STR);
            $stmt->bindParam(':direccion',$direccion, PDO::PARAM_STR);
            $stmt->bindParam(':orden',$orden, PDO::PARAM_INT);
            $stmt->bindParam(':entregado',$entregado, PDO::PARAM_STR);

            return $stmt->execute();
        }

        public static function delete_delivery_by_id($id){
            $database = new Database();
            $conn = $database->getConnection();

            $stmt = $conn->prepare('DELETE FROM puntos_entrega WHERE id=:id');
            $stmt->bindParam(':id',$id);
            return $stmt->execute();
        }

        public static function get_all_deliverys(){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('SELECT * FROM puntos_entrega');
            if ($stmt->execute()) {
                return $stmt->fetchAll(PDO::FETCH_ASSOC); // Devuelve los datos como array asociativo
            } else {
                return []; // o puedes lanzar una excepción o retornar false
            }
        }

        public static function update_delivery($id, $id_ruta, $direccion, $orden, $entregado){
            $database = new Database();
            $conn = $database->getConnection();

            $stmt = $conn->prepare('UPDATE puntos_entrega SET id_ruta=:id_ruta, direccion=:direccion, `orden`=:orden, entregado=:entregado WHERE id=:id');
            $stmt->bindParam(':id',$id , PDO::PARAM_INT);
            $stmt->bindParam(':id_ruta',$id_ruta , PDO::PARAM_STR);
            $stmt->bindParam(':direccion',$direccion, PDO::PARAM_STR);
            $stmt->bindParam(':orden',$orden, PDO::PARAM_INT);
            $stmt->bindParam(':entregado',$entregado, PDO::PARAM_STR);

            return $stmt->execute();

        }
    }

?>
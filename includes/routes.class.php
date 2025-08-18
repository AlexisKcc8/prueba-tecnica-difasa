<?php
    require_once('Database.class.php');

    class Routes{
        public static function create_route($nombre, $id_chofer){
            $database = new Database();
            $conn = $database->getConnection();

            $stmt = $conn->prepare('INSERT INTO rutas(nombre, id_chofer) VALUES(:nombre, :id_chofer)');
            $stmt->bindParam(':nombre',$nombre , PDO::PARAM_STR);
            $stmt->bindParam(':id_chofer',$id_chofer, PDO::PARAM_INT);

            return $stmt->execute();
        }

        public static function delete_route_by_id($id){
            $database = new Database();
            $conn = $database->getConnection();

            $stmt = $conn->prepare('DELETE FROM rutas WHERE id=:id');
            $stmt->bindParam(':id',$id);
            return $stmt->execute();
        }

        public static function get_all_routes(){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('SELECT * FROM rutas');
            if ($stmt->execute()) {
                return $stmt->fetchAll(PDO::FETCH_ASSOC); // Devuelve los datos como array asociativo
            } else {
                return []; // o puedes lanzar una excepción o retornar false
            }
        }

        public static function update_route($id, $nombre, $fecha ,$id_chofer){
            $database = new Database();
            $conn = $database->getConnection();

            $stmt = $conn->prepare('UPDATE rutas SET nombre=:nombre, fecha=:fecha, id_chofer=:id_chofer WHERE id=:id');
            $stmt->bindParam(':id',$id , PDO::PARAM_INT);
            $stmt->bindParam(':id_chofer',$id_chofer, PDO::PARAM_INT);
            $stmt->bindParam(':nombre',$nombre, PDO::PARAM_STR);
            $stmt->bindParam(':fecha',$fecha, PDO::PARAM_STR);

            return $stmt->execute();

        }
    }

?>
<?php
    require_once('Database.class.php');

    class Driver{
        public static function create_driver($nombre, $telefono){
            $database = new Database();
            $conn = $database->getConnection();

            $stmt = $conn->prepare('INSERT INTO choferes(nombre, telefono) VALUES(:nombre, :telefono)');
            $stmt->bindParam(':nombre',$nombre , PDO::PARAM_STR);
            $stmt->bindParam(':telefono',$telefono, PDO::PARAM_STR);

            return $stmt->execute();
        }

        public static function delete_driver_by_id($id){
            $database = new Database();
            $conn = $database->getConnection();

            $stmt = $conn->prepare('DELETE FROM choferes WHERE id=:id');
            $stmt->bindParam(':id',$id);
            return $stmt->execute();
        }

        public static function get_all_drivers(){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('SELECT * FROM choferes');
            if ($stmt->execute()) {
                return $stmt->fetchAll(PDO::FETCH_ASSOC); // Devuelve los datos como array asociativo
            } else {
                return []; // o puedes lanzar una excepción o retornar false
            }
        }

        public static function update_driver($id, $nombre, $telefono){
            $database = new Database();
            $conn = $database->getConnection();

            $stmt = $conn->prepare('UPDATE choferes SET nombre=:nombre, telefono=:telefono WHERE id=:id');
            $stmt->bindParam(':id',$id , PDO::PARAM_INT);
            $stmt->bindParam(':nombre',$nombre, PDO::PARAM_STR);
            $stmt->bindParam(':telefono',$telefono, PDO::PARAM_STR);


            return $stmt->execute();
        }
    }

?>
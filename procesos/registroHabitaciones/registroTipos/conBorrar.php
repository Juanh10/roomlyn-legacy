<?php

include "../../config/conex.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!empty($_FILES["imagenes"])) {

        $estado = false;
        $idTipo = 1;

        $sql = $dbh -> prepare("INSERT INTO habitaciones_imagenes(idTipoHabitacion, nombre, ruta) VALUES (:idTipo,:nombre,:ruta)");
        $imagenes = $_FILES['imagenes']['name'];

        $rutaImagenes = $_FILES['imagenes']['tmp_name'];

        for ($i = 0; $i < count($imagenes); $i++) {

            for ($i = 0; $i < count($rutaImagenes); $i++) {
                $imagenes2 = $imagenes[$i];
                $nameImagenes = pathinfo($imagenes2, PATHINFO_FILENAME);
                $extensionImagenes = pathinfo($imagenes2, PATHINFO_EXTENSION);
                $temp = $rutaImagenes[$i];

                $rutaImg = '../../../img/'. $nameImagenes . "." . $extensionImagenes;

                $sql -> bindParam(':idTipo',$idTipo);
                $sql -> bindParam(':nombre',$nameImagenes);
                $sql -> bindParam(':ruta',$rutaImg);

                if($sql -> execute()){
                    move_uploaded_file($temp, $rutaImg);
                    $estado = true;
                }else{
                    $estado = false;
                }
                

            }
        }

        if($estado){
            echo "NICEEEE";
        }else{
            echo "EFFE :(((";
        }
    }
}
?>
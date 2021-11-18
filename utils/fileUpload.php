<?php

namespace Utils;

use \Exception as Exception;

class fileUpload
{
    /**
     * Recibe un archivo y lo guarda en la carpeta uploads del proyecto.
     */
    public function UploadArchive($archive)
    {
        echo var_dump($archive);
        try {
            if ($archive["name"] == "") {
                throw new Exception("No se ha seleccionado ningun archivo.");
            }
            
            $explodedName = explode(".", $archive["name"]);
            $extension = strtolower($explodedName[count($explodedName) - 1]);
            if ($extension != "pdf") {
                throw new Exception("El archivo no es un pdf");
            }

            // Obtenemos nombre del archivo, tipo, direccion temporal
            $fileName = $archive["name"];
            $type = $archive["type"];
            $tempFileName = $archive["tmp_name"];

            $filePath = UPLOADS_PATH . basename($fileName);

            $fileType = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

            // Obtenemos el peso del archivo
            $fileSize = filesize($tempFileName);

            // Si tiene datos
            if ($fileSize !== false) {
                // Recibe el archivo, recibe la ruta a la que queremos moverlo 
                if (move_uploaded_file($tempFileName, $filePath)) {
                    $this->message = "Archivo subido correctamente";
                } else {
                    $this->message = "Ocurrió un error al intentar subir el archivo";
                }
            } else {
                $this->message = "El archivo no corresponde a una imágen";
            }
        } catch (Exception $ex) {
            $this->message = $ex->getMessage();
            throw $ex;
        }
    }

}
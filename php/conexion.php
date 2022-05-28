<?php

    function conectar() 
    {
        $servidor = 'localhost';
        $usuario = 'root';
        $clave = '';
        $db = 'peliculas';

        $conexion = mysqli_connect($servidor,$usuario,$clave,$db);

        if (!$conexion) {
            echo '<p>Conexión fallida con la base de datos.</p>';
        }
        else {
            return $conexion;
        }
    }

    function desconectar($conexion)
    {
        if ($conexion) {

            $desconexion = mysqli_close($conexion);

            if (!$desconexion) {
                echo '<p>Error al tratar de desconectar.</p>';
            }

        } else {
            echo '<p>Conexión inexistente al tratar de desconectar.</p>';
        }
    }

?>
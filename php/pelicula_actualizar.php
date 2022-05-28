<?php
    session_start();
    if(!empty($_SESSION['usuario']) && ($_SESSION['tipo'] == 'Administrador' || $_SESSION['tipo'] == 'Editor')) {
        $ruta = "../css";
        require_once("../html/encabezado.html");
        require_once("menu.php");
        require_once("conexion.php");
?>

<main>
    <article class="contenedor-mensaje">
    <?php 

        $conexion = conectar();

        if ($conexion && !empty($_POST['id'])) {     //LA CONEXIÓN SE CONTROLÓ CON UN IF EN LA FUNCIÓN conectar()

            if (!empty($_POST['titulo'])) {

                $id = $_POST['id'];
                $titulo = $_POST['titulo'];
                $duracion = (empty($_POST['duracion'])) ? 0 : $_POST['duracion'];
                $genero = (empty($_POST['genero'])) ? null : $_POST['genero'];
                $fecha_estreno = (empty($_POST['fecha_estreno'])) ? '0000-00-00' : $_POST['fecha_estreno'];
                $foto_portada = null;

                /*************** GUARDADO / BORRADO DE FOTOS ********************/

                $consulta = 'SELECT titulo, foto_portada FROM pelicula WHERE id = ' . $id . ';';
                $resultado = mysqli_query($conexion, $consulta);

                if($resultado) {

                    if($fila = mysqli_fetch_array($resultado)) { 

                        if (!empty($_FILES['foto_portada']['size'])) { //si hay foto nueva
        
                            $rutaOrigen = $_FILES['foto_portada']['tmp_name'];
                            $arraExt = explode('.', $_FILES['foto_portada']['name']);
                            $extencion = end($arraExt);
                            $rutaDestino = '../img/portadas/' . $titulo . '.' . $extencion;
                            $foto_portada = $titulo . '.' . $extencion;
                            
                            $existe = !empty($fila['foto_portada']) && file_exists('../img/portadas/' . $fila['foto_portada']);
                            
                            if($existe && $fila['foto_portada'] != $foto_portada) { //si había foto con diferente nombre en portadas, la borra
                                if(!unlink('../img/portadas/' . $fila['foto_portada'])) {
                                    echo '<p>No se pudo encontrar/borrar la foto anterior.</p>';
                                }
                            }
                                
                            if(!file_exists('../img/portadas')) {
                                mkdir('../img/portadas');
                            }
                            if(!move_uploaded_file($rutaOrigen,$rutaDestino)) { 
                                echo '<p>No se pudo guardar la foto de portada.</p>';
                            }
                        }
                        else { // si no hay foto nueva

                            if ($titulo != $fila['titulo']) { // si se cambió el título

                                if (!empty($fila['foto_portada'])) { // si había una foto en la base de datos
                                    $arraExt = explode('.', $fila['foto_portada']);
                                    $extencion = end($arraExt);
                                    $foto_portada = $titulo . '.' . $extencion;

                                    if(file_exists('../img/portadas/' . $fila['foto_portada'])) { //si había foto con diferente nombre en portadas, la renombra
                                        $rutaOrigen = '../img/portadas/' . $fila['foto_portada'];
                                        $rutaDestino = '../img/portadas/' . $titulo . '.' . $extencion;
                                        if(!rename($rutaOrigen,$rutaDestino)) {     //renmove_uploaded_file($rutaOrigen,$rutaDestino)
                                            echo '<p>No se pudo renombrar la foto de portada.</p>';
                                        }
                                    }
                                }
                            }
                        }
                    } else {
                        echo '<p>Error al buscar la portada en la base de datos.</p>';
                    }
                } else {
                    echo '<p>Error al realizar la consulta.</p>';
                }
                /*************** FIN (GUARDADO / BORRADO DE FOTOS) ********************/

                    // consulta para actualizar
                $consulta = 'UPDATE pelicula SET ';
                foreach ($_POST as $key => $value) {
                    if (!empty($value) && $key != 'id') {
                        $consulta .= $key . '= \'' . $value . '\', ';
                    }
                }
                if (!empty($_FILES['foto_portada']['size']) || $titulo != $fila['titulo']){
                    $consulta .= 'foto_portada' . '= \'' . $foto_portada . '\', ';
                }
                $consulta .= 'WHERE id = ' . $id; 
                $consulta = str_replace(", WHERE", " WHERE", $consulta);
                $resultado_consulta = mysqli_query($conexion, $consulta);
                desconectar($conexion);

                if($resultado_consulta) {
                    echo '<p>La base de datos de películas ha sido actualizada.</p>';
                } else {
                    echo '<p>Error al realizar la consulta.</p>';
                }
                header('refresh:3; url=pelicula_listado.php');
            }
            else {
                echo '<p><strong>Debe especificar al menos el título de la película para guardar.</strong></p>';
                header('refresh:3; url=pelicula_listado.php');
            }
        }
        else {
            echo '<p>Error de conexión / no se seleccionó ninguna película.</p>';
            header('refresh:3; url=pelicula_listado.php');
        }
    ?>
    
    </article>
</main>
</section>
<?php
    require_once("../html/pie.html");
} else {
    header('refresh:0; url=pelicula_listado.php');
}
?>
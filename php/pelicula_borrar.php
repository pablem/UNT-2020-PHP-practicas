<?php
    session_start();
    if(!empty($_SESSION['usuario']) && $_SESSION['tipo'] == 'Administrador') {
        $ruta = "../css";
        require_once("../html/encabezado.html");
        require_once("menu.php");
        require_once("conexion.php");
?>

<main>
    <article class="contenedor-mensaje">
        <?php 

            //cargar bd y borrar

            $conexion = conectar();

            if ($conexion && !empty($_GET['id'])) {     //LA CONEXIÓN SE CONTROLÓ CON UN IF EN LA FUNCIÓN conectar()

                $id = $_GET['id']; 

                /** Borrar foto **/
                $consulta = 'SELECT foto_portada FROM pelicula WHERE id = ' . $id . ';';
                $resultado = mysqli_query($conexion, $consulta);
                if($resultado) {
                    if($fila = mysqli_fetch_array($resultado)) {
                        if(!empty($fila['foto_portada']) && file_exists('../img/portadas/' . $fila['foto_portada'])) { // si tenía foto, la borra de portadas
                            if(!unlink('../img/portadas/' . $fila['foto_portada'])) {
                                echo '<p>No se pudo encontrar/borrar la foto de portada.</p>';
                            }
                        }
                    }
                    else {
                        echo '<p>Error al buscar la portada en la base de datos.</p>';
                    }
                }
                else {
                    echo '<p>Error al realizar la consulta.</p>';
                }
                /** fin borrar foto **/

                /** Borrar película **/
                $consulta = 'DELETE FROM pelicula WHERE id =' . $id;
                $resultado = mysqli_query($conexion, $consulta);
                desconectar($conexion);
                
                if($resultado) {
                    echo '<p>Se eliminó la película.</p>';
                    header('refresh:2; url=pelicula_listado.php');
                }
                else {
                    echo '<p>Error al intentar eliminar.</p>';
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
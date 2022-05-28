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

            if (!empty($_GET['id'])) {     //LA CONEXIÓN SE CONTROLÓ CON UN IF EN LA FUNCIÓN conectar()

                $id = $_GET['id']; 

                /** Borrar foto **/
                $consulta = 'SELECT foto FROM usuario WHERE id = ' . $id . ';';
                $resultado = mysqli_query($conexion, $consulta);
                if($resultado) {
                    if($fila = mysqli_fetch_array($resultado)) {
                        if(!empty($fila['foto']) && file_exists('../img/usuarios/' . $fila['foto'])) { // si tenía foto, la borra de la carpeta usuarios
                            if(!unlink('../img/usuarios/' . $fila['foto'])) {
                                echo '<p>No se pudo encontrar/borrar la foto de perfil.</p>';
                            }
                        }
                    }
                    else {
                        echo '<p>Error al buscar la foto de perfil en la base de datos.</p>';
                    }
                }
                else {
                    echo '<p>Error al realizar la operación.</p>';
                }
                /** fin borrar foto **/

                /** Borrar usuario **/
                $consulta = 'DELETE FROM usuario WHERE id =' . $id;
                $resultado = mysqli_query($conexion, $consulta);
                desconectar($conexion);
                
                if($resultado) {
                    echo '<p>Se eliminó el usuario.</p>';
                    header('refresh:2; url=usuario_listado.php');
                }
                else {
                    echo '<p>Error al intentar eliminar.</p>';
                    header('refresh:3; url=usuario_listado.php');
                }
            }
            else {
                echo '<p>No se seleccionó ningún usuario.</p>';
                header('refresh:3; url=usuario_listado.php');
            }
        ?>
    </article>
</main>
</section>

<?php
    require_once("../html/pie.html");
} else {
    header('refresh:0; url=usuario_listado.php');
}
?>
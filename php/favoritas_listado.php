<?php
    session_start();
    if(!empty($_SESSION['usuario'])) {
        $ruta = "../css";
        require_once("../html/encabezado.html");
        require_once("menu.php");
        require_once("conexion.php");
?>

<main>
    <?php 

        if(!empty($_COOKIE[$_SESSION['usuario']]) && isset($_COOKIE[$_SESSION['usuario']])) {
            $listado_favs = explode('-',$_COOKIE[$_SESSION['usuario']]);
        
            //cargar bd y mostrar
            
            $conexion = conectar();
                //LA CONEXIÓN SE CONTROLÓ CON UN IF EN LA FUNCIÓN conectar()
            $consulta = 'SELECT * FROM pelicula WHERE ';
            
            foreach ($listado_favs as $value) {
                $consulta .= 'id = ' . $value .' OR ';
            }
            $consulta = rtrim($consulta, 'OR ');
            $resultado = mysqli_query($conexion, $consulta);
            desconectar($conexion);

            if($resultado) {

                if (mysqli_num_rows($resultado)) {

                    echo '<h2>Listado de Favoritas</h2>';

                    while ($fila = mysqli_fetch_array($resultado)) {

                        $rutaImg = (!empty($fila['foto_portada']) && file_exists('../img/portadas/' . $fila['foto_portada'])) ? '../img/portadas/' . $fila['foto_portada'] : '../img/sin_imagen.png';
                        $duracion = ($fila['duracion'] == 0) ? "-" :  $fila['duracion'];
                        $fecha_estreno = ($fila['fecha_estreno'] == '0000-00-00') ? '-' : $fila['fecha_estreno'];
                        
                        echo '<article>';
                        echo '<figure class="portada"><img src="' . $rutaImg . '" alt="foto de portada de película"></figure>';
                        echo '<h3>' . $fila['titulo'] . '</h3>';
                        echo '<p>Género: ' . $fila['genero'] . '</p>';
                        echo '<p>Fecha de estreno: ' . $fecha_estreno . '</p>';
                        echo '<p>Duración: ' . $duracion . '</p>';
                        echo '<figure>';
                        if ($_SESSION['tipo'] == 'Administrador' || $_SESSION['tipo'] == 'Editor') echo '<a href="pelicula_editado.php?id=' . $fila['id'] .'"><img class="icono" src="../img/edit_pencil.png" alt="modificar"></a>';
                        if ($_SESSION['tipo'] == 'Administrador') echo '<a href="pelicula_confirmar.php?id=' . $fila['id'] .'"><img class="icono" src="../img/trash_empty.png" alt="borrar"></a>';
                        echo '<a href="guardar_favoritos.php?id=' . $fila['id'] .'"><img class="icono" src="../img/estrella.png" alt="añadir a favoritos"></a>';
                        echo '</figure>';
                        echo '</article>';
                    }
                } else {
                    echo '<article class="contenedor-mensaje">';
                    echo '  <p>No se encontraron resultados.</p>';
                    echo '</article>';
                }
            } else {
                echo '<p>Error al realizar la consulta.</p>';
                header('refresh:3; url=pelicula_listado.php');
            }
        } else {
            echo '<article class="contenedor-mensaje">';
            echo '  <p>La lista está vacía.</p>';
            echo '</article>';
        }
    ?>

</main>
</section>

<?php
    require_once("../html/pie.html");
} else {
    header('refresh:0; url=../index.php');
}
?>
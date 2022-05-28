<?php
    session_start();
    if(!empty($_SESSION['usuario']) && $_SESSION['tipo'] == 'Administrador') {
        $ruta = "../css";
        require_once("../html/encabezado.html");
        require_once("menu.php");
        require_once("conexion.php");
?>

<main>
    <h2>Eliminar película</h2>
    <article class="contenedor-mensaje">
        <?php 

            //cargar bd y mostrar

            $conexion = conectar();

            if ($conexion && !empty($_GET['id'])) {     //LA CONEXIÓN SE CONTROLÓ CON UN IF EN LA FUNCIÓN conectar()
                
                $id = $_GET['id']; 
                $consulta = 'SELECT titulo FROM pelicula WHERE id =' . $id;
                $resultado_consulta = mysqli_query($conexion, $consulta);

                if(mysqli_num_rows($resultado_consulta) === 1)  {
                    $fila = mysqli_fetch_array($resultado_consulta);
                    echo '<p>¿Está seguro que quiere eliminar la película <strong>' . $fila['titulo'] . '</strong>?</p>';
                    echo '<section class="botones"><a href="pelicula_borrar.php?id=' . $id . '">Aceptar</a>';
                    echo '<a href="pelicula_listado.php">Cancelar</a></section>';
                }
                else {
                    echo '<p>Error al realizar la consulta.</p>';
                    header('refresh:3; url=pelicula_listado.php');
                }
            }
            else {
                echo '<p>Error de conexión / no se seleccionó ninguna película.</p>';
                header('refresh:3; url=pelicula_listado.php');
            }

            desconectar($conexion);
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
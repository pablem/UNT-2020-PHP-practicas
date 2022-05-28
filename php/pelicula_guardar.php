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

            if (empty($_POST['titulo'])) {
                echo '<p><strong>Debe especificar al menos el título de la película para guardar.</strong></p>';
                header('refresh:3; url=pelicula_alta.php');
            }
            else {

                $titulo = $_POST['titulo'];
                $duracion = (empty($_POST['duracion'])) ? 0 : $_POST['duracion'];
                $genero = (empty($_POST['genero'])) ? null : $_POST['genero'];
                $fecha_estreno = (empty($_POST['fecha_estreno'])) ? '0000-00-00' : $_POST['fecha_estreno'];
                $foto_portada = null;
                
                //guardar la foto en img/portadas

                if (!empty($_FILES['foto']['size'])) {

                    if(!file_exists('../img/portadas'))
                    mkdir('../img/portadas');

                    $rutaOrigen = $_FILES['foto']['tmp_name'];
                    $arraExt = explode('.', $_FILES['foto']['name']);
                    $extencion = end($arraExt);
                    $rutaDestino = '../img/portadas/' . $titulo . '.' . $extencion;
                    
                    $foto_portada = $titulo . '.' . $extencion;  //<-- guarda la variable con el nombre de la foto

                    if(!move_uploaded_file($rutaOrigen,$rutaDestino)) 
                        echo '<p>No se pudo guardar la foto de portada.</p>';
                }
                
                //cargar bd y comparar
                
                $conexion = conectar();
                    //LA CONEXIÓN SE CONTROLÓ CON UN IF EN LA FUNCIÓN conectar()
                $consulta = 'INSERT INTO pelicula (titulo, duracion, genero, fecha_estreno, foto_portada) 
                             VALUES (\'' . $titulo . '\', ' . $duracion . ', \'' . $genero . '\', \'' . $fecha_estreno . '\', \'' . $foto_portada . '\')';
                
                $resultado_consulta = mysqli_query($conexion, $consulta);
                desconectar($conexion);

                if($resultado_consulta) {
                    echo '<p>La base de datos de películas ha sido actualizada.</p>';
                } else {
                    echo '<p>Error al realizar la operación.</p>';
                }
                header('refresh:3; url=pelicula_alta.php');
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
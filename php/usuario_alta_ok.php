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

            if (empty($_POST['usuario']) || empty($_POST['password']) || empty($_POST['mail']) || empty($_POST['tipo'])) {
                echo '<p><strong>Debe especificar al menos el título de la película para guardar.</strong></p>';
                header('refresh:3; url=pelicula_alta.php');
            }
            else {

                $usuario = $_POST['usuario'];
                $password = sha1($_POST['password']);
                $mail = $_POST['mail'];
                $tipo = $_POST['tipo'];
                $foto_perfil = null;
                
                //guardar fecha de alta
                date_default_timezone_set('America/Argentina/Buenos_Aires');
                $fecha_alta = date('Y-m-d');

                //guardar la foto en img/usuarios

                if (!empty($_FILES['foto']['size'])) {

                    if(!file_exists('../img/usuarios'))
                    mkdir('../img/usuarios');

                    $rutaOrigen = $_FILES['foto']['tmp_name'];
                    $arraExt = explode('.', $_FILES['foto']['name']);
                    $extencion = end($arraExt);
                    $rutaDestino = '../img/usuarios/' . $usuario . '.' . $extencion;
                    
                    $foto_perfil = $usuario . '.' . $extencion;  //<-- guarda la variable con el nombre de la foto

                    if(!move_uploaded_file($rutaOrigen,$rutaDestino)) 
                        echo '<p>No se pudo guardar la foto de portada.</p>';
                }
                
                //cargar bd e insertar
                
                $conexion = conectar();
                    //LA CONEXIÓN SE CONTROLÓ CON UN IF EN LA FUNCIÓN conectar()
                $consulta = 'INSERT INTO usuario (usuario, password, mail, fecha_alta, tipo, foto) 
                                VALUES (\'' . $usuario . '\', \'' . $password . '\', \'' . $mail . '\', \'' . $fecha_alta . '\', \'' . $tipo . '\', \'' . $foto_perfil . '\')';
    
                $resultado_consulta = mysqli_query($conexion, $consulta);
                desconectar($conexion);

                if($resultado_consulta) {
                    echo '<p>La base de datos de usuarios ha sido actualizada.</p>';
                } else {
                    echo '<p>Error al realizar la operación.</p>';
                }
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
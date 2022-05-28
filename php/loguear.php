<?php
    session_start();
    $ruta = "../css";
    require_once("../html/encabezado.html");
    require_once("conexion.php");
?>

<main>
    <article class="contenedor-mensaje">
        <?php 

            if (empty($_POST['usuario']) || empty($_POST['clave'])) {
                echo '<p><strong>Debe escribir su usario y contraseña.</strong></p>';
                header('refresh:3; url=../index.php');
            }
            else {

                $usuario = $_POST['usuario'];
                $clave = sha1($_POST['clave']);

                //cargar bd y comparar
                
                $conexion = conectar();
                    //LA CONEXIÓN SE CONTROLÓ CON UN IF EN LA FUNCIÓN conectar()
                $consulta = 'SELECT usuario, mail, tipo, foto FROM usuario WHERE usuario = \'' . $usuario . '\' AND password = \'' . $clave . '\'';
                
                $resultado = mysqli_query($conexion, $consulta);

                if($resultado) {

                    if (mysqli_num_rows($resultado) == 1) {
                        $fila = mysqli_fetch_array($resultado);
                        $_SESSION['usuario'] = $fila['usuario'];
                        $_SESSION['mail'] = $fila['mail'];
                        $_SESSION['tipo'] = $fila['tipo'];
                        $_SESSION['foto'] = $fila['foto'];
                        
                        header('refresh:0; url=pelicula_listado.php');
                    } else {
                        echo '<p>Datos incorrectos.</p>';
                        header('refresh:3; url=../index.php');
                    }

                } else {
                    echo '<p>Error al realizar la consulta.</p>';
                    header('refresh:3; url=../index.php');
                }

                desconectar($conexion);
            }
        ?>
    </article>
</main>

<?php
    require_once("../html/pie.html");         
?>
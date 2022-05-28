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

        if (!empty($_POST['id'])) {     //LA CONEXIÓN SE CONTROLÓ CON UN IF EN LA FUNCIÓN conectar()

            if (!empty($_POST['usuario']) && !empty($_POST['mail']) && !empty($_POST['tipo'])) {

                $id = $_POST['id'];
                $usuario = $_POST['usuario'];
                $foto_perfil = null;

                $_POST['password'] = (empty($_POST['password'])) ? null : sha1($_POST['password']); 

                /*************** GUARDADO / BORRADO DE FOTOS ********************/

                $consulta = 'SELECT usuario, foto FROM usuario WHERE id = ' . $id . ';';
                $resultado = mysqli_query($conexion, $consulta);

                if($resultado) {

                    if($fila = mysqli_fetch_array($resultado)) { 

                        if (!empty($_FILES['foto']['size'])) { //si hay foto nueva
        
                            $rutaOrigen = $_FILES['foto']['tmp_name'];
                            $arraExt = explode('.', $_FILES['foto']['name']);
                            $extencion = end($arraExt);
                            $rutaDestino = '../img/usuarios/' . $usuario . '.' . $extencion;
                            $foto_perfil = $usuario . '.' . $extencion;
                            
                            $existe = !empty($fila['foto']) && file_exists('../img/usuarios/' . $fila['foto']);
                            
                            if($existe && $fila['foto'] != $foto_perfil) { //si había foto con diferente nombre en portadas, la borra
                                if(!unlink('../img/usuarios/' . $fila['foto'])) {
                                    echo '<p>No se pudo encontrar/borrar la foto anterior.</p>';
                                }
                            }
                                
                            if(!file_exists('../img/usuarios')) {
                                mkdir('../img/usuarios');
                            }
                            if(!move_uploaded_file($rutaOrigen,$rutaDestino)) { 
                                echo '<p>No se pudo guardar la foto de de perfil.</p>';
                            }
                        }
                        else { // si no hay foto nueva

                            if ($usuario != $fila['usuario']) { // si se cambió el nombre de usuario

                                if (!empty($fila['foto'])) { // si había una foto en la base de datos
                                    $arraExt = explode('.', $fila['foto']);
                                    $extencion = end($arraExt);
                                    $foto_perfil = $usuario . '.' . $extencion;

                                    if(file_exists('../img/usuarios/' . $fila['foto'])) { //si había foto con diferente nombre en carpeta usuarios, la renombra
                                        $rutaOrigen = '../img/usuarios/' . $fila['foto'];
                                        $rutaDestino = '../img/usuarios/' . $usuario . '.' . $extencion;
                                        if(!rename($rutaOrigen,$rutaDestino)) {     //renmove_uploaded_file($rutaOrigen,$rutaDestino)
                                            echo '<p>No se pudo renombrar la foto de de usuario.</p>';
                                        }
                                    }
                                }
                            }
                        }
                    } else {
                        echo '<p>Error al buscar la foto en la base de datos.</p>';
                    }
                } else {
                    echo '<p>Error al realizar la operación.</p>';
                }
                /*************** FIN (GUARDADO / BORRADO DE FOTOS) ********************/

                    // consulta para actualizar
                $consulta = 'UPDATE usuario SET ';
                foreach ($_POST as $key => $value) {
                    if (!empty($value) && $key != 'id') {
                        $consulta .= $key . '= \'' . $value . '\', ';
                    }
                }
                if (!empty($_FILES['foto']['size']) || $usuario != $fila['usuario']){
                    $consulta .= 'foto' . '= \'' . $foto_perfil . '\', ';
                }
                $consulta .= 'WHERE id = ' . $id; 
                $consulta = str_replace(", WHERE", " WHERE", $consulta);
                $resultado_consulta = mysqli_query($conexion, $consulta);
                desconectar($conexion);

                if($resultado_consulta) {
                    echo '<p>La base de datos de usuarios ha sido actualizada.</p>';
                } else {
                    echo '<p>Error al realizar la operación.</p>';
                }
                header('refresh:3; url=usuario_listado.php');
            }
            else {
                echo '<p><strong>Debe llenar todos los campos para guardar.</strong></p>';
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
<?php
    session_start();
    if(!empty($_SESSION['usuario']) && ($_SESSION['tipo'] == 'Administrador' || $_SESSION['tipo'] == 'Editor')) {
        $ruta = "../css";
        require_once("../html/encabezado.html");
        require_once("menu.php");
        require_once("conexion.php");
?>

<main>
    <h2>Editar datos de la película</h2>
    <article class="contenedor-form-pelicula">

        <?php
            
            $conexion = conectar();
         
            if (!empty($_GET['id'])) {     //LA CONEXIÓN SE CONTROLÓ CON UN IF EN LA FUNCIÓN conectar()

                $id = $_GET['id']; 
                $consulta = 'SELECT * FROM usuario WHERE id =' . $id;
                $resultado_consulta = mysqli_query($conexion, $consulta);
        
                if(mysqli_num_rows($resultado_consulta) === 1)  { 

                    $fila = mysqli_fetch_array($resultado_consulta);

                    $id = $fila['id'];
                    $usuario = $fila['usuario'];
                    $password = $fila['password'];
                    $mail = $fila['mail'];
                    $tipo = $fila['tipo'];
                    $foto_portada = $fila['foto'];

                    $rutaImg = (!empty($foto_portada) && file_exists('../img/usuarios/' . $foto_portada)) ? '../img/usuarios/' . $foto_portada : '../img/sin_imagen.png';
        ?>

    <figure id="portada"><img src="../img/<?php echo $rutaImg ?>" alt="Foto de perfil"></figure>
    
    <form action="usuario_modificar_ok.php" method="POST" enctype="multipart/form-data">
        <fieldset>

            <input type="hidden" value="<?php echo $id ?>" name="id">

            <label for="usuario">Usuario: </label>
                <input type="text" name="usuario" id="usuario" maxlength="40" value="<?php echo $usuario; ?>" placeholder="Ingrese el nombre de usuario..." required>
            <label for="pass">Cambiar Contraseña? </label>
                <input type="password" name="password" id="pass" placeholder="Ingrese la nueva contraseña...">
            <label for="mail">Mail: </label>
                <input type="email" name="mail" id="mail" value="<?php echo $mail; ?>" placeholder="Ingrese la casilla de correo..." required>
            <label for="tipo">Tipo: </label>
                <select name="tipo" id="tipo" required>
                    <option value="Restringido"     <?php if($tipo=='Restringido') echo 'selected' ?>>Restringido</option>
                    <option value="Editor"          <?php if($tipo=='Editor') echo 'selected' ?>>Editor</option>
                    <option value="Administrador"   <?php if($tipo=='Administrador') echo 'selected' ?>>Administrador</option>
                </select>
            <label for="foto">Desea actualizar la foto? </label>
                <input type="file" name="foto" id="foto" accept="image/*">
            <fieldset class="botones">
                <input type="submit" value="Guardar">
                <a href="usuario_listado.php">Cancelar</a>
            </fieldset>
        </fieldset>
    </form>
        
        <?php
                }
                else {
                    echo '<p>Error al realizar la operación.</p>';
                    header('refresh:3; url=usuario_listado.php');
                }
            }
            else {
                echo '<p>No se seleccionó ninguna película.</p>';
                header('refresh:3; url=usuario_listado.php');
            }
            desconectar($conexion);
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
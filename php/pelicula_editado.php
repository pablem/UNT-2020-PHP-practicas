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
         
            if ($conexion && !empty($_GET['id'])) {     //LA CONEXIÓN SE CONTROLÓ CON UN IF EN LA FUNCIÓN conectar()
                $id = $_GET['id']; 
                $consulta = 'SELECT * FROM pelicula WHERE id =' . $id;
                $resultado_consulta = mysqli_query($conexion, $consulta);
        
                if(mysqli_num_rows($resultado_consulta) === 1)  { 
                    $fila = mysqli_fetch_array($resultado_consulta);
                    $titulo = $fila['titulo'];
                    $duracion = $fila['duracion'];
                    $genero = $fila['genero'];
                    $fecha_estreno = $fila['fecha_estreno'];
                    $foto_portada = $fila['foto_portada'];

                    $rutaImg = (!empty($foto_portada) && file_exists('../img/portadas/' . $foto_portada)) ? '../img/portadas/' . $foto_portada : '../img/sin_imagen.png';
        ?>

    <figure id="portada"><img src="../img/<?php echo $rutaImg ?>" alt="Foto de portada"></figure>
    <form action="pelicula_actualizar.php" method="POST" enctype="multipart/form-data">
        <fieldset>
            <input type="hidden" value="<?php echo $id ?>" name="id">
            <label for="titulo">Título: </label>
                <input type="text" name="titulo" id="titulo" maxlength="60" value="<?php echo $titulo; ?>" placeholder="Ingrese el títuo..." required>
            <label for="dura">Duración: </label>
                <input type="number" name="duracion" id="dura" value="<?php echo $duracion; ?>" placeholder="Ingrese su duración...">
            <label for="gen">Género: </label>
                <select name="genero" id="gen">
                    <option value="Acción"      <?php if($genero=='Acción')     echo 'selected' ?>>Acción</option>
                    <option value="Animé"       <?php if($genero=='Animé')      echo 'selected' ?>>Animé</option>
                    <option value="Ciencia Ficción" <?php if($genero=='Ciencia Ficción') echo 'selected'; ?>>Ciencia Ficción</option>
                    <option value="Comedia"     <?php if($genero=='Comedia')    echo 'selected' ?>>Comedia</option>
                    <option value="Documental"  <?php if($genero=='Documental') echo 'selected' ?>>Documental</option>
                    <option value="Drama"       <?php if($genero=='Drama')      echo 'selected' ?>>Drama</option>
                    <option value="Infantil y Familiar" <?php if($genero=='Infantil y Familiar') echo 'selected'; ?>>Infantil y Familiar</option>
                    <option value="Terror"      <?php if($genero=='Terror')     echo 'selected' ?>>Terror</option>
                    <option value="Otros"       <?php if($genero=='Otros')      echo 'selected' ?>>Otros</option>
                </select>
            <label for="fecha">Fecha de estreno: </label>
                <input type="date" id="fecha" name="fecha_estreno" min="1900-01-01" value="<?php echo $fecha_estreno; ?>">
            <label for="foto">Desea actualizar la portada? </label>
                <input type="file" name="foto_portada" id="foto" accept="image/*">
            <fieldset class="botones">
                <input type="submit" value="Guardar">
                <a href="pelicula_listado.php">Cancelar</a>
            </fieldset>
        </fieldset>
    </form>
        
        <?php
                }
                else {
                    echo '<p>Error al realizar la operación.</p>';
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
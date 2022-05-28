<?php
    session_start();
    if(!empty($_SESSION['usuario']) && $_SESSION['tipo'] == 'Administrador') {
        $ruta = "../css";
        require_once("../html/encabezado.html");
        require_once("menu.php");
        require_once("conexion.php");
?>

<main>
    <h2>Agregar películas</h2>
    <article class="contenedor-form-pelicula">
        <form action="pelicula_guardar.php" method="POST" enctype="multipart/form-data">
            <fieldset>
                <label for="titulo">Título: </label>
                    <input type="text" name="titulo" id="titulo" maxlength="60" placeholder="Ingrese el títuo..." required>
                <label for="dura">Duración: </label>
                    <input type="number" name="duracion" id="dura" placeholder="Ingrese su duración...">
                <label for="gen">Género: </label>
                    <select name="genero" id="gen">
                        <option value="Acción" selected>Acción</option>
                        <option value="Animé">Animé</option>
                        <option value="Ciencia Ficción">Ciencia Ficción</option>
                        <option value="Comedia">Comedia</option>
                        <option value="Documental">Documental</option>
                        <option value="Drama">Drama</option>
                        <option value="Infantil y Familiar">Infantil y Familiar</option>
                        <option value="Terror">Terror</option>
                        <option value="Otros">Otros</option>
                    </select>
                <label for="fecha">Fecha de estreno: </label>
                    <input type="date" id="fecha" name="fecha_estreno" min="1900-01-01">
                <label for="foto">Foto de portada: </label>
                    <input type="file" name="foto" id="foto" accept="image/*">
                <fieldset class="botones"><input type="submit" value="Guardar"></fieldset>
            </fieldset>
        </form>
    </article>
</main>
</section>
<?php
    require_once("../html/pie.html");
} else {
    header('refresh:0; url=pelicula_listado.php');
}
?>
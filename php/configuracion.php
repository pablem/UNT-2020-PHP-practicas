<?php
    session_start();
    if(!empty($_SESSION['usuario'])) {
        $ruta = "../css";
        require_once("../html/encabezado.html");
        require_once("menu.php");
?>

<main>
    <h2>Configuración</h2>

    <article class="contenedor-form-pelicula contenedor-form-config">

    <form action="configuracion_ok.php" method="POST">
        <fieldset>
            <label for="mod">Moderno </label>
                <input type="radio" id="mod" name="estilo" value="moderno" checked>
            <figure><img src="../img/moderno.jpg" alt="captura de pantalla de la página con estilo moderno"></figure>
            <label for="cls">Clásico </label>
                <input type="radio" id="cls" name="estilo" value="clasico">
            <figure><img src="../img/clasico.jpg" alt="captura de pantalla de la página con estilo clásico"></figure>
            <fieldset class="botones">
                <input type="submit" value="Guardar">
                <a href="pelicula_listado.php">Cancelar</a>
            </fieldset>
        </fieldset>
    </form>
        
    </article>
</main>
</section>
<?php
    require_once("../html/pie.html");
} else {
    header('refresh:0; url=../index.php');
}
?>
<?php
    session_start();
    if(!empty($_SESSION['usuario'])) {
        $ruta = "../css";
        require_once("../html/encabezado.html");
        require_once("menu.php");
        require_once("conexion.php");
?>

<main>
    <h2>Contáctenos</h2>
    <article class="contenedor-form-pelicula">
        <form id="form-contactenos" action="envio_mail.php" method="POST">
            <label for="motivo">Motivo: </label>
                <select name="motivo" id="motivo">
                    <option value="Sugerencias" selected>Sugerencias</option>
                    <option value="Reclamo">Reclamo</option>
                </select>
            <label for="mje">Mensaje: </label>
                <textarea name="mensaje" id="mje" cols="30" rows="10" placeholder="Ingrese aquí su mensaje..." required></textarea>
                <fieldset class="botones"><input type="submit" value="Enviar"></fieldset>
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
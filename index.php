
<?php
    $ruta = 'css';
    require_once("html/encabezado.html");
?>

<main>
    <article id="contenedor-login">
        <form action="php/loguear.php" method="POST">
            <fieldset>
                <legend>Inicie Sesión</legend>
                <label for="usuario">Usuario: </label>
                    <input type="text" name="usuario" id="usuario" maxlength="30" placeholder="Usuario" autocomplete="off" required>
                <label for="clave">Contraseña: </label>
                    <input type="password" name="clave" id="clave" maxlength="30" placeholder="Contraseña" autocomplete="off" required>
                <input type="submit" value="Iniciar sesión">
            </fieldset>
        </form>
    </article>
</main>

<?php
    require_once("html/pie.html");
?>
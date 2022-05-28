<?php
    session_start();
    if(!empty($_SESSION['usuario']) && $_SESSION['tipo'] == 'Administrador') {
        $ruta = "../css";
        require_once("../html/encabezado.html");
        require_once("menu.php");
        require_once("conexion.php");
?>

<main>
    <h2>Agregar usuario</h2>
    <article class="contenedor-form-pelicula">
        <form action="usuario_alta_ok.php" method="POST" enctype="multipart/form-data">
            <fieldset>
                <label for="usuario">Usuario: </label>
                    <input type="text" name="usuario" id="usuario" maxlength="40" placeholder="Ingrese el nombre de usuario..." required>
                <label for="pass">Contraseña: </label>
                    <input type="password" name="password" id="pass" placeholder="Ingrese la contraseña del nuevo usuario..." required>
                <label for="mail">Mail: </label>
                    <input type="email" name="mail" id="mail" placeholder="Ingrese la casilla de correo..." required>
                <label for="tipo">Tipo: </label>
                    <select name="tipo" id="tipo" required>
                        <option value="Restringido" selected>Restringido</option>
                        <option value="Editor">Editor</option>
                        <option value="Administrador">Administrador</option>
                    </select>
                <label for="foto">Foto de perfil: </label>
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
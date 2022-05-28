<?php
    if(!empty($_SESSION['usuario'])) {
        
        $foto_perfil = (empty($_SESSION['foto'])) ? 'usuario_default.png' : $foto_perfil = $_SESSION['foto'];
        $tipo_accs = $_SESSION['tipo'];
?>

<section>
    <nav>
        <article>
            <figure><img src="../img/usuarios/<?php echo $foto_perfil ?>" alt="foto de perfil"></figure>
            <p><?php echo  $_SESSION['usuario'] ?> | <a href="cerrar.php">Cerrar sesión</a></p>
        </article>
        <h2>Usuarios</h2>
        <ul>
            <?php if ($tipo_accs == 'Administrador') echo '<li><a href="usuario_alta.php">Nuevo usuario</a></li>'; ?>
            <li><a href="usuario_listado.php">Listado usuarios</a></li>
        </ul>

        <h2>Películas</h2>
        <ul>
            <?php if ($tipo_accs == 'Administrador') echo '<li><a href="pelicula_alta.php">Agregar películas</a></li>'; ?>
            <li><a href="pelicula_listado.php">Listar películas</a></li>
            <li><a href="favoritas_listado.php">Listar Favoritas</a></li>
        </ul>

        <h2>Opciones</h2>
        <ul>
            <li><a href="contactenos.php">Contáctenos</a></li>
            <li><a href="configuracion.php">Configuración</a></li>
        </ul>
    </nav>

    <?php
        } else {
            header('refresh:0; url=../index.php');
        }
    ?>
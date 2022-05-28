<?php
    session_start();
    if(!empty($_SESSION['usuario'])) {
        $ruta = "../css";
        require_once("../html/encabezado.html");
        require_once("menu.php");
        require_once("conexion.php");
?>

<main>
    <article class="contenedor-mensaje">
        <?php 

            if (!empty($_GET['id'])) {
                
                $id = $_GET['id']; 
                $usu = $_SESSION['usuario'];
                
                if(!empty($_COOKIE[$usu]) && isset($_COOKIE[$usu])) {
                    $cadena = $_COOKIE[$usu];
                    $cadena .= '-' . $id;
                }
                else {
                    $cadena = $id;
                }
                $tiempo_expira = time() + 60*24*60*60;
                setcookie($usu,$cadena,$tiempo_expira,'/');
                
                echo '<p>Película añadida a favoritas.</p>';
            }
            else {
                echo '<p>No seleccionó ninguna película.</p>';
            }
            header('refresh:2; url=pelicula_listado.php');
        ?>
    </article>
</main>
</section>
<?php
    require_once("../html/pie.html");
} else {
    header('refresh:0; url=../index.php');
}
?>
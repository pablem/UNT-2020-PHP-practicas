<?php
    session_start();
    if(!empty($_SESSION['usuario'])) {
        $ruta = "../css";
        require_once("../html/encabezado.html");
        require_once("menu.php");
?>

<main>
    <article class="contenedor-mensaje">
        <?php 

            if (!empty($_POST['estilo'])) {
                
                $tiempo_expira = time() + 60*24*60*60;
                setcookie('estilo_' . $_SESSION['usuario'],$_POST['estilo'],$tiempo_expira,'/');

                header('refresh:0; url=configuracion.php');
            }
            else {
                echo '<p>No seleccionó ninguna configuración.</p>';
                header('refresh:3; url=configuracion.php');
            }

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
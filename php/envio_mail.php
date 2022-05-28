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

            if (empty($_POST['motivo']) || empty($_POST['mensaje'])) {
                echo '<p><strong>Debe escribir un mensaje y seleccionar un motivo para enviar.</strong></p>';
                header('refresh:3; url=contactenos.php');
            }
            else {

                $usuario = $_SESSION['usuario'];
                $correoOrigen = $_SESSION['mail'];
                $correoDestino = 'palmierijpablo@gmail.com';

                $mensaje = $_POST['mensaje'];
                $motivo = $_POST['motivo'];
                $asunto = $motivo . ' - ' . $usuario;
                
                $cabecera = 'From: ' . $correoOrigen . "\r\n" . 'Reply-to: ' . $correoOrigen;
                
                $resultado = mail($correoDestino, $asunto, $mensaje, $cabecera);

               if($resultado) {
                    echo '<p>Mensaje enviado!</p>';
                    header('refresh:2; url=pelicula_listado.php');
                } else {
                    echo '<p>No se pudo enviar su mensaje.</p>';
                    header('refresh:2; url=contactenos.php');
                }
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
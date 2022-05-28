<?php
    session_start();
    if(!empty($_SESSION['usuario'])) {
        $ruta = "../css";
        require_once("../html/encabezado.html");
        require_once("menu.php");
        require_once("conexion.php");
?>

<main>
    <h2>Listado de usuarios</h2>
    
    <?php 

        //cargar bd y mostrar
        
        $conexion = conectar();
            //LA CONEXIÓN SE CONTROLÓ CON UN IF EN LA FUNCIÓN conectar() --> ÑO
        $consulta = 'SELECT * FROM usuario';
        $resultado_consulta = mysqli_query($conexion, $consulta);
        desconectar($conexion);

        if($resultado_consulta) {

            if (mysqli_num_rows($resultado_consulta)) {                
    ?>
    
    <table>
        <tr>
            <th scope="col">Usuario</th>
            <th scope="col">Mail</th>
            <th scope="col">Fecha alta</th>
            <th scope="col">Tipo</th>
            <?php 
                if ($_SESSION['tipo'] == 'Administrador' || $_SESSION['tipo'] == 'Editor') 
                    echo '<th scope="col">Modificar</th>';
                if ($_SESSION['tipo'] == 'Administrador') 
                    echo '<th scope="col">Eliminar</th>';
            ?>
        </tr>

    <?php
                while ($fila = mysqli_fetch_array($resultado_consulta)) {
                    
                    echo '<tr>';
                    echo '<td>' . $fila['usuario'] . '</td>';
                    echo '<td>' . $fila['mail'] . '</td>';
                    echo '<td>' . $fila['fecha_alta'] . '</td>';
                    echo '<td>' . $fila['tipo'] . '</td>';
                    if ($_SESSION['tipo'] == 'Administrador' || $_SESSION['tipo'] == 'Editor') 
                        echo '<td><a href="usuario_modificar.php?id=' . $fila['id'] .'"><img class="icono" src="../img/edit_pencil.png" alt="modificar"></a></td>';
                    if ($_SESSION['tipo'] == 'Administrador') 
                        echo '<td><a href="usuario_eliminar.php?id=' . $fila['id'] .'"><img class="icono" src="../img/trash_empty.png" alt="eliminar"></a></td>';
                    echo '</tr>';
                }

            } else {
                echo '<p>No se encontraron resultados.</p>';
                header('refresh:3; url=../index.php');
            }

        } else {
            echo '<p>Error al realizar la operación.</p>';
            header('refresh:3; url=../index.php');
        }
    ?>
    </table>
</main>
</section>
<?php
    require_once("../html/pie.html");
} else {
    header('refresh:0; url=../index.php');
}
?>
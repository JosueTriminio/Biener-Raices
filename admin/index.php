<?php

// REQUERIR CONEXION
require '../includes/config/database.php';
// INSTANCIAR CONEXION
$db = conectarDB();
// REALIZAR LAQUERY
$query = "SELECT * FROM propiedades";
// FINALIZAR CONSULTA
$resultado = mysqli_query($db, $query);

// MOSTRAR MENSAJE DESPUES DE CREAR UNA PROPIEDAD 'ANUNCIO'
$mensaje = $_GET['result'] ?? null;


// BORRAR PROPIEDADES

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if ($id) {
        // Eliminar imagen
        $query = "SELECT imagen FROM propiedades WHERE id = {$id}";
        $resultado = mysqli_query($db, $query);
        $imagen_propiedad = mysqli_fetch_assoc($resultado);
        unlink('../imgPropiedades/'. $imagen_propiedad['imagen']);

        //Eliminar Propiedad 
        $query = "DELETE FROM propiedades  WHERE id = {$id}";
        $resultado = mysqli_query($db, $query);
        if ($resultado) {
            header('location: /admin?result=3');
        }
    }
}



require '../includes/funciones.php';
incluirTemplate('header');
?>
<main class="contenedor seccion">

    <h1>Administrador de Bienes Raices</h1>
    <?php
    if (intval($mensaje) === 1) : ?>
        <p class="alerta exito">Anuncio Creado Correctamente!</p>
    <?php elseif (intval($mensaje) === 2) : ?>
        <p class="alerta exito">Anuncio Actualizado Correctamente!</p>;
    <?php elseif (intval($mensaje) === 3) : ?>
        <p class="alerta exito">Anuncio Eliminado Correctamente!</p>;
    <?php endif ?>
    <a href="/admin/propiedades/crear.php" class="boton boton-verde">Crear Propiedad</a>

    <!-- MOSTRAR PROPIEDADES -->
    <table class="tabla_propiedades">
        <thead>
            <tr>
                <th>ID</th>
                <th>Titulo</th>
                <th>Imagen</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
        <tbody class="container">
            <?php
            while ($res = mysqli_fetch_assoc($resultado)) : ?>

                <tr>
                    <td><?php echo $res['id']; ?></td>
                    <td><?php echo $res['titulo']; ?></td>
                    <td><img src="/imgPropiedades/<?php echo $res['imagen']; ?>" alt="casa de lujo" class="imagen-tabla"></td>
                    <td> € <?php echo $res['precio']; ?></td>
                    <td class="btn">

                        <form method="post">
                            <input type="hidden" name="id" value="<?php echo $res['id']; ?>">
                            <input type="submit" value="Eliminar" class="btn_eliminar">
                        </form>
                        <a href="admin/propiedades/actualizar.php?id=<?php echo $res['id']; ?>" class="btn_actualizar">Actualizar</a>
                    </td>
                </tr>

            <?php endwhile ?>


        </tbody>
        </thead>

    </table>


</main>

<?php
incluirTemplate('footer');
?>
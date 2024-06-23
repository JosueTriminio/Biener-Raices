<?php
// conexion DB
require '../../includes/config/database.php';
$db = conectarDB();
$errores = [];
$titulo = '';
$precio = '';
$imagen = '';
$descripcion = '';
$habitaciones = '';
$wc = '';
$estacionamiento = '';
$vendedorId = '';

$consulta = "SELECT * FROM  vendedor";
$resultadoVendedor = mysqli_query($db, $consulta);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Proyeger validar y sanitizar los envios a DB ebitar la inyeccion sql 

    $titulo = mysqli_real_escape_string($db, $_POST['titulo']);
    $precio = mysqli_real_escape_string($db, $_POST['precio']);
    $descripcion = mysqli_real_escape_string($db, $_POST['descripcion']);
    $habitaciones = mysqli_real_escape_string($db, $_POST['habitaciones']);
    $wc = mysqli_real_escape_string($db, $_POST['wc']);
    $estacionamiento = mysqli_real_escape_string($db, $_POST['estacionamiento']);
    $vendedorId = mysqli_real_escape_string($db, $_POST['vendedor']);

    // Asignar Files a una variable

    $imagen = $_FILES['imagen'];


    if (!$titulo) {
        $errores[] = 'Debes añadir un titulo';
    }
    if (!$precio) {
        $errores[] = 'Debes añadir un precio';
    }
    if (!$descripcion) {
        $errores[] = 'Debes añadir una descripcion';
    }
    if (!$habitaciones) {
        $errores[] = 'Falta añadir habitaciones';
    }
    if (!$wc) {
        $errores[] = 'Falta añadir Baños';
    }
    if (!$vendedorId) {
        $errores[] = 'Elige un vendedor';
    }

    //validar iamgenes
    $peso_img = 1000 * 1000;

    if (!$imagen['name'] || $imagen['error']) { 
        $errores[] = 'La imagen es obligatoria';
    }


    if ($imagen['size'] > $peso_img) {
        $errores[] = 'Esta imagen en muy grande el peso maximo es: 1mb';
    }


        // Validar si hay errores

    if (empty($errores)) {
        //** SUBIR ARCHIVOS */

        //**CREAR CARPETA PARA IMAGENES */
        $carpetaImg = '../../imgPropiedades/';

        if (!is_dir($carpetaImg)) {
            mkdir($carpetaImg, 0777,true);
        }

        //** GENERAR NOMBRE UNICO */
        $nombreImg = md5(uniqid(rand(),true)) . ".jpg" ;

        //** SUBIR LA IMAGEN */
        move_uploaded_file($imagen['tmp_name'],$carpetaImg .$nombreImg);
      

        // INSERTAR EN DB
        $query = "INSERT INTO propiedades (titulo,precio,descripcion,imagen,habitaciones,wc,estacionamiento,vendedor_id)
        VALUES ('$titulo',$precio,'$descripcion','$nombreImg',$habitaciones,$wc,$estacionamiento,$vendedorId)";
        $resultado = mysqli_query($db, $query);

        if ($resultado) {
            // Redireccionar despues de insertar los datos
            header('location: /admin?result=1');
        }
    }
}




require '../../includes/funciones.php'; 
incluirTemplate('header');
?>
<main class="contenedor seccion">
    <h1>Crear</h1>
    <a href="/admin" class="boton boton-verde">Volver</a>

    <!-- VALIDADOR-->

    <?php foreach ($errores as $error) { ?>

        <div class="alerta error">
            <?php echo $error ?>
        </div>

    <?php } ?>
    <!-- Formulario  -->
    <form action="/admin/propiedades/crear.php" class="formulario" method="post" enctype="multipart/form-data">
        <fieldset>
            <legend>Informacion General</legend>
            <label for="titulo">Titulo</label>
            <input type="text" name="titulo" id="titulo" placeholder="Nombre de la Propiedad" value="<?php echo $titulo ?>">
            <label for="titulo">Precio</label>
            <input type="number" min="1" name="precio" id="precio" placeholder="Precio de la Propiedad" value="<?php echo $precio ?>">
            <label for="imagen">imagen</label>
            <input type="file" name="imagen" id="imagen" accept="image/jpg, image/png, image/webp">
            <label for="descripcion">Descripcion</label>
            <textarea name="descripcion" id="descripcion"><?php echo $descripcion ?></textarea>
        </fieldset>
        <fieldset>
            <legend>Informacion de la Propiedad</legend>
            <label for="habitaciones"> Habitaciones</label>
            <input type="number" min="1" max="9" id="habitaciones" name="habitaciones" placeholder="Numero de habitaciones" value="<?php echo $habitaciones ?>">
            <label for="wc">Baños</label>
            <input type="number" min="1" max="9" id="wc" name="wc" placeholder="Baños eje:3" value="<?php echo $wc ?>">
            <label for="estacionamiento">Estacionamientos</label>
            <input type="number" min="1" max="9" id="estacionamiento" name="estacionamiento" placeholder="Estacionamiento eje:3" value="<?php echo $estacionamiento ?>">
        </fieldset>
        <fieldset>
            <legend>Vendedor</legend>
            <label>Selecciona un vendedor</label>
            <select name="vendedor" value="<?php echo $vendedorId ?>">
                <option value="">-- Elige un vendedor --</option>
                <?php
                while ($vendedor = mysqli_fetch_assoc($resultadoVendedor)) { ?>
                    <option <?php echo $vendedorId  === $vendedor['id'] ? 'selected' : ''; ?> value=<?php echo $vendedor['id']; ?>>
                        <?php echo $vendedor['nombre'] . " " . $vendedor['apellido']; ?>
                    </option>
                <?php } ?>
            </select>
        </fieldset>
        <input type="submit" class="boton boton-verde" value="Crear Propiedad">
    </form>

</main>

<?php
incluirTemplate('footer');
?>
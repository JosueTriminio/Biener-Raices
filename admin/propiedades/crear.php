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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $precio = $_POST['precio'];
    $imagen = $_POST['imagen'];
    $descripcion = $_POST['descripcion'];
    $habitaciones = $_POST['habitaciones'];
    $wc = $_POST['wc'];
    $estacionamiento = $_POST['estacionamiento'];
    $vendedorId = $_POST['vendedor'];

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
        $errores[] = 'Falta añadir Baño';
    }
    if (!$vendedorId) {
        $errores[] = 'Elige un vendedor';
    }

    if (empty($errores)) {
        // INSERTAR EN DB

        $query = "INSERT INTO propiedades (titulo,precio,descripcion,habitaciones,wc,estacionamiento,vendedor_id)
        VALUES ('$titulo',$precio,'$descripcion',$habitaciones,$wc,$estacionamiento,$vendedorId)";
        $resultado = mysqli_query($db, $query);
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
    <form action="/admin/propiedades/crear.php" class="formulario" method="post">
        <fieldset>
            <legend>Informacion General</legend>
            <label for="titulo">Titulo</label>
            <input type="text" name="titulo" id="titulo" placeholder="Nombre de la Propiedad" value="<?php echo $titulo ?>">
            <label for="titulo">Precio</label>
            <input type="number" min="1" name="precio" id="precio" placeholder="Precio de la Propiedad" value="<?php echo $precio ?>">
            <label for="imagen">imagen</label>
            <input type="file" name="imagen" id="imagen" accept="image/jpg, image/png, image/webp">
            <label for="descripcion">Descripcion</label>
            <textarea name="descripcion" id="descripcion" value="<?php echo $descripcion ?>"></textarea>
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
                <option value="1">Josue</option>
                <option value="2">Tania</option>
            </select>
        </fieldset>
        <input type="submit" class="boton boton-verde" value="Crear Propiedad">
    </form>

</main>

<?php
incluirTemplate('footer');
?>
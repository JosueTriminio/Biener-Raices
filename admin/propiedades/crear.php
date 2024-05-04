<?php
// conexion DB
require '../../includes/config/database.php';
$db=conectarDB();

/*echo '<pre>';
var_dump($db);
echo '</pre>';
*/
require '../../includes/funciones.php';
incluirTemplate('header');
?>
<main class="contenedor seccion">
    <h1>Crear</h1>
    <a href="/admin" class="boton boton-verde">Volver</a>
    <form action="" class="formulario">
        <fieldset>
            <legend>Informacion General</legend>
            <label for="titulo">Titulo</label>
            <input type="text" name="titulo" id="titulo" placeholder="Nombre de la Propiedad">
            <label for="titulo">Precio</label>
            <input type="number" min="1" name="precio" id="precio" placeholder="Precio de la Propiedad">
            <label for="imagen">imagen</label>
            <input type="file" name="imagen" id="imagen" accept="image/jpg, image/png, image/webp">
            <label for="descripcion">Descripcion</label>
            <textarea name="descripcion" id="descripcion"></textarea>
        </fieldset>
        <fieldset>
            <legend>Informacion de la Propiedad</legend>
            <label for="habitaciones"> Habitaciones</label>
            <input type="number" min="1" max="9" id="habitaciones" placeholder="Numero de habitaciones">
        </fieldset>
        <fieldset>
            <legend>Vendedor</legend>
            <label>Selecciona un vendedor</label>
            <select name="vendedor">
                <option selected disabled>-- Elige un vendedor --</option>
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
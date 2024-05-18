<?php
// MOSTRAR MENSAJE DESPUES DE CREAR UNA PROPIEDAD 'ANUNCIO'
$mensaje = $_GET['result']?? null;
require '../includes/funciones.php';
incluirTemplate('header');
?>
    <main class="contenedor seccion">
        <h1>Administrador de Bienes Raices</h1>
        <?php
            if (intval($mensaje) === 1) { ?>
                <p class="alerta exito">Anuncio Creado Correctamente!</p>                

        <?php }?>
        <a href="/admin/propiedades/crear.php" class="boton boton-verde">Crear Propiedad</a>
    </main>

<?php
incluirTemplate('footer');
?>
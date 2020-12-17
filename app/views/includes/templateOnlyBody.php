<!--
Será la plantilla para solo imprimir el cuerpo.
Será utilizada para imprimir en pdf las vistas.
-->
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
        require ("head.php");//Carga el header.php
    ?>
</head>
<!--Cargará el body según el $viewClass y $viewName de la clase View.php-->
<body class="<?php echo $viewClass; ?>"> 
    <?php
        require ($viewRuta); //Carga la vista que queremos(contenido del body). 
    ?>
</body>
<footer>
    <?php require ("footer.php");//Carga el footer.php?>
</footer>
</html>
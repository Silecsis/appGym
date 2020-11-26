<!--
Será la plantilla de las vistas que incluyen el header y footer de include y el body de las vistas inheaderiduales.
-->
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
        require_once ("head.php");//Carga el header.php
    ?>
</head>
<!--Cargará el body según el $viewClass y $viewName de la clase View.php-->
<body class="<?php echo $viewClass; ?>"> 
    <?php
        require_once ("header.php");
        require_once ($viewRuta); //Carga la vista que queremos(contenido del body). 
    ?>
</body>
<footer>
    <?php require_once ("footer.php");//Carga el footer.php?>
</footer>
</html>
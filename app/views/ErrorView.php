<!--Vista que mostrará un simple error según el error pasado por parámetro.-->
<!--METER EN SWITCH-->
<?php 
    if(isset($_GET["type"])){
        if($_GET["type"]=="editSelfAdmin"){
            echo '<div class="alert alert-danger" style="margin-top:5px;"> Un administrador no se puede editar a sí mismo desde el panel de listar usuarios.<br/> </div>';
        }else if($_GET["type"]=="unexpected"){
            echo '<div class="alert alert-danger" style="margin-top:5px;"> Error inesperado.<br/> </div>';
        }
    }else{
        echo '<div class="alert alert-danger" style="margin-top:5px;"> Error inesperado.<br/> </div>';
    }
?>
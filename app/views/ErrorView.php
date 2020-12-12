<!--Vista que mostrará un simple error según el error pasado por parámetro.-->
<!--METER EN SWITCH-->
<?php 
    if(isset($_GET["type"])){

        switch($_GET["type"]){
            case "editSelfAdmin":
                    echo '<div class="alert alert-danger" style="margin-top:5px;"> Un administrador no se puede editar a sí mismo desde el panel de listar usuarios.<br/> </div>';
                break;

            case "deleteSelfAdmin":
                echo '<div class="alert alert-danger" style="margin-top:5px;">  Un administrador no se puede eliminarse a sí mismo.<br/> </div>';
                break;

            case "changeStatusSelf":
                echo '<div class="alert alert-danger" style="margin-top:5px;">  Un administrador no se puede cambiar el estado a sí mismo.<br/> </div>';
                break;

            case "unexpected":
                    echo '<div class="alert alert-danger" style="margin-top:5px;"> Error inesperado.<br/> </div>';
                break;

            case "noAdmin":
                    echo '<div class="alert alert-danger" style="margin-top:5px;"> No puede acceder a este sitio sin ser administrador.<br/> </div>';
                break;
            
            case "":
                break;
        }
    }else{
        echo '<div class="alert alert-danger" style="margin-top:5px;"> Error inesperado.<br/> </div>';
    }
?>
<!--Vista de "editar actividad" desde el admin.
        Es la vista del formulario de editar la actividad desde la lista de usuarios y
        es la vista de "nueva actividad".-->

<div class="formAdminEU">
    <div class="container cuerpo text-center">
        <?php if(isset($_GET["id"])){ ?>	
            <p><h2>Editar actividad con id <?php echo $_GET["id"]?></h2></p>
        <?php }else{ ?>
            <p><h2>Crear nueva actividad</h2></p>
        <?php } ?>
    </div>
    <div class="container formContainer">
        <!--Se recarga a sí misma.-->
        <form action="" method="POST" enctype="multipart/form-data" class="formAdminEdit">
            <div class="text-center">
                <?php 
                    if (isset($_GET["success"]) && $_GET["success"]){
                        echo '<div class="alert alert-success" style="margin-top:5px;"> La edición ha sido realizada correctamente. </div>';
                        
                    }else if(isset($_GET["message"]) && $_GET["message"]=="created"){
                        echo '<div class="alert alert-success" style="margin-top:5px;"> La actividad se ha creado correctamente. </div>';
                    }
                ?> 
            </div>
            <label for="nombre">Nombre
                <input type="text" name="nombre" class="form-control" <?php rememberValue($_POST["nombre"],$activity->nombre) ?> /> 
                <?php echo mostrar_error($errors, "nombre"); ?>  
            </label>
            <br/>
            <label for="descripcion"> Descripción
                <input type="text" name="descripcion" class="form-control" <?php rememberValue($_POST["descripcion"],$activity->descripcion) ?> /> 
                <?php echo mostrar_error($errors, "descripcion"); ?>  
            </label>
            <br/>
            <label for="aforo"> Aforo
                <input type="number" name="aforo" class="form-control" <?php rememberValue($_POST["aforo"],$activity->aforo) ?> /> 
                <?php echo mostrar_error($errors, "aforo"); ?>  
            </label>
            <br>

            <div class=" text-right">
                <button type="button" class="btn btn-secondary" onclick="location.href='index.php?controller=adminActivities&action=listActivities&pagina=1&rxp=10'">Volver a "Listar actividades"</button>
                <?php if(isset($_GET["id"])){ ?>	
                    <input type="submit" name="submit" value="Editar actividad"  class="btn btn-primary"/> 
                <?php }else{ ?>
                    <input type="submit" name="submit" value="Crear actividad"  class="btn btn-primary"/> 
                <?php } ?>   
            </div>   
        </form>
    </div>
</div>
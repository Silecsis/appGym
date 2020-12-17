<!--Vista de "editar tramo" desde el admin.
        Es la vista del formulario de editar el tramo desde la lista de tramos y
        es la vista de "nuevo tramo".-->

        <div class="formAdminEU">
    <div class="container cuerpo text-center">
        <?php if(isset($_GET["id"])){ ?>	
            <p><h2>Editar tramo con id <?php echo $_GET["id"]?></h2></p>
        <?php }else{ ?>
            <p><h2>Crear nuevo tramo</h2></p>
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
            <label class="blu">Día: 
                    <select name="dia" class="blu"> <br>
                        <option value="" <?php rememberValueSelect($_GET["dia"],"",$vacio) ?>>Seleccionar</option>
                        <!--Recorremos la base de datos de dias para poner las opciones-->
                        <?php foreach ($days as $dd) :?>
                            <option value="<?php echo $dd["id"]?>" <?php rememberValueSelect($_POST["dia"],$dd["id"],$tramo->dia) ?>> <?php echo $dd["dia"] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php echo mostrar_error($errors, "dia"); ?>
            </label>
            <br/>
            <label for="hora_inicio">Hora de inicio
                <input type="text" name="hora_inicio" class="form-control" <?php rememberValue($_POST["hora_inicio"],$tramo->hora_inicio) ?> /> 
                <?php echo mostrar_error($errors, "hora_inicio"); ?>  
            </label>
            <br/>
            <label for="hora_fin">Hora de fin
                <input type="text" name="hora_fin" class="form-control" <?php rememberValue($_POST["hora_fin"],$tramo->hora_fin) ?> /> 
                <?php echo mostrar_error($errors, "hora_fin"); ?>  
            </label>
            <br/>
            <label class="blu">Actividad: 
                    <select name="actividad_id" class="blu"> <br>
                        <option value="" <?php rememberValueSelect($_GET["actividad"],"",$vacio) ?>>Seleccionar</option>
                        <!--Recorremos la base de datos de dias para poner las opciones-->
                        <?php foreach ($activities as $a) :?>
                            <option value="<?php echo $a["id"]?>" <?php rememberValueSelect($_POST["actividad_id"],$a["id"],$tramo->actividad_id) ?>> <?php echo $a["nombre"] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php echo mostrar_error($errors, "actividad_id"); ?>
            </label>
            <br/>
            <label for="fecha_alta"> Fecha de alta:
                <input type="text" name="fecha_alta" class="form-control" <?php rememberValue($_POST["fecha_alta"],$tramo->fecha_alta) ?> /> 
                <?php echo mostrar_error($errors, "fecha_alta"); ?>  
            </label>
            <br/>
            <label for="fecha_baja"> Fecha de baja:
                <input type="text" name="fecha_baja" class="form-control" <?php rememberValue($_POST["fecha_baja"],$tramo->fecha_baja) ?> /> 
                <?php echo mostrar_error($errors, "fecha_baja"); ?>  
            </label>
            <br>

            <div class=" text-right">
                <button type="button" class="btn btn-secondary" onclick="location.href='index.php?controller=adminTramos&action=listTramos&pagina=1&rxp=10'">Volver a "Listar tramos"</button>
                <?php if(isset($_GET["id"])){ ?>	
                    <input type="submit" name="submit" value="Editar tramo"  class="btn btn-primary"/> 
                <?php }else{ ?>
                    <input type="submit" name="submit" value="Crear tramo"  class="btn btn-primary"/> 
                <?php } ?>   
            </div>   
        </form>
    </div>
</div>
<div class="listUser">
    <table id="tablePreview" class="table table-striped table-sm table-hover table-bordered tabalListUser">
        <thead>
            <tr>
                <th>ID</th>
                <th>NIF</th>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Email</th>
                <th>Password</th>
                <th>Telefono</th>
                <th>Dirección</th>
                <th>Estado</th>
                <th>Nombre de imagen</th>
                <th>Rol</th>
                <th>Operaciones</th>
            </tr>
        </thead>
        <tbody>  
        <?php foreach ($data["users"] as $d) : ?>
            <tr>
                <td><?= $d["id"]?></td>
                <td><?= $d["nif"] ?></td>
                <td><?= $d["nombre"] ?></td>
                <td><?= $d["apellidos"] ?></td>
                <td><?= $d["email"] ?></td>
                <td><?= $d["password"] ?></td>
                <td><?= $d["telefono"] ?></td>
                <td><?= $d["direccion"] ?></td>
                <td><?= $d["estado"] ?></td>
                <td><?= $d["imagen"] ?></td>
                <td><?= $d["rol_id"] ?></td>
                <td>je</td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

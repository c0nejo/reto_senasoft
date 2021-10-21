<div>
    <h4 class="display-6">Administrar Personal</h4>
    <hr>
    <div class="row">
        <div class="col-md-8">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Crear
            </button>
        </div>
    </div>
    <hr>
    <table id="table" class="table table-striped table-hover">
        <thead class="text-center">
            <th>Nombres</th>
            <th>Especialidad</th>
            <th>Rol</th>
            <th>Acciones</th>
        </thead>
        <tbody>
            <?php
                foreach($persona as $per){
                    echo "<tr class='text-center'>";
                        echo "<td>".$per['per_nombres']."</td>";
                        echo "<td>".$per['esp_nombre']."</td>";
                        echo "<td>".$per['rol_nombre']."</td>";
                        echo "<td>";
                            echo "<a href='".getUrl("Persona","Persona","eliminar",array("id"=>$per['per_id']))."'><button type='button' class='btn btn-danger m-1'>Eliminar</button></a>";
                            echo "<button type='button' data-id='".$per['per_id']."' data-url='".getUrl('Persona','Persona','getEditar',false,'ajax')."' onclick='editar(this)' class='btn btn-primary'>Editar</button>";
                        echo "</td>";
                    echo "</tr>";
                }
            ?>
        </tbody>
    </table>
    <!--Modal de crear y editar las personas-->
    <div id="mdl"></div>
</div>
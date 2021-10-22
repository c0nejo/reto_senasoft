<!--Modal Editar-->
<div class="modal fade" id="editarModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Persona</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo getUrl('Persona','Persona','editar');?>" method="POST">
                <input type="hidden" value="<?php echo $dat['per_id'];?>" name="id">
                <div class="modal-body">
                    <label for="nombres">Nombres</label>
                    <input type="text" name="nombre" placeholder="Juan..." class="form-control" value="<?php echo $dat['per_nombres'];?>">
                    <label for="" class="mt-3">Especialidad</label>
                    <select name="especialidad" id="especialidad" class="form-select">
                        <option value="">Seleccione...</option>
                        <?php
                            //Realiza la carga del select para dejar el dato seleccionado para la especialida
                            //teniendo en cuenta el id del usuario
                            $this->obj->CargaSelected("*", "especialidad", $dat["esp_id"]);
                        ?>                     
                    </select>
                        
                    <label for="" class="mt-3">Rol</label>
                    <select name="rol" id="rol" class="form-select">
                        <option value="">Seleccione...</option>
                            <?php 
                                $this->obj->CargaSelected("*", "rol", $dat["rol_id"]);
                            ?> 
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Editar</button>
                </div>
            </form>
        </div>
    </div>
</div>
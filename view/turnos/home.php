<div>
    <h4 class="display-6">Administrar turnos</h4>
    <hr>
    <div class="row">
        <div class="col-md-8">
            <form method="POST" action="<?php echo getUrl("Turnos","Turnos","crearTurnos") ?>">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Fecha de inicio</label>
                        <input type="date" name="fecha_inicio" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Fecha fin</label>
                        <input type="date" name="fecha_fin" class="form-control">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Intensidad horaria</label>
                    <input type="number" class="form-control" name="intensidad_horaria">
                </div>
                <div class="mb-3">
                    <label class="form-label">Servicios de salud</label>
                    <select name="esp_id" id="especialidades" class="form-select" data-url="<?php echo getUrl("Turnos", "Turnos", "consultPersonal", false, "ajax") ?>">
                        <option value="">Seleccione...</option>
                        <?php $this->obj->CargaSelectGeneral("*", "especialidad"); ?>
                    </select>
                </div>
                <div>
                    <h5>Elegir personal</h5>
                    <div id="contenedor-personal">
                        
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Generar turnos</button>
            </form>
        </div>
    </div>
</div>
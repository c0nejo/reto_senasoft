<div>
    <h4 class="display-6">Generar turnos por fechas</h4>
    <hr>
    <div class="row">
        <div class="col-md-8">
            <form method="POST" action="<?php echo getUrl("Turnos", "Turnos", "crearTurnos") ?>" id="formulario" onsubmit="return validarForm();">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Fecha de inicio</label>
                        <input type="date" name="fecha_inicio" class="form-control" id="fecha_inicio">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Fecha fin</label>
                        <input type="date" name="fecha_fin" class="form-control" id="fecha_fin">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Intensidad horaria</label>
                        <input type="number" class="form-control" name="intensidad_horaria" id="intensidad_horaria">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Personal por turno</label>
                        <input type="number" class="form-control" name="turno_dia" id="personal_turno">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Servicios de salud</label>
                    <select name="esp_id" id="especialidades" class="form-select" data-url="<?php echo getUrl("Turnos", "Turnos", "consultPersonal", array("s" => 4, "a" => 4, "f" => 4,), "ajax") ?>">
                        <option value="">Seleccione...</option>
                        <?php $this->obj->CargaSelectGeneral("*", "especialidad"); ?>
                    </select>
                </div>
                <div>
                    <h5>Elegir personal</h5>
                    <div id="passwordHelpBlock" class="form-text">
                     Tenga en cuenta: a la hora de elegir el personal este de debe ser mayor a los turnos que generados a partir de 
                     la intensidad horaria elegida multiplicado por la cantidad de personas por turno.
                     Ej. Intensidad horaria: 8, turnos por persona: 2, personal requerido: 8 <br>
                     De lo contrario no se generara los descansos debidos.
                    </div>
                    <div id="contenedor-personal">

                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-2">Generar turnos</button>
            </form> 
            
        </div>
    </div>
</div>
<div>
    <h4 class="display-6">Administrar turnos</h4>
    <hr>
    <div class="row">
        <div class="col-md-8">
            <form method="POST" action="<?php echo getUrl("Turnos", "Turnos", "crearTurnos") ?>" id="formulario">
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
                <div class="mb-3">
                    <label class="form-label">Intensidad horaria</label>
                    <input type="number" class="form-control" name="intensidad_horaria" id="intensidad_horaria">
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
                    <div id="contenedor-personal">

                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Generar turnos</button>
            </form>
            <button type="button" class="btn btn-primary" @click="abrirModal()">
                Launch demo modal
            </button>

            <!-- Modal -->
            <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-static">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Turnos generados</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <table class="table table-bordered">
                                <tr>
                                    <td v-for="(fecha, index) of datos.fechas">{{index}}</td>
                                </tr>
                            </table>
                            <div v-for="(fecha, index) of this.datos.fechas">{{index}}

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
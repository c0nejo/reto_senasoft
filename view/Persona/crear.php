<!-- Modal Crear-->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Crear Personal</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form action="<?php echo getUrl('Persona','Persona','crear');?>" method="POST">
          <div class="modal-body">
            <label for="nombres">Nombres</label>
            <input type="text" name="nombre" placeholder="Juan..." class="form-control">
            <label for="" class="mt-3">Especialidad</label>
            <select name="especialidad" id="especialidad" class="form-select">
                <option value="">Seleccione...</option>
                  <?php
                      foreach($especialidad as $esp){
                          echo "<option value='".$esp['esp_id']."'>".$esp['esp_nombre']."</option>";
                      }
                  ?>
            </select>
            <label for="" class="mt-3">Rol</label>
            <select name="rol" id="rol" class="form-select">
                <option value="">Seleccione...</option>
                    <?php
                        foreach($rol as $r){
                            echo "<option value='".$r['rol_id']."'>".$r['rol_nombre']."</option>";
                        }
                    ?>
            </select>
          </div>
          <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Crear</button>
      </div>
      </div>
      </form>
  </div>
</div>
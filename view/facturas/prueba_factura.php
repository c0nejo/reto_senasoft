<div id="app">
    <div class="container">
        <div class="row">
            <div class="col-md-6 mt-5">
                <form autocomplete="off" @submit="eliminarBorrador()">
                    <div class="form-group">
                        <label for="nombre">Nombre producto</label>
                        <input type="text" @keyup="crearBorrador()" class="form-control" id="nombre" v-model="datos.nombre">
                    </div>
                    <div class="form-group">
                        <label for="precio">Precio</label>
                        <input type="number" @keyup="crearBorrador()" class="form-control" id="precio" v-model="datos.precio">
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>
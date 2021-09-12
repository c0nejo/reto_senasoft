const app = new Vue({
    el: '#app',
    data: {
        datos: {
            nombre: '',
            precio: '',
        }
    },

    methods: {
        crearBorrador(){
            localStorage.setItem("borrador", JSON.stringify(this.datos));
        },
        eliminarBorrador(){
            localStorage.removeItem("borrador");
        }
    },

    created() {
        let datosGuardados = localStorage.getItem("borrador");
        if(datosGuardados != null){
            this.datos = JSON.parse(datosGuardados);
        }
    },
});
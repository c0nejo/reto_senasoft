const app = new Vue({
  el: "#app",
  data: {
    datos: [],
  },
  computed: {},

  methods: {
    async generarturnos(){
      let fecha_inicio = $("#fecha_inicio").val();
      let fecha_fin = $("#fecha_fin").val();
      let intensidad_horaria = $("#intensidad_horaria").val();
      let especialidades = $("#especialidades option:selected").val();
      let per_id = [];
      $("[name='per_id[]']:checked").each(function(){
        per_id.push(this.value);
      });

      let url = "ajax.php?modulo=Turnos&controlador=Turnos&funcion=crearTurnos&fecha_inicio="+fecha_inicio+"&fecha_fin="+fecha_fin+"&intensidad_horaria="+intensidad_horaria+"&especialidades="+especialidades;

      console.log(url);

    },
    abrirModal(){

    }
  },

  created() {
    
  },
});

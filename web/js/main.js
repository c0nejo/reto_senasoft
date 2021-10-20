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
      //let variable = `&per_id=[${per_id}]`;
      //url += variable;
      console.log(url);
      //let {data} = await axios.post(url);
      /*
      let id = document.getElementById("formulario");
      const datos = new FormData(id);
       fetch(url, { method: "POST", body: datos, })
          .then(function (response) {
              return response.json();
          })
          .then(function (data) {
              this.datos = data;
              
              $("#modal").modal("show");
          })
          .catch(function (error) {
              console.log(error);
          });
          console.log(this.datos) */
    },
    abrirModal(){

    }
  },

  created() {
    
  },
});

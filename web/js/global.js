$(document).ready(function () {
    $(document).on("change","#especialidades", function (){
        let url = $(this).attr("data-url");
        $(this, "option:selected").each(function () {
            var elegido = $(this).val();
            if (elegido > 0) {
              $.ajax({
                url: url,
                data: "esp_id=" + elegido,
                type: "POST",
                success: function (datos) {
                  $("#contenedor-personal").html(datos);
                },
              });
            } else if (elegido == 0) {
              $("#contenedor-personal").html("");
            }
          });
    });

});

function validarForm(){
      if($("#fecha_inicio").val() == ""){
        $("#fecha_inicio").addClass("is-invalid");
        return false;
      }else{
        $("#fecha_inicio").addClass("is-valid");
      }

      if($("#fecha_fin").val() == ""){
        $("#fecha_fin").addClass("is-invalid");
        return false;
      }else{
        $("#fecha_fin").addClass("is-valid");
      }

      if($("#intensidad_horaria").val() == ""){
        $("#intensidad_horaria").addClass("is-invalid");
        return false;
      }else{
        $("#intensidad_horaria").addClass("is-valid");
      }
      if($("#personal_turno").val() == ""){
        $("#personal_turno").addClass("is-invalid");
        return false;
      }else{
        $("#personal_turno").addClass("is-valid");
      }

      if($("#especialidades option:selected").val() == ""){
        $("#especialidades").addClass("is-invalid");
        return false;
      }else{
        $("#especialidades").addClass("is-valid");
      }

      return true;
}
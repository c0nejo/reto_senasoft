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
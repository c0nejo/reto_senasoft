function editar(boton){
    let url = $(boton).attr("data-url");
    let id = $(boton).attr("data-id");
    $.ajax({
        url: url,
        data: "id="+id,
        type: "POST",
        success: function(datos){
            $("#mdl").html(datos);
            $("#editarModal").modal("show");
        }
    });
}
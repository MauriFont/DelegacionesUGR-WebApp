var new_pleno_dialog = $("#new_pleno-popup").dialog({
    autoOpen: false,
    height: 400,
    width: 350,
    modal: false,
    responsive: true,
    buttons: {
        "Generar": function () {
            $("#new_pleno-popup > form").submit();
        },
        Cancelar: function () {
            new_pleno_dialog.dialog("close");
        }
    }
});

$("#nuevo_pleno").button().on("click", function () {
    new_pleno_dialog.dialog("open");
});
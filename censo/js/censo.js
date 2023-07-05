function setupDialog(id, height = "auto", width = 400) {
    return $(id).dialog({
        autoOpen: false,
        height: height,
        width: width,
        modal: true,
        responsive: true,
        create: function(event, ui){
            $('.ui-dialog').wrap('<jq-ui-scope />');
        },
        open: function(event, ui){
            $('.ui-widget-overlay').wrap('<jq-ui-scope />');
        },
        close: function(event, ui){
            clearInputs($(this).find('form'));
            $("jq-ui-scope").filter(function() {
                if ($(this).text() == "")
                {
                    return true;
                }
                return false;
            }).remove();
        }
    });
}

var dialog_edit_miembro = setupDialog("#dialog-edit-actual", 400);

var dialog_remover_actual = setupDialog("#dialog-remover-actual");

var dialog_borrar_area = setupDialog("#dialog-borrar-area");

var dialog_borrar_cargo = setupDialog("#dialog-borrar-cargo");

var dialog_borrar_mcargo = setupDialog("#dialog-borrar-mcargo");

var dialog_add_c = setupDialog("#dialog_add_c");
var btns = {
    "Crear": function () {
        $("#dialog_add_c > form").submit();
    },
    Cancelar: function () {
        dialog_add_c.dialog("close");
    }
};
dialog_add_c.dialog("option", "buttons", btns);

var dialog_add_m = setupDialog("#dialog_add_m");
var btns = {
    "Añadir": function () {
        $("#dialog_add_m > form").submit();
    },
    Cancelar: function () {
        dialog_add_m.dialog("close");
    }
};
dialog_add_m.dialog("option", "buttons", btns);

function clearInputs(target) {
    $(target).find("input, select").val('');
}

$("#d_excel").click(function() {
    window.open("censo/php/excel_miembros_actual.php", '_blank');
});

$("#add-miembro").button().on("click", function () {
    var form = $("#dialog-edit-actual");
    form.find("[name='id']").val('-1');

    $("#dialog-edit-actual").dialog("option", "title", "Añadir miembro");

    var btns = {
        Aniadir: {
            text: "Añadir",
            class: "btn btn-success",
            click: function () {
                    $("#dialog-edit-actual > form").submit();
                }
        },
        Cancelar: {
            text: "Cancelar",
            class: "btn btn-secondary",
            click: function () {
                dialog_edit_miembro.dialog("close");
            }
        }
    };
    dialog_edit_miembro.dialog("option", "buttons", btns);

    dialog_edit_miembro.dialog("open");
});

$(".edit_actual").button().on("click", function () {
    var form = $("#dialog-edit-actual");
    $(this).parent().siblings().each(function() {
        var col = $(this).attr("column");
        if (col == "centro") {
            form.find("[name='"+col+"'] option[value='"+$(this).attr("centroid")+"']").prop("selected", true);
        } else {
            form.find("[name='"+col+"']").val($(this).html());
        }
    });

    form.find("[name='id']").val($(this).attr("miembroid"));

    $("#dialog-edit-actual").dialog("option", "title", "Editar miembro");

    var btns = {
        Editar: {
            text: "Editar",
            class: "btn btn-success",
            click: function () {
                    $("#dialog-edit-actual > form").submit();
                }
        },
        Cancelar: {
            text: "Cancelar",
            class: "btn btn-secondary",
            click: function () {
                dialog_edit_miembro.dialog("close");
            }
        }
    };
    dialog_edit_miembro.dialog("option", "buttons", btns);

    dialog_edit_miembro.dialog("open");
});

$(".remover_actual").button().on("click", function () {
    var tr = $(this).closest("tr");
    var id = tr.attr("miembroid");
    var nombre = $("[column=apellidos]", tr).html() + ", " + $("[column=nombre]", tr).html();
    var dial = $("#dialog-remover-actual");

    dial.find(".nom_miembro").html(nombre);

    $("form", dial).find("[name='id']").val(id);

    var btns = {
        Remover: {
            text: "Remover miembro",
            class: "btn btn-danger",
            click: function () { $("#dialog-remover-actual > form").submit(); }
        },
        Cancelar: {
            text: "Cancelar",
            class: "btn btn-secondary",
            click: function () {
                dialog_remover_actual.dialog("close");
            }
        }
    };
    dialog_remover_actual.dialog("option", "buttons", btns);

    dialog_remover_actual.dialog("open");
});

$(".moveup_area").button().on("click", function () {
    var table = $(this).closest("table");
    var orden = parseInt(table.attr("orden"));
    var new_orden = orden-1;

    var prev_table = $("table[orden='"+new_orden+"']");

    var id1 = $(this).closest("table").attr("areaid");
    var btns = prev_table.find(".areas-area-btns");
    var id2 = prev_table.attr("areaid");

    if (new_orden == 1) {
        $(this).attr("style", "display: none");
        btns.children(".moveup_area").attr("style", "");
    }

    if (orden == total_areas) { //total_areas lo agrega el php
        $(this).siblings(".movedown_area").attr("style", "");
        btns.children(".movedown_area").attr("style", "display: none");
    }

    prev_table.before(table);
    prev_table.attr("orden", orden);
    table.attr("orden", new_orden);

    $.post("censo/php/chg_orden_area.php", {"id1":id1, "orden1":new_orden, "id2":id2, "orden2":orden});
});

$(".movedown_area").button().on("click", function () {
    var table = $(this).closest("table");
    var orden = parseInt(table.attr("orden"));
    var new_orden = orden+1;

    var prev_table = $("table[orden='"+new_orden+"']");

    var id1 = $(this).closest("table").attr("areaid");
    var btns = prev_table.find(".areas-btns");
    var id2 = prev_table.attr("areaid");

    if (new_orden == total_areas) {
        $(this).attr("style", "display: none");
        btns.children(".movedown_area").attr("style", "");
    }

    if (orden == 1) { //total_areas lo agrega el php
        $(this).siblings(".moveup_area").attr("style", "");
        btns.children(".moveup_area").attr("style", "display: none");
    }

    prev_table.after(table);
    prev_table.attr("orden", orden);
    table.attr("orden", new_orden);

    $.post("censo/php/chg_orden_area.php", {"id1":id1, "orden1":new_orden, "id2":id2, "orden2":orden});
});

$(".edit_area").button().on("click", function () {
    var th = $(this).parent().parent();
    var span = th.children("span");

    $(this).siblings(".confirm_area").css("display", "");
    $(this).css("display", "none");

    span.css("display", "none");

    span.after("<input type='text' value='"+span.html()+"'>");
});

$(".confirm_area").button().on("click", function () {
    var th = $(this).parent().parent();
    var span = th.children("span");
    var inpt = th.children("input");
    var nombre = inpt.val();
    var id = $(this).closest("table").attr("areaid");

    $(this).siblings(".edit_area").css("display", "");
    $(this).css("display", "none");

    span.html(nombre);
    span.css("display", "");

    inpt.remove();

    $.post("censo/php/chg_nombre_area.php", {"id":id, "nombre":nombre});
});

$(".delete_area").button().on("click", function () {
    var id = $(this).closest("table").attr("areaid");
    var nombre = $(this).parent().siblings("span").html();

    $("#dialog-borrar-area").find(".nom_area").html(nombre);

    var buttons = {
        Eliminar: {
            text: "Eliminar area",
            class: 'btn btn-danger',
            click: function () { 
                $.post("censo/php/delete_area.php", {"id":id});
                dialog_borrar_area.dialog("close");
                location.reload();
            }
        },
        Cancelar: function () {
            dialog_borrar_area.dialog("close");
        }
    };

    dialog_borrar_area.dialog("option", "buttons", buttons);

    dialog_borrar_area.dialog("open");
});

$(".admin_cargos").button().on("click", function () {
    var table = $(this).closest("table");
    var area_id = table.attr("areaid");
    var area_name = $(".area_name", table).html();

    $("#dialog_add_c input[placeholder='Area']").val(area_name);
    $("#dialog_add_c input[name='area_id']").val(area_id);

    dialog_add_c.dialog("open");
});

$(".add_miembro_area").button().on("click", function () {
    var table = $(this).closest("table");
    var area_id = table.attr("areaid");
    var area_name = $(".area_name", table).html();
    var select_cargos = $("#dialog_add_m select[name='cargo_id']");

    $("#dialog_add_m input[placeholder='Area']").val(area_name);
    $("#dialog_add_m input[name='area_id']").val(area_id);

    $("option[value!='']", select_cargos).remove();

    for (const [key, value] of Object.entries(list_cargos)) { // list_cargos lo crea el php
        if (value["area_id"] == area_id)
            select_cargos.append(`<option value="${key}">${value["nombre"]}</option>`);
    }

    if(typeof window.list_todos_miembros === 'undefined') {
        $("#cargando_m").css("display", "block");
        fetch_t_miembros();
    }

    dialog_add_m.dialog("open");
});

function fetch_t_miembros() {
    $.post("censo/php/get_t_miembros.php", function (data) {
        window.list_todos_miembros = data;
        for (const [key, value] of Object.entries(window.list_todos_miembros))
        $("#dialog_add_m select[name='miembro_id']").append(`<option value="${key}">${value["completo"]}</option>`);

        $("#cargando_m").css("display", "none");
    }, "json");
}

$(".moveup_cargo").button().on("click", function () {
    var cargo_tr = $(this).closest("tr");
    var orden = parseInt(cargo_tr.attr("orden"));
    var new_orden = orden-1;
    var table = cargo_tr.closest("table");

    var prev_tr = $("tr[orden='"+new_orden+"']", table);

    var id1 = cargo_tr.attr("cargoid");
    var btns = prev_tr.find(".areas-btns");
    var id2 = prev_tr.attr("cargoid");

    var max_cargos = table.attr("maxcargos");

    if (new_orden == 1) {
        $(this).attr("style", "display: none");
        btns.children(".moveup_cargo").attr("style", "");
    }

    if (orden == max_cargos) {
        $(this).siblings(".movedown_cargo").attr("style", "");
        btns.children(".movedown_cargo").attr("style", "display: none");
    }

    prev_tr.before($("tr[cargoid='"+id1+"']", table));
    prev_tr.attr("orden", orden);
    cargo_tr.attr("orden", new_orden);

    $.post("censo/php/chg_orden_cargo.php", {"id1":id1, "orden1":new_orden, "id2":id2, "orden2":orden});
});

$(".movedown_cargo").button().on("click", function () {
    var cargo_tr = $(this).closest("tr");
    var orden = parseInt(cargo_tr.attr("orden"));
    var new_orden = orden+1;
    var table = cargo_tr.closest("table");

    var prev_tr = $("tr[orden='"+new_orden+"']", table);

    var id1 = cargo_tr.attr("cargoid");
    var btns = prev_tr.find(".areas-btns");
    var id2 = prev_tr.attr("cargoid");

    var max_cargos = cargo_tr.closest("table").attr("maxcargos");

    if (new_orden == max_cargos) {
        $(this).attr("style", "display: none");
        btns.children(".movedown_cargo").attr("style", "");
    }

    if (orden == 1) {
        $(this).siblings(".moveup_cargo").attr("style", "");
        btns.children(".moveup_cargo").attr("style", "display: none");
    }

    prev_tr.after($("tr[cargoid='"+id1+"']", table));
    prev_tr.attr("orden", orden);
    cargo_tr.attr("orden", new_orden);

    $.post("censo/php/chg_orden_cargo.php", {"id1":id1, "orden1":new_orden, "id2":id2, "orden2":orden});
});

$(".edit_cargo").button().on("click", function () {
    var td = $(this).parent().parent();
    var span = td.children("span");

    $(this).siblings(".confirm_cargo").css("display", "");
    $(this).css("display", "none");

    span.css("display", "none");

    span.after("<input type='text' value='"+span.html()+"'>");
});

$(".confirm_cargo").button().on("click", function () {
    var td = $(this).parent().parent();
    var span = td.children("span");
    var inpt = td.children("input");
    var nombre = inpt.val();
    var id = $(this).closest("tr").attr("cargoid");

    $(this).siblings(".edit_cargo").css("display", "");
    $(this).css("display", "none");

    span.html(nombre);
    span.css("display", "");

    inpt.remove();

    $.post("censo/php/chg_nombre_cargo.php", {"id":id, "nombre":nombre});
});

$(".delete_cargo").button().on("click", function () {
    var id = $(this).closest("tr").attr("cargoid");
    var nombre = $(this).parent().siblings("span").html();

    $("#dialog-borrar-cargo").find(".nom_cargo").html(nombre);

    var buttons = {
        Eliminar: {
            text: "Eliminar cargo",
            class: 'btn btn-danger',
            click: function () { 
                $.post("censo/php/delete_cargo.php", {"id":id});
                dialog_borrar_cargo.dialog("close");
                location.reload();
            }
        },
        Cancelar: function () {
            dialog_borrar_cargo.dialog("close");
        }
    };

    dialog_borrar_cargo.dialog("option", "buttons", buttons);

    dialog_borrar_cargo.dialog("open");
});

$(".remove_miembro").button().on("click", function () {
    var id = $(this).closest("td").attr("m_cargoid");
    var area = $(this).closest("table").find(".area_name").html();
    var nombre = $(this).parent().siblings("span").html();

    $("#dialog-borrar-mcargo").find(".nom_area").html(area);
    $("#dialog-borrar-mcargo").find(".nom_mcargo").html(nombre);

    var buttons = { 
        Remover: {
            text: "Remover",
            class: 'btn btn-danger',
            click:function () {
                $.post("censo/php/remove_m_cargo.php", {"id":id});
                dialog_borrar_mcargo.dialog("close");
                location.reload();
            }
        },
        Cancelar: function () {
            dialog_borrar_mcargo.dialog("close");
        }
    };

    dialog_borrar_mcargo.dialog("option", "buttons", buttons);

    dialog_borrar_mcargo.dialog("open");
});

$("td,th").mouseenter(function() {
    $(this).find(".mousenter-dots").css("visibility", "hidden");
    $(this).find(".mousenter-btns").css("visibility", "");
});

$("td,th").mouseleave(function() {
    $(this).find(".mousenter-dots").css("visibility", "");
    $(this).find(".mousenter-btns").css("visibility", "hidden");
});
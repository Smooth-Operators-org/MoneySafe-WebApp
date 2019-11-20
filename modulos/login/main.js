$(document).ready(function(){
//Iniciar Select Materialize
    $('select').formSelect();
//Cambiar Form
    $("#mensaje a").click(function () {
        $("form").animate({
            height: "toggle",
            opacity: "toggle",
          },
          "slow"
        );
    });
//Guardar Coockies
    var remember = $.cookie("remember");
    if (remember == "true") {
        var username = $.cookie("username");
        var password = $.cookie("password");
        $("#email").attr("value", username);
        $("#password").attr("value", password);
        $("#remember").prop("checked", remember);
    }
});
$(document).ready(function() {
    $('#guardar').click(function() {
        $.post("../../controlador/Ciudad.php", $("#frmciudad").serialize(), function(respuesta) {
            if (respuesta == 1) {
                alert('Registro con Exito');
                $('input[type="text"]').val('');
            }
        });
    });
});
$(document).ready(function (){
    $('#grupo_usuario').select2();
    $('#estatus').select2();    
    
   $('#guardar').click(function (){
        $.post( "../../controlador/Perfil.php", $("#frmperfil").serialize(),function (respuesta){
            if(respuesta == 1){
                alert('Registro con Exito') ;
                $('input[type="text"]').val('');
           }
        } );
    });
});


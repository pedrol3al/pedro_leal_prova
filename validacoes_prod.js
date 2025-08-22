$(document).ready(function(){
    $('#valor_unit').mask('000.000.000.000.000,00', {reverse: true});
    
    $('#valor_unit').on('blur', function(){
        if($(this).val() !== ""){
            $(this).val('R$ ' + $(this).val());
        }
    });
});



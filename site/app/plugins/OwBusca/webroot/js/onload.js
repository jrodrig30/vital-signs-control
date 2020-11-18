var OW_BUSCA_TIPO_ENTRE = 8;
var OW_BUSCA_TIPO_VAZIO = 9;
var OW_BUSCA_TIPO_NAO_VAZIO = 10;
    
    
function OwBuscaVerificarTipo(obj){
    
    
    var tipo = obj.val();
    var num = obj.attr('name').replace('OwBusca[','').replace('][tipo]','');
    
    if(tipo == OW_BUSCA_TIPO_ENTRE){
        $('#owbusca-'+ num +'-valor').val('');
        $('#owbusca-'+ num +'-valor').hide();
        
        $('.min_' + num).show();
        $('.max_' + num).show();
    }else{
        if(tipo == OW_BUSCA_TIPO_VAZIO || tipo == OW_BUSCA_TIPO_NAO_VAZIO){
            $('#owbusca-'+ num +'-valor').val('');
            $('.min_' + num).val('');
            $('.max_' + num).val('');
            
            $('#owbusca-'+ num +'-valor').hide();
            $('.min_' + num).hide();
            $('.max_' + num).hide();
        }else{
            $('#owbusca-'+ num +'-valor').show();
            
            $('.min_' + num).val('');
            $('.max_' + num).val('');
            $('.min_' + num).hide();
            $('.max_' + num).hide();
        }
    }
}

function OwBuscaDesativarCamposVazios(){
    var numeroCampos = $('#OwCamposBusca div.OwBuscaCampoBusca').length;
    
    for(var i = 0; i < numeroCampos; i++){
        var tudoVazio = $('#owbusca-'+ i +'-valor').val().length === 0 && 
                        $('#owbusca-'+ i +'-entre-min').val().length === 0 && 
                        $('#owbusca-'+ i +'-entre-max').val().length === 0;
                
        
        var isTipoNaoVazio = $('#owbusca-'+ i +'-tipo').val() == OW_BUSCA_TIPO_NAO_VAZIO;
        var isTipoVazio = $('#owbusca-'+ i +'-tipo').val() == OW_BUSCA_TIPO_VAZIO;
        var isTipoEntre = $('#owbusca-'+ i +'-tipo').val() == OW_BUSCA_TIPO_ENTRE;
        
        if(isTipoEntre){
            $('#DivOwBuscaCampoBusca' + i + ' :input[id$=-valor]').prop('disabled', true);
        }else{
            $('#DivOwBuscaCampoBusca' + i + ' :input[id$=-entre-min]').prop('disabled', true);
            $('#DivOwBuscaCampoBusca' + i + ' :input[id$=-entre-max]').prop('disabled', true);
        }
        
        if(!tudoVazio){
            continue;
        }
        
        if(isTipoNaoVazio || isTipoVazio){
            $('#DivOwBuscaCampoBusca' + i + ' :input[id$=-valor]').prop('disabled', true);
            continue;
        }
        
        $('#DivOwBuscaCampoBusca' + i + ' :input').prop('disabled', true);
    }
}

$(function(){
    $('#owbusca-0-valor').focus();
    $('.OwBuscaCampoTipo').bind('change', function (){ 
        OwBuscaVerificarTipo($(this));
    });
	
    $('.OwBuscaCampoTipo').each(function (){ 
            OwBuscaVerificarTipo($(this));
    });
    
    $('#owbuscalimit-limit').change(function (){
        this.form.submit();
    });
    
    if($('#OwBuscaBuscarOnChangeSelect').length > 0){
        $('.DivOwBuscaValor select').bind('change', function (){ 
            this.form.submit();
        });
    }
    
    $('#OwCamposBusca form').submit(function (e){
        OwBuscaDesativarCamposVazios();
    });
});
<script>
$(function (){
    checarTipo()
    $('#AcoTipo').change(function (){
        checarTipo()
    })
})

function checarTipo(){
    $('#TipoU, #TipoO').hide();
    $('#Tipo' + $('#AcoTipo').val()).show();
}

</script>
<script>
    
$(function (){
    $('.checkController').change(function (){
        $('#' + this.value + ' input[type=checkbox]').attr('checked', this.checked)
    })
    
    
})
</script>
<div class="owGrupos setarPermissoes">
<h2><?php  __('Setar permissões do grupo ' . $ow_grupo['UsuarioGrupo']['nome']);?></h2>
    <form method="post" action="<?php echo $this->Html->url(array('action' => 'setar_permissoes', $ow_grupo['UsuarioGrupo']['id'])) ?>">
        <?php 
        $count = 0;
        $ultimo_controller = $controller = '';
        ?>
        <?php foreach($ow_acos as $k=>$aco): ?>
            <?php
            $str = '';
            $isUrl = false;
            
            if($aco['Aco']['tipo'] == Aco::TIPO_URL){
                $isUrl = true;
                if(strlen($aco['Aco']['plugin'])){
                    $str = '/' . $aco['Aco']['plugin'];
                }
                $str .= '/' . $aco['Aco']['controller'] . '/' . $aco['Aco']['action'];
                $controller = $aco['Aco']['controller'];
            }else{
                $str = $aco['Aco']['objeto'];
            }

            $trocouController = $ultimo_controller != $controller;
            
            if($isUrl && $trocouController){
                echo '<input class="checkController" type="checkbox" value="Controller_'. $controller .'" id="Check'. $controller .'" />';
                echo '<label for="Check'. $controller .'">Controller ' . $controller . '</label>';
                echo '<div style="padding-left: 10px;" id="Controller_'. $controller .'">';
            }
            
            $checked = false;
            if(isset( $aco['Permissao']['id'] ) && strlen( $aco['Permissao']['id'] )){
                echo '<input type="hidden" name="data[Permissao]['. $count .'][id]" value="'. $aco['Permissao']['id'] .'"  />';
                $checked = true;
            }
            echo '<input type="hidden" name="data[Permissao]['. $count .'][usuario_grupo_id]" value="'. $ow_grupo['UsuarioGrupo']['id'] .'"  />';
            echo '<input type="hidden" name="data[Permissao]['. $count .'][aco_id]" value="0"  />';
            echo '<input type="checkbox" name="data[Permissao]['. $count .'][aco_id]" value="'. $aco['Aco']['id'] .'" id="aco'. $aco['Aco']['id'] .'" '. ($checked ? ' checked="checked"' : '') .' />';
            echo '<label for="aco'. $aco['Aco']['id'] .'">'. $str .'</label>';
            
            $proximoController = isset($ow_acos[$k+1]) ? $ow_acos[$k+1]['Aco']['controller'] : '';
            if($isUrl && $controller != $proximoController){
                echo '</div>';
            }
            
            $ultimo_controller = $controller;
            $count++;
            ?><br />
        <?php endforeach; ?>
            <input type="submit" name="" value="Salvar" />
    </form>
</div>
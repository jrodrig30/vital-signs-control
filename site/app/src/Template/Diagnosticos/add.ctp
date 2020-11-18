<style>
    .col-md-6 {
        width: 100%;
    }
</style>
<script>
    $(function () {
        $('.colunas-5').hide();
        $('#sinal_0').show();
        $('.mais_um').bind('click', function () {
            $('#sinal_' + this.id).show();
            $('#' + this.id).html('');
        });

        //remover campos vazios no submit
        $('form').submit(function () {
            var $empty_fields = $(this).find(':input').filter(function () {
                return $(this).val() === '';
            });
            $empty_fields.prop('disabled', true);
            return true;
        });
    });
</script>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Adicionar Diagnóstico
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Adicionar</a></li>
        <li class="active">Diagnóstico</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-6">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"></h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body">
                    <?= $this->Form->create($diagnostico); ?>
                    <?php
                    echo $this->Form->input('nome');
                    echo $this->Form->input('codigo');
		    echo $this->Form->input('acao', ['type' => 'textarea', 'label' => 'Ação']);
                    for ($i = 0; $i < count($sinais); $i++) {
                        $class = '';
                        if ($i > 0) {
                            $options['empty'] = true;
                            $options['required'] = false;
                        }
                        echo '<div class="colunas-5 ' . $class . '" id="sinal_' . $i . '">';
                        echo '<legend>Sinal ' . ($i + 1) . '</legend>';
                        echo $this->Form->input('diagnosticos_sinais.' . $i . '.sinal_id', ['options' => $sinais, 'empty' => 'Selecione']);
                        echo $this->Form->input('diagnosticos_sinais.' . $i . '.valor_maximo', ['label' => 'Valor Máximo']);
                        echo $this->Form->input('diagnosticos_sinais.' . $i . '.valor_minimo', ['label' => 'Valor Mínimo']);
                        echo $this->Form->input('diagnosticos_sinais.' . $i . '.valor_medio');
                        echo $this->Form->input('diagnosticos_sinais.' . $i . '.idade_minima', ['label' => 'Idade Miníma']);
                        echo $this->Form->input('diagnosticos_sinais.' . $i . '.idade_maxima', ['label' => 'Idade Máxima']);
                        echo '<div class="mais_um" style="cursor: pointer" id="' . ($i + 1) . '"><i class="fa fa-fw fa-plus" style="color: red;font-size: 19px"></i><span style="font-weight: bold">Adicionar mais um sinal</span></div>';
                        echo '</div>';
                        echo '<div class="clear"></div>';
                    }
                    ?>

                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Adicionar</button>
                </div>
            </div>
            <!-- /.box -->


            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!--/.col (right) -->
    <!-- /.row -->
</section>
<!-- /.content -->

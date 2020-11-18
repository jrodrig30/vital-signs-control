<style>
    .col-md-6 {
        width: 100%;
    }
</style>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Adicionar Diagnóstico
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Adicionar Diagnóstico</a></li>
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
                        echo $this->Form->input('diagnosticos_sinais.' . $i . '.idade_minima');
                        echo $this->Form->input('diagnosticos_sinais.' . $i . '.idade_maxima');
                        echo '<div class="mais_um" style="cursor: pointer" id="' . ($i + 1) . '"><i class="fa fa-fw fa-plus" style="color: red;font-size: 19px"></i><span style="font-weight: bold">Adicionar mais um sinal</span></div>';
                        echo '</div>';
                        echo '<div class="clear"></div>';
                    }
                    ?>

                    <div class="checkbox">
                        <label>
                            <input type="checkbox"> Adicionar mais um sinal vital
                        </label>
                    </div>
                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
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


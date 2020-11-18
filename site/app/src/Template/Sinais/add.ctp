<style>
    .col-md-6 {
        width: 100%;
    }
</style>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Adicionar Sinais Vitais
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Adicionar Sinais Vitais</a></li>
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
                    <?= $this->Form->create($sinal); ?>
                    <?= $this->Form->input('nome'); ?>
                    <?= $this->Form->input('maior_valor', ['label' => 'Valor Minímo']); ?>
                    <?= $this->Form->input('menor_valor', ['label' => 'Valor Máximo']); ?>
                    <?= $this->Form->input('valor_medio', ['label' => 'Valor Médio']); ?>
                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Salvar</button>
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
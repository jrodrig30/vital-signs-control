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
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Forms</a></li>
        <li class="active">General</li>
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
                    <?= $this->Form->create('Diagnostico'); ?>
                    <?= $this->Form->input('nome'); ?>
                    <?= $this->Form->input('sinal_id'); ?>
                    <?= $this->Form->input('maior', ['label' => 'Maior que']); ?>
                    <?= $this->Form->input('menor', ['label' => 'Menor que']); ?>
                    <?= $this->Form->input('medio', ['label' => 'Valor Médio']); ?>
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



<!-- Content Header (Page header) -->
<?php // debug('oioi');exit; ?>
<section class="content-header">
    <h1>
        Diagnósticos
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Diagnósticos</a></li>
        <li class="active">Listar</li>
    </ol>
</section>
<style type="text/css">
    table td{
        font-weight: bold;
    }

    .div_legend {
        width: 20px;
        height: 10px;
        color: red;
        background-color: red;
        float: left;
        margin-top: 5px;
    }

    .sinal_responsavel{
        color:white;
        background-color: red;
        font-weight: bold;
    }

    .btn-app{
        background-color: #3c8dbc;
        color: white;
    }

</style>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <!-- div class="box-header">
                    <h3 class="box-title">Sinais Vitais Paciente 3</h3>
                </div -->
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="example2" class="table table-bordered table-hover">
                        <a href="<?=
                        $this->Url->build(["controller" => "diagnosticos",
                            "action" => "gerar_classificador"]);
                        ?>" class="btn btn-app">
                            <i class="fa fa-play"></i> Gerar Novo Classificador
                        </a>
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Sinais</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($diagnosticos as $key => $diagnostico):
                                ?>
                                <tr>
                                    <td><?= $diagnostico->nome; ?></td>
                                    <td><?= $this->Diagnostico->getSinaisByDiagnostico($diagnostico->id); ?></td>
                                    <td>
                                        <?= $this->Html->link(__(''), ['action' => 'edit', $diagnostico->id], ['title' => 'Editar', 'class' => 'fa fa-fw fa-edit',]) ?>
                                        <?= $this->Form->postLink(__(''), ['action' => 'delete', $diagnostico->id], ['title' => 'Remover', 'class' => 'fa fa-fw fa-remove', 'confirm' => __('Você tem certeza que deseja remove o Diagnóstico # {0}?', $diagnostico->id)]) ?>
                                    </td>

                                </tr>
                                <?php
                            endforeach;
                            ?>


                        </tbody>
                        <tfoot>
                            <tr>

                            </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->

            <div class="box">
                <div class="box-header">
                    <!--<h3 class="box-title">Data Table With Full Features</h3> -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">

                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->

<?php
$this->Html->css([
    'AdminLTE./plugins/datatables/dataTables.bootstrap',
        ], ['block' => 'css']);

$this->Html->script([
    'AdminLTE./plugins/datatables/jquery.dataTables.min',
    'AdminLTE./plugins/datatables/dataTables.bootstrap.min',
        ], ['block' => 'script']);
?>

<?php $this->start('scriptBotton'); ?>
<script>
    $(function () {
        $("#example1").DataTable();
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false
        });
    });
</script>
<?php $this->end(); ?>


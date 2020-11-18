<!-- Content Header (Page header) -->
<?php // debug('oioi');exit; ?>
<section class="content-header">
    <h1>
        Sinais Vitais
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Sinais  Vitais</a></li>
        <li><a href="#">Listar</a></li>
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
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Valor Máximo</th>
                                <th>Valor Minímo</th>
                                <th>Valor Médio</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($sinais as $key => $sinal):
                                ?>
                                <tr>
                                    <td><?= $sinal->nome; ?></td>
                                    <td><?= $sinal->menor_valor; ?></td>
                                    <td><?= $sinal->maior_valor; ?></td>
                                    <td><?= $sinal->valor_medio; ?></td>
                                    <td>
                                        <?= $this->Html->link(__(''), ['action' => 'edit', $sinal->id], ['title' => 'Editar', 'class' => 'fa fa-fw fa-edit',]) ?>
                                        <?= $this->Form->postLink(__(''), ['action' => 'delete', $sinal->id], ['title' => 'Remover', 'class' => 'fa fa-fw fa-remove', 'confirm' => __('Você tem certeza que deseja remove o Sinal # {0}?', $sinal->id)]) ?>

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



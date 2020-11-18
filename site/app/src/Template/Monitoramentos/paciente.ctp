<!-- Content Header (Page header) -->
<?php // debug('oioi');exit; ?>

<section class="content-header">
    <h1>
        Sinais Vitais por Paciente 
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Tables</a></li>
        <li class="active">Sinais Vitais</li>
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

    .invalid-blink {
        background-color: red;
    }

    td {
        padding: 1em;
    }

</style>

<script type="text/javascript">
    $(function () {
        var on = false;
        window.setInterval(function () {
            on = !on;
            if (on) {
                $('.invalid').addClass('invalid-blink')
            } else {
                $('.invalid-blink').removeClass('invalid-blink')
            }
        }, 2000);
    });
</script>


<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Sinais Vitais Paciente <?= $dados[0]->paciente ?> de <?= $dados[0]->idade ?> anos.</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <a href="reiniciar_classificador" class="btn btn-app" style="float: right">
                        <i class="fa fa-play"></i> Reiniciar Classificador
                    </a>

                    <table id="example2" class="table table-bordered table-hover">
                        <div class="div_legend"></div>&nbsp;<b class="label_legenda">  Sinais vitais que interferiram no diagnóstico</b>
                        <br />
                        <br />
                        <thead>
                            <tr>
                                <th>Data/Horário</th>
                                <th>Temperatura</th>
                                <th>Frequência Cardiáca</th> 
                                <th>Frequência Respiratória</th>
                                <th>Pressão Diastólica</th>
                                <th>Pressão Sistólica</th>
                                <th>Pressão Média</th>
                                <th>Saturação Oxigênio</th>
                                <th>Diagnóstico</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($dados as $key => $dado):
                                $pd = empty($dado->pressao_dia) ? 80 : $dado->pressao_dia;
                                $ps = empty($dado->pressao_sis) ? 120 : $dado->pressao_sis;
                                $pam = (($pd * 2) + $ps) / 3;
                                $diagnostico = $this->Diagnostico->getDiagnostico($dado->idade, empty($dado->frequencia_cardiaca) ? 80 : $dado->frequencia_cardiaca, empty($dado->frequencia_respiratoria) ? 20 : $dado->frequencia_respiratoria, $pd, $ps, round($pam, 2), empty($dado->saturacao_oxigenio) ? 94 : $dado->saturacao_oxigenio, $dado->temperatura > 0 ? round($dado->temperatura, 2) : 37
                                );
                                $classe = "";
                                if ($diagnostico != '99') {
                                    $classe = "invalid";
                                }
                                ?>
                                <tr class="<?= $classe; ?>">
                                    <td><?= $dado->horario; ?></td>
                                    <td class="<?= $this->Diagnostico->sinalIsResponsavel($diagnostico, 7); ?>"><?= round($dado->temperatura, 2) > 0 ? round($dado->temperatura, 2) : ''; ?></td>
                                    <td class="<?= $this->Diagnostico->sinalIsResponsavel($diagnostico, 1); ?>"><?= $dado->frequencia_cardiaca; ?></td>
                                    <td class="<?= $this->Diagnostico->sinalIsResponsavel($diagnostico, 2); ?>"><?= $dado->frequencia_respiratoria; ?></td>
                                    <td class="<?= $this->Diagnostico->sinalIsResponsavel($diagnostico, 3); ?>"><?= $dado->pressao_dia; ?></td>
                                    <td class="<?= $this->Diagnostico->sinalIsResponsavel($diagnostico, 4); ?>"><?= $dado->pressao_sis; ?></td>
                                    <td class="<?= $this->Diagnostico->sinalIsResponsavel($diagnostico, 5); ?>"><?= empty($dado->pressao_dia) ? '' : round($pam, 2); ?></td>
                                    <td class="<?= $this->Diagnostico->sinalIsResponsavel($diagnostico, 6); ?>"><?= $dado->saturacao_oxigenio; ?></td>
                                    <td><?= empty($diagnostico) ? '<b style="color:red"> Classifier Off</b>' : $this->Diagnostico->getNomeDiagnostico($diagnostico); ?></td>
                                    <td><?php
                                        if ($diagnostico != 99) {
                                            echo $this->Diagnostico->sinalIsResponsavel($diagnostico, 1) ? 'Administrar o rémedio x' : 'Administrar o rémedio y';
                                        }
                                        ?></td>
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


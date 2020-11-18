<!-- Content Header (Page header) -->
<?php // debug('oioi');exit; ?>

<section class="content-header">
    <h1>
        Pacientes em monitoramento
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
        $('#example2 tbody tr').click(function () {
            var url = window.location.href;
            if (url.indexOf('pacientes') != -1) {
                window.location.href = 'paciente/' + $(this).attr('data-paciente');
                return;
            }
            
            window.location.href = 'monitoramentos/paciente/' + $(this).attr('data-paciente');
        });

        if ($('.player_audio').length == 0) {
            $('#Alarm').hide();
            $('#Visual').hide();
        }

        $('#Alarm').click(function () {

            if ($('.player_audio').prop("paused") == false) {
                $('.player_audio').trigger("pause");
                $('#Alarm i').removeClass('fa fa-pause');
                $('#Alarm i').addClass('fa fa-play');
                $('#TextAlarm').text('Alarme Desabilitado');
            } else {
                $('.player_audio').trigger("play");
                $('#Alarm i').removeClass('fa fa-play');
                $('#Alarm i').addClass('fa fa-pause');
                $('#TextAlarm').text('Parar Alarme');
            }
        });

        $('#Visual').click(function () {
         $( "tr" ).removeClass("invalid");
        });


    }
    );
</script>


<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <input type="hidden" value="">
                    <a href="reiniciar_classificador" class="btn btn-app" style="float: right">
                        <i class="fa fa-play"></i> Reiniciar Classificador
                    </a>

                    <a href="#" class="btn btn-app" style="float: right" id="Alarm">
                        <i class="fa fa-pause"></i> <span id="TextAlarm">Parar Alarme</span>
                    </a>

                    <a href="#" class="btn btn-app" style="float: right" id="Visual">
                        <i class="fa fa-pause"></i> <span id="TextVisual">Parar Alarme Visual</span>
                    </a>


                    <table id="example2" class="table table-bordered table-hover">
                        <div class="div_legend"></div>&nbsp;<b class="label_legenda">  Sinais vitais que interferiram no diagnóstico</b>
                        <br />
                        <br />
                        <thead>
                            <tr>
                                <th>Paciente</th>
                                <th>Data/Horário</th>
                                <th>Temperatura (°C)</th>
                                <th>Frequência Cardiáca (bpm)</th> 
                                <th>Frequência Respiratória (mrm)</th>
                                <th>Pressão Diastólica (mmHg)</th>
                                <th>Pressão Sistólica (mmHg)</th>
                                <th>Pressão Média (mmHg)</th>
                                <th>Saturação Oxigênio (SpO2)</th>
                                <th>Diagnóstico</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($dados as $key => $dado):
                                $pd = empty($dado['pressao_dia']) ? 80 : $dado['pressao_dia'];
                                $ps = empty($dado['pressao_sis']) ? 120 : $dado['pressao_sis'];
                                $pam = (($pd * 2) + $ps) / 3;
                                $diagnostico = $this->Diagnostico->getDiagnostico($dado['idade'], empty($dado['frequencia_cardiaca']) ? 80 : $dado['frequencia_cardiaca'], empty($dado['frequencia_respiratoria']) ? 20 : $dado['frequencia_respiratoria'], $pd, $ps, round($pam, 2), empty($dado['saturacao_oxigenio']) ? 94 : $dado['saturacao_oxigenio'], $dado['temperatura'] > 0 ? round($dado['temperatura'], 2) : 37
                                );

                                $classe = "";
                                if ($diagnostico != '99') {
                                    ?>
                                <audio class='player_audio' controls autoplay style="display: none" loop="loop">
                                    <source src="../alarm.mp3" type="audio/mpeg">
                                    Your browser does not support the audio element.
                                </audio>
                                <?php
                                $classe = "invalid";
                            }
                            ?>
                            <tr style="cursor: pointer" data-horario="<?= substr($dado['horario'], 0, 10); ?>" data-paciente="<?= $dado['paciente']; ?>" class="<?= $classe; ?>">
                                <td><?= $dado['paciente']; ?></td>
                                <td><?= $dado['horario']; ?></td>
                                <td class="<?= $this->Diagnostico->sinalIsResponsavel($diagnostico, 7); ?>"><?= round($dado['temperatura'], 2) > 0 ? round($dado['temperatura'], 2) : ''; ?></td>
                                <td class="<?= $this->Diagnostico->sinalIsResponsavel($diagnostico, 1); ?>"><?= $dado['frequencia_cardiaca']; ?></td>
                                <td class="<?= $this->Diagnostico->sinalIsResponsavel($diagnostico, 2); ?>"><?= $dado['frequencia_respiratoria']; ?></td>
                                <td class="<?= $this->Diagnostico->sinalIsResponsavel($diagnostico, 3); ?>"><?= $dado['pressao_dia']; ?></td>
                                <td class="<?= $this->Diagnostico->sinalIsResponsavel($diagnostico, 4); ?>"><?= $dado['pressao_sis']; ?></td>
                                <td class="<?= $this->Diagnostico->sinalIsResponsavel($diagnostico, 5); ?>"><?= empty($dado['pressao_dia']) ? '' : round($pam, 2); ?></td>
                                <td class="<?= $this->Diagnostico->sinalIsResponsavel($diagnostico, 6); ?>"><?= $dado['saturacao_oxigenio']; ?></td>
                                <td><?= empty($diagnostico) ? '<b style="color:red"> Classifier Off</b>' : $this->Diagnostico->getNomeDiagnostico($diagnostico); ?></td>
                                <td><?php
                                    if ($diagnostico != 99) {
                                        echo $this->Diagnostico->getAcao($diagnostico);
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
            "autoWidth": false,
            "ajax": 'getUltimaLeituraPacientes'

        });
    });
</script>
<?php $this->end(); ?>


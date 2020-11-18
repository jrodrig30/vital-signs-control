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

</style>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Sinais Vitais Paciente 3</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="example2" class="table table-bordered table-hover">
                        <div class="div_legend"></div>&nbsp;<b class="label_legenda">  Sinais vitais que interferiram no diagnóstico</b>
                        <br />
                        <br />
                        <thead>
                            <tr>
                                <th>Idade</th>
                                <th>Temperatura</th>
                                <th>Frequência Cardiáca</th>
                                <th>Frequência Respiratória</th>
                                <th>Pressão Diastólica</th>
                                <th>Pressão Sistólica</th>
                                <th>Pressão Média</th>
                                <th>Saturação Oxigênio</th>
                                <th>Diagnóstico</th>
                            </tr>
                        </thead>
                        <tbody>
                        <!--<tr style="background-color: red;color:white">
                          <td>70</td>
                          <td>17/10/2017 08:23:00 </td>
                          <td>37,7</td>
                          <td style="background-color: white;color:red">120</td>
                          <td>16</td>
                          <td>90</td>
                          <td style="background-color: white;color:red">150</td>
                          <td style="background-color: white;color:red">110</td>
                          <td>96</td>
                          <td><b style="font-size: 18px">Taquicardia e Pressão Alta</b></td>
                        </tr>
                        <tr style="background-color: #e3e300;color:white">
                          <td>70</td>
                          <td>17/10/2017 08:24:00 </td>
                          <td>37</td>
                          <td>96</td>
                          <td>16</td>
                          <td>90</td>
                          <td style="background-color: white;color:red">150</td>
                          <td style="background-color: white;color:red">110</td>
                          <td>96</td>
                          <td><b style="font-size: 18px">Pressão Alta</b></td>
                        </tr>
                        <tr style="background-color: green;color:white">
                          <td>70</td>
                          <td>17/10/2017 08:25:00 </td>
                          <td>37</td>
                          <td>96</td>
                          <td>16</td>
                          <td>80</td>
                          <td>120</td>
                          <td>93</td>
                          <td>96</td>
                          <td><b style="font-size: 18px">Normal<b></td>
                        </tr>
                         <tr style="background-color: green;color:white">
                          <td>70</td>
                          <td>17/10/2017 08:26:00 </td>
                          <td>37</td>
                          <td>96</td>
                          <td>16</td>
                          <td>80</td>
                          <td>120</td>
                          <td>93</td>
                          <td>96</td>
                          <td><b style="font-size: 18px">Normal</b></td>
                        </tr> -->
                            <?php
                            foreach ($dados as $key => $dado):
                                $pam = (($dado->pressao_dia * 2) + $dado->pressao_sis) / 3;
                                $diagnostico = $this->Diagnostico->getDiagnostico($dado->idade, $dado->frequencia_cardiaca, $dado->frequencia_respiratoria, $dado->pressao_dia, $dado->pressao_sis, round($pam, 2), $dado->saturacao_oxigenio, round($dado->temperatura, 2));
                                ?>
                                <tr>
                                    <td><?= $dado->idade; ?></td>
                                    <td class="<?= $this->Diagnostico->temperaturaIsResponsavel($diagnostico); ?>"><?= round($dado->temperatura, 2); ?></td>
                                    <td class="<?= $this->Diagnostico->frequenciaCardiacaIsResponsavel($diagnostico); ?>"><?= $dado->frequencia_cardiaca; ?></td>
                                    <td class="<?= $this->Diagnostico->frequenciaRespiratoriaIsResponsavel($diagnostico); ?>"><?= $dado->frequencia_respiratoria; ?></td>
                                    <td class="<?= $this->Diagnostico->pressaoDiaIsResponsavel($diagnostico); ?>"><?= $dado->pressao_dia; ?></td>
                                    <td class="<?= $this->Diagnostico->pressaoSisIsResponsavel($diagnostico); ?>"><?= $dado->pressao_sis; ?></td>
                                    <td class="<?= $this->Diagnostico->pamIsResponsavel($diagnostico); ?>"><?= round($pam, 2); ?></td>
                                    <td class="<?= $this->Diagnostico->saturacaoIsResponsavel($diagnostico); ?>"><?= $dado->saturacao_oxigenio; ?></td>
                                    <td><?= $this->Diagnostico->getNomeDiagnostico($diagnostico); ?></td>
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

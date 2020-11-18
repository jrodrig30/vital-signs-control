<style>
    .col-md-6 {
        width: 100%;
    }

    .form-group{
        width: 100px;
        float: left;
        margin-left: 10px;
    }

    #idade, #temperatura, #classe {
        margin-top: 20px;
    }

    .textarea{
        width: 900px;
        float: none;
    }

    .sinal_responsavel{
        color:white;
        background-color: red;
        font-weight: bold;
    }
</style>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Simulador de Diagnóstico
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Simulador de Diagnóstico</a></li>
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
                <script>
                    $(function () {
                        $('#pd, #ps').keyup(function () {
                            pam = parseFloat((parseInt($('#pd').val() * 2)) + parseInt($('#ps').val() > 0 ? $('#ps').val() : 0)) / 3;
                            $('#pm').val(pam.toFixed(2));
                        });
                    });
                </script>
                <div class="box-body">
                    <?php
                    $diagnostico = '';
                    $diagnosticoCodigo = 99;
                    if (isset($dados)) {
                        $diagnosticoCodigo = $this->Diagnostico->getDiagnostico($dados['idade'], $dados['fc'], $dados['fr'], $dados['pd'], $dados['ps'], $dados['pm'], $dados['so'], $dados['temperatura']);
                        $diagnostico = $this->Diagnostico->getNomeDiagnostico($diagnosticoCodigo, $detalhar = true);
                    }
                    ?>
                    <?= $this->Form->create(); ?>
                    <?= $this->Form->input('idade'); ?> 
                    <?= $this->Form->input('temperatura', ['class' => 'form-control ' . $this->Diagnostico->sinalIsResponsavel($diagnosticoCodigo, 7)]); ?>
                    <?= $this->Form->input('fc', ['label' => 'Frequência Cardíaca', 'class' => 'form-control ' . $this->Diagnostico->sinalIsResponsavel($diagnosticoCodigo, 1)]); ?>
                    <?= $this->Form->input('fr', ['label' => 'Frequência Respiratória', 'class' => 'form-control ' . $this->Diagnostico->sinalIsResponsavel($diagnosticoCodigo, 2)]); ?>
                    <?= $this->Form->input('pd', ['label' => 'Pressão Diastólica', 'class' => 'form-control ' . $this->Diagnostico->sinalIsResponsavel($diagnosticoCodigo, 3)]); ?>
                    <?= $this->Form->input('ps', ['label' => 'Pressão Sistólica', 'class' => 'form-control ' . $this->Diagnostico->sinalIsResponsavel($diagnosticoCodigo, 4)]); ?>
                    <?= $this->Form->input('pm', ['label' => 'Pressão Arterial Média', 'class' => 'form-control ' . $this->Diagnostico->sinalIsResponsavel($diagnosticoCodigo, 5)]); ?>
                    <?= $this->Form->input('so', ['label' => 'Saturação Oxigênio', 'class' => 'form-control ' . $this->Diagnostico->sinalIsResponsavel($diagnosticoCodigo, 6)]); ?>
                    <?= $this->Form->input('classe', ['type' => 'textarea', 'rows' =>10, 'label' => 'Diagnóstico', 'value' => $diagnostico, 'div' => ['id' => 'diagnostico']]); ?>
                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Simular</button>
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
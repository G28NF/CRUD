<div class="mb-3">
    <h2 class="card-title mb-0">Importação</h2>
</div>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 50vh;">
    <div class="col-md-10 col-lg-9">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body p-5">

                <div class="alert alert-primary text-dark text-center" role="alert" style="font-weight:500;">
                    <i class="fa fa-info-circle me-2"></i>
                    <strong>Caminho para exportação destes dados no SUAP:</strong><br><br>

                    Ensino → Relatórios → Listagem de Alunos<br>
                    Nos filtros, na parte inferior, em <strong>"Exibição"</strong>, marcar os campos
                    <strong>Telefone</strong> e <strong>Turma</strong>.<br>
                    Clicar no botão <strong>[Exportar para XLS]</strong>, no canto superior direito.<br>
                </div>

                <form method="post" action="<?= base_url('sys/importar'); ?>" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    
                    <div class="mb-4 text-center">
                        <label for="planilha" class="w-100">
                            <div class="card p-5 text-center border rounded-4 text-white"  style="font: weight 500px;">
                                <div id="nomeArquivo">Selecione o arquivo Excel</div>
                            </div>
                        </label>
                        <input type="file" id="planilha" name="planilha" hidden required>
                    </div>  
                    
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary btn-fw py-2 fs-6" style="width: 175px;">
                            <i class="fa fa-upload" btn-icon-prepend></i>
                            Importar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
<?php if (session()->has('erros')): ?>
    <?php foreach ((array)session('erros') as $erro): ?>
        $.toast({
        heading: 'Erro',
        text: '<?= esc($erro); ?>',
        showHideTransition: 'fade',
        icon: 'error',
        loaderBg: '#dc3545',
        position: 'top-center'
        });
    <?php endforeach; ?>
<?php endif; ?>

<?php if (!session()->has('erros') && session()->has('sucesso')): ?>
    $.toast({
        heading: 'Sucesso',
        text: '<?= session('sucesso') ?>',
        showHideTransition: 'fade',
        icon: 'success',
        loaderBg: '#35dc5fff',
        position: 'top-center'
    });
<?php endif; ?>

<?php if (session()->has('avisos')): ?>
    <?php foreach ((array) session('avisos') as $avisos): ?>
        $.toast({
            heading: 'Aviso',
            text: '<?= esc($avisos); ?>',
            showHideTransition: 'fade',
            icon: 'warning',
            loaderBg: 'rgb(179, 111, 9)',
            position: 'top-center',
            hideAfter: 4000
        });
    <?php endforeach; ?>
<?php endif; ?>

document.getElementById('planilha').addEventListener('change', function() {
    const nome = this.files.length ? this.files[0].name : 'Selecione o arquivo Excel';
    document.getElementById('nomeArquivo').textContent = nome;
});
</script>
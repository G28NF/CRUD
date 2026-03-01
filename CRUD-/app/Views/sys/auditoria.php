<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Logs de Auditoria</h4>
                
                <div class="row mb-4">
                    <div class="col-md-3">
                        <label>Ação</label>
                        <select id="filtro-acao" class="form-control js-example-basic-single">
                            <option value="">Todas</option>
                            <option value="Inserção">Inserção</option>
                            <option value="Edição">Edição</option>
                            <option value="Exclusão">Exclusão</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>Tabela Afetada</label>
                        <input type="text" id="filtro-tabela" class="form-control" placeholder="Ex: aulas, alunos...">
                    </div>
                </div>

                <div class="table-responsive d-none d-lg-block">
                    <table id="tabela-logs" class="table table-hover table-striped mb-4">
                        <thead>
                            <tr>
                                <th style="width: 10%;">Data/Hora</th>
                                <th style="width: 15%;">Usuário</th>
                                <th style="width: 10%;">Ação</th>
                                <th>Item/Modificação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <td>02/02/2026 - 08:33</td>
                            <td>ID:1 NOME: admin</td>
                            <td><span class="badge badge-success">Inserção</span></td>
                            <td>aluno: Novo aluno cadastrado</td>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    const table = $('#tabela-logs').DataTable({
        language: {
            url: "<?= base_url('assets/js/traducao-dataTable/pt_br.json'); ?>"
        },
        order: [[0, 'desc']],
        pageLength: 25
    });

    $('#filtro-acao').on('change', function() {
        table.column(2).search(this.value).draw();
    });

    $('#filtro-tabela').on('keyup', function() {
        table.column(3).search(this.value).draw();
    });
});
</script>
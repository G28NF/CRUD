<div class="mb-3">
    <h2 class="card-title mb-0">Análise das Solicitações</h2>
</div>

<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <?php if (!empty($solicitacoes)): ?>
                    <table id="listagem-solicitacoes" class="table mb-4 w-100 text-center">
                        <thead>
                            <tr>
                                <th>Solicitante</th>
                                <th>Data da Solicitação</th>
                                <th>Data da Retirada</th>
                                <th>Motivo</th>
                                <th>Link via SEI</th>
                                <th style="text-align: center; width: 10%; min-width: 100px;">Ações</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                <?php else: ?>
                    <p>Nenhum solicitação encontrado no banco de dados.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
/* Container dos botões de Ações */
#listagem-solicitacoes td .d-flex {
    justify-content: center;  
    gap: 8px;                 
}

/* Botões Aprovar/Recusar */
#listagem-solicitacoes td .btn-inverse-success,
#listagem-solicitacoes td .btn-inverse-danger {
    display: inline-flex;
    align-items: center;       
    justify-content: center;   
    width: 32px;               
    height: 32px;           
    padding: 0;                
    border-radius: 6px;       
    font-size: 14px;            
    line-height: 1;
}

/* Ícones dentro dos botões */
#listagem-solicitacoes td .btn-inverse-success i,
#listagem-solicitacoes td .btn-inverse-danger i {
    pointer-events: none; 
}
</style>

<script>
    const dataTableLangUrl = "<?= base_url('assets/js/traducao-dataTable/pt_br.json'); ?>";
    const solicitacoesData = <?= json_encode($solicitacoes ?? []) ?>;

    $(document).ready(function() {
        const motivos = {
            0: 'Contraturno',
            1: 'Estágio',
            2: 'Treino',
            3: 'Projeto',
            4: 'Visita Técnica'
    };

        $('#listagem-solicitacoes').DataTable({
            data: solicitacoesData,
            columns: [
                { data: 'nome_solicitante' },
                { 
                    data: 'data_solicitada',
                },
                { 
                    data: 'data_refeicao',
                },
                { 
                    data: 'motivo',
                    render: d => motivos[d] ?? '—'
                },
                { 
                    data: null,
                    render: () => '—' // Link via SEI sempre "-"
                },
                { 
                    data: null,
                    orderable: false,
                    searchable: false,
                    render: row => `
                        <div class="d-flex justify-content-center gap-2">
                            <form method="post" action="<?= site_url('sys/analise/atualizar') ?>">
                                <input type="hidden" name="id" value="${row.id}">
                                <input type="hidden" name="status" value="2">
                                <button type="submit" class="btn btn-inverse-success btn-icon" data-bs-toggle="tooltip" title="Aprovar">
                                    <i class="fa fa-check"></i>
                                </button>
                            </form>
                            <form method="post" action="<?= site_url('sys/analise/atualizar') ?>">
                                <input type="hidden" name="id" value="${row.id}">
                                <input type="hidden" name="status" value="1">
                                <button type="submit" class="btn btn-inverse-danger btn-icon" data-bs-toggle="tooltip" title="Recusar">
                                    <i class="fa fa-times"></i>
                                </button>
                            </form>
                        </div>`
                }
            ],
            language: { search: "Pesquisar:", url: dataTableLangUrl },
            ordering: true,
            lengthMenu: [[10,25,50,-1],[10,25,50,"Todos"]]
        });
    });
</script>
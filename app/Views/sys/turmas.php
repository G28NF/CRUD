<?= $this->include('components/turmas/modal_cadastrar_turma', ['cursos' => $cursos]) ?>
<?= $this->include('components/turmas/modal_editar_turma', ['cursos' => $cursos]) ?>
<?= $this->include('components/turmas/modal_deletar_turma', ['cursos' => $cursos]) ?>
<?= $this->include('components/turmas/modal_importar_alunos_turma', ['cursos' => $cursos]) ?>
<?= $this->include('components/turmas/modal_confirmar_senha') ?>
<?= $this->include('components/turmas/modal_importar_turmas') ?>
<?= $this->include('components/turmas/modal_deletar_multiplos_turmas') ?>

<div class="mb-3">
    <h2 class="card-title mb-0">Turmas</h2>
</div>
<div class="row">
    <div class="col-md-4 grid-margin stretch-card">
        <div class="card ">
            <div class="card-body">
                <div class="mb-3">
                    <h5 class="card-title mb-0">Ações</h5>
                </div>
                <div>
                    <button type="button" class="btn btn-primary btn-fw" data-bs-toggle="modal" data-bs-target="#modal-cadastrar-turma">
                        <i class="fa fa-plus-circle btn-icon-prepend"></i>
                        Nova Turma
                    </button>
                </div>
                <div class="mt-3">
                    <!-- Botão de confirma as exclusões do turmas padronizador igual ao de agendamento -->
                    <span data-bs-toggle="tooltip" title="Excluir turmas selecionados" data-bs-placement="bottom">
                        <button type="button" class="btn btn-danger d-none" id="btn-delete-multi" data-bs-toggle="modal" data-bs-target="#modal_deletar_multiplos_turmas">
                            <i class="fa fa-trash btn-icon-prepend"></i>
                        </button>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8 grid-margin stretch-card">
        <div class="card ">
            <div class="card-body">
                <div class="mb-3">
                    <h5 class="card-title">Filtros</h5>
                    <div class="form-group row align-items-end">
                        <div class="col-md-3">
                            <label for="filtro-curso">Curso</label>
                            <select id="filtro-curso" class="js-example-basic-single" style="width:100%">
                                <option value="">--</option>
                                <?php foreach ($cursos as $curso): ?>
                                    <option value="<?= esc($curso['nome']) ?>"><?= esc($curso['nome']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <?php if (!empty($turmas)): ?>
                    <table class="table mb-4" id="tabela-turmas">
                        <thead>
                            <th style="width: 3%; min-width: 40px;"><!-- Botão de selecionar turmas pra exclusão --></th>
                            <th style="width: 3%; min-width: 40px;"><strong>Id</strong></th>
                            <th><strong>Código da Turma</strong></th>
                            <th><strong>Nome</strong></th>
                            <th><strong>Curso</strong></th>
                            <th class="text-nowrap" style="text-align: center; width: 12%; min-width: 100px;"><strong>Ações</strong></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>Nenhuma turma encontrada no banco de dados.</p>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>

<script>
    const dataTableLangUrl = "<?php echo base_url('assets/js/traducao-dataTable/pt_br.json'); ?>";
    const turmasData = <?= json_encode($turmas ?? []) ?>;

    $(document).ready(function() {

        //ESSA PARTE APENAS RENDERIZA O MODELO DO CORONA
        $('.js-example-basic-single').select2();

        const initTooltips = () => {
            $('[data-bs-toggle="tooltip"]').each(function() {
                const tooltipInstance = bootstrap.Tooltip.getInstance(this);
                if (tooltipInstance) {
                    tooltipInstance.dispose();
                }
                new bootstrap.Tooltip(this, {
                    container: 'body',
                    customClass: 'tooltip-on-top',
                    offset: [0, 10]
                });
            });
        };

        const btnDeleteHtml = `
            <div class="btn-delete-multi-wrapper d-none btn-delete-multi-target" style="display: inline-block; margin-left: 15px; vertical-align: middle;">
                <span class="contador-selecionados text-muted me-2 fw-bold" style="font-size: 0.9em;"></span>
                <span data-bs-toggle="tooltip" title="Excluir itens selecionados" data-bs-placement="top">
                <button type="button" class="btn btn-danger btn-sm btn-multi-delete-trigger">
                    <i class="fa fa-trash"></i>
                </button>
            </div>`;

        if (turmasData.length > 0) {
            $('#tabela-turmas').DataTable({
                data: turmasData,
                columns: [{
                        //Botão de exclusão individual padronizador igual ao de agendamento
                        data: 'id',
                        render: data =>
                            `<div class="form-check form-check-flat form-check-primary" style="margin: 0;">
                            <label class="form-check-label">
                            <input type="checkbox" class="form-check-input check-turmas" name="ids[]" value="${data}">
                            <i class="input-helper"></i>
                            </label>
                            </div>`
                    },
                    {
                        data: 'id'
                    },
                    {
                        data: 'codTurma'
                    },
                    {
                        data: 'nome'
                    },
                    {
                        data: 'curso_nome'
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `
                                <div class="d-flex d-flex align-center justify-content-center gap-2">
                                    <span data-bs-toggle="tooltip" data-placement="top" title="Editar">
                                        <button
                                            type="button"
                                            class="justify-content-center align-items-center d-flex btn btn-inverse-success button-trans-success btn-icon me-1 edit-turma-btn"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modal-editar-turma"
                                            data-id="${data.id}"
                                            data-cod="${data.codTurma}"
                                            data-nome="${data.nome}"
                                            data-curso_id="${data.curso_id}">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                    </span>
                                    <span data-bs-toggle="tooltip" data-placement="top" title="Excluir">
                                        <button
                                            type="button"
                                            class="justify-content-center align-items-center d-flex btn btn-inverse-danger button-trans-danger btn-icon me-1 delete-turma-btn"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modal-deletar-turma"
                                            data-id="${data.id}"
                                            data-nome="${data.nome}">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </span>
                                </div>
                            `;
                        }
                    }
                ],
                //Botão de selecionar todos os turmas pra exclusão padronizador igual ao de agendamento
                columnDefs: [{
                    targets: 0,
                    orderable: false,
                    searchable: false,
                    title: `
                    <div class="form-check form-check-flat form-check-primary" style="margin: 0;">
                        <label class="form-check-label">
                            <input type="checkbox" class="form-check-input" id="check-todos">
                            <i class="input-helper"></i>
                        </label>
                    </div>
                  `
                }],
                language: {
                    search: "Pesquisar:",
                    url: dataTableLangUrl
                },
                ordering: true,
                aLengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, "Todos"],
                ],
                initComplete: function(settings, json) {
                    $('.dataTables_length').append(btnDeleteHtml);
                    $('.dataTables_info').append(btnDeleteHtml);
                    initTooltips();
                },
                drawCallback: function() {
                    initTooltips();
                    $('#check-todos').prop('checked', false);
                    $('.btn-delete-multi-target').addClass('d-none');
                }
            });

            $('#filtro-curso').on('change', function() {
                const valorCurso = $(this).val();
                const table = $('#tabela-turmas').DataTable();

                if (valorCurso) {
                    table.column(4).search('^' + valorCurso + '$', true, false).draw();
                } else {
                    table.column(4).search('').draw();
                }
                // Salva no localStorage
                localStorage.setItem('filtroCursoTurmas', valorCurso);
            });
        }

        const table = $('#tabela-turmas').DataTable();
        const valorSalvo = localStorage.getItem('filtroCursoTurmas');
        if (valorSalvo) {
            $('#filtro-curso').val(valorSalvo).trigger('change');
        }

        // Lógica de notificação
        <?php if (session()->has('erros')): ?>
            <?php foreach (session('erros') as $erro): ?>
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

        // Lógica para preencher o modal de edição
        $('#modal-editar-turma').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var nome = button.data('nome');
            var curso_id = button.data('curso_id');
            var modal = $(this);
            modal.find('#edit-turma-id').val(id);
            modal.find('#edit-turma-nome').val(nome);
            modal.find('#edit-curso-id').val(curso_id);
        });

        // Lógica para preencher o modal de exclusão
        $('#modal-deletar-turma').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var nome = button.data('nome');
            var modal = $(this);
            modal.find('#deletar-id').val(id);
            modal.find('#deletar-nome').html('<b>' + nome + '</b>');
        });

        // Lógica para preencher o modal de importar alunos
        $('#modal-importar-alunos-turma').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var nome = button.data('nome');
            var cursoNome = button.data('curso_nome');
            var cursoId = button.data('curso_id');
            var modal = $(this);
            modal.find('#importar-turma-id').val(id);
            modal.find('#importar-turma-nome').text(nome);
            modal.find('#importar-curso-id').val(cursoId);
            modal.find('#importar-curso-nome').text(cursoNome);
        });
    });

    function abrirModalDeletarTurma(id, nome) {
        // Verifica via AJAX se há alunos vinculados à turma
        $.get("<?= base_url('sys/turmas/verificarAlunos') ?>/" + id, function(resposta) {
            const temAlunos = resposta.temAlunos;

            if (temAlunos) {
                // Mensagem de alerta se houver alunos
                $('#deleteModalBody').html(`
                    <p class="text-break">
                        <strong>ATENÇÃO!</strong>
                        A turma <strong>${nome}</strong> possui alunos cadastrados.
                        Deseja excluir mesmo assim?
                    </p>
                `);

                $('#deleteModalFooter').html(`
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="btnConfirmarExclusao">Sim</button>
                `);

                $('#deleteTurmaId').val(id); // Atualiza o input hidden
                $('#modal-deletar-turma').modal('show');

                // Clique em "Sim" → abre modal de senha
                $(document).off('click', '#btnConfirmarExclusao').on('click', '#btnConfirmarExclusao', function() {
                    $('#senhaTurmaId').val(id);
                    $('#modal-deletar-turma').modal('hide');
                    $('#modal-confirmar-senha').modal('show');
                });

            } else {
                // Mensagem normal
                $('#deleteModalBody').html(`
                    <p class="text-break">
                        Confirma a exclusão da turma <strong>${nome}</strong>?
                    </p>
                `);

                $('#deleteModalFooter').html(`
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger" id="btnExcluirTurma">Excluir Turma</button>
                `);

                $('#deleteTurmaId').val(id);
                $('#modal-deletar-turma').modal('show');
            }
        });
    }

    // Botão de deletar
    $(document).on('click', '.delete-turma-btn', function() {
        const id = $(this).data('id');
        const nome = $(this).data('nome');
        abrirModalDeletarTurma(id, nome);
    });

    //Função do JS da exclusão de turmas
    $(document).ready(function() {

        const atualizarInterfaceDelete = () => {
            const marcados = $('.check-turmas:checked').length;
            const total = $('.check-turmas').length;
            $('#check-todos').prop('checked', total > 0 && total === marcados);
            
            if (marcados > 0) {
                $('.btn-delete-multi-target').removeClass('d-none');
                const texto = marcados === 1 ? '1 Turma selecionada' : `${marcados} Turmas selecionadas`;
                $('.contador-selecionados').text(texto);
            } else {
                $('.btn-delete-multi-target').addClass('d-none');
            }
        };

        $(document).on('change', '#check-todos', function() {
            $('.check-turmas').prop('checked', this.checked);
            atualizarInterfaceDelete();
        });

        $(document).on('change', '.check-turmas', function() {
            atualizarInterfaceDelete();
        });

        $(document).on('click', '.btn-multi-delete-trigger', function(e) {
            e.preventDefault();
            
            const ids = [];
            $('.check-turmas:checked').each(function() { 
                ids.push($(this).val()); 
            });

            if (ids.length === 0) return;

            const marcados = ids.length;

            $.ajax({
                url: "<?= site_url('sys/turmas/verificarVariosAlunos') ?>",
                type: "POST",
                data: {
                    "<?= csrf_token() ?>": "<?= csrf_hash() ?>",
                    ids: ids
                },
                dataType: 'json',
                success: function(resposta) {
                    if (resposta.temAlunos) {
                        // Caso haja alunos: Exibe o alerta de confirmação primeiro
                        const textoTurma = marcados === 1 ? 'A turma selecionada possui' : `As ${marcados} turmas selecionadas possuem`;

                        $('#deleteModalBody').html(`
                            <p class="text-break">
                                <strong>ATENÇÃO!</strong><br>
                                ${textoTurma} alunos cadastrados. 
                                Deseja excluir mesmo assim?
                            </p>
                        `);

                        $('#deleteModalFooter').html(`
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-danger" id="btnConfirmarExclusaoMulti">Sim, continuar</button>
                        `);

                        $('#modal-deletar-turma').modal('show');

                        $(document).off('click', '#btnConfirmarExclusaoMulti').on('click', '#btnConfirmarExclusaoMulti', function() {
                            $('#senhaTurmaId').val(ids.join(','));
                            $('#modal-deletar-turma').modal('hide');
                            $('#modal-confirmar-senha').modal('show');
                        });

                    } else {
                        const container = $('#inputs-nomes');
                        container.empty();
                        ids.forEach(id => {
                            container.append(`<input type="hidden" name="ids[]" value="${id}">`);
                        });
                        
                        $('#modal_deletar_multiplos_turmas').modal('show');
                    }
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    alert("Erro ao processar solicitação.");
                }
            });
        });

        $('#modal_deletar_multiplos_turmas').on('show.bs.modal', function() {
            const container = $('#inputs-nomes');
            container.empty();
            $('.check-turmas:checked').each(function() {
                container.append(`<input type="hidden" name="ids[]" value="${this.value}">`);
            });
        });

        $('#listagem-turmas').on('draw.dt', function() {
            $('#check-todos').prop('checked', false);
            $('#btn-delete-multi').addClass('d-none');
        });

    });
</script>
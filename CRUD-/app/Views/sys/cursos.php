<?php echo view('components/cursos/modal_cadastrar_curso') ?>
<?php echo view('components/cursos/modal_editar_curso') ?>
<?php echo view('components/cursos/modal_deletar_curso') ?>
<?php echo view('components/cursos/modal_confirmar_senha_curso') ?>
<?php echo view('components/cursos/modal_importar_cursos') ?>
<?= $this->include('components/cursos/modal_deletar_multiplos_cursos') ?>

<div class="mb-3">
    <h2 class="card-title mb-0">Cursos</h2>
</div>
<div class="row">
    <div class="col-md-4 grid-margin stretch-card">
        <div class="card ">
            <div class="card-body">
                <div>
                    <div class="mb-3">
                        <h5 class="card-title mb-0">Ações</h5>
                    </div>
                    <button type="button" class="btn btn-primary btn-fw " data-bs-toggle="modal" data-bs-target="#modal-cadastrar-curso">
                        <i class="fa fa-plus-circle btn-icon-prepend"></i>
                        Novo Curso
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- =-=-=-=-= SE PRECISAR DE FILTROS NESSA TELA, DESCOMENTAR ESSA DIV =-=-=-=-= -->
    <!-- <div class="col-md-8 grid-margin stretch-card">
        <div class="card ">
            <div class="card-body">
                <div class="mb-3">
                    <h5 class="card-title mb-0">Filtros</h5>
                </div>
            </div>
        </div>
    </div> -->
</div>

<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <?php if (isset($cursos) && !empty($cursos)): ?>
                    <table class="table mb-4" id="listagem-cursos" style="width:100%;">
                        <thead>
                            <tr>
                                <th style="width: 3%; min-width: 40px;"><!-- Botão de selecionar cursos pra exclusão --></th>
                                <th style="width: 3%; min-width: 40px;"><strong>Código</strong></th>
                                <th><strong>Nome</strong></th>
                                <th style="text-align: center; width: 10%; min-width: 100px;"><strong>Ações</strong></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>Nenhum curso encontrado no banco de dados.</p>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>

<script>
    const dataTableLangUrl = "<?php echo base_url('assets/js/traducao-dataTable/pt_br.json'); ?>";
    const cursosData = <?= json_encode($cursos ?? []) ?>;

    $(document).ready(function() {

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
                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modal_deletar_multiplos_cursos">
                    <i class="fa fa-trash"></i>
                </button>
            </div>`;

        if (cursosData.length > 0) {
            $('#listagem-cursos').DataTable({
                data: cursosData,
                columns: [{
                        //Botão de exclusão individual padronizador igual ao de agendamento
                        data: 'id',
                        render: data =>
                            `<div class="form-check form-check-flat form-check-primary" style="margin: 0;">
                            <label class="form-check-label">
                            <input type="checkbox" class="form-check-input check-cursos" name="ids[]" value="${data}">
                            <i class="input-helper"></i>
                            </label>
                            </div>`
                    },
                    {
                        data: 'id'
                    },
                    {
                        data: 'nome'
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `
                                <div class="d-flex align-center justify-content-center gap-2">
                                    <span data-bs-toggle="tooltip" data-placement="top" title="Atualizar dados do curso">
                                        <button
                                            type="button"
                                            class="justify-content-center align-items-center d-flex btn btn-inverse-success button-trans-success btn-icon me-1"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modal-editar-curso"
                                            data-id="${data.id}"
                                            data-nome="${data.nome}">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                    </span>
                                    <span data-bs-toggle="tooltip" data-placement="top" title="Excluir curso">
                                        <button
                                            type="button"
                                            class="justify-content-center align-items-center d-flex btn btn-inverse-danger button-trans-danger btn-icon me-1 delete-curso-btn"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modal-deletar-curso"
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
                //Botão de selecionar todos os cursos pra exclusão padronizado igual ao de agendamento
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
    });

    function abrirModalDeletarCurso(id, nome) {
        $('#deletar-id').val(id);
        $('#deletar-nome').text(nome);

        // Verifica via AJAX se o curso tem turmas associadas
        $.get("<?= base_url('sys/cursos/verificarTurmas') ?>/" + id, function(resposta) {
            const temTurmas = resposta.temTurmas;

            if (temTurmas) {
                // Altera o corpo do modal com aviso
                $('#modal-deletar-curso .modal-body').html(`
                    <p class="text-break">
                        O curso <strong>${nome}</strong> possui turmas cadastradas. Ao deletar o curso, todas as turmas associadas também serão excluídas.<br>
                        Deseja excluir mesmo assim?
                    </p>
                `);

                // Altera os botões
                $('#modal-deletar-curso .modal-footer').html(`
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="btnConfirmarExclusaoCurso">Sim</button>
                `);

                $('#modal-deletar-curso').modal('show');

                // Ao clicar em "Sim", abre o modal de senha
                $(document).off('click', '#btnConfirmarExclusaoCurso').on('click', '#btnConfirmarExclusaoCurso', function() {
                    $('#senhaCursoId').val(id);
                    $('#modal-deletar-curso').modal('hide');
                    $('#modal-confirmar-senha-curso').modal('show');
                });

            } else {
                // Caso não tenha turmas, usa o modal simples
                $('#modal-deletar-curso .modal-body').html(`
                    <p class="text-break">Confirma a exclusão do curso <strong>${nome}</strong>?</p>
                `);

                $('#modal-deletar-curso .modal-footer').html(`
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Excluir</button>
                `);


                $('#deletar-id').val(id); // ← importante!

                $('#modal-deletar-curso').modal('show');
            }
        });
    }

    // Ao clicar no botão de deletar curso
    $(document).on('click', '.delete-curso-btn', function() {
        const id = $(this).data('id');
        const nome = $(this).data('nome');
        abrirModalDeletarCurso(id, nome);
    });

    //Função JS responsavel da exclusão de cursos
    $(document).ready(function() {
        const atualizarInterfaceDelete = () => {
            const marcados = $('.check-cursos:checked').length;
            const total = $('.check-cursos').length;
            $('#check-todos').prop('checked', total > 0 && total === marcados);
            if (marcados > 0) {
                $('.btn-delete-multi-target').removeClass('d-none');
                const texto = marcados === 1 ? '1 Curso selecionado' : `${marcados} Cursos selecionados`;
                $('.contador-selecionados').text(texto);
            } else {
                $('.btn-delete-multi-target').addClass('d-none');
            }
        };

        $(document).on('change', '#check-todos', function() {
            $('.check-cursos').prop('checked', this.checked);
            atualizarInterfaceDelete();
        });

        $(document).on('change', '.check-cursos', function() {
            atualizarInterfaceDelete();
        });

        $('#listagem-cursos').on('draw.dt', function() {
            $('#check-todos').prop('checked', false);
            $('#wrapper-delete-multi').addClass('d-none');
        });

        $('#modal_deletar_multiplos_cursos').on('show.bs.modal', function() {
            const container = $('#inputs-nomes');
            container.empty();
            $('.check-cursos:checked').each(function() {
                container.append(`<input type="hidden" name="ids[]" value="${this.value}">`);
            });
        });
    });
</script>
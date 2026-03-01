<?= $this->include('components/alunos/modal_cad_aluno', ['turmas' => $turmas]) ?>
<?= $this->include('components/alunos/modal_del_aluno') ?>
<?= $this->include('components/alunos/modal_edit_aluno', ['turmas' => $turmas]) ?>
<?= $this->include('components/alunos/modal_importar_aluno', ['turmas' => $turmas]) ?>
<?= $this->include('components/alunos/modal_deletar_multiplos_alunos') ?>

<div class="mb-3">
    <h2 class="card-title mb-0">Alunos</h2>
</div>
<div class="row">
    <div class="col-md-4 grid-margin stretch-card">
        <div class="card ">
            <div class="card-body">
                <div class="my-1">
                    <div class="mb-3">
                        <h5 class="card-title mb-0">Ações</h5>
                    </div>
                    <button type="button" class="btn btn-primary btn-fw" data-bs-toggle="modal"
                        data-bs-target="#modal-cadastrar-aluno">
                        <i class="mdi mdi-plus-circle btn-icon-prepend"></i>
                        Novo Aluno
                    </button>
                    <!-- Botão de confirma as exclusões do alunos padronizador igual ao de agendamento -->
                    <!-- <span data-bs-toggle="tooltip" title="Excluir alunos selecionados" data-bs-placement="bottom">
                        <button type="button" class="btn btn-danger d-none" id="btn-delete-multi" data-bs-toggle="modal"
                            data-bs-target="#modal_deletar_multiplos_alunos">
                            <i class="fa fa-trash btn-icon-prepend"></i>
                    </span> -->
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
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="filtro-turma">Turma</label>
                            <select id="filtro-turma" class="js-example-basic-single" style="width:100%">
                                <option value="">--</option>
                                <?php foreach ($turmas as $turma): ?>
                                    <option value="<?= esc($turma['nome']) ?>"><?= esc($turma['nome']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="filtro-status">Status</label>
                            <select id="filtro-status" class="js-example-basic-single" style="width:100%">
                                <option value="">--</option>
                                <option value="Ativo">Ativo</option>
                                <option value="Inativo">Inativo</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="filtro-telefone">Telefone</label>
                            <select id="filtro-telefone" class="js-example-basic-single" style="width:100%">
                                <option value="">--</option>
                                <option value="confirmado">Confirmado</option>
                                <option value="nao-confirmado">Não Confirmado</option>
                                <option value="sem-telefone">Sem Telefone</option>
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
                <?php if (!empty($alunos)): ?>
                    <table class="table" id="tabela-alunos" style="width:100%;">
                        <thead>
                            <tr>
                                <th style="width: 5%;"><!-- Botão de selecionar alunos pra exclusão --></th>
                                <th>Matrícula</th>
                                <th>Nome</th>
                                <th>Turma</th>
                                <th>Curso</th>
                                <th>Telefone</th>
                                <th>Status</th>
                                <th style="text-align: center; width: 10%; min-width: 100px;">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>Nenhum aluno encontrado no banco de dados.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
    .modal-dialog {
        margin-top: 10vh;
    }

    .form-control[disabled],
    .form-control[readonly] {
        background-color: #2a3038;
        color: #fff;
        opacity: 1;
    }

    .form-control {
        color: #fff !important;
    }

    select.form-control {
        cursor: pointer;
    }

    input#curso.form-control[disabled] {
        cursor: not-allowed;
    }

    .tooltip-on-top {
        z-index: 1060 !important;
    }
</style>

<script>
    const oldTelefones = <?= json_encode(old('telefone') ?? []) ?>;
    const oldCursoId = <?= json_encode(old('curso_id')) ?>;
    const oldTurmaId = <?= json_encode(old('turma_id')) ?>;
    const hasErrors = <?= session()->has('erros') ? 'true' : 'false' ?>;
    const turmasPorCurso = <?= json_encode($turmas) ?>;
    const dataTableLangUrl = "<?php echo base_url('assets/js/traducao-dataTable/pt_br.json'); ?>";
    const alunosData = <?= json_encode($alunos) ?>;
    const btnDeleteHtml = `
        <div class="btn-delete-multi-wrapper d-none btn-delete-multi-target" style="display: inline-block; margin-left: 15px; vertical-align: middle;">
            <span class="contador-selecionados text-muted me-2 fw-bold" style="font-size: 0.9em;"></span>
            <span data-bs-toggle="tooltip" title="Excluir itens selecionados" data-bs-placement="top">
            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modal_deletar_multiplos_alunos">
                <i class="fa fa-trash"></i>
            </button>
        </div>`;
    const atualizarInterfaceDelete = () => {
        const marcados = $('.check-aluno:checked').length;
        const total = $('.check-aluno').length;

        $('#check-todos').prop('checked', total > 0 && total === marcados);
        
        if (marcados > 0) {
            $('.btn-delete-multi-target').removeClass('d-none');
            const texto = marcados === 1 ? '1 aluno selecionado' : `${marcados} alunos selecionados`;
            $('.contador-selecionados').text(texto);
        } else {
            $('.btn-delete-multi-target').addClass('d-none');
        }
    };

    $(document).ready(function () {

        // Inicializa o plugin Select2
        $('.js-example-basic-single').select2();

        $('#curso_id').on('change', function () {
            const cursoId = this.value;
            const $turma = $('#turma_id');

            $turma
                .prop('disabled', !cursoId)
                .html('<option value="">Selecione uma turma</option>');

            if (!cursoId) return;

            turmasPorCurso
                .filter(t => t.curso_id == cursoId)
                .forEach(t => {
                    $turma.append(`<option value="${t.id}">${t.nome}</option>`);
                });

            $turma.trigger('change');
        });

        $('#edit_curso_id').on('change', function () {
            const cursoId = this.value;
            const $turma = $('#edit_turma_id');

            $turma
                .prop('disabled', !cursoId)
                .html('<option value="">Selecione uma turma</option>');

            if (!cursoId) return;

            turmasPorCurso
                .filter(t => t.curso_id == cursoId)
                .forEach(t => {
                    $turma.append(
                        `<option value="${t.id}">${t.nome}</option>`
                    );
                });
        });

        $('#modal-cadastrar-aluno').on('shown.bs.modal', function () {

            if (!hasErrors) return;
            if (oldCursoId) {
                $('#curso_id').val(oldCursoId).trigger('change');
            }
            if (oldTurmaId) {
                setTimeout(() => {
                    $('#turma_id').val(oldTurmaId).trigger('change');
                }, 50);
            }
            if (oldTelefones.length) {
                setupRepeater('#telefone-repeater-container', 'telefone', oldTelefones);
            }
        });

        const cursosSet = new Set();
        alunosData.forEach(aluno => {
            if (aluno.curso_nome) cursosSet.add(aluno.curso_nome);
        });

        const $cursoSelect = $('#filtro-curso');
        cursosSet.forEach(curso => {
            $cursoSelect.append(`<option value="${curso}">${curso}</option>`); // Adiciona cada curso ao select
        });

        // Objeto que contém os templates e a lógica para repetidores
        const repeaters = {
            telefone: {
                template: (value = '') => `
                    <div class="telefone-repeater-item d-flex align-items-center mb-2">
                        <div class="input-group me-2">
                            <input type="text" class="form-control form-control-sm telefone-input" name="telefone[]" placeholder="Ex: (99) 99999-9090" value="${value}" required>
                        </div>
                        <button type="button" class="btn btn-inverse-danger btn-sm icon-btn remove-telefone me-2" data-bs-toggle="tooltip" title="Remover Telefone">
                            <i class="mdi mdi-delete"></i>
                        </button>
                        <button type="button" class="btn btn-inverse-info btn-sm icon-btn add-telefone" data-bs-toggle="tooltip" title="Adicionar Telefone">
                            <i class="mdi mdi-plus"></i>
                        </button>
                    </div>`,
                placeholder: 'É necessário ter pelo menos um telefone.'
            }
        };

        const initTooltips = () => {
            $('[data-bs-toggle="tooltip"]').each(function () {
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

        const setupRepeater = (containerId, type, values = []) => {
            const container = $(containerId);
            container.empty();
            if (values.length > 0) {
                values.forEach(value => container.append(repeaters[type].template(value)));
            } else {
                container.append(repeaters[type].template());
            }
            updateRepeaterButtons(container);
        };

        const updateRepeaterButtons = container => {
            // Verifica a contagem
            const isSingleItem = container.find('.telefone-repeater-item').length <= 1;
            container.find('.remove-telefone').toggle(!isSingleItem);
        };

        const handleAddButtonClick = function () {
            const type = 'telefone';
            const container = $(this).closest('.card-body').find(`[id$="-repeater-container"]`);
            container.append(repeaters[type].template());
            updateRepeaterButtons(container);
            initTooltips();
        };

        const handleRemoveButtonClick = function () {
            const type = 'telefone';
            const container = $(this).closest('.card-body').find(`[id$="-repeater-container"]`);

            if (container.find(`.${type}-repeater-item`).length > 1) {
                const tooltipInstance = bootstrap.Tooltip.getInstance(this);
                if (tooltipInstance) {
                    tooltipInstance.dispose();
                }
                $(this).closest(`.${type}-repeater-item`).remove();
                updateRepeaterButtons(container);
                initTooltips();
            } else {
                alert(repeaters[type].placeholder);
            }
        };

        const handleTurmaChange = function () {
            const cursoNome = $(this).find('option:selected').data('curso-nome');
            $(this).closest('.modal-body').find('input[name="curso"]').val(cursoNome || 'Selecione uma turma');
        };

        const handleDeletarModalShow = function (event) {
            const button = $(event.relatedTarget);
            const matricula = button.data('matricula');
            const nome = button.data('nome');
            const modal = $(this);
            modal.find('.modal-body p').html(`Tem certeza de que deseja deletar o aluno <strong>${nome}</strong> (Matrícula: ${matricula})?`);
            modal.find('#delete-matricula').val(matricula);
        };

        $('#modal-cadastrar-aluno').on('show.bs.modal', function () {
            $(this).find('form')[0].reset();
            $('#curso').val('Selecione uma turma');
            setupRepeater('#telefone-repeater-container', 'telefone');
            initTooltips();
        });

        $('#modal-editar-aluno').on('show.bs.modal', function (event) {
            const matricula = $(event.relatedTarget).data('matricula');
            const modal = $(this);
            const url = `<?= base_url('sys/alunos/edit') ?>/${matricula}`;

            fetch(url)
                .then(response => response.json())
                .then(aluno => {

                    modal.find('#matricula_original').val(aluno.matricula);
                    modal.find('#edit_matricula_view').val(aluno.matricula);
                    modal.find('#edit_nome').val(aluno.nome);
                    modal.find('#edit_status').val(aluno.status);

                    modal.find('#edit_curso_id')
                        .val(aluno.curso_id)
                        .trigger('change');

                    modal.find('#edit_turma_id')
                        .val(aluno.turma_id);

                    setupRepeater(
                        '#edit-telefone-repeater-container',
                        'telefone',
                        aluno.telefones
                    );

                    initTooltips();
                })
                .catch(error =>
                    console.error('Erro ao buscar dados do aluno:', error)
                );
        });

        $(document).on('click', '.add-telefone', handleAddButtonClick);
        $(document).on('click', '.remove-telefone', handleRemoveButtonClick);
        $(document).on('change', '#turma_id, #edit_turma_id', handleTurmaChange);
        $('#deletarModal').on('show.bs.modal', handleDeletarModalShow);

        // Inicialização do DataTables
        const table = $('#tabela-alunos').DataTable({
            data: alunosData,
            columns: [{
                //Botão de exclusão individual padronizador igual ao de agendamento
                data: 'matricula',
                render: data =>
                    `<div class="form-check form-check-flat form-check-primary" style="margin: 0;">
                    <label class="form-check-label">
                    <input type="checkbox" class="form-check-input check-aluno" value="${data}">
                    <i class="input-helper"></i>
                    </label>
                    </div>`
            },
            {
                data: 'matricula'
            },
            {
                data: 'nome'
            },
            {
                data: 'turma_nome'
            },
            {
                data: 'curso_nome'
            },
            { // Coluna Telefone (índice 4)
                data: 'telefones',
                render: function (data, type, row) {
                    if (!Array.isArray(data) || data.length === 0) {
                        return `<div class="text-danger" data-bs-toggle="tooltip" data-placement="top" title="Este aluno não possui nenhum número cadastrado">
                                    <i class="mdi mdi-alert-circle"></i> <small>Sem número</small>
                                </div>`;
                    }
                    return data.map(t => {
                        const isConfirmado = t.status == 1;
                        const icon = isConfirmado 
                            ? '<i class="mdi mdi-check-circle text-success" data-bs-toggle="tooltip" data-placement="top" title="Número Confirmado"></i>' 
                            : '<i class="mdi mdi-clock text-warning" data-bs-toggle="tooltip" data-placement="top" title="Aguardando Confirmação"></i>';
                        
                        return `<div class="d-flex align-items-center gap-1 mb-1">
                                    ${icon} <small class="font-weight-bold">${t.telefone}</small>
                                </div>`;
                    }).join('');
                }
            },
            { // Coluna Status (índice 5)
                data: 'status',
                render: function (data, type, row) {
                    return data == 1 ? 'Ativo' : 'Inativo';
                }
            },
            { // Coluna Ações (índice 6)
                data: null,
                render: function (data, type, row) {
                    return `
                            <div class="d-flex align-center justify-content-center gap-2">
                                <span data-bs-toggle="tooltip" data-placement="top" title="Editar">
                                    <button
                                        type="button"
                                        class="justify-content-center align-items-center d-flex btn btn-inverse-success btn-icon me-1 edit-aluno-btn"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modal-editar-aluno"
                                        data-matricula="${data.matricula}">
                                        <i class="mdi mdi-pencil"></i>
                                    </button>
                                </span>
                                <span data-bs-toggle="tooltip" data-placement="top" title="Excluir">
                                    <button
                                        type="button"
                                        class="justify-content-center align-items-center d-flex btn btn-inverse-danger btn-icon"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deletarModal"
                                        data-matricula="${data.matricula}"
                                        data-nome="${data.nome}">
                                        <i class="mdi mdi-delete"></i>
                                    </button>
                                </span>
                            </div>
                        `;
                }
            }
            ],
            //Botão de selecionar todos os alunos pra exclusão padronizador igual ao de agendamento
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
            initComplete: function (settings, json) {
                $('.dataTables_length').append(btnDeleteHtml);
                $('.dataTables_info').append(btnDeleteHtml);
                initTooltips();
            },
            drawCallback: function () {
                initTooltips();
                $('#check-todos').prop('checked', false);
                $('.btn-delete-multi-target').addClass('d-none');
            }
        });

        // Filtro de DataTable
        // Índices de coluna ajustados: Status é agora o índice 5.
        $.fn.dataTable.ext.search.push(function (settings, searchData, index, rowData) {
            const filtroCurso = $('#filtro-curso').val();
            const filtroTurma = $('#filtro-turma').val();
            const filtroStatus = $('#filtro-status').val();
            const filtroTelefone = $('#filtro-telefone').val();

            const rowCurso = searchData[4]; 
            const rowTurma = searchData[3]; 
            const rowStatus = searchData[6]; 
            const listaTelefones = rowData.telefones || [];

            // Lógica Filtro Telefone
            let passTelefone = true;
            if (filtroTelefone === 'sem-telefone') {
                passTelefone = (listaTelefones.length === 0);
            } 
            else if (filtroTelefone === 'confirmado') {
                // Mostra o aluno se ele tiver PELO MENOS UM número confirmado
                passTelefone = listaTelefones.some(t => t.status == 1);
            } 
            else if (filtroTelefone === 'nao-confirmado') {
                // Mostra o aluno se ele tiver PELO MENOS UM número não confirmado
                passTelefone = listaTelefones.some(t => t.status == 0);
            }

            // Lógica dos outros filtros
            const passCurso = !filtroCurso || rowCurso === filtroCurso;
            const passTurma = !filtroTurma || rowTurma === filtroTurma;
            const passStatus = !filtroStatus || rowStatus === filtroStatus;

            return passCurso && passTurma && passStatus && passTelefone;
        });

        $('#filtro-curso').on('change', function() {
            const cursoNome = $(this).val();
            const $selectTurma = $('#filtro-turma');
            const table = $('#tabela-alunos').DataTable();

            $selectTurma.html('<option value="">--</option>');
            if (cursoNome) {
                const turmasFiltradas = turmasPorCurso.filter(t => t.curso_nome === cursoNome);
                turmasFiltradas.forEach(t => {
                    $selectTurma.append(`<option value="${t.nome}">${t.nome}</option>`);
                });
            } else {
                turmasPorCurso.forEach(t => {
                    $selectTurma.append(`<option value="${t.nome}">${t.nome}</option>`);
                });
            }
            $selectTurma.val('').trigger('change.select2');
        
            localStorage.setItem('filtroCurso', cursoNome);
            table.draw();
        });

        $('#filtro-curso, #filtro-turma, #filtro-status, #filtro-telefone').on('change', function () {
            // localStorage.setItem('filtroCurso', $('#filtro-curso').val());
            localStorage.setItem('filtroTurma', $('#filtro-turma').val());
            localStorage.setItem('filtroStatus', $('#filtro-status').val());
            localStorage.setItem('filtroTelefone', $('#filtro-telefone').val());
            const table = $('#tabela-alunos').DataTable();
            table.draw();
        });

        // Recuperar e aplicar filtros
        const curso = localStorage.getItem('filtroCurso');
        const turma = localStorage.getItem('filtroTurma');
        const status = localStorage.getItem('filtroStatus');

        if (curso) $('#filtro-curso').val(curso).trigger('change');
        if (turma) $('#filtro-turma').val(turma).trigger('change');
        if (status) $('#filtro-status').val(status).trigger('change');

        // Redesenha a tabela já com os filtros aplicados
        table.draw();

        // Lógica de notificação (sem alteração)
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

        <?php if (session()->has('erros')): ?>
            const modalCadastrarAluno = new bootstrap.Modal(
                document.getElementById('modal-cadastrar-aluno')
            );
            modalCadastrarAluno.show();
        <?php endif; ?>

        // Máscara de Telefone
        $(document).on('input', '.telefone-input', function () {
            let telefone = $(this).val().replace(/\D/g, '').slice(0, 11);

            if (telefone.length > 2)
                telefone = '(' + telefone.slice(0, 2) + ') ' + telefone.slice(2);

            if (telefone.length > 10)
                telefone = telefone.slice(0, 10) + '-' + telefone.slice(10);

            $(this).val(telefone);
        });

    });

    //Função do JavaScript responsavel pela exclusão de alunos
    $(document).ready(function () {

        $(document).on('change', '#check-todos', function () {
            const marcado = this.checked;

            $('.check-aluno').prop('checked', marcado);

            $('#btn-delete-multi').toggleClass('d-none', !marcado);
            $('.check-aluno').prop('checked', this.checked);
            atualizarInterfaceDelete();
        });

        $(document).on('change', '.check-aluno', function () {
            const total = $('.check-aluno').length;
            const marcados = $('.check-aluno:checked').length;

            $('#check-todos').prop('checked', total > 0 && total === marcados);
            $('#btn-delete-multi').toggleClass('d-none', marcados === 0);
            atualizarInterfaceDelete();
        });

        $('#modal_deletar_multiplos_alunos').on('show.bs.modal', function () {
            const container = $('#inputs-matriculas');
            container.empty();

            $('.check-aluno:checked').each(function () {
                container.append(
                    `<input type="hidden" name="matricula[]" value="${this.value}">`
                );
            });
        });

        $('#tabela-alunos').on('draw.dt', function () {
            $('#check-todos').prop('checked', false);
            $('#btn-delete-multi').addClass('d-none');
        });
    });

    $('#editarAlunoForm').on('submit', function () {
        $('#edit_matricula_hidden').val(
            $('#edit_matricula_view').val()
        );
    });
</script>
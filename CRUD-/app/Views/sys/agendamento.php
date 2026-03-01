<?php echo view('components/agendamentos/modal_cadastrar_agendamento', ['turmas' => $turmas, 'alunos' => $alunos]) ?>
<?php echo view('components/agendamentos/modal_editar_agendamento', ["turmas" => $turmas]); ?>
<?php echo view('components/agendamentos/modal_deletar_agendamento'); ?>
<?php echo view('components/agendamentos/modal_deletar_agendamentos'); ?>
<?php echo view('components/agendamentos/modal_reenviar_agendamento'); ?>


<div class="mb-3">
    <h2 class="card-title mb-0">Agendamento de Refeição</h2>
</div>
<div class="row">
    <div class="col-12 col-xl-3 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    <h5 class="card-title mb-0">Ações</h5>
                </div>
                <div class="my-4">
                    <span data-bs-toggle="tooltip" title="Cadastrar Agendamento">
                        <button type="button" class="btn btn-primary btn-fw" data-bs-toggle="modal"
                            data-bs-target="#modal-cadastrar-agendamento">
                            <i class="fa fa-plus-circle btn-icon-prepend"></i>
                            <span class="d-none d-md-inline ms-1">Novo Agendamento</span>
                        </button>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-xl-9 grid-margin stretch-card">
        <div class="card ">
            <div class="card-body">
                <div class="mb-3">
                    <h5 class="card-title">Filtros</h5>
                    <div class="form-group row align-items-end">
                        <div class="col-md-2">
                            <label>Turma</label>
                            <select id="filtro-turma" class="js-example-basic-single" style="width:100%">
                                <option value="">--</option>
                                <?php foreach ($turmas as $turma): ?>
                                    <option value="<?= esc($turma['id']) ?>"><?= esc($turma['nome_turma']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label>Status</label>
                            <select id="filtro-status" class="js-example-basic-single" style="width:100%">
                                <option value="">--</option>
                                <option value="Disponível">Disponível</option>
                                <option value="Confirmada">Confirmada</option>
                                <option value="Retirada">Retirada</option>
                                <option value="Cancelada">Cancelada</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label>Motivo</label>
                            <select id="filtro-motivo" class="js-example-basic-single" style="width:100%">
                                <option value="">--</option>
                                <option value="Contraturno">Contraturno</option>
                                <option value="Estágio">Estágio</option>
                                <option value="Treino">Treino</option>
                                <option value="Projeto">Projeto</option>
                                <option value="Visita Técnica">Visita Técnica</option>
                            </select>
                        </div>
                        <div class="col-md-5">
                            <label for="">Período:</label>
                            <div id="datepicker-popup" class="input-group input-daterange d-flex align-items-center">
                                <input type="text" class="form-control" style="background-color: black;">
                                <div class="input-group-addon mx-4"> até </div>
                                <input type="text" class="form-control" style="background-color: black;">
                            </div>
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
                <div class="table-responsive">
                    <?php if (isset($agendamentos) && !empty($agendamentos)): ?>
                        <table class="table mb-4" id="listagem-agendamentos" style="width:100%;">
                            <thead>
                                <tr>
                                    <th style="width: 5%;">
                                        <div class="form-check form-check-flat form-check-primary" style="margin: 0;">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" id="selectAll">
                                                <i class="input-helper"></i>
                                            </label>
                                        </div>
                                    </th>
                                    <th><strong>Aluno(a)<i class="mdi mdi-chevron-down"></i></strong></th>
                                    <th><strong>Turma<i class="mdi mdi-chevron-down"></i></strong></th>
                                    <th><strong>Data do Agendamento<i class="mdi mdi-chevron-down"></i></strong></th>
                                    <th><strong>Status<i class="mdi mdi-chevron-down"></i></strong></th>
                                    <th><strong>Motivo<i class="mdi mdi-chevron-down"></i></strong></th>
                                    <th style="text-align: center; width: 10%; min-width: 100px;"><strong>Ações</strong>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p>Nenhum agendamento encontrado no banco de dados.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .tooltip-on-top {
        z-index: 9999 !important;
    }

    .tooltip-on-top .tooltip-inner {
        background-color: #333;
        color: #fff;
        font-size: 13px;
        padding: 8px 10px;
        border-radius: 6px;
        text-align: center;
        max-width: 220px;
    }

    .tooltip-on-top .tooltip-arrow::before {
        border-top-color: #333 !important;
    }

    .datepicker table tr td.today.active::before {
        background-color: #28a745 !important;
        color: #fff !important;
    }

    table.dataTable tbody td.dt-checkboxes-cell {
        vertical-align: middle;
        text-align: center;
    }

    #listagem-agendamentos tbody td:nth-child(4) {
        padding-left: 50px;
    }

    .form-select.no-arrow {
        --bs-form-select-bg-img: none;
    }
</style>

<script>
    const dataTableLangUrl = "<?= base_url('assets/js/traducao-dataTable/pt_br.json'); ?>";
    const agendamentosData = <?= json_encode($agendamentos ?? []) ?>;
    const getAlunosByTurmaUrl = '<?= base_url('sys/agendamento/admin/getAlunosByTurma') ?>';

    let flatpickrEditInstance = null;
    let tabela;

    function initTooltips() {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            // Limpa instâncias antigas para evitar bugs
            const oldTooltip = bootstrap.Tooltip.getInstance(tooltipTriggerEl);
            if (oldTooltip) {
                oldTooltip.dispose();
            }
            // Cria a nova instância
            return new bootstrap.Tooltip(tooltipTriggerEl, {
                container: 'body' // Garante que o tooltip apareça sobre outros elementos
            });
        });
    }

    function restaurarFiltros() {
        const salvo = localStorage.getItem('filtrosAgendamentos');
        if (!salvo) return;

        const filtros = JSON.parse(salvo);

        $('#filtro-turma').val(filtros.turma);
        $('#filtro-status').val(filtros.status);
        $('#filtro-motivo').val(filtros.motivo);
        $('#datepicker-popup input:first').val(filtros.dataInicio);
        $('#datepicker-popup input:last').val(filtros.dataFim);
    }

    function alternarBotaoExcluir() {
        const quantidade = $('.checkbox-item:checked').length;
        if (quantidade > 0) {
            $('.btn-delete-multi').fadeIn();
        } else {
            $('.btn-delete-multi').fadeOut();
        }
    }

    $(document).ready(function () {
        restaurarFiltros();

        //ESSA PARTE APENAS RENDERIZA O MODELO DO CORONA
        $('.js-example-basic-single').select2();
        $('.js-example-basic-multiple').select2();


        $('#modal-cadastrar-agendamento').on('shown.bs.modal', function () {
            $(this).find('.js-example-basic-single').select2({
                dropdownParent: $('#modal-cadastrar-agendamento')
            });
            $(this).find('.js-example-basic-multiple').select2({
                dropdownParent: $('#modal-cadastrar-agendamento')
            });

            const $cal = $('#inline-datepicker');
            $cal.datepicker('destroy'); // garante uma instância limpa
            $cal.datepicker({
                format: 'yyyy-mm-dd',
                todayHighlight: true,
                multidate: true,
                language: 'pt-BR',
                startDate: new Date()
            }).on('changeDate', function (e) {
                const datas = e.dates.map(date => {
                    const y = date.getFullYear();
                    const m = String(date.getMonth() + 1).padStart(2, '0');
                    const d = String(date.getDate()).padStart(2, '0');
                    return `${y}-${m}-${d}`;
                });
                $('#datas-hidden').val(datas.join(','));
            });
        });
        //FIM DA PARTE DO CORONA

        const btnDeleteHtml = `
            <div class="btn-delete-multi-wrapper d-none btn-delete-multi-target" style="display: inline-block; margin-left: 15px; vertical-align: middle;">
                <span class="contador-selecionados text-muted me-2 fw-bold" style="font-size: 0.9em;"></span>
                <span data-bs-toggle="tooltip" title="Excluir itens selecionados" data-bs-placement="top">
                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modal-deletar-agendamentos">
                    <i class="fa fa-trash"></i>
                </button>
            </div>`;

        const atualizarInterfaceDelete = () => {
            const marcados = $('.checkbox-item:checked').length;
            const total = $('.checkbox-item').length;

            $('#selectAll').prop('checked', total > 0 && total === marcados);

            if (marcados > 0) {
                $('.btn-delete-multi-target').removeClass('d-none');
                const texto = marcados === 1 ? '1 agendamento selecionado' : `${marcados} agendamentos selecionados`;
                $('.contador-selecionados').text(texto);
            } else {
                $('.btn-delete-multi-target').addClass('d-none');
            }
        };


        if (agendamentosData && agendamentosData.length > 0) {
            const tabela = $('#listagem-agendamentos').DataTable({
                data: agendamentosData,
                order: [[3, 'asc'], [1, 'asc']],
                columnDefs: [
                    { orderable: false, targets: [0, 6] }
                ],
                columns: [
                    {
                        data: 'id',
                        render: function (data, type, row) {
                            return `
                                <div class="form-check form-check-flat form-check-primary" style="margin: 0;">
                                    <label class="form-check-label">
                                        <input type="checkbox" class="form-check-input checkbox-item" name="selecionados[]" value="${data}">
                                        <i class="input-helper"></i>
                                    </label>
                                </div>
                            `;
                        }
                    },
                    {
                        data: 'turma_aluno',
                        render: function (data, type, row) {
                            const alunosJson = JSON.stringify(row.alunos).replace(/'/g, "&apos;");
                            const turmasAlunosJson = JSON.stringify(row.alunos_por_turma).replace(/'/g, "&apos;");

                            if (row.tipo === 'turma') {
                                return `<a href="#" 
                                    class="ver-alunos-link" 
                                    data-bs-toggle="tooltip" 
                                    title="Ver Alunos" 
                                    data-alunos='${alunosJson}'><u>${data}</u></a>`;

                            } else if (row.tipo === 'multi_turma') {
                                return `<a href="#" 
                                    class="ver-alunos-link" 
                                    data-bs-toggle="tooltip" 
                                    title="Ver Turmas e Alunos" 
                                    data-turmas-alunos='${turmasAlunosJson}'><u>${data}</u></a>`;
                            }
                            return data;
                        }
                    }, {
                        data: 'turma'
                    }, {
                        data: 'data'
                    }, {
                        data: 'status'
                    }, {
                        data: 'motivo'
                    }, {
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function (data, type, row) {
                            const deleteInfoAttr = JSON.stringify(row.delete_info);
                            const editInfoAttr = JSON.stringify(row);

                            return `
                            <div class="d-flex align-center justify-content-center gap-2">
                                <span data-bs-toggle="tooltip" title="Reenviar QRCode">
                                    <button type="button" class="btn btn-inverse-info btn-icon me-1 btn-reenviar-agendamento d-flex align-items-center justify-content-center"
                                        data-bs-toggle="modal" data-bs-target="#modal-reenviar-agendamento"
                                        data-id="${row.id}">
                                        <i class="mdi mdi-qrcode-scan"></i>
                                    </button>
                                </span>
                                <span data-bs-toggle="tooltip" title="Editar agendamento">
                                    <button type="button" class="btn btn-inverse-success btn-icon me-1 btn-editar-agendamento d-flex align-items-center justify-content-center"
                                        data-bs-toggle="modal" data-bs-target="#modal-editar-agendamento"
                                        data-edit-info='${editInfoAttr}'>
                                        <i class="fa fa-edit"></i>
                                    </button>
                                </span>
                                <span data-bs-toggle="tooltip" title="Excluir agendamento">
                                    <button type="button" class="btn btn-inverse-danger btn-icon me-1 btn-excluir-agendamento d-flex align-items-center justify-content-center"
                                        data-bs-toggle="modal" data-bs-target="#modal-deletar-agendamento"
                                        data-nome="${row.turma_aluno}" data-delete-info='${deleteInfoAttr}'>
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </span>
                            </div>
                        `;
                        }
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
                    $('#selectAll').prop('checked', false);
                    $('.btn-delete-multi-target').addClass('d-none');
                }
            });

            // Função para converter data no formato DMY para objeto Date
            function parseDateDMY(str) {
                if (typeof str !== 'string' || !str.trim()) return null;

                const s = str.trim();

                // Padrões de formato possíveis
                const isoPattern = /^(\d{4})-(\d{2})-(\d{2})$/;  // YYYY-MM-DD
                const brPattern = /^(\d{2})\/(\d{2})\/(\d{4})$/; // DD/MM/YYYY

                let dia, mes, ano;

                if (isoPattern.test(s)) {
                    [, ano, mes, dia] = s.match(isoPattern).map(Number);
                } else if (brPattern.test(s)) {
                    [, dia, mes, ano] = s.match(brPattern).map(Number);
                } else {
                    return null; // formato não reconhecido
                }

                const data = new Date(ano, mes - 1, dia);

                // Garante que a data é válida (ex: 31/02 -> inválida)
                return isNaN(data.getTime()) ? null : data;
            }

            if ($('#datepicker-popup').length) {
                $('#datepicker-popup').datepicker('destroy'); // remove a configuração antiga
                $('#datepicker-popup').datepicker({
                    format: 'dd/mm/yyyy',
                    autoclose: true,
                    todayHighlight: true,
                    language: 'pt-BR'
                });
            }

            function filtrarTabela() {
                const turmaSelecionada = $('#filtro-turma').val()?.trim();
                const statusSelecionado = $('#filtro-status').val()?.toLowerCase().trim();
                const motivoSelecionado = $('#filtro-motivo').val()?.toLowerCase().trim();

                const dataInicioStr = $('#datepicker-popup input:first').val()?.trim();
                const dataFimStr = $('#datepicker-popup input:last').val()?.trim();

                const dataInicio = parseDateDMY(dataInicioStr);
                const dataFim = parseDateDMY(dataFimStr);

                const filtrados = agendamentosData.filter(item => {

                    const matchTurma = !turmaSelecionada || item.turma?.includes($('#filtro-turma option:selected').text().trim());
                    const matchStatus = !statusSelecionado || item.status?.toLowerCase().trim() === statusSelecionado;
                    const matchMotivo = !motivoSelecionado || item.motivo?.toLowerCase().trim() === motivoSelecionado;

                    let matchData = true;
                    if (dataInicio || dataFim) {
                        const itemData = parseDateDMY(item.data);
                        if (!itemData) return false;
                        if (dataInicio && itemData < dataInicio) matchData = false;
                        if (dataFim && itemData > dataFim) matchData = false;
                    }

                    return matchTurma && matchStatus && matchMotivo && matchData;
                });

                tabela.clear().rows.add(filtrados).draw();
            }

            function salvarFiltros() {
                const filtros = {
                    turma: $('#filtro-turma').val(),
                    status: $('#filtro-status').val(),
                    motivo: $('#filtro-motivo').val(),
                    dataInicio: $('#datepicker-popup input:first').val(),
                    dataFim: $('#datepicker-popup input:last').val()
                };

                localStorage.setItem('filtrosAgendamentos', JSON.stringify(filtros));
            }

            $('#filtro-turma').on('change', function () {
                salvarFiltros();
                filtrarTabela();
            });

            $('#filtro-status').on('change', function () {
                salvarFiltros();
                filtrarTabela();
            });

            $('#filtro-motivo').on('change', function () {
                salvarFiltros();
                filtrarTabela();
            });

            $('#datepicker-popup').on('changeDate', function () {
                salvarFiltros();
                filtrarTabela();
            });

            $('#datepicker-popup input').on('keyup change', function () {
                salvarFiltros();
                filtrarTabela();
            });

            $(document).on('change', '#selectAll', function () {
                const estaMarcado = $(this).is(':checked');
                $('.checkbox-item').prop('checked', estaMarcado);
                alternarBotaoExcluir();
                atualizarInterfaceDelete();
            });

            $('#listagem-agendamentos tbody').on('change', '.checkbox-item', function () {
                alternarBotaoExcluir();
                if (!$(this).is(':checked')) {
                    $('#selectAll').prop('checked', false);
                }
                const totalCheckboxes = $('.checkbox-item').length;
                const totalMarcados = $('.checkbox-item:checked').length;
                if (totalCheckboxes === totalMarcados && totalCheckboxes > 0) {
                    $('#selectAll').prop('checked', true);
                }
                atualizarInterfaceDelete();
            });

            // Função para deletar multiplos agendamentos
            $('#formDeletarMulti').on('submit', function (e) {
                e.preventDefault();
                const form = $(this);
                const url = form.attr('action');
                let ids = [];
                $('.checkbox-item:checked').each(function () {
                    ids.push($(this).val());
                });

                if (ids.length === 0) {
                    alert('Nenhum item selecionado.');
                    return;
                }

                $.ajax({
                    type: 'POST',
                    url: url,
                    data: { selecionados: ids },
                    success: function (response) {
                        if (response.trim() === "ok" || response.includes('sucesso')) {
                            $.toast({
                                heading: 'Sucesso',
                                text: 'Agendamentos excluídos com sucesso!',
                                icon: 'success',
                                loaderBg: '#f96868',
                                position: 'top-center'
                            });

                            $('#modal-deletar-agendamentos').modal('hide');
                            setTimeout(() => window.location.reload(), 100);
                        } else {
                            alert(response);
                            $('#modal-deletar-agendamentos').modal('hide');
                        }
                    },
                    error: function () {
                        alert('Erro ao processar a solicitação.');
                    }
                });
            });
        }

        filtrarTabela();

        // Modal de EXCLUSÃO de Agendamento
        $('#listagem-agendamentos').on('click', '.btn-excluir-agendamento', function () {
            const button = $(this);
            const nome = button.data('nome');
            const deleteInfo = button.data('delete-info');
            const modal = $('#modal-deletar-agendamento');
            modal.find('#deleteAgendamentoNome').text(nome);
            modal.find('#deleteAgendamentoInfo').val(JSON.stringify(deleteInfo));
        });

        // Modal de EDIÇÃO de Agendamento
        $('#listagem-agendamentos').on('click', '.btn-editar-agendamento', function () {
            const data = $(this).data('edit-info');
            const deleteInfo = data.delete_info;
            const statusMap = { 'Disponível': '0', 'Confirmada': '1', 'Retirada': '2', 'Cancelada': '3' };
            const motivoMap = { 'Contraturno': '0', 'Estágio': '1', 'Treino': '2', 'Projeto': '3', 'Visita Técnica': '4' };

            $('#edit_original_aluno_ids').val(deleteInfo.aluno_ids.join(','));
            $('#edit_original_datas').val(deleteInfo.datas.join(','));
            $('#edit_original_motivo').val(deleteInfo.motivo);
            const turmaSelecionada = (data.turmas && data.turmas.length > 0) ? data.turmas[0] : "";

            $('#edit_turma_id').val(turmaSelecionada).trigger('change');

            // --- CARREGAR ALUNO DA TURMA ---
            const alunosSelect = $('#edit_alunos_id');
            alunosSelect.empty().prop('disabled', true);
            if (turmaSelecionada) {

                fetch(`${getAlunosByTurmaUrl}?turmas=${turmaSelecionada}`)
                    .then(res => {
                        if (!res.ok) throw new Error(`Erro HTTP: ${res.status}`);
                        return res.json();
                    })
                    .then(alunos => {
                        alunos.forEach(aluno => {
                            const matriculaString = String(aluno.matricula);
                            const idsSalvos = deleteInfo.aluno_ids.map(id => String(id));
                            const selected = idsSalvos.includes(matriculaString);
                            const option = new Option(aluno.nome, aluno.matricula, selected, selected);
                            alunosSelect.append(option);
                        });

                        alunosSelect.prop('disabled', false).trigger('change');
                    })
                    .catch(err => {
                        alunosSelect.prop('disabled', false);
                        console.error('Erro ao carregar alunos:', err);
                    });
            }
            $('#edit_motivo').val(motivoMap[data.motivo] || deleteInfo.motivo);
            $('#edit_status').val(statusMap[data.status]);
            const dataMaisAntiga = deleteInfo.datas[0];
            $('#modal-editar-agendamento').data('datas-para-selecionar', deleteInfo.datas);
            $('#modal-editar-agendamento').data('min-date-para-editar', dataMaisAntiga);
            $('#edit_datas-hidden').val(deleteInfo.datas.join(','));
        });

        // Inicializa o datepicker do modal de edição ANTES de abrir a modal
        const $editCal = $('#edit-inline-datepicker');

        $editCal.datepicker({
            format: 'yyyy-mm-dd',
            todayHighlight: true,
            multidate: false,
            language: 'pt-BR',
            autoclose: true
        }).on('changeDate', function (e) {

            const dateObj = e.date;
            if (!dateObj) return;

            const y = dateObj.getFullYear();
            const m = String(dateObj.getMonth() + 1).padStart(2, '0');
            const d = String(dateObj.getDate()).padStart(2, '0');

            $('#edit_datas-hidden').val(`${y}-${m}-${d}`);
        });

        // Função pra puxar as datas selecionadas ao abrir o modal com o clique do botão <--> ISSO É IMPORTANTE PARA NÃO DAR O DELAY NA ABERTURA DA MODAL
        $(document).on('click', '.btn-editar-agendamento', function (e) {
            // pega o JSON bruto do atributo
            const raw = $(this).attr('data-edit-info');
            let editInfo = {};
            try {
                editInfo = raw ? JSON.parse(raw) : {};
            } catch (err) {
                console.error('Erro parseando data-edit-info:', err, raw);
                editInfo = $(this).data('edit-info') || {};
            }
            const deleteInfo = editInfo.delete_info || editInfo;

            const datasParaSelecionar = Array.isArray(deleteInfo.datas) ? deleteInfo.datas : (deleteInfo.datas ? String(deleteInfo.datas).split(',') : []);

            const hoje = new Date();
            hoje.setHours(0, 0, 0, 0);

            $editCal.datepicker('setStartDate', hoje);

            // limpa seleção anterior imediatamente (evita piscar data antiga)
            $editCal.datepicker('clearDates');

            if (datasParaSelecionar.length > 0) {
                const unica = datasParaSelecionar[0];
                const partes = unica.split('-');
                const data = new Date(partes[0], partes[1] - 1, partes[2]);

                // seta a nova data (antes da modal abrir)
                $editCal.datepicker('setDate', data);
                $('#edit_datas-hidden').val(unica);
            } else {
                $('#edit_datas-hidden').val('');
            }
        });

        const getAlunosByTurmaUrl = "<?= base_url('sys/agendamento/admin/getAlunosByTurma') ?>";

        // --- EDIÇÃO ---
        $('#edit_turma_id').on('change', function () {
            const turmaSelecionada = $(this).val(); // string
            const alunosSelect = $('#edit_alunos_id');

            alunosSelect.prop('disabled', true).empty();

            if (turmaSelecionada && turmaSelecionada.length > 0) {
                fetch(`${getAlunosByTurmaUrl}?turmas=${turmaSelecionada}`)
                    .then(res => {
                        if (!res.ok) throw new Error(`HTTP error! status: ${res.status}`);
                        return res.json();
                    })
                    .then(alunos => {
                        alunos.forEach(aluno => {
                            // Evita duplicatas
                            if ($('#edit_alunos_id option[value="' + aluno.matricula + '"]').length === 0) {
                                const option = new Option(aluno.nome, aluno.matricula, false, false);
                                alunosSelect.append(option);
                            }
                        });
                        alunosSelect.prop('disabled', false).trigger('change');
                    })
                    .catch(err => {
                        alunosSelect.prop('disabled', false);
                        console.error('Erro no fetch:', err);
                        alert('Erro ao carregar alunos. Veja o console para detalhes.');
                    });
            } else {
                alunosSelect.prop('disabled', false);
            }
        });

        $('#listagem-agendamentos').on('click', '.btn-reenviar-agendamento', function () {
            $('#reenvioAgendamentoId').val($(this).data('id'));
            $('#reenvioAgendamentoNome').text($(this).data('nome'));
            $('#modal-reenviar-agendamento').modal('show');
        });

        $('#form-reenviar-agendamento').on('submit', function (e) {
            e.preventDefault();
            const btn = $('#btnConfirmarReenvio').prop('disabled', true).text('Enviando...');

            $.post('<?= base_url('sys/agendamento/admin/reenviar') ?>', $(this).serialize(), function (res) {
                $.toast({
                    heading: res.success ? 'Sucesso' : 'Erro',
                    text: res.message,
                    icon: res.success ? 'success' : 'error',
                    loaderBg: res.success ? '#f96868' : '#dc3545',
                    position: 'top-center'
                });
                if (res.success) $('#modal-reenviar-agendamento').modal('hide');
            }, 'json').always(() => btn.prop('disabled', false).text('Sim, Reenviar'));
        });

        $(document).on('mouseenter', '.datepicker-days td.day.disabled', function () {
            const el = this;
            let tooltipTitle = '';
            if (
                $(el).closest('#modal-editar-agendamento').length || $(el).closest('#modal-cadastrar-agendamento').length
            ) {
                tooltipTitle = `<i class="fa fa-exclamation-triangle text-warning" style="margin-right: 6px;"></i> A data não pode ser anterior à data de hoje`;
            }
            const tooltip = new bootstrap.Tooltip(el, {
                html: true,
                title: tooltipTitle,
                trigger: 'manual',
                container: 'body',
                customClass: 'tooltip-on-top'
            });
            tooltip.show();

            // Ajuste automático de posição caso o calendário esteja no topo da tela
            const tip = $(tooltip.tip);
            const offset = $(el).offset();
            const tipHeight = tip.outerHeight();
            const scrollTop = $(window).scrollTop();

            // Se o tooltip estiver saindo da tela, move para baixo
            if (offset.top - tipHeight < scrollTop) {
                tooltip.dispose();
                const tooltipBottom = new bootstrap.Tooltip(el, {
                    html: true,
                    title: tooltipTitle,
                    trigger: 'manual',
                    container: 'body',
                    placement: 'bottom',
                    customClass: 'tooltip-on-top'
                });
                tooltipBottom.show();
            }
        });

        $(document).on('mouseleave', '.datepicker-days td.day.disabled', function () {
            const el = this;
            const tooltip = bootstrap.Tooltip.getInstance(el);
            if (tooltip) {
                tooltip.dispose();
            }
        });
        $(document).ready(function () {
            <?php if (session()->getFlashdata('sucesso')): ?>
                $.toast({
                    heading: 'Sucesso!',
                    text: '<?= session()->getFlashdata('sucesso') ?>',
                    showHideTransition: 'fade',
                    icon: 'success',
                    loaderBg: '#28a745',
                    position: 'top-center'
                });
            <?php endif; ?>

            <?php if (session()->getFlashdata('erros')): ?>
                $.toast({
                    heading: 'Erro',
                    text: '<?= session()->getFlashdata('erros')[0] ?>',
                    showHideTransition: 'fade',
                    icon: 'error',
                    loaderBg: '#dc3545',
                    position: 'top-center'
                });
            <?php endif; ?>
        });

    });
    // --- CADASTRO --- OBS: Deixei aqui no final por que estava dando problema em carregar o select2 dos alunos
    if (document.getElementById('form-cadastrar-agendamento')) {

        const getAlunosByTurmaUrl = "<?= base_url('sys/agendamento/admin/getAlunosByTurma') ?>";
        // Inicializa Select2 nos selects já existentes
        $('#turma_id').on('change', function () {
            const turmasSelecionadas = $(this).val(); // array de IDs
            const alunosSelect = $('#alunos_id');

            alunosSelect.prop('disabled', true).empty();

            if (turmasSelecionadas && turmasSelecionadas.length > 0) {
                fetch(`${getAlunosByTurmaUrl}?turmas=${turmasSelecionadas.join(',')}`)
                    .then(res => {
                        if (!res.ok) throw new Error(`HTTP error! status: ${res.status}`);
                        return res.json();
                    })
                    .then(alunos => {
                        alunosSelect.empty();
                        // Adiciona a opção "Selecionar Todos"
                        alunosSelect.append('<option value="select_all">-- Selecionar Todos --</option>');

                        // Adiciona os alunos retornados
                        alunos.forEach(aluno => {
                            // Cria opção apenas se ainda não existir
                            if ($('#alunos_id option[value="' + aluno.matricula + '"]').length === 0) {
                                const option = new Option(aluno.nome, aluno.matricula, false, false); // selecionado
                                $('#alunos_id').append(option).trigger('change');
                            }
                        });
                        alunosSelect.prop('disabled', false).trigger('change');
                    })
                    .catch(err => {
                        alunosSelect.prop('disabled', false);
                        console.error('Erro no fetch:', err);
                        alert('Erro ao carregar alunos. Veja o console para detalhes.');
                    });
            } else {
                alunosSelect.prop('disabled', false);
            }
        });

        // Evento: Selecionar Todos os alunos
        $('#alunos_id').on('change', function () {
            const valoresSelecionados = $(this).val() || [];
            if (valoresSelecionados.includes('select_all')) {
                // Marca todos os alunos (exceto o "select_all")
                const todosAlunos = $('#alunos_id option')
                    .map(function () { return this.value; })
                    .get()
                    .filter(v => v !== 'select_all');

                // Atualiza o Select2
                $('#alunos_id').val(todosAlunos).trigger('change');
            }
        });

        $('#form-cadastrar-agendamento').on('submit', function (e) {
            e.preventDefault(); // Impede o recarregamento da página
            const form = this;
            const formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.reload();
                    } else {
                        $.toast({
                            heading: 'Erro ao Salvar',
                            text: data.message || 'Verifique os dados e tente novamente.',
                            showHideTransition: 'fade',
                            icon: 'error',
                            loaderBg: '#dc3545',
                            position: 'top-center'
                        });
                    }
                })
                .catch(error => {
                    console.error('Erro na requisição:', error);
                    $.toast({
                        heading: 'Erro de Conexão',
                        text: 'Não foi possível se conectar ao servidor.',
                        showHideTransition: 'fade',
                        icon: 'error',
                        loaderBg: '#dc3545',
                        position: 'top-center'
                    });
                });
        });
    }
</script>
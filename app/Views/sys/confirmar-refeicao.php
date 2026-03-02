<div class="mb-3">
  <h2 class="card-title mb-0">Controle de Refeições</h2>
</div>

<div class="container py-5">

  <div class="row justify-content-center">
    <div class="col-lg-8 col-md-10">
      <div class="card shadow-sm border-0">
        <div class="card-body text-center py-5">

          <div id="container-selecao-camera" class="mb-3 w-100" style="max-width: 400px; margin: 0 auto;">
            <label for="camera-select" class="form-label fw-bold">Selecione a Câmera:</label>
            <select id="camera-select" class="form-select mb-3">
              <option value="" disabled selected>Carregando câmeras...</option>
            </select>
          </div>

          <button id="btn-iniciar-leitura" class="btn btn-primary btn-lg px-5" disabled>
            <i class="mdi mdi-qrcode-scan me-2"></i> Ler QR Code
          </button>

          <div id="reader-container" class="d-none mt-4">
            <div id="reader"
              style="width: 100%; max-width: 400px; margin: 0 auto; border-radius: 8px; overflow: hidden;"></div>
            <button id="btn-cancelar-leitura" class="btn btn-outline-secondary mt-3 w-100" style="max-width: 400px;">
              <i class="mdi mdi-close-circle-outline me-1"></i> Cancelar Leitura
            </button>
          </div>

          <div id="result-container" class="d-none mt-4 animate__animated animate__fadeIn">

            <div class="p-4 rounded-3 text-start border border-secondary"
              style="background-color: rgba(255, 255, 255, 0.05);">

              <div class="row g-0 align-items-center">

                <div class="col-md-4 text-center pe-md-4 border-end border-secondary">
                  <img id="foto-aluno" src="" alt="Foto" class="rounded shadow-sm mb-3 mb-md-0"
                    style="width: 100%; max-width: 120px; aspect-ratio: 1/1; object-fit: cover;">
                </div>

                <div class="col-md-8 ps-md-4">

                  <div class="mb-3">
                    <small class="text-secondary fw-bold text-uppercase d-block"
                      style="font-size: 0.7rem;">Aluno(a)</small>
                    <h3 id="nome-aluno" class="fw-bold text-white mb-0 text-break" style="line-height: 1.2;">--</h3>
                  </div>

                  <div class="row">
                    <div class="col-6">
                      <small class="text-secondary fw-bold text-uppercase d-block" style="font-size: 0.7rem;">Data
                        Refeição</small>
                      <span id="data-refeicao" class="fs-5 fw-semibold text-light">--/--/--</span>
                    </div>
                    <div class="col-6">
                      <small class="text-secondary fw-bold text-uppercase d-block"
                        style="font-size: 0.7rem;">Status</small>
                      <span id="badge-status" class="badge fs-6 fw-normal">--</span>
                    </div>
                  </div>

                </div>
              </div>
            </div>
            <div id="container-acoes" class="mt-4 text-center d-none">
              <button id="btn-confirmar" class="btn btn-success btn-lg px-5 shadow fw-bold">
                <i class="mdi mdi-check-circle-outline me-2"></i> Confirmar Retirada
              </button>
            </div>

            <div class="text-center mt-4">
              <button id="btn-limpar" class="btn btn-link text-decoration-none btn-nova-leitura">
                <i class="mdi mdi-refresh me-1"></i> Nova Leitura
              </button>
            </div>
          </div>

          <div id="status-msg" class="mt-4 fw-semibold fs-6"></div>

        </div>
      </div>
    </div>
  </div>
</div>

<style>
  .btn-nova-leitura {
    color: #6c757d;
    transition: all 0.3s ease;
  }

  .btn-nova-leitura:hover {
    color: #ffffff !important;
    text-decoration: underline !important;
    transform: scale(1.05);
  }
</style>

<script>
  window.toastAberto = false;

  document.addEventListener('DOMContentLoaded', function () {
    const els = {
      containerSelect: document.getElementById('container-selecao-camera'),
      cameraSelect: document.getElementById('camera-select'),
      btnIniciar: document.getElementById('btn-iniciar-leitura'),
      readerContainer: document.getElementById('reader-container'),
      btnCancelar: document.getElementById('btn-cancelar-leitura'),

      resultContainer: document.getElementById('result-container'),
      containerAcoes: document.getElementById('container-acoes'),
      btnConfirmar: document.getElementById('btn-confirmar'),
      btnLimpar: document.getElementById('btn-limpar'),
      statusMsg: document.getElementById('status-msg'),

      // Dados do Card
      fotoAluno: document.getElementById('foto-aluno'),
      nomeAluno: document.getElementById('nome-aluno'),
      dataRefeicao: document.getElementById('data-refeicao'),
      badgeStatus: document.getElementById('badge-status')
    };

    const somCheck = new Audio("<?= base_url('assets/sounds/Som de Sucesso.mp3') ?>");
    somCheck.preload = "auto";

    let html5QrCode = null;
    let refeicaoId = null;
    let leituraBloqueada = false;
    const csrfHeader = "<?= csrf_header() ?>";
    const csrfHash = "<?= csrf_hash() ?>";
    const pathFotos = "<?= base_url('assets/img/alunos/') ?>";

    Html5Qrcode.getCameras().then(devices => {
      els.cameraSelect.innerHTML = "";
      if (devices && devices.length) {
        devices.forEach(d => {
          let opt = document.createElement("option");
          opt.value = d.id;
          opt.text = d.label || `Câmera ${els.cameraSelect.options.length + 1}`;
          els.cameraSelect.appendChild(opt);
        });
        els.btnIniciar.disabled = false;
      } else {
        els.cameraSelect.innerHTML = "<option>Nenhuma câmera encontrada</option>";
      }
    }).catch(() => els.cameraSelect.innerHTML = "<option>Erro câmeras</option>");

    function iniciarLeitura() {
      const cameraId = els.cameraSelect.value;
      if (!cameraId) return alert("Selecione uma câmera!");

      resetTela();
      els.containerSelect.classList.add('d-none');
      els.btnIniciar.classList.add('d-none');

      els.readerContainer.classList.remove('d-none');

      html5QrCode = new Html5Qrcode("reader");
      html5QrCode.start(cameraId, { fps: 10, qrbox: { width: 250, height: 250 } }, onScanSuccess, () => { })
        .catch(err => {
          console.error(err);
          pararLeitura();
          alert("Erro ao abrir câmera");
        });
    }

    function pararLeitura() {
      if (html5QrCode) {
        html5QrCode.stop().then(() => { html5QrCode.clear(); html5QrCode = null; }).catch(() => { });
      }
      els.readerContainer.classList.add('d-none');

      if (els.resultContainer.classList.contains('d-none')) {
        els.containerSelect.classList.remove('d-none');
        els.btnIniciar.classList.remove('d-none');
      }
    }

    function resetTela() {
      els.resultContainer.classList.add('d-none');
      els.containerAcoes.classList.add('d-none');
      els.statusMsg.innerHTML = '';
      leituraBloqueada = false;
      els.containerSelect.classList.remove('d-none');
      els.btnIniciar.classList.remove('d-none');
    }

    async function onScanSuccess(decodedText) {
      if (leituraBloqueada) return;
      leituraBloqueada = true;
      if (html5QrCode) html5QrCode.pause();

      els.statusMsg.innerHTML = 'Consultando...';
      els.statusMsg.className = 'text-warning fw-bold';

      try {
        const response = await fetch("<?= base_url('/sys/controle-refeicoes/validar') ?>", {
          method: 'POST',
          headers: { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest', [csrfHeader]: csrfHash },
          body: JSON.stringify({ codigo: decodedText })
        });
        const res = await response.json();

        if (res.success) {
          const data = res.data;
          refeicaoId = data.id;
          somCheck.currentTime = 0;
          somCheck.play().catch(() => { });

          if (html5QrCode) { await html5QrCode.stop(); html5QrCode.clear(); html5QrCode = null; }
          els.readerContainer.classList.add('d-none');
          els.containerSelect.classList.add('d-none');
          els.btnIniciar.classList.add('d-none');

          // Se o PHP não mandar foto, ele vai usar um avatar generico
          const avatar = `https://ui-avatars.com/api/?background=random&size=180&name=${encodeURIComponent(data.aluno.nome)}`;
          let imagemFinal = avatar;
          if (data.aluno.foto_url && data.aluno.foto_url.trim() !== "") {
            imagemFinal = data.aluno.foto_url;
          }
          else if (data.aluno.foto && data.aluno.foto.trim() !== "") {
            imagemFinal = pathFotos + data.aluno.foto;
          }
          els.fotoAluno.src = imagemFinal;
          els.nomeAluno.textContent = data.aluno.nome;
          els.dataRefeicao.textContent = data.data_refeicao;

          const statusInfo = obterStatusVisual(data.status);
          els.badgeStatus.textContent = statusInfo.texto;
          els.badgeStatus.className = `badge fs-6 fw-normal ${statusInfo.classe}`;

          if (data.status == 0 || data.pode_servir) {
            els.containerAcoes.classList.remove('d-none');
          } else {
            els.containerAcoes.classList.add('d-none');
          }

          els.resultContainer.classList.remove('d-none');
          els.statusMsg.innerHTML = '';

          if (parseInt(data.status) === 2) {
            setTimeout(() => {
              resetTela();
              iniciarLeitura();
            }, 8000);
          }
          
        } else {
          mostrarErro(res.error);
          els.statusMsg.innerHTML = '';
          setTimeout(() => { leituraBloqueada = false; if (html5QrCode) html5QrCode.resume(); }, 2000);
        }
      } catch (err) {
        mostrarErro('Erro requisição');
        setTimeout(() => { leituraBloqueada = false; if (html5QrCode) html5QrCode.resume(); }, 2000);
      }
    }

    function obterStatusVisual(statusId) {
      const id = parseInt(statusId);

      switch (id) {
        case 0: return { texto: '-', classe: 'bg-primary' };
        case 1: return { texto: 'DISPONÍVEL', classe: 'bg-success' };
        case 2: return { texto: 'RETIRADA', classe: 'bg-secondary' };
        case 3: return { texto: 'CANCELADA', classe: 'bg-danger' };
        default: return { texto: 'DESCONHECIDO', classe: 'bg-dark' };
      }
    }

    async function handleConfirmar() {
      if (!refeicaoId) return;
      els.statusMsg.innerHTML = 'Confirmando...';
      els.btnConfirmar.disabled = true;

      try {
        const response = await fetch("<?= base_url('/sys/controle-refeicoes/confirmar') ?>", {
          method: 'POST',
          headers: { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest', [csrfHeader]: csrfHash },
          body: JSON.stringify({ id: refeicaoId })
        });
        const data = await response.json();

        if (data.success) {
          mostrarSucesso('Refeição Entregue!');
          const novoStatus = obterStatusVisual(2);
          els.badgeStatus.textContent = novoStatus.texto;
          els.badgeStatus.className = `badge fs-6 fw-normal ${novoStatus.classe}`;
          els.containerAcoes.classList.add('d-none');

          setTimeout(() => {
            resetTela();
            iniciarLeitura();
          }, 5000);

        } else {
          mostrarErro(data.error || 'Erro ao confirmar');
        }
      } catch (e) { mostrarErro('Erro no servidor'); }
      els.btnConfirmar.disabled = false;
      els.statusMsg.innerHTML = '';
    }

    function mostrarErro(msg) {
      if (window.toastAberto) return; window.toastAberto = true;
      $.toast({ heading: 'Erro', text: msg, icon: 'error', loaderBg: '#dc3545', position: 'top-center', hideAfter: 3000, afterHidden: () => window.toastAberto = false });
    }
    function mostrarSucesso(msg) {
      if (window.toastAberto) return; window.toastAberto = true;
      $.toast({ heading: 'Sucesso', text: msg, icon: 'success', loaderBg: '#198754', position: 'top-center', hideAfter: 3000, afterHidden: () => window.toastAberto = false });
    }

    els.btnIniciar.addEventListener('click', iniciarLeitura);
    els.btnCancelar.addEventListener('click', pararLeitura);
    els.btnConfirmar.addEventListener('click', handleConfirmar);
    els.btnLimpar.addEventListener('click', () => {
      resetTela();
      iniciarLeitura();
    });
  });
</script>
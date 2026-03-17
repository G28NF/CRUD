<div class="modal fade" id="modalEditar">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Editar Usuário</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form method="post" action="<?= base_url('home/update') ?>">
          <input type="hidden" name="id" id="editar_id" required>
          <div class="mb-2">
            <label>Nome</label>
            <input type="text" name="nome" id="editar_nome" class="form-control" required>
          </div>
          <div class="mb-2">
            <label>Email</label>
            <input type="email" name="email" id="editar_email" class="form-control" required>
          </div>
          <div>
            <label for="senha">Senha</label>
            <input type="text" name="senha" id="editar_senha" class="form-control" required>
          </div>
          <div>
            <label>Nascimento</label>
            <input type="date" name="nascimento" id="editar_nascimento" class="form-control" required>
          </div>
            <div>
                <label>CEP</label>
                <input type="text" name="cep" id="editar_cep" class="form-control" required>
            </div>
            <div>
                <label>Logradouro</label>
                <input type="text" name="logradouro" id="editar_logradouro" class="form-control" required>
            </div>
            <div>
                <label>Numero</label>
                <input type="text" name="numero" id="editar_numero" class="form-control" required>
            </div>
            <div>
                <label>Complemento</label>
                <input type="text" name="complemento" id="editar_complemento" class="form-control">
            </div>
            <div>
                <label>Bairro</label>
                <input type="text" name="bairro" id="editar_bairro" class="form-control" required>
            </div>
            <div>
                <label>Cidade</label>
                <input type="text" name="cidade" id="editar_cidade" class="form-control" required>
            </div>
            <div>
                <label>UF</label>
                <input type="text" name="uf" id="editar_uf" class="form-control" required>
            </div>
          <button class="btn btn-success">Salvar</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!DOCTYPE HTML!>
<html lang="pt-br">
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Cadastro de Usuário</title>
    </head>

<body>
    <div class="container-fluid mt-5">
        <div class="card mb-4 w-100">
            <div class="card-header bg-dark text-white">
                Cadastrar Usuário
            </div>

            <div class="card-body">
                <form method="post" action="<?= site_url('home/create') ?>">
                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nome</label>
                            <input type="text" name="nome" id="name" class="form-control" required>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Nascimento</label>
                            <input type="date" name="nascimento" id="nascimento" class="form-control" required>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">CEP</label>
                            <input type="text" name="cep" id="cep" class="form-control" required>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Senha</label>
                            <input type="password" name="senha" id="senha" class="form-control" required>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Logradouro</label>
                            <input type="text" name="logradouro" id="logradouro" class="form-control" required>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Número</label>
                            <input type="text" name="numero" id="numero" class="form-control" required>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Complemento</label>
                            <input type="text" name="complemento" id="complemento" class="form-control">
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Bairro</label>
                            <input type="text" name="bairro" id="bairro" class="form-control"required>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Cidade</label>
                            <input type="text" name="cidade" id="cidade" class="form-control"required>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">UF</label>
                            <input type="text" name="uf" id="uf" class="form-control"required>
                        </div>
                    </div>

                    <button class="btn btn-primary">Cadastrar</button>

                </form>
            </div>
        </div>


        <!-- LISTA DE USUÁRIOS -->
        <div class="card w-100">

            <div class="card-header bg-dark text-white">
                Usuários cadastrados
            </div>

            <div class="card-body">
                <table class="table table-striped">

                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Senha</th>
                            <th>Nascimento</th>
                            <th>CEP</th>
                            <th>Logradouro</th>
                            <th>Numero</th>
                            <th>Complemento</th>
                            <th>Bairro</th>
                            <th>Cidade</th>
                            <th>UF</th>
                            <th>Ações</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($usuarios as $usuario): ?>
                        <tr>
                            <td><?= $usuario['nome'] ?></td>
                            <td><?= $usuario['email'] ?></td>
                            <td><?= $usuario['senha'] ?></td>
                            <td><?= $usuario['nascimento'] ?></td>
                            <td><?= $usuario['cep'] ?></td>
                            <td><?= $usuario['logradouro'] ?></td>
                            <td><?= $usuario['numero'] ?></td>
                            <td><?= $usuario['complemento'] ?></td>
                            <td><?= $usuario['bairro'] ?></td>
                            <td><?= $usuario['cidade'] ?></td>
                            <td><?= $usuario['uf'] ?></td>
                            <td>

                            <a class="btn btn-warning btn-sm btn-editar"
                                data-id="<?= $usuario['id'] ?> ">
                                Editar
                            </a>

                            <form action="<?= site_url('home/delete') ?>" method="post">
                                <input type="hidden" name="id" value="<?= $usuario['id'] ?>">
                                <button class="btn btn-danger btn-sm">Excluir</button>
                            </form>

                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>

                </table>
            </div>
        </div>
    </div>
    
</html>
</body>

<?= view('modalEditar') ?> 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

  document.querySelectorAll('.btn-editar').forEach(btn => {
    btn.addEventListener('click', function () {

      let id = this.dataset.id;

      fetch('/CRUD/public/index.php/home/buscar/' + id)
        .then(res => res.json())
        .then(data => {

          document.getElementById('editar_id').value = data.id;
          document.getElementById('editar_nome').value = data.nome;
          document.getElementById('editar_senha').value = data.senha;
          document.getElementById('editar_email').value = data.email;
          document.getElementById('editar_nascimento').value = data.nascimento;
          document.getElementById('editar_cep').value = data.cep;
          document.getElementById('editar_logradouro').value = data.logradouro;
          document.getElementById('editar_numero').value = data.numero;
          document.getElementById('editar_complemento').value = data.complemento;
          document.getElementById('editar_bairro').value = data.bairro;
          document.getElementById('editar_cidade').value = data.cidade;
          document.getElementById('editar_uf').value = data.uf;

          new bootstrap.Modal(document.getElementById('modalEditar')).show();
        });

    });
  });

});
</script>
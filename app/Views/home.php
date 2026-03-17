<!DOCTYPE HTML!>
<html lang="pt-br">
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Cadastro de Usuário</title>
    </head>

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
                        <input type="text" name="nome" class="form-control" required>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">Nascimento</label>
                        <input type="date" name="nascimento" class="form-control" required>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">CEP</label>
                        <input type="text" name="cep" class="form-control" required>
                    </div>

                </div>

                <div class="row">

                    <div class="col-md-3 mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">Senha</label>
                        <input type="password" name="senha" class="form-control" required>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">logradouro</label>
                        <input type="text" name="logradouro" class="form-control" required>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">numero</label>
                        <input type="text" name="numero" class="form-control" required>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">complemento</label>
                        <input type="text" name="complemento" class="form-control">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">bairro</label>
                        <input type="text" name="bairro" class="form-control"required>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">cidade</label>
                        <input type="text" name="cidade" class="form-control"required>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">uf</label>
                        <input type="text" name="uf" class="form-control"required>
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

                            <a href="/home/editar/<?= $usuario['id'] ?>" class="btn btn-warning btn-sm">
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

<script>

</script>
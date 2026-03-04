<!DOCTYPE HTML!>
<html lang="pt-br">
    <head>
        <title>Cadastro de Usuário</title>
    </head>

    <body>
        <form method="post" action="<?= base_url('home/create'); ?>">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required><br>

            <label for="nascimento">Data de Nascimento:</label>
            <input type="date" id="nascimento" name="nascimento" required><br>

            <label for="email">Email:</label>
            <input type="text" id="email" name="email" required><br>

            <label for="senha">Senha:</label>
            <input type="text" id="senha" name="senha" required><br>

            <label for="cep">CEP:</label>
            <input type="text" id="cep" name="cep" required><br>

            <label for="logradouro">Logradouro:</label>
            <input type="text" id="logradouro" name="logradouro" required><br>

            <label for="numero">Numero:</label>
            <input type="text" id="numero" name="numero" required><br>

            <label for="complemento">Complemento:</label>
            <input type="text" id="complemento" name="complemento" required><br>

            <label for="bairro">Bairro:</label>
            <input type="text" id="bairro" name="bairro" required><br>

            <label for="cidade">Cidade:</label>
            <input type="text" id="cidade" name="cidade" required><br>

            <label for="uf">UF:</label>
            <input type="text" id="uf" name="uf" required><br>

            <button type="submit">Enviar</button>
        </form>
    </body>
</html>

<script>

</script>
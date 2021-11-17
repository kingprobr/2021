<?php
require_once 'init.php';
// abre a conexão
$PDO = db_connect();

// SQL para contar o total de registros
// A biblioteca PDO possui o método rowCount(), 
// mas ele pode ser impreciso.
// É recomendável usar a função COUNT da SQL
$sql_count = "SELECT COUNT(*) AS total FROM jogos ORDER BY nomeJogo ASC";

// SQL para selecionar os registros
$sql = "SELECT * "
        . "FROM jogos ORDER BY nomeJogo ASC";

// conta o total de registros
$stmt_count = $PDO->prepare($sql_count);
$stmt_count->execute();
$total = $stmt_count->fetchColumn();

// seleciona os registros
$stmt = $PDO->prepare($sql);
$stmt->execute();
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Sistema de Cadastro de Jogos</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    </head>
    <body>
    <div class="container">
        <div class="jumbotron">
        <h1>Sistema de Cadastro de Jogos</h1>
        </div>
        <h2>Lista de Jogos</h2>
        <p>Total de Jogos: <?php echo $total ?></p>
        <?php if ($total > 0): ?>
            <div class="shadow p-3 mb-5 bg-white rounded">
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th>Nome</th>
                        <th>Data de lançamento</th>
                        <th>Desenvolvedora</th>
                        <th>Gênero</th>
                        <th>Preço</th>
                        <th>Especificações minimas</th>
                        <th>Especificações recomendadas</th>
                        <th>Plataforma</th>
                        <th>Ajustes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($jogos = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                        <tr>
                            <td><?php echo $jogos['nomeJogo'] ?></td>
                            <td><?php echo dateConvert($jogos['dtLancamento']) ?></td>
                            <td><?php echo $jogos['desenvolvedora'] ?></td>
                            <td><?php echo $jogos['genero'] ?></td>
                            <td><?php echo $jogos['preco'] ?></td>
                            <td><?php echo $jogos['especsMin'] ?></td>
                            <td><?php echo $jogos['especsRec'] ?></td>
                            <td><?php echo $jogos['plataforma'] ?></td>
                                      </div>
                            <td>
                                <a href="form-edit.php?idJogo=<?php echo $jogos['idJogo'] ?>">Editar</a>
                                <a href="delete.php?idJogo=<?php echo $jogos['idJogo'] ?>" 
                                   onclick="return confirm('Tem certeza de que deseja remover?');">
                                    Remover
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Nenhum jogo cadastrado</p>
        <?php endif; ?>
        <p><a class="btn btn-success" role="button" href="form-add.php">Adicionar Jogo</a></p>
        </div>
    </body>
</html>
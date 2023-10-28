<?php
include("conexao.php");
include("funcao.php");

if (isset($_GET["deletar"])) {
    $id = intval($_GET["deletar"]);
    $sql_query = $mysqli->query("SELECT * FROM arquivos WHERE id = '$id'") or die($mysqli->error);
    $arquivo = $sql_query->fetch_assoc();
      
    if ($arquivo) {
        $caminho_arquivo = $arquivo['path'];

        if (file_exists($caminho_arquivo)) {
            if (unlink($caminho_arquivo)) {
                $deucerto = $mysqli->query("DELETE FROM arquivos WHERE id = '$id'") or die($mysqli->error);
                if ($deucerto) {
                    echo "Arquivo excluído com sucesso.";
                } else {
                    echo "Erro ao excluir o registro do banco de dados.";
                }
            } else {
                echo "Erro ao excluir o arquivo.";
            }
        } else {
            echo "O arquivo não existe no caminho especificado.";
        }
    } else {
        echo "Arquivo não encontrado no banco de dados.";
    }
}

if (isset($_FILES["arquivos"])) {
    $tudo_certo = true;
    $arquivos = $_FILES["arquivos"];
    foreach ($arquivos["name"] as $index => $nome_arquivo) {
        $erro= enviarArquivo($arquivos["error"][$index], $arquivos["size"][$index],
         $arquivos["name"][$index], $arquivos["tmp_name"][$index]);
        if ($erro !== true) {
            $tudo_certo = false;
            $erros[] = $erro; // Armazena o erro no array
        }
    }
    if ($tudo_certo) {
        echo "<p>Todos os arquivos foram enviados com sucesso.</p>";
    } else {
        echo "<p>Ocorreram o(s) seguinte erro(s) no envio dos arquivos:</p>";
        foreach ($erros as $erro) {
            echo "<p>$erro</p>"; // Exibe os erros individualmente
        }
    }}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload de arquivo</title>
    <h1>upload de arquivos</h1>
    <h2>os path dos arquivos vao para o banco de daddos, as fotos vao para o servidor(meu pc no caso), e mostra o nome do caminho e a data de envio</h2>
</head>

<body>
    <form method="POST" enctype="multipart/form-data" action="" method="get">
        <label for="">Selecione o arquivo</label><br>
        <input type="file" multiple name="arquivos[]" id="arquivo">
        <button name="upload" type="submit">Enviar arquivo</button>
    </form>

    <table border="1" cellpading="10">
        <h1>Lista de arquivos</h1>
        <thead>
            <th>Preview</th>
            <th>Arquivo</th>
            <th>Data de envio</th>
       
        </thead>
        <tbody>
            <?php
            $sql_query = $mysqli->query("SELECT * FROM arquivos") or die($mysqli->error);
            while ($arquivo = $sql_query->fetch_assoc()) {
            ?>
                <tr>
                <td><img src="<?php echo $arquivo['path']; ?>" width="50" height="50"></a></td>
                    <td><?php echo $arquivo["nome_arquivo"]; ?></td>
                    <td><?php echo date("d/m/Y H:i", strtotime($arquivo['data_upload'])); ?></td>
                    <td><a href="index.php?deletar=<?php echo $arquivo['id'];?>">deletar</a></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<h3>criado por elias :)</h3>
</body>

</html>
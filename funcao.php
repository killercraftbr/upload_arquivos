<?php
include("conexao.php");

function enviarArquivo($error, $size, $name, $tmp_name) {
    include("conexao.php");

    // Verifica se existe o arquivo e mostra que foi "enviado"
    if (isset($_FILES["arquivos"])) {
        if ($size > 2097152) {
            return "Arquivo muito grande! O tamanho máximo permitido é de 2MB.";
        } elseif ($error) {
            return "Falha ao enviar um arquivo.";
        } else {
            $nomeDoArquivo = $name;
            $novoNomeDoArquivo = uniqid();
            $extensao = strtolower(pathinfo($nomeDoArquivo, PATHINFO_EXTENSION));
            $path = "arquivos/$novoNomeDoArquivo.$extensao";

            if ($extensao != "jpg" && $extensao != "png") {
                return "Tipo de arquivo não aceito. Apenas arquivos JPG e PNG são permitidos.";
            } else {
             $deucerto = move_uploaded_file($tmp_name, $path);
                if ($deucerto) {
                    $mysqli->query("INSERT INTO arquivos (nome_arquivo, path, data_upload) VALUES ('$novoNomeDoArquivo', '$path', NOW())");

                    return true;
                } else {
                    return "Erro ao mover o arquivo para o destino.";
                }
            }
        }
    }
}
?>
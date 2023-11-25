<?php
// Verifica se o formulário foi enviado

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se há um arquivo enviado
    if (isset($_FILES["arquivo"])) {
        $arquivo = $_FILES["arquivo"];

        // Verifica se a extensão do arquivo é .txt
        $extensao_permitida = "txt";
        $extensao_arquivo = pathinfo($arquivo["name"], PATHINFO_EXTENSION);

        if (strtolower($extensao_arquivo) == $extensao_permitida) {
            // Diretório de destino para o upload
            $diretorio_destino = "../";

            // Caminho completo do arquivo no servidor
            $caminho_destino = $diretorio_destino . $arquivo["name"];

            // Move o arquivo para o diretório de destino
            if (move_uploaded_file($arquivo["tmp_name"], $caminho_destino)) {
                echo "Upload realizado com sucesso!";
                convert_json($caminho_destino);
            } else {
                echo "Erro ao realizar o upload.";
            }
        } else {
            echo "Somente arquivos .txt são permitidos.";
            echo '<div> <a href="index.html"> <button>VOLTA </button></a> </div>';

        }
    } else {
        echo "Nenhum arquivo selecionado.";
        echo '<div> <a href="index.html"> <button>VOLTA </button></a> </div>';
    }
}


function convert_json($nome_arquivo)
{

    $arquivo = fopen($nome_arquivo, 'r');
    $nomes = [];

    if ($arquivo) {
        $nomes = [];
        // Lê cada linha do arquivo
        while (($linha = fgets($arquivo)) !== false) {
            // Processa a linha (exemplo: exibe a linha)
            echo "<div> \n" . $linha  ;
            
            $nomes[] = trim($linha);

            // Converter caracteres acentuados para UTF-8
            foreach ($nomes as &$nome) {
                $nome = mb_convert_encoding($nome, 'UTF-8');
            }

            $data = ["nomes" => $nomes];
        }
        $json_data = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        // Caminho para o arquivo onde você deseja salvar os dados JSON
        $caminho_arquivo = '../lista.json';

        // Salva os dados JSON no arquivo
        file_put_contents($caminho_arquivo, $json_data);

        // Exibe uma mensagem indicando que a operação foi bem-sucedida ou não
        if (file_exists($caminho_arquivo)) {
            echo "Os dados foram salvos com sucesso no arquivo JSON.";
            echo '<div> <a href="../index.html"> <button>VOLTA PARA PAGINA SORTEIO </button></a> </div>';
        } else {
            echo "Erro ao salvar os dados no arquivo JSON.";
        }

        // Fecha o arquivo
        fclose($arquivo);
    } else {
        // Trata erros ao abrir o arquivo
        echo "Não foi possível abrir o arquivo.";
    }
}

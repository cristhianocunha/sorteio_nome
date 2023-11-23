<?php

declare(strict_types=1);

$nomes = [];

while ($line = fgets(STDIN)) {
    $nomes[] = trim($line);
}

// Converter caracteres acentuados para UTF-8
foreach ($nomes as &$nome) {
    $nome = mb_convert_encoding($nome, 'UTF-8');
}

$data = ["nomes" => $nomes];

// Usar JSON_UNESCAPED_UNICODE para manter caracteres acentuados como UTF-8
echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
exit(0);
?>

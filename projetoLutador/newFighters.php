<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// Ler nomes do arquivo nomes.txt
$nomes = file('nomes.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$nomes = array_map('utf8_encode', $nomes);

// Ler países do arquivo paises.json
$paisesJson = file_get_contents('paises.json');
$paises = json_decode($paisesJson, true);

// Definir a quantidade de lutadores a serem criados
$quantidadeLutadores = 5; // Altere conforme necessário

// Array para armazenar os lutadores gerados
$lutadores = [];

// Gerar lutadores aleatórios
for ($i = 0; $i < $quantidadeLutadores; $i++) {
    $nome = $nomes[array_rand($nomes)];
    echo $nome .  '<br>';
    $nacionalidade = $paises[array_rand($paises)]['country'];
    $idade = rand(18, 40);
    $altura = rand(160, 200) / 100; // Altura em metros
    $peso = rand(60, 100);
    $categoria = 'Peso Médio'; // Modifique conforme necessário
    $vitorias = rand(0, 30);
    $derrotas = rand(0, 10);
    $empates = rand(0, 5);

    // Gerar ID único usando uniqid()
    $id = uniqid();

    // Construir array do lutador
    $lutador = [
        'id' => $id,
        'nome' => $nome,
        'nacionalidade' => $nacionalidade,
        'idade' => $idade,
        'altura' => $altura,
        'peso' => $peso,
        'categoria' => $categoria,
        'vitorias' => $vitorias,
        'derrotas' => $derrotas,
        'empates' => $empates,
    ];

    // Adicionar lutador ao array
    $lutadores[] = $lutador;
}

// Ler lutadores existentes do arquivo lutadores.json
$jsonFile = './lutadores.json';
$lutadoresExist = [];

if (file_exists($jsonFile)) {
    $jsonContent = file_get_contents($jsonFile);
    $lutadoresExist = json_decode($jsonContent, true) ?? [];
}

// Adicionar os novos lutadores aos existentes
$lutadores = array_merge($lutadoresExist, $lutadores);

// Salvar a lista atualizada de lutadores no arquivo lutadores.json
$jsonUpdated = json_encode($lutadores, JSON_PRETTY_PRINT);
file_put_contents($jsonFile, $jsonUpdated);

// Mensagem de sucesso
echo "Lutadores adicionados com sucesso!";

?>

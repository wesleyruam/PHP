<?php
function verify_tipo_acao() {
    if ($_GET['tipo_acao'] == 'adicionar_lutador') {
        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            $data = $_GET;

            // Lista dos campos obrigatórios
            $requiredFields = ['nome', 'nacionalidade', 'idade', 'altura', 'peso', 'categoria'];
            $missingFields = [];

            // Verificar campos obrigatórios
            foreach ($requiredFields as $field) {
                if (!isset($data[$field]) || empty($data[$field])) {
                    $missingFields[] = $field;
                }
            }

            if (!empty($missingFields)) {
                // Alguns campos estão em branco, exiba um alerta
                echo "<script>alert('Não foi possível adicionar. Preencha os seguintes campos: " . implode(', ', $missingFields) . "');</script>";
            } else {
                // Todos os campos obrigatórios estão preenchidos
                $jsonFile = './lutadores.json';

                // Verifique se o arquivo JSON existe
                if (!file_exists($jsonFile)) {
                    file_put_contents($jsonFile, '[]');
                }

                // Lê o conteúdo do arquivo JSON existente
                $jsonContent = file_get_contents($jsonFile);

                // Converte o conteúdo JSON em um array PHP
                $lutadores = json_decode($jsonContent, true);

                // Verifique se um lutador com o mesmo nome já existe
                $nomeLutador = $data['nome'];
                $lutadorExistente = false;

                foreach ($lutadores as $lutador) {
                    if ($lutador['nome'] === $nomeLutador) {
                        $lutadorExistente = true;
                        break;
                    }
                }

                if ($lutadorExistente) {
                    echo "<script>alert('Lutador já adicionado.');</script>";
                } else {
                    // Crie o novo lutador com um ID único
                    $novoLutador = [
                        'id' => uniqid(), // Adiciona um ID único
                        'nome' => $data['nome'],
                        'nacionalidade' => $data['nacionalidade'],
                        'idade' => (int)$data['idade'],
                        'altura' => (float)$data['altura'],
                        'peso' => (float)$data['peso'],
                        'categoria' => $data['categoria'],
                        'vitorias' => $data['vitorias'],
                        'derrotas' => $data['derrotas'],
                        'empates' => $data['empates']
                    ];

                    // Adicione o novo lutador ao array
                    $lutadores[] = $novoLutador;

                    // Converta o array PHP atualizado para JSON
                    $jsonUpdated = json_encode($lutadores, JSON_PRETTY_PRINT);

                    // Escreva o JSON atualizado no arquivo
                    file_put_contents($jsonFile, $jsonUpdated);

                    // Mostre um alerta de sucesso
                    echo "<script>alert('Lutador adicionado com sucesso.');</script>";
                }
            }
        }
    }
}


verify_tipo_acao();
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .containerFighterCreator {
            width: 90%;
            height: 100%;
            margin-top: 30px;
        }
    </style>
    <title>Adicionar Lutador</title>
</head>

<body>

    <div class="containerFighterCreator">
        <h1 class="alert-heading">Adicionar Lutador</h1>


        <form action="" method="GET">
            <div class="form-group">
                <label>Nome: </label>
                <input type="text" name="nome" class="form-control">
                <br>
                <label>Idade: </label>
                <input type="number" name="idade" class="form-control">
                <br>
                <label>Nacionalidade: </label>
                <select id="country-select" class="form-control" name="nacionalidade"></select>
                <br>
                <label>Altura: </label>
                <input type="number" step="0.01" name="altura" class="form-control">
                <br>
                <label>Peso: </label>
                <input type="number" min="60" step="0.01" name="peso" id="peso" class="form-control" oninput="changeValueCategoria(this.value)">
                <br>
                <label>Categoria: </label>
                <input type="text" id="categoria" name="categoria" class="form-control" readonly>
                <br>
                <label>Vitorias: </label>
                <input type="number" name="vitorias" class="form-control">
                <br>
                <label>Derrotas: </label>
                <input type="number" name="derrotas" class="form-control">
                <br>
                <label>Empates: </label>
                <input type="number" name="empates" class="form-control">
                <br>
                <input type="submit" class="btn btn-primary" value="Adicionar">
            </div>
            <input type="hidden" name="tipo_acao" value="adicionar_lutador">
        </form>
        <a href="index.php" class="btn btn-secondary">Voltar</a>
        
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>

    <script>
        const selectElement = document.getElementById("country-select");
        const searchInputElement = document.getElementById("search-input");
        const resultsElement = document.getElementById("results");
        let countriesData = [];

        function fillCountrySelect() {
            countriesData.forEach((country) => {
                const option = document.createElement("option");
                option.value = country.country + " - " + country.iso_code;
                option.textContent = country.country;
                selectElement.appendChild(option);
            });
        }

        fetch('paises.json')
            .then(response => response.json())
            .then(data => {
                countriesData = data;
                fillCountrySelect();
            })
            .catch(error => console.error('Erro ao buscar o arquivo JSON:', error));


        /* function viewValueNac(){
            console.log(selectElement.value);
        }
         */

        function changeValueCategoria(valorPeso) {
            const inputCategoria = document.getElementById('categoria');

            let categoria;

            switch (true) {
                case valorPeso >= 60 && valorPeso < 66:
                    categoria = 'Peso Extra Leve';
                    break;
                case valorPeso >= 66 && valorPeso < 73:
                    categoria = 'Peso Meio Leve';
                    break;
                case valorPeso >= 73 && valorPeso < 81:
                    categoria = 'Peso Leve';
                    break;
                case valorPeso >= 81 && valorPeso < 90:
                    categoria = 'Peso Meio Médio';
                    break;
                case valorPeso >= 90 && valorPeso < 100:
                    categoria = 'Peso Meio Pesado';
                    break;
                case valorPeso >= 100:
                    categoria = 'Peso Pesado';
                    break;
                default:
                    categoria = 'Lutador Inapto Para Lutar.';
            }

            inputCategoria.value = categoria;
        }
    </script>
</body>
</html>
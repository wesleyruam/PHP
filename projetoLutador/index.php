<?php 
session_unset();
session_destroy();

$jsonFile = './lutadores.json';

if (file_exists($jsonFile)){
    $jsonContent = file_get_contents($jsonFile);

    $lutadores = json_decode($jsonContent, true);
}

$lutaoresSelecionados = Array();

function listFighters($lutadores){
    foreach ($lutadores as $index => $lutador){
        echo '<tr>';
        echo '<td colspan="2">';
        echo '<label for="' . $index . '">' . $lutador['nome'] . ' - ' . $lutador['categoria'] . '</label>';
        echo '</td>';
        echo '<td>';
        echo '<input type="checkbox" id="lutador' . $index . '" name="opcao" class="' . $lutador['id'] . '" onchange="verificarCheckbox(' . $index . ')">';
        echo '</td>';
        echo '</tr>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        body {
            background-color: #303030;
            color: white;

        }

        .btn-events {
            font-family: monospace;
            font-size: 1.5rem;
            color: #FAFAFA;
            text-transform: uppercase;
            padding: 10px 20px;
            border-radius: 10px;
            border: 2px solid #FAFAFA;
            background: #252525;
            box-shadow: 3px 3px #fafafa;
            cursor: pointer;
            margin: 35px 0;
        }

        .btn-events:active {
            box-shadow: none;
            transform: translate(3px, 3px);
        }

        .forBorder {
            border-collapse: collapse;
        }

        td,
        th {
            text-align: center;
            align-items: center;
            padding: 8px;
        }

        .check {
            margin: 5px;
        }

        .fightersForFight {
            position: sticky;
            top: 0;
        }
    </style>
</head>

<body>

    <table style="width: auto; border: none;">
        <tr>
            <td>
                <table class="forBorder" style="border-collapse: collapse; border: 1px solid white;">
                    <tr>
                        <th colspan="2">Lista de Lutadores</th>
                    </tr>
                    <?php listFighters($lutadores)?>
                    <tr>
                        <td>
                            <a href="./criarLutador.php"><button class="b-addFighter btn-events">Adicionar
                                    Lutador</button></a>
                        </td>
                    </tr>
                </table>
            </td>
            <td style="position: absolute; width: 50%;">
                <table border="1" class="fightersForFight forBorder"
                    style="border: none;border-collapse: collapse; border: 1px solid white;">
                    <thead>
                        <th colspan="9">Lutares Para Lutar</th>
                    </thead>
                    <tbody>
                        <th>Nome</th>
                        <th>Idade</th>
                        <th>Nacionalidade</th>
                        <th>Altura(m)</th>
                        <th>Peso(Kg)</th>
                        <th>Categoria</th>
                        <th>Vitorias</th>
                        <th>Derrotas</th>
                        <th>Empates</th>
                    </tbody>
                    <td colspan="9">
                        <button class="b-createFight btn-events" onclick="criarLuta()">Criar Luta</button>
                    </td>
                </table>
            </td>
        </tr>
    </table>

    <script>
        const checkboxes = document.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', () => {
                const checkedCheckboxes = document.querySelectorAll('input[type="checkbox"]:checked');
                if (checkedCheckboxes.length > 2) {
                    checkbox.checked = false;
                }

                // Desabilitar checkboxes após selecionar 2
                checkboxes.forEach(cb => {
                    cb.disabled = checkedCheckboxes.length >= 2 && !cb.checked;
                });
            });
        });

        const lutadorData = <?php echo json_encode($lutadores); ?>;

        function verificarCheckbox(id) {
            const checkbox = document.getElementById('lutador' + id);
            const tableBody = document.querySelector('.fightersForFight tbody');

            if (checkbox.checked) {
                const lutadorSelecionado = lutadorData[id];

                const tableRow = document.createElement('tr');
                tableRow.innerHTML = `
                    <td>${lutadorSelecionado.nome}</td>
                    <td>${lutadorSelecionado.idade}</td>
                    <td>${lutadorSelecionado.nacionalidade}</td>
                    <td>${lutadorSelecionado.altura}</td>
                    <td>${lutadorSelecionado.peso}</td>
                    <td>${lutadorSelecionado.categoria}</td>
                    <td>${lutadorSelecionado.vitorias}</td>
                    <td>${lutadorSelecionado.derrotas}</td>
                    <td>${lutadorSelecionado.empates}</td>`;
                tableBody.appendChild(tableRow);

                // Desabilitar checkboxes após adicionar 2 lutadores
                checkboxes.forEach(cb => {
                    cb.disabled = checkbox.checked || document.querySelectorAll('input[type="checkbox"]:checked').length >= 2;
                });
            } else {
                const rows = tableBody.querySelectorAll('tr:not(:first-child)');
                for (let i = 0; i < rows.length; i++) {
                    const cells = rows[i].getElementsByTagName('td');
                    const nomeLutador = cells[0].innerText;

                    if (nomeLutador === lutadorData[id].nome) {
                        tableBody.removeChild(rows[i]);
                        break;
                    }
                }

                checkboxes.forEach(cb => {
                    cb.disabled = false;
                });
            }
        }

        function criarLuta() {
            const checkboxesSelecionados = document.querySelectorAll('input[type="checkbox"]:checked');
            console.log(checkboxesSelecionados)
            const classes = [];

            checkboxesSelecionados.forEach(checkbox => {
                classes.push(checkbox.className);
            });

            const jsonData = encodeURIComponent(JSON.stringify(classes));

            window.location.href = `proc.php?ids=${jsonData}`;
        }



    </script>
</body>

</html>
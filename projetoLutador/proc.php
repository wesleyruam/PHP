<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

class Lutador {
    private $id;
    private $nome;
    private $nacionalidade;
    private $idade;
    private $altura;
    private $peso;
    private $categoria;
    private $vitorias;
    private $derrotas;
    private $empates;

    function __construct($id, $nome, $nacionalidade, $idade, $altura, $peso, $categoria, $vitorias, $derrotas, $empates) {
        $this->id = $id;
        $this->nome = $nome;
        $this->nacionalidade = $nacionalidade;
        $this->idade = $idade;
        $this->altura = $altura;
        $this->peso = $peso;
        $this->categoria = $categoria;
        $this->vitorias = $vitorias;
        $this->derrotas = $derrotas;
        $this->empates = $empates;
    }

    function getId() {
        return $this->id;
    }

    function getNome() {
        return $this->nome;
    }

    function getNacionalidade() {
        return $this->nacionalidade;
    }

    function getIdade() {
        return $this->idade;
    }

    function getAltura() {
        return $this->altura;
    }

    function getPeso() {
        return $this->peso;
    }

    function getCategoria() {
        return $this->categoria;
    }

    function getVitorias() {
        return $this->vitorias;
    }

    function getDerrotas() {
        return $this->derrotas;
    }

    function getEmpates() {
        return $this->empates;
    }

    // Setters
    function setNome($nome) {
        $this->nome = $nome;
    }

    function setNacionalidade($nacionalidade) {
        $this->nacionalidade = $nacionalidade;
    }

    function setIdade($idade) {
        $this->idade = $idade;
    }

    function setAltura($altura) {
        $this->altura = $altura;
    }

    function setPeso($peso) {
        $this->peso = $peso;
    }

    function setCategoria($categoria) {
        $this->categoria = $categoria;
    }

    function setVitorias($vitorias) {
        $this->vitorias = $vitorias;
    }

    function setDerrotas($derrotas) {
        $this->derrotas = $derrotas;
    }

    function setEmpates($empates) {
        $this->empates = $empates;
    }

    function apresentar() {
        echo $this->nome . "<br>";
        echo $this->nacionalidade . "<br>";
        echo $this->idade . "<br>";
        echo $this->altura . "<br>";
        echo $this->peso . "<br>";
        echo $this->categoria . "<br>";
        echo $this->vitorias . "<br>";
        echo $this->derrotas . "<br>";
        echo $this->empates . "<br>";
    }

    function status() {
        echo $this->vitorias . "<br>";
        echo $this->derrotas . "<br>";
        echo $this->empates . "<br>";
    }

    function ganharLuta() {
        $this->vitorias += 1;
        $this->updateJson();
    }

    function perderLuta() {
        $this->derrotas += 1;
       $this->updateJson();
    }

    function empatarLuta() {    
        $this->empates += 1;
       $this->updateJson();
    }


    function updateJson() {
        $jsonFile = 'lutadores.json';

        if (!file_exists($jsonFile)) {
            return;
        }

        $jsonContent = file_get_contents($jsonFile);

        $lutadores = json_decode($jsonContent, true);

        foreach ($lutadores as &$lutador) {
            if ($lutador['id'] === $this->id) {
                $lutador['vitorias'] = $this->vitorias;
                $lutador['derrotas'] = $this->derrotas;
                $lustador['empates'] = $this->empates;
                break;
            }
        }

        file_put_contents($jsonFile, json_encode($lutadores, JSON_PRETTY_PRINT));
    }
}



class Luta{
    private $rounds;
    private $pontosDesafiado = 0;
    private $pontosDesafiante = 0;
    private $aprovada;
    private $desafiado;
    private $desafiante;
    private $ganhador;


    function __construct(Lutador $desafiado, Lutador $desafiante, int $rounds, bool $aprovada){
        $this->desafiado = $desafiado;
        $this->desafiante = $desafiante;
        $this->rounds = $rounds;
        $this->aprovada = $aprovada;
    }

    function getGanhador(){
        return $this->ganhador;
    }

    function getPontosDesafiado(){
        return $this->pontosDesafiado;
    }

    function getPontosDesafiante(){
        return $this->pontosDesafiante;
    }

    function getRounds(){
        return $this->rounds;
    }

    function marcarLuta() {

    }

    private function desafianteRoundWin(){
        $this->pontosDesafiante += 1;
    }

    private function desafiadoRoundWin(){
        $this->pontosDesafiado += 1;
    }

    private function drawRound(){
        $this->pontosDesafiante += 1;
        $this->pontosDesafiado += 1;
    }

    private function verifyWin(){
        if ($this->pontosDesafiado == $this->pontosDesafiante){
            $this->desafiado->empatarLuta();
            $this->desafiante->empatarLuta();

            $this->ganhador = "Empate";
        }else if ($this->pontosDesafiado > $this->pontosDesafiante){
            $this->desafiado->ganharLuta();
            $this->desafiante->perderLuta();

            $this->ganhador = $this->desafiado;
        }else{
            $this->desafiante->ganharLuta();
            $this->desafiado->perderLuta();
            
            $this->ganhador = $this->desafiante;
        }
    }

    private function verifyLuta($jogada_desafiado, $jogada_desafiante){
        $this->rounds -= 1;
        if ($jogada_desafiado == $jogada_desafiante){
            $this->drawRound();
        }else{
            if (
                ($jogada_desafiado == 'rock' && $jogada_desafiante == 'scissors') ||
                ($jogada_desafiado == 'paper' && $jogada_desafiante == 'rock') ||
                ($jogada_desafiado == 'scissors' && $jogada_desafiante == 'paper')
            ) {
               $this->desafiadoRoundWin();
            } else {
                $this->desafianteRoundWin();
            }
        }

        

        if ($this->rounds == 0){
            $this->verifyWin();


            if (gettype($this->ganhador) == 'object'){
                echo "<script>alert('" . $this->ganhador->getNome() . "')</script>";
            }else{
                echo "<script>alert('" . $this->ganhador . "')</script>";
            }
            

            unset($_SESSION['luta']);
            unset($_SESSION['jogadaDesafiante']);
            unset($_SESSION['jogadaDesafiado']);
        }

    }

    function lutar(){
        $game = Array(
            1 => 'rock',
            2 => 'paper',
            3 => 'scissors'
        );



        $jogada_desafiado = rand(1, 3);
        $jogada_desafiante = rand(1,3);

        $this->verifyLuta($game[$jogada_desafiado], $game[$jogada_desafiante]);

        return Array(
            0 => $game[$jogada_desafiado], 
            1 => $game[$jogada_desafiante]
        );
    }
}

function randImageAvatar(){
    $dir = 'img';
    $files = array_diff(scandir($dir), array('..', '.'));

    $imageFiles = preg_grep('/\.(jpg|png|jpeg)$/', $files);

    $imagemSorteada = $imageFiles[array_rand($imageFiles)];
    return $dir . '/' . $imagemSorteada;
}

function buscarLutadorPorId($id) {
    $jsonFile = 'lutadores.json';

    if (!file_exists($jsonFile)) {
        return null;
    }

    $jsonContent = file_get_contents($jsonFile);

    $lutadores = json_decode($jsonContent, true);

    foreach ($lutadores as $lutador) {
        if ($lutador['id'] === $id) {
            return new Lutador(
                $lutador['id'],
                $lutador['nome'],
                $lutador['nacionalidade'],
                $lutador['idade'],
                $lutador['altura'],
                $lutador['peso'],
                $lutador['categoria'],
                $lutador['vitorias'],
                $lutador['derrotas'],
                $lutador['empates']
            );
        }
    }

    return null;
}



if (isset($_GET['ids'])) {
    $lutadorIds = json_decode(urldecode($_GET['ids']), true);

    if (count($lutadorIds) === 2) {
        $lutador1 = buscarLutadorPorId($lutadorIds[0]);
        $lutador2 = buscarLutadorPorId($lutadorIds[1]);

        if (!isset($_SESSION['lutador1']) && !isset($_SESSION['lutador2'])){
            $_SESSION['lutador1'] = $lutador1;
            $_SESSION['lutador2'] = $lutador2;

        }

        
        if (isset($_SESSION['lutador1']) && isset($_SESSION['lutador2'])){
            if (!isset($_SESSION['luta'])){
                $luta = new Luta($_SESSION['lutador1'], $_SESSION['lutador2'], 5, true);
    
                $_SESSION['luta'] = $luta;
            }
            
            
        }

    } else { 
        echo "<script>alert('Por favor, selecione exatamente dois lutadores.'); window.location.href = 'index.php';</script>";

    }
}

if (isset($_POST['btn-fight'])){
    // ------------ //
    if (isset($_SESSION['luta'])){
        $round = $_SESSION['luta']->lutar();
        $_SESSION['jogadaDesafiante'] = $round[0];
        $_SESSION['jogadaDesafiado'] = $round[1];
    }
      
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <style>
        body {
            background-color: #2b2b2b;
        }

        .avatar {
            vertical-align: middle;
            width: 70px;
            height: 70px;
            border-radius: 50%;
        }

        .card {
            width: 190px;
            height: 254px;
            background-color: #1a1a1a;
            border: none;
            border-radius: 10px;
            position: relative;
            margin: auto;
            font-family: inherit;
        }

        .card span {
            font-weight: 600;
            color: white;
            text-align: center;
            display: block;
            padding-top: 10px;
            font-size: 1.3em;
        }

        .card .job {
            font-weight: 400;
            color: white;
            display: block;
            text-align: center;
            font-size: 1em;
        }

        .card .img {
            width: 70px;
            height: 70px;
            background: #e8e8e8;
            border-radius: 100%;
            margin: auto;
            margin-top: 20px;
        }

        .card button {
            padding: 8px 25px;
            display: block;
            margin: auto;
            border-radius: 8px;
            border: none;
            margin-top: 30px;
            background: #e8e8e8;
            color: #111111;
            font-weight: 600;
        }

        .card button:hover {
            background: #212121;
            color: #ffffff;
        }


        button {
            position: relative;
            width: 11em;
            height: 4em;
            outline: none;
            transition: 0.1s;
            background-color: transparent;
            border: none;
            font-size: 13px;
            font-weight: bold;
            color: #ddebf0;
            width: 50%;
            margin: 50px;
        }

        #clip {
            --color: #5c5c5c;
            position: absolute;
            top: 0;
            overflow: hidden;
            width: 100%;
            height: 100%;
            border: 5px double var(--color);
            box-shadow: inset 0px 0px 15px #9f9f9f;
            -webkit-clip-path: polygon(30% 0%, 70% 0%, 100% 30%, 100% 70%, 70% 100%, 30% 100%, 0% 70%, 0% 30%);
        }

        .arrow {
            position: absolute;
            transition: 0.2s;
            background-color: #2761c3;
            top: 35%;
            width: 11%;
            height: 30%;
        }

        #leftArrow {
            left: -13.5%;
            -webkit-clip-path: polygon(100% 0, 100% 100%, 0 50%);
        }

        #rightArrow {
            -webkit-clip-path: polygon(100% 49%, 0 0, 0 100%);
            left: 107%;
        }

        button:hover #rightArrow {
            background-color: #323232;
            left: -15%;
            animation: 0.6s ease-in-out both infinite alternate rightArrow8;
        }

        button:hover #leftArrow {
            background-color: #323232;
            left: 103%;
            animation: 0.6s ease-in-out both infinite alternate leftArrow8;
        }

        .corner {
            position: absolute;
            width: 4em;
            height: 4em;
            background-color: #5b5b5b;
            box-shadow: inset 1px 1px 8px #2d2d2d;
            transform: scale(1) rotate(45deg);
            transition: 0.2s;
        }

        #rightTop {
            top: -1.98em;
            left: 91%;
        }

        #leftTop {
            top: -1.96em;
            left: -3.0em;
        }

        #leftBottom {
            top: 2.10em;
            left: -2.15em;
        }

        #rightBottom {
            top: 45%;
            left: 88%;
        }

        button:hover #leftTop {
            animation: 0.1s ease-in-out 0.05s both changeColor8,
                0.2s linear 0.4s both lightEffect8;
        }

        button:hover #rightTop {
            animation: 0.1s ease-in-out 0.15s both changeColor8,
                0.2s linear 0.4s both lightEffect8;
        }

        button:hover #rightBottom {
            animation: 0.1s ease-in-out 0.25s both changeColor8,
                0.2s linear 0.4s both lightEffect8;
        }

        button:hover #leftBottom {
            animation: 0.1s ease-in-out 0.35s both changeColor8,
                0.2s linear 0.4s both lightEffect8;
        }

        button:hover .corner {
            transform: scale(1.25) rotate(45deg);
        }

        button:hover #clip {
            animation: 0.2s ease-in-out 0.55s both greenLight8;
            --color: #484848;
        }

        @keyframes changeColor8 {
            from {
                background-color: #444444;
            }

            to {
                background-color: #767676;
            }
        }

        @keyframes lightEffect8 {
            from {
                box-shadow: 1px 1px 5px #868686;
            }

            to {
                box-shadow: 0 0 2px #292929;
            }
        }

        @keyframes greenLight8 {
            from {}

            to {
                box-shadow: inset 0px 0px 32px #a5a5a5;
            }
        }

        @keyframes leftArrow8 {
            from {
                transform: translate(0px);
            }

            to {
                transform: translateX(10px);
            }
        }

        @keyframes rightArrow8 {
            from {
                transform: translate(0px);
            }

            to {
                transform: translateX(-10px);
            }
        }

        .container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);

            width: auto;
            padding: 15px;
        }



        #contador {
            margin-left: 50px;
            margin-right: 50px;
            color: #000000;
            text-align: center;
            font-weight: bold;
        }

        .countdown {
            margin-left: 50px;
            margin-right: 50px;
            display: inline-block;
            animation: countDown 1s ease-in-out;
        }

        @keyframes countDown {
            0% {
                opacity: 1;
                transform: scale(1);
            }

            100% {
                opacity: 0;
                transform: scale(2);
            }
        }

        .blockGame {
            border: 1px solid black;
            height: 100px;
            width: auto;
            margin-top: 20px;
        }
    </style>
    <title>Document</title>
</head>

<body>
    <h3 style="font-size: 25px;color: white;font-family: DejaVu Sans Mono, monospace; margin: 20px;">Pontos Desafiante: <?php if(isset($_SESSION['luta'])){echo $_SESSION['luta']->getPontosDesafiante();} ?> </h3>
    <h3 style="font-size: 25px;color: white;font-family: DejaVu Sans Mono, monospace; margin: 20px;">Pontos Desafiado: <?php if(isset($_SESSION['luta'])){echo $_SESSION['luta']->getPontosDesafiado();} ?> </h3>
    <div class="container" style="background-color: #4f4f4f; border: 1px solid black; margin: auto; padding: auto; z-index: -1;">
        <table>
            <tr>
                <th colspan="3"
                    style="font-size: 30px;font-family: DejaVu Sans Mono, monospace; text-align: center;color: rgb(255, 0, 0);">
                    Rounds:
                    <?php if(isset($_SESSION['luta'])){echo $_SESSION['luta']->getRounds();} ?>
                </th>
            </tr>
            <tr>
                <td>
                    <div class="fighter fighter1 card">
                        <div class="card-border-top">
                        </div>
                        <div class="img">
                            <img src="<?php echo randImageAvatar()?>" alt="Avatar" class="avatar">
                        </div>
                        <span>
                            <?php echo $_SESSION['lutador1']->getNome(); ?>
                        </span>
                        <p class="job">
                            <?php echo $_SESSION['lutador1']->getCategoria(); ?>
                        </p>
                        <p class="job">Vitorias:
                            <?php echo $_SESSION['lutador1']->getVitorias(); ?>
                        </p>
                        <p class="job">Derrotas:
                            <?php echo $_SESSION['lutador1']->getDerrotas(); ?>
                        </p>
                    </div>

                    <div class="blockGame">

                    <?php
                        if (isset($_SESSION['jogadaDesafiante'])){
                            echo '<img src="./img/hands/icon-' . $_SESSION['jogadaDesafiante'] . '.svg" alt="' . $_SESSION['jogadaDesafiante'] . '">';
                        }
                    ?>
                    </div>
                </td>
                <td>
                    <h1 id="contador" style="font-size: 100px;font-family: DejaVu Sans Mono, monospace; margin: 15px;">
                        vs</h1>
                    <span style="margin-left: 25px; margin-right: 250px;opacity: 0;" invisible="">.</span>
                </td>
                <td>
                    <div class="fighter fighter2 card">
                        <div class="card-border-top">
                        </div>
                        <div class="img">
                            <img src="<?php echo randImageAvatar()?>" alt="Avatar" class="avatar">
                        </div>
                        <span>
                            <?php echo $_SESSION['lutador2']->getNome(); ?>
                        </span>
                        <p class="job">
                            <?php echo $_SESSION['lutador2']->getCategoria(); ?>
                        </p>
                        <p class="job">Vitorias:
                            <?php echo $_SESSION['lutador2']->getVitorias(); ?>
                        </p>
                        <p class="job">Derrotas:
                            <?php echo $_SESSION['lutador2']->getDerrotas(); ?>
                        </p>
                    </div>
                    <div class="blockGame">
                        <?php
                            if (isset($_SESSION['jogadaDesafiado'])){
                                echo '<img src="./img/hands/icon-' . $_SESSION['jogadaDesafiado'] . '.svg" alt="' . $_SESSION['jogadaDesafiado'] . '">';
                            }
                        ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: center;">
                    <form method="post">
                        <input type="submit" name="btn-fight" value="Lutar" class="btn btn-primary"
                            style="padding: 15px; font-size: 25px;">
                    </form>
                </td>
            </tr>
        </table>
    </div>


    <script>
        function iniciarContagem() {
            var contador = 5;

            var intervalo = setInterval(function () {
                var contadorElement = document.getElementById('contador');
                contadorElement.innerHTML = `<span class="countdown">${contador}</span>`;

                if (contador === 0) {
                    clearInterval(intervalo);
                    contadorElement.innerText = '';
                } else {
                    contador--;
                }
            }, 1000);
        }
    </script>

</body>

</html>
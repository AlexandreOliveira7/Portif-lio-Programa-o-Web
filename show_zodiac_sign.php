<html lang="pt-br">
<?php include('layouts/header.php'); ?>  
    <body>
        <?php
            $data_nascimento = $_POST['data_nascimento'];
            $signos = simplexml_load_file("signos.xml");

            function criarDataCompleta($data, $ano) {
                $data_str = (string)$data;
                return DateTime::createFromFormat('d/m/Y', $data_str . '/' . $ano);
            }

            $signo_encontrado = null;
            $data_nascimento = new DateTime($data_nascimento);

            foreach ($signos->signo as $signo) {
                $data_inicio = criarDataCompleta($signo->dataInicio, $data_nascimento->format('Y'));
                $data_fim = criarDataCompleta($signo->dataFim, $data_nascimento->format('Y'));

                if ($data_nascimento >= $data_inicio && $data_nascimento <= $data_fim) {
                    $signo_encontrado = $signo->signoNome;
                    $descricao_signo = $signo->descricao;
                    break;
                }
            }

            if (!$signo_encontrado) {
                $data_inicio = criarDataCompleta($signos->signo[0]->dataInicio, $data_nascimento->format('Y') + 1);
                $data_fim = criarDataCompleta($signos->signo[0]->dataFim, $data_nascimento->format('Y') + 1);
                if ($data_nascimento >= $data_inicio && $data_nascimento <= $data_fim) {
                    $signo_encontrado = $signos->signo[0]->signoNome;
                    $descricao_signo = $signos->signo[0]->descricao;
                }
            }
        ?>

        <div class="container mt-5">
            <h1>Seu Signo é: <?php echo $signo_encontrado; ?></h1>
            <p><?php echo $descricao_signo; ?></p>
        </div>
    </body>
</html>
<?php

class NumerologiaCalculos
{
    public static function somarAlgarismos($numero)
    {
        return array_sum(str_split($numero));
    }
    public static function reduzirNumeroSimples($numero)
    {
        while ($numero > 9) {
            $numero = self::somarAlgarismos($numero);
        }
        return $numero;
    }
    public static function reduzirNumeroSimplesAteOito($numero)
    {
        while ($numero > 9) {
            $numero = self::somarAlgarismos($numero);
        }
        return $numero;
    }
    public static function reduzirNumeroMestre($numero)
    {
        while ($numero > 9 && !in_array($numero, [11, 22])) {
            $numero = self::somarAlgarismos($numero);
        }
        return $numero;
    }
    public static function reduzirTeosoficamente($numero)
    {
        while ($numero > 9 && $numero != 11 && $numero != 22) {
            $numero = array_sum(str_split($numero));
        }
        return $numero;
    }
    public static function reduzirTeosoficamenteAte11($numero)
    {
        while ($numero > 9 && $numero != 11 ) {
            $numero = array_sum(str_split($numero));
        }
        return $numero;
    }
    public static function calcularSomaLetras($nome, $tabela)
    {
        $soma = 0;
        foreach (str_split($nome) as $letra) {
            if (isset($tabela[$letra])) {
                $soma += $tabela[$letra];
            }
        }
        return self::reduzirNumeroMestre($soma);
    }
    public static function calcularSomaLetrasSemReduzir($nome, $tabela)
    {
        $soma = 0;
        foreach (str_split($nome) as $letra) {
            if (isset($tabela[$letra])) {
                $soma += $tabela[$letra];
            }
        }
        return $soma;
    }
    public static function separarNomeCompleto($nomeCompleto) {
        // Remove espaços em excesso no início e no fim do nome e converte para minúsculas
        $nomeCompleto = trim(strtolower($nomeCompleto));

        // Separa o nome em partes, considerando espaços como delimitadores
        $partesNome = explode(' ', $nomeCompleto);

        // Filtra partes vazias que podem resultar de espaços extras ou múltiplos
        $partesNome = array_filter($partesNome, function($parte) {
            return !empty(trim($parte));
        });

        // Reindexa o array para garantir que os índices sejam contínuos
        return array_values($partesNome);
    }
    public static function nomeMesParaNumero($nomeMes)
    {
        $meses = [
            'Jan' => '01',
            'Fev' => '02',
            'Mar' => '03',
            'Abr' => '04',
            'Mai' => '05',
            'Jun' => '06',
            'Jul' => '07',
            'Ago' => '08',
            'Set' => '09',
            'Out' => '10',
            'Nov' => '11',
            'Dez' => '12'
        ];
        return $meses[$nomeMes];
    }
    public static function converterNomeRua($nomeRua, $alfabeto) {
        $soma = self::calcularSomaLetras($nomeRua, $alfabeto);
        return self::reduzirTeosoficamente($soma);
    }
    public static function calcularEndereco($numeroCasa, $nomeRua, $alfabeto, $numeroApto = null) {

        $somaRua = self::converterNomeRua($nomeRua, $alfabeto);
        $somaNumeroCasa = self::reduzirTeosoficamente($numeroCasa);

        if ($numeroApto) {
            $somaNumeroApto = self::reduzirTeosoficamente($numeroApto);
            $resultadoFinal = $somaRua + $somaNumeroCasa + $somaNumeroApto;
        } else {
            $resultadoFinal = $somaRua + $somaNumeroCasa;
        }
        return self::reduzirTeosoficamente($resultadoFinal);
    }
    public static function calcularNumeroCasa($numeroCasa) {
        $soma = self::somarAlgarismos($numeroCasa);
        return self::reduzirTeosoficamente($soma);
    }
    public static function calcularPlaca($placa, $alfabeto)
    {
        $soma = 0;

        // Iterar sobre cada caractere da placa
        for ($i = 0; $i < strlen($placa); $i++) {
            $char = $placa[$i];

            // Se for uma letra, buscar o valor na tabela
            if (isset($alfabeto[$char])) {
                $soma += $alfabeto[$char];
            } elseif (is_numeric($char)) {
                // Se for um número, somar diretamente
                $soma += (int)$char;
            }
        }
        // Aplicar a redução teosófica
        return self::reduzirTeosoficamente($soma);
    }
    public static function calcularTelefone($telefone) {
        $soma = 0;

        // Remover todos os caracteres não numéricos
        $telefone = preg_replace('/\D/', '', $telefone);

        // Remover o DDD (considerando os primeiros 2 ou 3 dígitos)
        if (strlen($telefone) > 8) {
            $telefone = substr($telefone, -8); // Pega apenas os últimos 8 dígitos
        }

        // Iterar sobre cada caractere do telefone
        for ($i = 0; $i < strlen($telefone); $i++) {
            $char = $telefone[$i];

            // Somente processar números
            if (is_numeric($char)) {
                $soma += (int)$char;
            }
        }

        // Aplicar a redução teosófica
        return self::reduzirTeosoficamente($soma);
    }
    public static function calcularAnoPessoal($dataNascimento)
    {
        $anoAtual = intval(date('Y'));
        $diaNascimento = (int)date('d', strtotime($dataNascimento));
        $mesNascimento = (int)date('m', strtotime($dataNascimento));

        // Reduzindo os valores para dígitos únicos
        $diaNascimento = self::reduzirNumeroSimples($diaNascimento);
        $mesNascimento = self::reduzirNumeroSimples($mesNascimento);

        // Verificando se o aniversário já passou neste ano
        $aniversarioEsteAno = new DateTime("$anoAtual-$mesNascimento-$diaNascimento");
        $hoje = new DateTime();

        // Se o aniversário ainda não passou, usamos o ano anterior
//      $anoUso = $hoje < $aniversarioEsteAno ? $anoAtual : $anoAtual - 1;
        $anoUso = $hoje < $aniversarioEsteAno ? $anoAtual - 1 : $anoAtual;
        $anoUso = self::reduzirTeosoficamente($anoUso);

        // Calculando a soma e a redução final
        $soma = $diaNascimento + $mesNascimento + $anoUso;
        return self::reduzirNumeroSimples($soma);
    }
    public static function mesPessoalCalc($anoPessoal)
    {
        $mes = date('m');
        $mesPessoal = $anoPessoal + intval($mes);

        return self::reduzirTeosoficamenteAte11($mesPessoal);
    }
    public static function calcularDiaPessoal($mesPessoal)
    {
        $hoje = intval(date('d'));
        $diaPessoal = $hoje + intval($mesPessoal);

        return self::reduzirNumeroMestre($diaPessoal);
    }
    public static function calcularNumeroDestino($dataNascimento)
    {

        $dia = self::reduzirNumeroMestre((int)date('d', strtotime($dataNascimento)));
        $mes = self::reduzirNumeroMestre((int)date('m', strtotime($dataNascimento)));
        $ano = self::reduzirNumeroMestre((int)date('Y', strtotime($dataNascimento)));

        $sem_reducao = $dia + $mes + $ano;

        return self::reduzirNumeroMestre($sem_reducao);
    }
//    public static function calcularLicoesCarmicas($nome, $tabela)
//    {
//
//        $contagemNumeros = array_fill(1, 9, 0);
//
//        foreach (str_split(strtolower($nome)) as $letra) {
//            if (isset($tabela[$letra])) {
//                $contagemNumeros[$tabela[$letra]]++;
//            }
//        }
//        $licoes =  array_keys(array_filter($contagemNumeros, fn($count) => $count == 0));
//
//        return !empty($licoes) ? implode(', ', $licoes) : 'Sem Lições Cármicas';
//    }
//    public static function calcularLicoesCarmicas($nome, $tabela)
//    {
//        // Converte o nome para minúsculas (mantém compatibilidade com acentos)
//        $nome = mb_strtolower($nome, 'UTF-8');
//
//        // Inicializa a contagem dos números de 1 a 9
//        $frequencias = array_fill(1, 9, 0);
//
//        // Percorre cada caractere do nome
//        foreach (mb_str_split($nome) as $letra) {
//            if (isset($tabela[$letra])) {
//                var_dump($letra);
//                $numero = $tabela[$letra];
//                $frequencias[$numero]++;
//            }
//        }
//
//        // Identifica os números ausentes (Lições Cármicas)
//        $licoesCarmicas = [];
//        foreach ($frequencias as $numero => $quantidade) {
//            if ($quantidade === 0) {
//                $licoesCarmicas[] = $numero;
//            }
//        }
//        return !empty($licoesCarmicas)
//            ? $licoesCarmicas
//            : ['Sem Lições Cármicas'];
//    }
    public static function calcularLicoesCarmicas($nome, $tabela)
    {
        // Contagem das ocorrências dos números (1 a 9)
        $frequencias = array_fill(1, 9, 0);

        // Remover espaços antes de processar as letras
        $nome = str_replace(' ', '', $nome);

        // Contar as frequências das letras
        foreach (str_split($nome) as $letra) {
            if (isset($tabela[$letra])) {
                $numero = $tabela[$letra];
                $frequencias[$numero]++;
            }
        }

        // Identificar os números ausentes (Lições Cármicas)
        $licoesCarmicas = [];
        for ($i = 1; $i <= 9; $i++) {  // De 1 a 9
            if ($frequencias[$i] === 0) {
                $licoesCarmicas[] = $i;  // Adicionar todas as lições ausentes
            }
        }

        // Retornar as lições cármicas ou mensagem informando que não há
        return !empty($licoesCarmicas) ? $licoesCarmicas : ['Sem Lições Cármicas'];
    }

    public static function calcularCiclos($dataNascimento, $licoesCarmicas)
    {
        $dia = (int)date('d', strtotime($dataNascimento));
        $mes = (int)date('m', strtotime($dataNascimento));
        $ano = (int)date('Y', strtotime($dataNascimento));

        $primeiroCiclo = ($mes != 11) ? self::reduzirNumeroSimples($mes) : $mes;
        $numeroDestino = self::calcularNumeroDestino($dataNascimento);
        $anoInicioPrimeiroCiclo = $ano;
        $anoFimPrimeiroCiclo = $anoInicioPrimeiroCiclo + (37 - $numeroDestino);
        $dataInicioPrimeiroCiclo = "{$dia}/{$mes}/{$anoInicioPrimeiroCiclo}";
        $dataFimPrimeiroCiclo = "{$dia}-{$mes}-{$anoFimPrimeiroCiclo}";

        $segundoCiclo = ($dia != 11 && $dia != 22) ? self::reduzirNumeroSimples($dia) : $dia;
        $anoInicioSegundoCiclo = $anoFimPrimeiroCiclo;
        $anoFimSegundoCiclo = $anoInicioSegundoCiclo + 27;
        $dataInicioSegundoCiclo = "{$dia}/{$mes}/{$anoInicioSegundoCiclo}";
        $dataFimSegundoCiclo = "{$dia}-{$mes}-{$anoFimSegundoCiclo}";

        $terceiroCiclo = ($ano != 11 && $ano != 22) ? self::reduzirNumeroSimples($ano) : $ano;
        $anoInicioTerceiroCiclo = $anoFimSegundoCiclo;
        $dataInicioTerceiroCiclo = "{$dia}/{$mes}/{$anoInicioTerceiroCiclo}";

        //$idade_primeiro_periodo = $dataNascimento - $$dataFimPrimeiroCiclo;

        $ciclos = [
            'ciclo_1' => [
                'ciclo' => 'Ciclo 1',
                'numero' => $primeiroCiclo,
                'periodo' => "{$dataInicioPrimeiroCiclo} a {$dataFimPrimeiroCiclo}"
            ],
            'ciclo_2' => [
                'ciclo' => 'Ciclo 2',
                'numero' => $segundoCiclo,
                'periodo' => "{$dataInicioSegundoCiclo} a {$dataFimSegundoCiclo}"
            ],
            'ciclo_3' => [
                'ciclo' => 'Ciclo 3',
                'numero' => $terceiroCiclo,
                'periodo' => "{$dataInicioTerceiroCiclo} até o fim da vida"
            ]
        ];

        $alertas = [];
        foreach ($ciclos as $nomeCiclo => $ciclo) {
            if (in_array($ciclo['numero'], $licoesCarmicas)) {
                $alertas[] = "Alerta: O {$ciclo['ciclo']} (numero: {$ciclo['numero']}) coincide com uma Lição Cármica. Este período pode ser conturbado.";
            }
        }

        return [
            'ciclos' => $ciclos,
            'alertas' => $alertas,
            'fim_primeiro_ciclo' => $dataFimPrimeiroCiclo
        ];
    }
    public static function coresFavoraveis($nomeCompleto, $alfabeto, $cores)
    {
        $numeroExpressao = NumerologiaCalculos::calcularNumeroExpressao($nomeCompleto, $alfabeto);

        return isset($cores[$numeroExpressao])
            ? 'Cores favoráveis: ' . implode(', ', $cores[$numeroExpressao])
            : 'Nenhuma cor favorável encontrada para este número de Expressão';
    }
    public static function grauAscensao($nomeCompleto)
    {
        $consoantes = NumerologiaDados::obterConsoantes();
        $vogais = NumerologiaDados::obterVogais();
        $numeroConsoante = self::calcularSomaLetrasSemReduzir($nomeCompleto, $consoantes); // provável que não terá redução teosofica
        $numeroVogal = self::calcularSomaLetrasSemReduzir($nomeCompleto, $vogais); // provável que não terá redução teosofica
        if ($numeroVogal == $numeroConsoante) {
            return "Espírito Elevado"; // ok
        } elseif ($numeroVogal > $numeroConsoante) {
            return "Espírito Rebaixado";
        } elseif ($numeroVogal < $numeroConsoante) {
            return "Espírito em Ascensão";
        }
    }
    public static function numerosHarmonicos($dataNascimento, $numerosHarmonicosTabela)
    {
        // Extrair o dia da data de nascimento
        $dia = date('d', strtotime($dataNascimento));

        // Realizar a redução teosófica do dia
        $reduzido = array_sum(str_split($dia));
        while ($reduzido > 9) {
            $reduzido = array_sum(str_split($reduzido));
        }

        // Obter o conjunto de números harmônicos baseado no resultado reduzido
        $numerosResultantes = $numerosHarmonicosTabela[$reduzido];

        // Retornar o resultado
        return $numerosResultantes;
    }
    public static function obterDiasFavoraveis($dataNascimento, $tabelaNumerosFavoraveis, $meses)
    {
        $diaNascimento = (int)date('d', strtotime($dataNascimento));
        $mesNascimento = (int)date('m', strtotime($dataNascimento));

        $mesStr = $meses[$mesNascimento - 1];

        $numerosBasicos = $tabelaNumerosFavoraveis[$mesStr][$diaNascimento] ?? [];
        if (empty($numerosBasicos)) {
            return [];
        }

        $sequencia = $numerosBasicos;
        for ($i = 2; $i < 10; $i++) {
            $novoNumero = $sequencia[$i - 1] + ($i % 2 == 0 ? $numerosBasicos[1] : $numerosBasicos[0]);
            if ($novoNumero <= 31) {
                $sequencia[] = $novoNumero;
            } else {
                break;
            }
        }


        return !empty($sequencia) ? implode(', ', $sequencia) : '';
    }
    public static function calcularNumeroImpressao($nome, $consoantes)
    {
        return self::calcularSomaLetras($nome, $consoantes);
    }
    public static function calcularNumeroExpressao($nomeCompleto, $tabela)
    {
        return self::calcularSomaLetras($nomeCompleto, $tabela);
    }
    public static function calcularNumeroMotivacao($nome, $vogais)
    {
        return self::calcularSomaLetras($nome, $vogais);
    }
    public static function calcularNumeroMissao($numeroDestino, $numeroExpressao)
    {
        $soma = $numeroDestino + $numeroExpressao;
        return self::reduzirNumeroMestre($soma);
    }
    public static function calculoDividasCarmicas($nomeCompleto, $dataNascimento, $tabela)
    {
        $diaNascimento = (int)date('d', strtotime($dataNascimento));
        $dividaCarmica = in_array($diaNascimento, [13, 14, 16, 19]) ? [$diaNascimento] : [];

        $numeroDestino = self::calcularNumeroDestino($dataNascimento);
        $numeroMotivacao = self::calcularSomaLetras(preg_replace('/[^aeiouAEIOUY]/', '', $nomeCompleto), $tabela);
        $numeroExpressao = self::calcularNumeroExpressao($nomeCompleto, $tabela);

        $mapaDividas = [
            4 => 13,
            5 => 14,
            7 => 16,
            1 => 19
        ];

        foreach ([$numeroDestino, $numeroMotivacao, $numeroExpressao] as $numero) {
            if (isset($mapaDividas[$numero])) {
                $dividaCarmica[] = $mapaDividas[$numero];
            }
        }

        $dividaCarmica = array_unique($dividaCarmica);
        sort($dividaCarmica);

        return !empty($dividaCarmica) ? implode(', ', $dividaCarmica) : 'Sem Dívida Cármica';
    }
    public static function calcularTendenciaOculta($nome, $tabela)
    {
        // Remover espaços e caracteres não alfabéticos
        $nome = preg_replace('/[^a-zA-Z]/', '', $nome);

        // Contagem de frequências dos números
        $frequencias = [];
        foreach (str_split($nome) as $letra) {
            if (isset($tabela[$letra])) {
                $numero = self::reduzirNumeroSimples($tabela[$letra]);
                if (isset($frequencias[$numero])) {
                    $frequencias[$numero]++;
                } else {
                    $frequencias[$numero] = 1;
                }
            }
        }

        // Identificar tendências ocultas
        $tendenciasOcultas = [];
        foreach ($frequencias as $numero => $contagem) {
            if ($contagem > 3) {
                $tendenciasOcultas[] = $numero;
            }
        }

        // Ordenar as tendências ocultas em ordem numérica
        sort($tendenciasOcultas);

        // Retornar tendências ocultas
        return !empty($tendenciasOcultas) ? implode(', ', $tendenciasOcultas) : '$tendenciasOcultas';
    }
    public static function calcularRespostaSubconsciente($nome, $tabela)
    {
        $nome = preg_replace('/[^a-zA-Z]/', '', $nome);
        $numeros = [];

        foreach (str_split($nome) as $letra) {
            if (isset($tabela[$letra])) {
                $numeros[] = $tabela[$letra];
            }
        }

        return count(array_unique($numeros));
    }
    public static function relacoesIntervalores($nomeCompleto, $tabela)
    {
        $primeiroNome = explode(' ', trim($nomeCompleto))[0];
        $primeiroNome = strtolower($primeiroNome);

        $numeros = [];
        foreach (str_split($primeiroNome) as $letra) {
            if (isset($tabela[$letra])) {
                $numeros[] = $tabela[$letra];
            }
        }

        $contagemNumeros = array_count_values($numeros);
        $grupos = array_filter($contagemNumeros, fn($contagem) => $contagem > 1);

        return count($grupos) === 1 ? array_key_first($grupos) : "Nenhuma relação intervalor";
    }
    public static function calcularNumeroPsiquico($dataNascimento)
    {
        $diaNascimento = (int)date('d', strtotime($dataNascimento));
        return self::reduzirNumeroSimples($diaNascimento);
    }
    public static function talentoOculto($motivacao, $numeroDeExpressao)
    {
        $talentoOculto = self::reduzirNumeroMestre($motivacao + $numeroDeExpressao);

        if (in_array($talentoOculto, [10, 11])) {
            return $talentoOculto;
        }

        return self::reduzirNumeroMestre($talentoOculto);
    }
    public static function momentosDecisivos($dataNascimento, $dataFimPrimeiroCiclo)
    {
        $dataFimPrimeiroCiclo = (int)date('Y', strtotime($dataFimPrimeiroCiclo));
        $diaNascimento = (int)date('d', strtotime($dataNascimento));
        $mesNascimento = (int)date('m', strtotime($dataNascimento));
        $anoNascimento = (int)date('Y', strtotime($dataNascimento));

        $diaReduzido = self::reduzirTeosoficamente($diaNascimento);
        $mesReduzido = self::reduzirTeosoficamente($mesNascimento);
        $anoReduzido = self::reduzirTeosoficamente($anoNascimento);

        $primeiroMomento = $diaReduzido + $mesReduzido;
        $segundoMomento = $diaReduzido + $anoReduzido;
        $terceiroMomento = $primeiroMomento + $segundoMomento;
        $quartoMomento = $mesReduzido + $anoReduzido;

        $primeiroMomento = self::reduzirTeosoficamente($primeiroMomento);
        $segundoMomento = self::reduzirTeosoficamente($segundoMomento);
        $terceiroMomento = self::reduzirTeosoficamente($terceiroMomento);
        $quartoMomento = self::reduzirTeosoficamente($quartoMomento);
        return [
            "primeiroMomento" => $primeiroMomento,
            "momentoInicial1" => $anoNascimento,
            "momentoFinal1" => $dataFimPrimeiroCiclo,

            "segundoMomento" => $segundoMomento,
            "momentoInicial2" => $dataFimPrimeiroCiclo,
            "momentoFinal2" => $dataFimPrimeiroCiclo + 9,

            "terceiroMomento" => $terceiroMomento,
            "momentoInicial3" => $dataFimPrimeiroCiclo + 9,
            "momentoFinal3" => $dataFimPrimeiroCiclo + 18,

            "quartoMomento" => $quartoMomento,
            "momentoInicial4" => $dataFimPrimeiroCiclo + 18,
            "momentoFinal4" => "até o fim da vida"
        ];
    }
    public static function calcularNumeroAmor($numero_destino, $numero_expressao, $tabelaNumeros)
    {

        $soma = $numero_destino + $numero_expressao;
        $numero_amor = self::reduzirNumeroSimples($soma);
        if (isset($tabelaNumeros[$numero_amor])) {
            return $tabelaNumeros[$numero_amor];
        }
        return $tabelaNumeros[$numero_amor];
    }
    public static function calcularArcanos($nomeCompleto, $dataNascimento, $alfabeto)
    {
        // Converter o nome completo em números usando a tabela
        $numeros = [];
        $nomeArray = preg_split('//u', $nomeCompleto, -1, PREG_SPLIT_NO_EMPTY);

        foreach ($nomeArray as $letra) {
            if (isset($alfabeto[$letra])) {
                $numeros[] = $alfabeto[$letra];
            }
        }

        // Calcular os arcanos
        $arcanos = [];
        for ($i = 0; $i < count($numeros) - 1; $i++) {
            $arcano = $numeros[$i] * 10 + $numeros[$i + 1];
            $arcanos[] = $arcano;
        }

        // Calcular a duração de cada Arcano
        $numArcanos = count($arcanos);
        if ($numArcanos > 0) {
            $duracaoArcanoTotal = 90 / $numArcanos;
        } else {
            // Defina um valor padrão ou lance uma exceção
            error_log('Número de arcanos inválido: 0');
            $duracaoArcanoTotal = 0; // Ou um valor padrão
        }
        $anosPorArcano = floor($duracaoArcanoTotal);
        $mesesDecimais = ($duracaoArcanoTotal - $anosPorArcano) * 12;
        $mesesPorArcano = floor($mesesDecimais);
        $diasPorArcano = (int)(($mesesDecimais - $mesesPorArcano) * 30);

        // Definir a data inicial para cálculo de arcanos
        $inicioArcano = new DateTime($dataNascimento);
        $arcanosDetalhados = [];

        foreach ($arcanos as $index => $arcano) {
            // Calcular a data de fim do arcano, ajustando os dias a partir do segundo período
            $fimArcano = clone $inicioArcano;
            $diasAjustados = $index > 0 ? $diasPorArcano - 1 : $diasPorArcano;
            $diasAjustados = abs($diasAjustados); // Garantir que o número de dias seja positivo
            $fimArcano->add(new DateInterval("P{$anosPorArcano}Y{$mesesPorArcano}M{$diasAjustados}D"));

            // Calcular a idade da pessoa no início e fim do arcano
            $idadeInicio = $inicioArcano->diff(new DateTime($dataNascimento));
            $idadeFim = $fimArcano->diff(new DateTime($dataNascimento));

            // Adicionar o arcano com suas informações detalhadas
            $arcanosDetalhados[] = [
                'arcano' => $arcano,
                'inicio' => $inicioArcano->format('d-m-Y'),
                'fim' => $fimArcano->format('d-m-Y'),
                'idadeInicio' => "{$idadeInicio->y} anos, {$idadeInicio->m} meses e {$idadeInicio->d} dias",
                'idadeFim' => "{$idadeFim->y} anos, {$idadeFim->m} meses e {$idadeFim->d} dias",
            ];

            // Atualizar o início para o próximo arcano (exatamente um dia após o fim do arcano atual)
            $inicioArcano = clone $fimArcano;
            $inicioArcano->add(new DateInterval("P1D"));
        }

        return [
            'arcanos' => $arcanosDetalhados,
            'anosPorArcano' => $anosPorArcano,
            'mesesPorArcano' => $mesesPorArcano,
            'diasPorArcano' => $diasPorArcano,
        ];
    }
    public static function getArcanoAtual($arcanos) {
        $atual = date('d-m-Y'); // Pega a data atual
        $arcanoAtual = null;

        // Percorre o array de arcanos para encontrar o ciclo atual
        foreach ($arcanos as $arcano) {
            $inicio = DateTime::createFromFormat('d-m-Y', $arcano['inicio']);
            $fim = DateTime::createFromFormat('d-m-Y', $arcano['fim']);
            $dataAtual = DateTime::createFromFormat('d-m-Y', $atual);

            // Verifica se a data atual está dentro do ciclo
            if ($dataAtual >= $inicio && $dataAtual <= $fim) {
                $arcanoAtual = $arcano;
                break; // Para o loop assim que encontrar o arcano atual
            }
        }

        return $arcanoAtual;
    }
    public static function calcularArcanoVida($nomeCompleto, $dataNascimento, $tabelaBase)
    {
        $diaNascimento = (int)date('d', strtotime($dataNascimento));

        $diaReducao = array_sum(str_split($diaNascimento)); // Reduzir o dia
        if ($diaReducao >= 10) {
            $diaReducao = array_sum(str_split($diaReducao));
        }

        // Criar uma nova tabela deslocada de acordo com a redução do dia
        $tabelaDeslocada = [];
        $tamanhoTabela = count($tabelaBase);

        foreach ($tabelaBase as $posicao => $letras) {
            $novaPosicao = ($posicao + $diaReducao - 1) % $tamanhoTabela + 1;
            $tabelaDeslocada[$novaPosicao] = $letras;
        }

        // Variáveis para soma e sequência
        $soma = 0;
        $sequencia = "";

        // Convertendo o nome para um array de caracteres considerando codificação UTF-8
        $nomeArray = preg_split('//u', $nomeCompleto, -1, PREG_SPLIT_NO_EMPTY);

        // Definição dos símbolos especiais utilizando seus códigos UTF-8
        $simbolosEspeciais1 = ["\xC2\xA8", "\x60", "\xC2\xB4", "\x27"]; // Trema, Crase, Agudo, Apóstrofo
        $simbolosEspeciais2 = ["\xC2\xB0", "\x5E"]; // Grau e Circunferência
        $simbolosEspeciais3 = ["\x7E"]; // Til

        // Iterar sobre cada letra do nome
        for ($i = 0; $i < count($nomeArray); $i++) {
            $letra = $nomeArray[$i];
            $valorLetra = 0;

            // Procurar o valor da letra na tabela deslocada
            foreach ($tabelaDeslocada as $numero => $letras) {
                if (in_array($letra, $letras)) {
                    $valorLetra = $numero;
                    break;
                }
            }

            // Verificar se há símbolos especiais à esquerda da letra atual
            if ($i > 0) {
                $simboloAnterior = $nomeArray[$i - 1];

                // Verificar presença de símbolos do grupo 1
                if (in_array($simboloAnterior, $simbolosEspeciais1)) {
                    $valorLetra += 2;
                }

                // Verificar presença de símbolos do grupo 2
                if (in_array($simboloAnterior, $simbolosEspeciais2)) {
                    $valorLetra += 7;
                }

                // Verificar presença de símbolos do grupo 3
                if (in_array($simboloAnterior, $simbolosEspeciais3)) {
                    $valorLetra += 3;
                }

                // Aplicar redução teosófica se o valor da letra modificada for maior que 9
                while ($valorLetra > 9) {
                    $valorLetra = array_sum(str_split($valorLetra));
                }
            }

            // Atualizar a soma total e a sequência de valores
            $soma += $valorLetra;
            $sequencia .= $valorLetra > 0 ? $valorLetra : '';
        }

        // Reduzir a soma a um único dígito ou número mestre
        while ($soma > 9 && $soma != 11 && $soma != 22) {
            $soma = array_sum(str_split($soma));
        }

        // Converter o nome completo em números usando a tabela deslocada
        $numeros = [];
        foreach ($nomeArray as $letra) {
            foreach ($tabelaDeslocada as $numero => $letras) {
                if (in_array($letra, $letras)) {
                    $numeros[] = $numero;
                    break;
                }
            }
        }

        // Gerar a sequência de Arcanos
        $arcanos = [];
        for ($i = 0; $i < count($numeros) - 1; $i++) {
            $arcano = $numeros[$i] * 10 + $numeros[$i + 1];
            $arcanos[] = $arcano;
        }

        // Calcular a duração de cada Arcano
        $numArcanos = count($arcanos);
        $duracaoArcanoTotal = ($numArcanos > 0) ? 90 / $numArcanos : null;
        $anosPorArcano = floor($duracaoArcanoTotal);
        $mesesPorArcano = ($duracaoArcanoTotal - $anosPorArcano) * 12;
        $mesesPorArcano = (int)$mesesPorArcano;

        // Definir a data inicial
        $inicioArcano = new DateTime($dataNascimento);
        $arcanosDetalhados = [];

        for ($i = 0; $i < count($arcanos); $i++) {
            // Calcular a data de fim do arcano
            $fimArcano = clone $inicioArcano;
            $fimArcano->add(new DateInterval("P{$anosPorArcano}Y{$mesesPorArcano}M"));

            // Calcular a idade da pessoa no início e fim do arcano
            $idadeInicio = $inicioArcano->diff(new DateTime($dataNascimento));
            $idadeFim = $fimArcano->diff(new DateTime($dataNascimento));

            // Adicionar o arcano com suas informações detalhadas
            $arcanosDetalhados[] = [
                'arcano' => $arcanos[$i],
                'inicio' => $inicioArcano->format('d-m-Y'),
                'fim' => $fimArcano->format('d-m-Y'),
                'idadeInicio' => "{$idadeInicio->y} anos e {$idadeInicio->m} meses",
                'idadeFim' => "{$idadeFim->y} anos e {$idadeFim->m} meses"
            ];

            // Atualizar o início para o próximo arcano
            $inicioArcano = clone $fimArcano;
        }

        return  $arcanosDetalhados;
        //
    }
    public static function calcularArcanoPessoal($nomeCompleto, $dataNascimento, $tabelaBase)
    {
        $diaNascimento = (int)date('d', strtotime($dataNascimento));

        $diaReducao = array_sum(str_split($diaNascimento)); // Reduzir o dia
        if ($diaReducao >= 10) {
            $diaReducao = array_sum(str_split($diaReducao));
        }

        // Criar uma nova tabela deslocada de acordo com a redução do dia
        $tabelaDeslocada = [];
        $tamanhoTabela = count($tabelaBase);

        foreach ($tabelaBase as $posicao => $letras) {
            $novaPosicao = ($posicao + $diaReducao - 1) % $tamanhoTabela + 1;
            $tabelaDeslocada[$novaPosicao] = $letras;
        }

        // Variáveis para soma e sequência
        $soma = 0;
        $sequencia = "";

        // Convertendo o nome para um array de caracteres considerando codificação UTF-8
        $nomeArray = preg_split('//u', $nomeCompleto, -1, PREG_SPLIT_NO_EMPTY);

        // Definição dos símbolos especiais utilizando seus códigos UTF-8
        $simbolosEspeciais1 = ["\xC2\xA8", "\x60", "\xC2\xB4", "\x27"]; // Trema, Crase, Agudo, Apóstrofo
        $simbolosEspeciais2 = ["\xC2\xB0", "\x5E"]; // Grau e Circunferência
        $simbolosEspeciais3 = ["\x7E"]; // Til

        // Iterar sobre cada letra do nome
        for ($i = 0; $i < count($nomeArray); $i++) {
            $letra = $nomeArray[$i];
            $valorLetra = 0;

            // Procurar o valor da letra na tabela deslocada
            foreach ($tabelaDeslocada as $numero => $letras) {
                if (in_array($letra, $letras)) {
                    $valorLetra = $numero;
                    break;
                }
            }

            // Verificar se há símbolos especiais à esquerda da letra atual
            if ($i > 0) {
                $simboloAnterior = $nomeArray[$i - 1];

                // Verificar presença de símbolos do grupo 1
                if (in_array($simboloAnterior, $simbolosEspeciais1)) {
                    $valorLetra += 2;
                }

                // Verificar presença de símbolos do grupo 2
                if (in_array($simboloAnterior, $simbolosEspeciais2)) {
                    $valorLetra += 7;
                }

                // Verificar presença de símbolos do grupo 3
                if (in_array($simboloAnterior, $simbolosEspeciais3)) {
                    $valorLetra += 3;
                }

                // Aplicar redução teosófica se o valor da letra modificada for maior que 9
                while ($valorLetra > 9) {
                    $valorLetra = array_sum(str_split($valorLetra));
                }
            }

            // Atualizar a soma total e a sequência de valores
            $soma += $valorLetra;
            $sequencia .= $valorLetra > 0 ? $valorLetra : '';
        }

        // Reduzir a soma a um único dígito ou número mestre
        while ($soma > 9 && $soma != 11 && $soma != 22) {
            $soma = array_sum(str_split($soma));
        }

        // Converter o nome completo em números usando a tabela deslocada
        $numeros = [];
        foreach ($nomeArray as $letra) {
            foreach ($tabelaDeslocada as $numero => $letras) {
                if (in_array($letra, $letras)) {
                    $numeros[] = $numero;
                    break;
                }
            }
        }

        // Gerar a sequência de Arcanos
        $arcanos = [];
        for ($i = 0; $i < count($numeros) - 1; $i++) {
            $arcano = $numeros[$i] * 10 + $numeros[$i + 1];
            $arcanos[] = $arcano;
        }

        // Calcular a duração de cada Arcano
        $numArcanos = count($arcanos);
        $duracaoArcanoTotal = ($numArcanos > 0) ? 90 / $numArcanos : null;
        $anosPorArcano = floor($duracaoArcanoTotal);
        $mesesPorArcano = ($duracaoArcanoTotal - $anosPorArcano) * 12;
        $mesesPorArcano = (int)$mesesPorArcano;

        // Definir a data inicial
        $inicioArcano = new DateTime($dataNascimento);
        $arcanosDetalhados = [];

        for ($i = 0; $i < count($arcanos); $i++) {
            // Calcular a data de fim do arcano
            $fimArcano = clone $inicioArcano;
            $fimArcano->add(new DateInterval("P{$anosPorArcano}Y{$mesesPorArcano}M"));

            // Calcular a idade da pessoa no início e fim do arcano
            $idadeInicio = $inicioArcano->diff(new DateTime($dataNascimento));
            $idadeFim = $fimArcano->diff(new DateTime($dataNascimento));

            // Adicionar o arcano com suas informações detalhadas
            $arcanosDetalhados[] = [
                'arcano' => $arcanos[$i],
                'inicio' => $inicioArcano->format('d-m-Y'),
                'fim' => $fimArcano->format('d-m-Y'),
                'idadeInicio' => "{$idadeInicio->y} anos e {$idadeInicio->m} meses",
                'idadeFim' => "{$idadeFim->y} anos e {$idadeFim->m} meses"
            ];

            // Atualizar o início para o próximo arcano
            $inicioArcano = clone $fimArcano;
        }

        return  $arcanosDetalhados;
        //
    }
    public static function calcularArcanoSocial($nomeCompleto, $dataNascimento, $tabelaBase)
    {
        $mesNascimento = (int)date('m', strtotime($dataNascimento));

        // Extrair o mês do nascimento
        $mesReducao = array_sum(str_split($mesNascimento));
        if ($mesReducao > 9) {
            $mesReducao = array_sum(str_split($mesReducao));
        }

        // Criar uma nova tabela deslocada de acordo com a redução do dia
        $tabelaDeslocada = [];
        $tamanhoTabela = count($tabelaBase);

        foreach ($tabelaBase as $posicao => $letras) {
            $novaPosicao = ($posicao + $mesReducao - 1) % $tamanhoTabela + 1;
            $tabelaDeslocada[$novaPosicao] = $letras;
        }

        // Variáveis para soma e sequência
        $soma = 0;
        $sequencia = "";

        // Convertendo o nome para um array de caracteres considerando codificação UTF-8
        $nomeArray = preg_split('//u', $nomeCompleto, -1, PREG_SPLIT_NO_EMPTY);

        // Definição dos símbolos especiais utilizando seus códigos UTF-8
        $simbolosEspeciais1 = ["\xC2\xA8", "\x60", "\xC2\xB4", "\x27"]; // Trema, Crase, Agudo, Apóstrofo
        $simbolosEspeciais2 = ["\xC2\xB0", "\x5E"]; // Grau e Circunferência
        $simbolosEspeciais3 = ["\x7E"]; // Til

        // Iterar sobre cada letra do nome
        for ($i = 0; $i < count($nomeArray); $i++) {
            $letra = $nomeArray[$i];
            $valorLetra = 0;

            // Procurar o valor da letra na tabela deslocada
            foreach ($tabelaDeslocada as $numero => $letras) {
                if (in_array($letra, $letras)) {
                    $valorLetra = $numero;
                    break;
                }
            }

            // Verificar se há símbolos especiais à esquerda da letra atual
            if ($i > 0) {
                $simboloAnterior = $nomeArray[$i - 1];

                // Verificar presença de símbolos do grupo 1
                if (in_array($simboloAnterior, $simbolosEspeciais1)) {
                    $valorLetra += 2;
                }

                // Verificar presença de símbolos do grupo 2
                if (in_array($simboloAnterior, $simbolosEspeciais2)) {
                    $valorLetra += 7;
                }

                // Verificar presença de símbolos do grupo 3
                if (in_array($simboloAnterior, $simbolosEspeciais3)) {
                    $valorLetra += 3;
                }

                // Aplicar redução teosófica se o valor da letra modificada for maior que 9
                while ($valorLetra > 9) {
                    $valorLetra = array_sum(str_split($valorLetra));
                }
            }

            // Atualizar a soma total e a sequência de valores
            $soma += $valorLetra;
            $sequencia .= $valorLetra > 0 ? $valorLetra : '';
        }

        // Reduzir a soma a um único dígito ou número mestre
        while ($soma > 9 && $soma != 11 && $soma != 22) {
            $soma = array_sum(str_split($soma));
        }

        // Converter o nome completo em números usando a tabela deslocada
        $numeros = [];
        foreach ($nomeArray as $letra) {
            foreach ($tabelaDeslocada as $numero => $letras) {
                if (in_array($letra, $letras)) {
                    $numeros[] = $numero;
                    break;
                }
            }
        }

        // Gerar a sequência de Arcanos
        $arcanos = [];
        for ($i = 0; $i < count($numeros) - 1; $i++) {
            $arcano = $numeros[$i] * 10 + $numeros[$i + 1];
            $arcanos[] = $arcano;
        }

        // Calcular a duração de cada Arcano
        $numArcanos = count($arcanos);
        $duracaoArcanoTotal = ($numArcanos > 0) ? 90 / $numArcanos : null;
        $anosPorArcano = floor($duracaoArcanoTotal);
        $mesesPorArcano = ($duracaoArcanoTotal - $anosPorArcano) * 12;
        $mesesPorArcano = (int)$mesesPorArcano;

        // Definir a data inicial
        $inicioArcano = new DateTime($dataNascimento);
        $arcanosDetalhados = [];

        for ($i = 0; $i < count($arcanos); $i++) {
            // Calcular a data de fim do arcano
            $fimArcano = clone $inicioArcano;
            $fimArcano->add(new DateInterval("P{$anosPorArcano}Y{$mesesPorArcano}M"));

            // Calcular a idade da pessoa no início e fim do arcano
            $idadeInicio = $inicioArcano->diff(new DateTime($dataNascimento));
            $idadeFim = $fimArcano->diff(new DateTime($dataNascimento));

            // Adicionar o arcano com suas informações detalhadas
            $arcanosDetalhados[] = [
                'arcano' => $arcanos[$i],
                'inicio' => $inicioArcano->format('d-m-Y'),
                'fim' => $fimArcano->format('d-m-Y'),
                'idadeInicio' => "{$idadeInicio->y} anos e {$idadeInicio->m} meses",
                'idadeFim' => "{$idadeFim->y} anos e {$idadeFim->m} meses"
            ];

            // Atualizar o início para o próximo arcano
            $inicioArcano = clone $fimArcano;
        }

        return $arcanosDetalhados;
        //
    }
    public static function calcularArcanoDestino($nomeCompleto, $dataNascimento, $tabelaBase)
    {
        $diaNascimento = (int)date('d', strtotime($dataNascimento));
        $mesNascimento = (int)date('m', strtotime($dataNascimento));

        $diaReducao = array_sum(str_split($diaNascimento)); // Reduzir o dia
        if ($diaReducao >= 10) {
            $diaReducao = array_sum(str_split($diaReducao));
        }
        // Extrair o mês do nascimento
        $mesReducao = array_sum(str_split($mesNascimento));
        if ($mesReducao > 9) {
            $mesReducao = array_sum(str_split($mesReducao));
        }
        // soma dia e mes nascimento reduzido, e reduz se necessário
        $reducaoFinal = $diaReducao + $mesReducao;
        if ($reducaoFinal > 9) {
            $reducaoFinal = array_sum(str_split($reducaoFinal));
        }

        // Criar uma nova tabela deslocada de acordo com a redução do dia
        $tabelaDeslocada = [];
        $tamanhoTabela = count($tabelaBase);

        foreach ($tabelaBase as $posicao => $letras) {
            $novaPosicao = ($posicao + $reducaoFinal - 1) % $tamanhoTabela + 1;
            $tabelaDeslocada[$novaPosicao] = $letras;
        }

        // Variáveis para soma e sequência
        $soma = 0;
        $sequencia = "";

        // Convertendo o nome para um array de caracteres considerando codificação UTF-8
        $nomeArray = preg_split('//u', $nomeCompleto, -1, PREG_SPLIT_NO_EMPTY);

        // Definição dos símbolos especiais utilizando seus códigos UTF-8
        $simbolosEspeciais1 = ["\xC2\xA8", "\x60", "\xC2\xB4", "\x27"]; // Trema, Crase, Agudo, Apóstrofo
        $simbolosEspeciais2 = ["\xC2\xB0", "\x5E"]; // Grau e Circunferência
        $simbolosEspeciais3 = ["\x7E"]; // Til

        // Iterar sobre cada letra do nome
        for ($i = 0; $i < count($nomeArray); $i++) {
            $letra = $nomeArray[$i];
            $valorLetra = 0;

            // Procurar o valor da letra na tabela deslocada
            foreach ($tabelaDeslocada as $numero => $letras) {
                if (in_array($letra, $letras)) {
                    $valorLetra = $numero;
                    break;
                }
            }

            // Verificar se há símbolos especiais à esquerda da letra atual
            if ($i > 0) {
                $simboloAnterior = $nomeArray[$i - 1];

                // Verificar presença de símbolos do grupo 1
                if (in_array($simboloAnterior, $simbolosEspeciais1)) {
                    $valorLetra += 2;
                }

                // Verificar presença de símbolos do grupo 2
                if (in_array($simboloAnterior, $simbolosEspeciais2)) {
                    $valorLetra += 7;
                }

                // Verificar presença de símbolos do grupo 3
                if (in_array($simboloAnterior, $simbolosEspeciais3)) {
                    $valorLetra += 3;
                }

                // Aplicar redução teosófica se o valor da letra modificada for maior que 9
                while ($valorLetra > 9) {
                    $valorLetra = array_sum(str_split($valorLetra));
                }
            }

            // Atualizar a soma total e a sequência de valores
            $soma += $valorLetra;
            $sequencia .= $valorLetra > 0 ? $valorLetra : '';
        }

        // Reduzir a soma a um único dígito ou número mestre
        while ($soma > 9 && $soma != 11 && $soma != 22) {
            $soma = array_sum(str_split($soma));
        }

        // Converter o nome completo em números usando a tabela deslocada
        $numeros = [];
        foreach ($nomeArray as $letra) {
            foreach ($tabelaDeslocada as $numero => $letras) {
                if (in_array($letra, $letras)) {
                    $numeros[] = $numero;
                    break;
                }
            }
        }

        // Gerar a sequência de Arcanos
        $arcanos = [];
        for ($i = 0; $i < count($numeros) - 1; $i++) {
            $arcano = $numeros[$i] * 10 + $numeros[$i + 1];
            $arcanos[] = $arcano;
        }

        // Calcular a duração de cada Arcano
        $numArcanos = count($arcanos);
        $duracaoArcanoTotal = ($numArcanos > 0) ? 90 / $numArcanos : null;
        $anosPorArcano = floor($duracaoArcanoTotal);
        $mesesPorArcano = ($duracaoArcanoTotal - $anosPorArcano) * 12;
        $mesesPorArcano = (int)$mesesPorArcano;

        // Definir a data inicial
        $inicioArcano = new DateTime($dataNascimento);
        $arcanosDetalhados = [];

        for ($i = 0; $i < count($arcanos); $i++) {
            // Calcular a data de fim do arcano
            $fimArcano = clone $inicioArcano;
            $fimArcano->add(new DateInterval("P{$anosPorArcano}Y{$mesesPorArcano}M"));

            // Calcular a idade da pessoa no início e fim do arcano
            $idadeInicio = $inicioArcano->diff(new DateTime($dataNascimento));
            $idadeFim = $fimArcano->diff(new DateTime($dataNascimento));

            // Adicionar o arcano com suas informações detalhadas
            $arcanosDetalhados[] = [
                'arcano' => $arcanos[$i],
                'inicio' => $inicioArcano->format('d-m-Y'),
                'fim' => $fimArcano->format('d-m-Y'),
                'idadeInicio' => "{$idadeInicio->y} anos e {$idadeInicio->m} meses",
                'idadeFim' => "{$idadeFim->y} anos e {$idadeFim->m} meses"
            ];

            // Atualizar o início para o próximo arcano
            $inicioArcano = clone $fimArcano;
        }

        return $arcanosDetalhados;
        //
    }
    public static function calcularPiramideDestino($nomeCompleto, $dataNascimento, $tabelaPiramde)
    {
        $diaNascimento = (int)date('d', strtotime($dataNascimento));
        $mesNascimento = (int)date('m', strtotime($dataNascimento));

        // Reduzir o dia e o mês
        $diaReducao = array_sum(str_split($diaNascimento));
        if ($diaReducao >= 10) {
            $diaReducao = array_sum(str_split($diaReducao));
        }

        $mesReducao = array_sum(str_split($mesNascimento));
        if ($mesReducao >= 10) {
            $mesReducao = array_sum(str_split($mesReducao));
        }

        // Somar as reduções e reduzir novamente se necessário
        $reducaoFinal = $diaReducao + $mesReducao;
        if ($reducaoFinal > 9) {
            $reducaoFinal = array_sum(str_split($reducaoFinal));
        }

        $tabelaDeslocada = [];
        $tamanhoTabela = count($tabelaPiramde);

        foreach ($tabelaPiramde as $posicao => $letras) {
            $novaPosicao = ($posicao + $reducaoFinal - 1) % $tamanhoTabela + 1;
            $tabelaDeslocada[$novaPosicao] = $letras;
        }

        // Converter o nome completo em números usando a tabela deslocada
        $numeros = [];
        for ($i = 0; $i < strlen($nomeCompleto); $i++) {
            $letra = $nomeCompleto[$i];
            foreach ($tabelaDeslocada as $numero => $letras) {
                if (in_array($letra, $letras)) {
                    $numeros[] = $numero;
                    break;
                }
            }
        }

        // Construir a pirâmide
        $piramide = [];
        $piramide[] = $numeros;

        while (count($numeros) > 1) {
            $novaLinha = [];
            for ($i = 0; $i < count($numeros) - 1; $i++) {
                $soma = $numeros[$i] + $numeros[$i + 1];
                $novaLinha[] = $soma >= 10 ? $soma - 9 : $soma;
            }
            $piramide[] = $novaLinha;
            $numeros = $novaLinha;
        }

        return $piramide;
    }
    public static function calcularPiramidePessoal($nomeCompleto, $dataNascimento, $tabelaPiramide)
    {

        $diaNascimento = (int)date('d', strtotime($dataNascimento));
        $diaReducao = array_sum(str_split($diaNascimento)); // Reduzir o dia
        if ($diaReducao >= 10) {
            $diaReducao = array_sum(str_split($diaReducao));
        }

        // Criar uma nova tabela deslocada de acordo com a redução do dia
        $tabelaDeslocada = [];
        $tamanhoTabela = count($tabelaPiramide);

        foreach ($tabelaPiramide as $posicao => $letras) {
            $novaPosicao = ($posicao + $diaReducao - 1) % $tamanhoTabela + 1;
            $tabelaDeslocada[$novaPosicao] = $letras;
        }

        // Converter o nome completo em números usando a tabela deslocada
        $numeros = [];
        for ($i = 0; $i < strlen($nomeCompleto); $i++) {
            $letra = $nomeCompleto[$i];
            foreach ($tabelaDeslocada as $numero => $letras) {
                if (in_array($letra, $letras)) {
                    $numeros[] = $numero;
                    break;
                }
            }
        }

        // Construir a pirâmide
        $piramide = [];
        $piramide[] = $numeros;

        while (count($numeros) > 1) {
            $novaLinha = [];
            for ($i = 0; $i < count($numeros) - 1; $i++) {
                $soma = $numeros[$i] + $numeros[$i + 1];
                $novaLinha[] = $soma >= 10 ? $soma - 9 : $soma;
            }
            $piramide[] = $novaLinha;
            $numeros = $novaLinha;
        }

        return $piramide;
    }
    public static function calcularPiramideSocial($nomeCompleto, $dataNascimento, $tabelaPiramides)
    {
        // Extrair o mês do nascimento do formato "dd-mm-yyyy"
        $mesNascimento = (int)date('m', strtotime($dataNascimento));

        $mesReducao = array_sum(str_split($mesNascimento)); // Reduzir o mês
        if ($mesReducao >= 10) {
            $mesReducao = array_sum(str_split($mesReducao));
        }

        // Criar uma nova tabela deslocada de acordo com a redução do mês
        $tabelaDeslocada = [];
        $tamanhoTabela = count($tabelaPiramides);

        foreach ($tabelaPiramides as $posicao => $letras) {
            $novaPosicao = ($posicao + $mesReducao - 1) % $tamanhoTabela + 1;
            $tabelaDeslocada[$novaPosicao] = $letras;
        }

        // Converter o nome completo em números usando a tabela deslocada
        $numeros = [];
        for ($i = 0; $i < strlen($nomeCompleto); $i++) {
            $letra = $nomeCompleto[$i];
            foreach ($tabelaDeslocada as $numero => $letras) {
                if (in_array($letra, $letras)) {
                    $numeros[] = $numero;
                    break;
                }
            }
        }

        // Construir a pirâmide
        $piramide = [];
        $piramide[] = $numeros;

        while (count($numeros) > 1) {
            $novaLinha = [];
            for ($i = 0; $i < count($numeros) - 1; $i++) {
                $soma = $numeros[$i] + $numeros[$i + 1];
                $novaLinha[] = $soma >= 10 ? $soma - 9 : $soma;
            }
            $piramide[] = $novaLinha;
            $numeros = $novaLinha;
        }
        return $piramide;
    }
    public static function calcularPiramideVida($nomeCompleto, $alfabeto)
    {

        // Converter o nome completo em números usando a tabela
        $numeros = [];
        for ($i = 0; $i < strlen($nomeCompleto); $i++) {
            $letra = $nomeCompleto[$i];
            if (isset($alfabeto[$letra])) {
                $numeros[] = $alfabeto[$letra];
            }
        }

        $piramide = [];
        $piramide[] = $numeros;

        while (count($numeros) > 1) {
            $novaLinha = [];
            for ($i = 0; $i < count($numeros) - 1; $i++) {
                $soma = $numeros[$i] + $numeros[$i + 1];
                $novaLinha[] = $soma >= 10 ? $soma - 9 : $soma;
            }
            $piramide[] = $novaLinha;
            $numeros = $novaLinha;
        }

        return $piramide;
    }
    public static function sequenciasEncontradas($sequencia_piramide, $sequencias)
    {
        // Obter as sequências vibracionais positivas e negativas
        $sequenciasPositivas = $sequencias['positivas'];
        $sequenciasNegativas = $sequencias['negativas'];

        // Arrays para armazenar as sequências encontradas
        $resultado = [
            'positivas' => [],
            'negativas' => [],
        ];

        // Percorre cada string no array $sequencia_piramide
        foreach ($sequencia_piramide as $string) {
            // Verificar as sequências positivas
            foreach ($sequenciasPositivas as $sequencia) {
                if (strpos($string, $sequencia) !== false && !in_array($sequencia, $resultado['positivas'])) {
                    $resultado['positivas'][] = $sequencia;
                }
            }

            // Verificar as sequências negativas
            foreach ($sequenciasNegativas as $sequencia) {
                if (strpos($string, $sequencia) !== false && !in_array($sequencia, $resultado['negativas'])) {
                    $resultado['negativas'][] = $sequencia;
                }
            }
        }

        // Retorna o array com as sequências positivas e negativas encontradas
        return $resultado;
    }
    public static function sequenciaVibracional($piramide)
    {
        // Listas de sequências negativas e positivas
        $sequenciasNegativas = ['111', '222', '333', '444', '555', '666', '777', '888', '999'];
        $sequenciasPositivas = ['116', '118', '119', '123', '168', '252', '272', '375', '518', '575', '637', '651', '665', '667', '725', '757', '922', '923', '924', '926'];

        // Array para armazenar o resultado formatado
        $resultado = [];

        // Iterar por cada linha da pirâmide
        foreach ($piramide as $linha) {
            // String temporária para armazenar a linha formatada
            $linhaFormatada = '';

            // Iterar pelos números da linha
            for ($i = 0; $i < count($linha); $i++) {
                // Criar uma string com o número atual e os próximos 2 números (para comparações de sequência)
                $sequenciaAtual = isset($linha[$i + 1], $linha[$i + 2])
                    ? $linha[$i] . $linha[$i + 1] . $linha[$i + 2]
                    : null;

                // Verifica se a sequência atual está nas listas
                if ($sequenciaAtual && in_array(str_replace(' ', '', $sequenciaAtual), $sequenciasNegativas)) {
                    // Sequência negativa encontrada, destacar em negrito
                    $linhaFormatada .= "<span class='bg-[#D8CAE5] rounded-[5px] sequecia'>$sequenciaAtual</span>";
                    // Pular os próximos dois números, pois já foram verificados como parte da sequência
                    $i += 2;
                } elseif ($sequenciaAtual && in_array(str_replace(' ', '', $sequenciaAtual), $sequenciasPositivas)) {
                    // Sequência positiva encontrada, destacar em itálico
                    $linhaFormatada .= "<span class='bg-[#F7D9D9] rounded-[5px] sequecia'>$sequenciaAtual</span>";
                    // Pular os próximos dois números
                    $i += 2;
                } else {
                    // Caso não seja sequência especial, apenas adicionar o número normalmente
                    $linhaFormatada .= "<span class='espaco px-1'>$linha[$i]</span>";
                }
            }

            // Adicionar a linha formatada ao resultado final, sem mudar sua posição
            $resultado[] = trim($linhaFormatada);
        }

        // Retorna a pirâmide com as sequências formatadas, mantendo a ordem original das linhas
        return $resultado;
    }
    public static function calcularArcanoPiramideDestino($nomeCompleto, $dataNascimento, $tabelaPiramde)
    {
        $diaNascimento = (int)date('d', strtotime($dataNascimento));
        $mesNascimento = (int)date('m', strtotime($dataNascimento));

        $diaReducao = array_sum(str_split($diaNascimento)) >= 10 ? array_sum(str_split($diaNascimento)) : '';
        $mesReducao = array_sum(str_split($mesNascimento)) >= 10 ? array_sum(str_split($mesNascimento)) : '';
        $reducaoFinal = (int)$diaReducao + (int)$mesReducao;
        $reducaoFinal = self::reduzirNumeroSimples($reducaoFinal);

        $tabelaDeslocada = [];
        $tamanhoTabela = count($tabelaPiramde);

        foreach ($tabelaPiramde as $posicao => $letras) {
            $novaPosicao = ($posicao + $reducaoFinal - 1) % $tamanhoTabela + 1;
            $tabelaDeslocada[$novaPosicao] = $letras;
        }

        $numeros = [];
        for ($i = 0; $i < strlen($nomeCompleto); $i++) {
            $letra = $nomeCompleto[$i];
            foreach ($tabelaDeslocada as $numero => $letras) {
                if (in_array($letra, $letras)) {
                    $numeros[] = $numero;
                    break;
                }
            }
        }

        // Gerar a sequência de Arcanos
        $arcanos = [];
        for ($i = 0; $i < count($numeros) - 1; $i++) {
            $arcano = $numeros[$i] * 10 + $numeros[$i + 1];
            $arcanos[] = $arcano;
        }

        // Calcular a duração de cada Arcano
        $numArcanos = count($arcanos);
        $duracaoArcanoTotal = 90 / $numArcanos;
        $anosPorArcano = floor($duracaoArcanoTotal);

        // Extrair o número após o ponto decimal para usar como meses
        $mesesPorArcano = ($duracaoArcanoTotal - $anosPorArcano) * 12;
        $mesesPorArcano = (int)$mesesPorArcano; // Converte para inteiro para garantir que seja um valor inteiro

        // Definir a data inicial
        $inicioArcano = new DateTime($dataNascimento);

        $arcanoAtual = '';
        $dataAtual = new DateTime();

        for ($i = 0; $i < count($arcanos); $i++) {
            // Clonar a data de início para não modificar o objeto original
            $fimArcano = clone $inicioArcano;

            // Adicionar os anos e meses calculados
            $fimArcano->add(new DateInterval("P{$anosPorArcano}Y{$mesesPorArcano}M"));

            // Verificar se a data atual está no intervalo deste Arcano
            if ($dataAtual >= $inicioArcano && $dataAtual < $fimArcano) {
                $arcanoAtual = $arcanos[$i];
                break;
            }

            // Atualizar o início do próximo Arcano
            $inicioArcano = clone $fimArcano;
        }

        // Retornar o Arcano em que a pessoa está atualmente
        return [
            'arcanoAtual' => $arcanoAtual,
            'anosPorArcano' => $anosPorArcano,
            'mesesPorArcano' => $mesesPorArcano
        ];
    }
    public static function calcularArcanoPiramidePessoal($nomeCompleto, $dataNascimento, $tabelaPiramde)
    {
        $diaNascimento = (int)date('d', strtotime($dataNascimento));
        $mesNascimento = (int)date('m', strtotime($dataNascimento));

        $diaReducao = array_sum(str_split($diaNascimento)) >= 10 ? array_sum(str_split($diaNascimento)) : '';
        $mesReducao = array_sum(str_split($mesNascimento)) >= 10 ? array_sum(str_split($mesNascimento)) : '';
        $reducaoFinal = $diaReducao + $mesReducao;
        $reducaoFinal = self::reduzirNumeroSimples($reducaoFinal);

        $tabelaDeslocada = [];
        $tamanhoTabela = count($tabelaPiramde);

        foreach ($tabelaPiramde as $posicao => $letras) {
            $novaPosicao = ($posicao + $reducaoFinal - 1) % $tamanhoTabela + 1;
            $tabelaDeslocada[$novaPosicao] = $letras;
        }

        $numeros = [];
        for ($i = 0; $i < strlen($nomeCompleto); $i++) {
            $letra = $nomeCompleto[$i];
            foreach ($tabelaDeslocada as $numero => $letras) {
                if (in_array($letra, $letras)) {
                    $numeros[] = $numero;
                    break;
                }
            }
        }

        // Gerar a sequência de Arcanos
        $arcanos = [];
        for ($i = 0; $i < count($numeros) - 1; $i++) {
            $arcano = $numeros[$i] * 10 + $numeros[$i + 1];
            $arcanos[] = $arcano;
        }

        // Calcular a duração de cada Arcano
        $numArcanos = count($arcanos);
        $duracaoArcanoTotal = 90 / $numArcanos;
        $anosPorArcano = floor($duracaoArcanoTotal);

        // Extrair o número após o ponto decimal para usar como meses
        $mesesPorArcano = ($duracaoArcanoTotal - $anosPorArcano) * 12;
        $mesesPorArcano = (int)$mesesPorArcano; // Converte para inteiro para garantir que seja um valor inteiro

        // Definir a data inicial
        $inicioArcano = new DateTime($dataNascimento);

        $arcanoAtual = '';
        $dataAtual = new DateTime();

        for ($i = 0; $i < count($arcanos); $i++) {
            // Clonar a data de início para não modificar o objeto original
            $fimArcano = clone $inicioArcano;

            // Adicionar os anos e meses calculados
            $fimArcano->add(new DateInterval("P{$anosPorArcano}Y{$mesesPorArcano}M"));

            // Verificar se a data atual está no intervalo deste Arcano
            if ($dataAtual >= $inicioArcano && $dataAtual < $fimArcano) {
                $arcanoAtual = $arcanos[$i];
                break;
            }

            // Atualizar o início do próximo Arcano
            $inicioArcano = clone $fimArcano;
        }

        // Retornar o Arcano em que a pessoa está atualmente
        return [
            'arcanoAtual' => $arcanoAtual,
            'anosPorArcano' => $anosPorArcano,
            'mesesPorArcano' => $mesesPorArcano
        ];
    }
    public static function calcularArcanoPiramideSocial($nomeCompleto, $dataNascimento, $tabelaPiramde)
    {
        $mesNascimento = (int)date('m', strtotime($dataNascimento));

        $mesReducao = array_sum(str_split($mesNascimento)) >= 10 ? array_sum(str_split($mesNascimento)) : '';

        $tabelaDeslocada = [];
        $tamanhoTabela = count($tabelaPiramde);

        foreach ($tabelaPiramde as $posicao => $letras) {
            $novaPosicao = ($posicao + $mesReducao - 1) % $tamanhoTabela + 1;
            $tabelaDeslocada[$novaPosicao] = $letras;
        }

        $numeros = [];
        for ($i = 0; $i < strlen($nomeCompleto); $i++) {
            $letra = $nomeCompleto[$i];
            foreach ($tabelaDeslocada as $numero => $letras) {
                if (in_array($letra, $letras)) {
                    $numeros[] = $numero;
                    break;
                }
            }
        }

        // Gerar a sequência de Arcanos
        $arcanos = [];
        for ($i = 0; $i < count($numeros) - 1; $i++) {
            $arcano = $numeros[$i] * 10 + $numeros[$i + 1];
            $arcanos[] = $arcano;
        }

        // Calcular a duração de cada Arcano
        $numArcanos = count($arcanos);
        $duracaoArcanoTotal = 90 / $numArcanos;
        $anosPorArcano = floor($duracaoArcanoTotal);

        // Extrair o número após o ponto decimal para usar como meses
        $mesesPorArcano = ($duracaoArcanoTotal - $anosPorArcano) * 12;
        $mesesPorArcano = (int)$mesesPorArcano; // Converte para inteiro para garantir que seja um valor inteiro

        // Definir a data inicial
        $inicioArcano = new DateTime($dataNascimento);

        $arcanoAtual = '';
        $dataAtual = new DateTime();

        for ($i = 0; $i < count($arcanos); $i++) {
            // Clonar a data de início para não modificar o objeto original
            $fimArcano = clone $inicioArcano;

            // Adicionar os anos e meses calculados
            $fimArcano->add(new DateInterval("P{$anosPorArcano}Y{$mesesPorArcano}M"));

            // Verificar se a data atual está no intervalo deste Arcano
            if ($dataAtual >= $inicioArcano && $dataAtual < $fimArcano) {
                $arcanoAtual = $arcanos[$i];
                break;
            }

            // Atualizar o início do próximo Arcano
            $inicioArcano = clone $fimArcano;
        }

        // Retornar o Arcano em que a pessoa está atualmente
        return [
            'arcanoAtual' => $arcanoAtual,
            'anosPorArcano' => $anosPorArcano,
            'mesesPorArcano' => $mesesPorArcano
        ];
    }
    public static function calcularDesafios($dataNascimento)
    {
        $diaNascimento = NumerologiaCalculos::reduzirNumeroSimplesAteOito((int)date('d', strtotime($dataNascimento)));
        $mesNascimento = NumerologiaCalculos::reduzirNumeroSimplesAteOito((int)date('m', strtotime($dataNascimento)));
        $anoNascimento = NumerologiaCalculos::reduzirNumeroSimplesAteOito((int)date('Y', strtotime($dataNascimento)));

        $primeiroDesafio = abs($mesNascimento - $diaNascimento);
        $segundoDesafio = abs($anoNascimento - $diaNascimento);
        $terceiroDesafio = abs($segundoDesafio - $primeiroDesafio);

        // Caso algum desafio seja "11" ou "22", reduzir para "2" e "4" respectivamente
        $primeiroDesafio = ($primeiroDesafio == 11) ? 2 : (($primeiroDesafio == 22) ? 4 : $primeiroDesafio);
        $segundoDesafio = ($segundoDesafio == 11) ? 2 : (($segundoDesafio == 22) ? 4 : $segundoDesafio);
        $terceiroDesafio = ($terceiroDesafio == 11) ? 2 : (($terceiroDesafio == 22) ? 4 : $terceiroDesafio);

        return [
            'primeiroDesafio' => $primeiroDesafio,
            'segundoDesafio' => $segundoDesafio,
            'terceiroDesafio' => $terceiroDesafio
        ];
    }
    public static function calcularTesteVocacional($numeroDestino, $numeroMissao, $numeroExpressao, $dataNascimento, $listaProfissoes)
    {
        // Obtém o dia do nascimento
        $diaNascimento = (int)date('d', strtotime($dataNascimento));

        // Mapeia os parâmetros para as chaves do array
        $valores = [
            'destino' => $numeroDestino,
            'missao' => $numeroMissao,
            'expressao' => $numeroExpressao,
            'dataNascimento' => $diaNascimento
        ];
        // Mapeamento personalizado para corrigir acentuação e espaços
        $mapaFontes = [
            'destino' => 'Destino',
            'missao' => 'Missão',
            'expressao' => 'Expressão',
            'dataNascimento' => 'Dia Nascimento',
        ];

        // Lista para armazenar todas as profissões encontradas com suas fontes
        $todasProfissoes = [];

        // Verifica se os números existem no array e adiciona suas profissões à lista
        foreach ($valores as $categoria => $numero) {
            if (isset($listaProfissoes[$categoria][$numero])) {
                // Adiciona as profissões à lista com a sua fonte
                foreach ($listaProfissoes[$categoria][$numero] as $profissao) {
                    $todasProfissoes[] = ['profissao' => $profissao, 'fonte' => $categoria];
                }
            }
        }

        // Conta as repetições de cada profissão e registra as fontes
        $contagemProfissoes = [];

        foreach ($todasProfissoes as $entrada) {
            $profissao = $entrada['profissao'];
            // Usa o mapa para exibir a fonte corretamente
            $fonte = $mapaFontes[$entrada['fonte']] ?? ucfirst($entrada['fonte']);
//            $fonte = ucfirst($entrada['fonte']);  // Capitaliza a fonte para exibição (Ex: Destino)

            if (!isset($contagemProfissoes[$profissao])) {
                $contagemProfissoes[$profissao] = ['contagem' => 0, 'fontes' => []];
            }

            // Incrementa a contagem e adiciona a fonte à lista de fontes
            $contagemProfissoes[$profissao]['contagem']++;
            if (!in_array($fonte, $contagemProfissoes[$profissao]['fontes'])) {
                $contagemProfissoes[$profissao]['fontes'][] = $fonte;
            }
        }

        // Filtra as profissões que aparecem 2 ou mais vezes
        $contagemProfissoes = array_filter($contagemProfissoes, function($entry) {
            return $entry['contagem'] >= 2;
        });

        // Ordena as profissões pela quantidade de vezes que aparecem (do maior para o menor)
        uasort($contagemProfissoes, function($a, $b) {
            return $b['contagem'] - $a['contagem'];
        });

        // Formata a saída conforme solicitado
        $resultado = [];
        foreach ($contagemProfissoes as $profissao => $dados) {
            $resultado[] = "{$profissao} {$dados['contagem']} x - " . implode(', ', $dados['fontes']);
        }

        // Retorna a lista formatada
        return $resultado;
//        // Obtém o dia do nascimento
//        $diaNascimento = (int)date('d', strtotime($dataNascimento));
//
//        // Mapeia os parâmetros para as chaves do array
//        $valores = [
//            'destino' => $numeroDestino,
//            'missao' => $numeroMissao,
//            'expressao' => $numeroExpressao,
//            'dataNascimento' => $diaNascimento
//        ];
//
//        // Lista para armazenar todas as profissões encontradas
//        $todasProfissoes = [];
//
//        // Verifica se os números existem no array e adiciona suas profissões à lista
//        foreach ($valores as $categoria => $numero) {
//            if (isset($listaProfissoes[$categoria][$numero])) {
//                // Adiciona as profissões à lista
//                $todasProfissoes = array_merge($todasProfissoes, $listaProfissoes[$categoria][$numero]);
//            }
//        }
//
//        // Conta as repetições de cada profissão
//        $contagemProfissoes = array_count_values($todasProfissoes);
//
//        // Ordena as profissões pela quantidade de vezes que aparecem (do maior para o menor)
//        arsort($contagemProfissoes);
//
//        // Filtra as profissões que aparecem 2 ou mais vezes
//        $contagemProfissoes = array_filter($contagemProfissoes, function($count) {
//            return $count >= 2;
//        });
//        // Retorna o array com as contagens das profissões
//        return $contagemProfissoes;
    }
    public static function buscaAnjo($dataNascimento, $anjos)
    {
        $dia = intval(date('d', strtotime($dataNascimento)));
        $mes = intval(date('m', strtotime($dataNascimento)));

        $selectedAnjo = [];

        foreach ($anjos as $anjo) {
            // Explode as datas para verificar
            $datas =  $anjo['datas'];

            // Iterar pelas datas
            foreach ($datas as $data) {
                // Remover espaços em branco
                $data = trim($data);
                // Converter o nome do mês em número e obter o dia
                $partesData = explode(' ', $data);
                $diaAnjo = $partesData[0];
                $mesAnjo = self::nomeMesParaNumero($partesData[1]);

                // Verificar se dia e mês coincidem
                if ($dia == $diaAnjo && $mes == $mesAnjo) {
                    $selectedAnjo[] = $anjo;
                    return $selectedAnjo;
                }
            }
        }

        return "Anjo não encontrado.";
    }
    public static function faseLua($data_str)
    {
        // Converter a string de data para um objeto DateTime
        $data = DateTime::createFromFormat('Y-m-d', $data_str);
        if (!$data) {
            return "Data inválida!";
        }

        // Data base para o cálculo (2000-01-06 18:14 UTC - uma Lua Nova conhecida)
        $data_base = new DateTime('2000-01-06 18:14:00', new DateTimeZone('UTC'));

        // Calcular a diferença em dias entre a data fornecida e a data base
        $diferenca_dias = $data_base->diff($data)->days;
        if ($data < $data_base) {
            $diferenca_dias = -$diferenca_dias;
        }

        // Duração média do ciclo lunar em dias
        $ciclo_lunar = 29.53058867;

        // Calcular a idade da Lua
        $idade_lua = fmod($diferenca_dias, $ciclo_lunar);
        if ($idade_lua < 0) {
            $idade_lua += $ciclo_lunar;
        }

        // Determinar a fase da Lua com base na idade
        if ($idade_lua < 1.84566) {
            $fase = "Nova";
        } elseif ($idade_lua < 5.53699) {
            $fase = "Crescente Côncava";
        } elseif ($idade_lua < 9.22831) {
            $fase = "Quarto Crescente";
        } elseif ($idade_lua < 12.91963) {
            $fase = "Crescente Gibosa";
        } elseif ($idade_lua < 16.61096) {
            $fase = "Cheia";
        } elseif ($idade_lua < 20.30228) {
            $fase = "Minguante Gibosa";
        } elseif ($idade_lua < 23.99361) {
            $fase = "Quarto Minguante";
        } elseif ($idade_lua < 27.68493) {
            $fase = "Minguante Côncava";
        } else {
            $fase = "Lua Nova";
        }

        // Obter o nome do dia da semana em português
        $dias_semana = [
            'Sunday' => 'Domingo',
            'Monday' => 'Segunda-feira',
            'Tuesday' => 'Terça-feira',
            'Wednesday' => 'Quarta-feira',
            'Thursday' => 'Quinta-feira',
            'Friday' => 'Sexta-feira',
            'Saturday' => 'Sábado'
        ];
        $dia_semana_en = $data->format('l');
        $dia_semana_pt = $dias_semana[$dia_semana_en];

        return "Lua " . $fase . ".";
    }
}

<?php

class NumerologiaDados
{
    public static function obterAlfabeto()
    {
        return [
            'a' => 1,
            'A' => 1,
            'b' => 2,
            'B' => 2,
            'c' => 3,
            'C' => 3,
            'd' => 4,
            'D' => 4,
            'e' => 5,
            'E' => 5,
            'f' => 8,
            'F' => 8,
            'g' => 3,
            'G' => 3,
            'h' => 5,
            'H' => 5,
            'i' => 1,
            'I' => 1,
            'j' => 1,
            'J' => 1,
            'k' => 2,
            'K' => 2,
            'l' => 3,
            'L' => 3,
            'm' => 4,
            'M' => 4,
            'n' => 5,
            'N' => 5,
            'o' => 7,
            'O' => 7,
            'p' => 8,
            'P' => 8,
            'q' => 1,
            'Q' => 1,
            'r' => 2,
            'R' => 2,
            's' => 3,
            'S' => 3,
            't' => 4,
            'T' => 4,
            'u' => 6,
            'U' => 6,
            'v' => 6,
            'V' => 6,
            'w' => 6,
            'W' => 6,
            'x' => 5,
            'X' => 5,
            'y' => 1,
            'Y' => 1,
            'z' => 7,
            'Z' => 7,
            'ç' => 6,
            'Ç' => 6,
            // Acrescentar símbolos especiais
            'Á' => 3,
            'á' => 3,
            'à' => 3,
            'À' => 3,
            'â' => 8,
            'Â' => 8,
            'ä' => 3,
            'Ä' => 3,
            'å' => 8,
            'Å' => 8,
            'Ã' => 4,
            'ã' => 4,
            'é' => 7,
            'É' => 7,
            'è' => 7,
            'È' => 7,
            'ê' => 3,
            'Ê' => 3,
            'ë' => 7,
            'Ë' => 7,
            'ẽ' => 8,
            'Ẽ' => 8,
            'í' => 3,
            'Í' => 3,
            'ì' => 3,
            'Ì' => 3,
            'î' => 8,
            'Î' => 8,
            'ï' => 3,
            'Ï' => 3,
            'ĩ' => 4,
            'Ĩ' => 4,
            'ó' => 9,
            'Ó' => 9,
            'ò' => 9,
            'Ò' => 9,
            'ô' => 5,
            'Ô' => 5,
            'õ' => 1,
            'Õ' => 1,
            'ö' => 9,
            'Ö' => 9,
            'ú' => 8,
            'Ú' => 8,
            'ù' => 8,
            'Ù' => 8,
            'û' => 4,
            'Û' => 4,
            'ü' => 8,
            'Ü' => 8,
            'ů' => 4,
            'Ů' => 4,
            'ū' => 9,
            'Ū' => 9,
            'ć' => 5,
            'Ć' => 5,
            'ĉ' => 1,
            'Ĉ' => 1,
            'ñ' => 8,
            'Ñ' => 8,
            'ń' => 7,
            'Ń' => 7,
            'ś' => 5,
            'Ś' => 5,
            'ŝ' => 1,
            'Ŝ' => 1,
            'ź' => 9,
            'Ź' => 9,
            'ģ' => 5,
            'Ǵ' => 5,
            "¨" => 2,
            "`" => 2,
            "´" => 2,
            "'" => 2,
            "°" => 7,
            "^" => 7,
            "~" => 3
        ];
    }

    public static function obterTabelaPiramides()
    {
        return [
            1 => ['a', 'A', 'i', 'I', 'j', 'J', 'q', 'Q', 'y', 'Y', 'ĉ', 'Ĉ', 'Ŝ', 'ŝ', 'õ', 'Õ'],
            2 => ['b', 'B', 'k', 'K', 'r', 'R'],
            3 => ['c', 'C', 'g', 'G', 'l', 'L', 's', 'S', 'Á', 'á', 'à', 'À', 'ä', 'Ä', 'ê', 'Ê', 'í', 'Í', 'ì', 'Ì', 'ï', 'Ï',],
            4 => ['d', 'D', 'm', 'M', 't', 'T', 'ã', 'Ã', 'ĩ', 'Ĩ', 'û', 'Û', 'ů', 'Ů'],
            5 => ['e', 'E', 'h', 'H', 'n', 'N', 'x', 'X', 'ô', 'Ô'],
            6 => ['u', 'U', 'v', 'V', 'w', 'W', 'ç', 'Ç'],
            7 => ['o', 'O', 'z', 'Z', 'é', 'É', 'è', 'È', 'ë', 'Ë'],
            8 => ['f', 'F', 'p', 'P', 'å', 'Å', 'â', 'Â', 'ẽ', 'Ẽ', 'î', 'Î', 'ú', 'Ú', 'ù', 'Ù', 'ü', 'Ü'],
            9 => ['ó', 'Ó', 'ò', 'ö', 'Ö', 'Ò', 'ź', 'Ź', 'ū', 'Ū'] // Posicionamento de letras adicionadas ou modificadas
        ];
    }

    public static function obterVogais()
    {
        $alfabeto = self::obterAlfabeto();
        return array_filter($alfabeto, function ($letra) {
            return in_array(strtolower($letra), ['a', 'A', 'e', 'E', 'i', 'I', 'o', 'O', 'u', 'U', 'Á', 'á', 'à', 'À', 'â', 'Â', 'ä', 'Ä', 'å', 'Å', 'ā', 'Ā', 'ã', 'Ã', 'é', 'É', 'è', 'È', 'ê', 'Ê', 'ë', 'Ë', 'ẽ', 'Ẽ', 'í', 'Í', 'ì', 'Ì', 'î', 'Î', 'ï', 'Ï', 'ĩ', 'Ĩ', 'ó', 'Ó', 'ò', 'Ò', 'ô', 'Ô', 'õ', 'Õ', 'ö', 'Ö', 'ú', 'Ú', 'ù', 'Ù', 'û', 'Û', 'ü', 'Ü', 'ů', 'Ů', 'ū', 'Ū', 'y', 'Y']);
        }, ARRAY_FILTER_USE_KEY);
    }

    public static function obterConsoantes()
    {
        $alfabeto = self::obterAlfabeto();
        return array_filter($alfabeto, function ($letra) {
            return !in_array(strtolower($letra), ['a', 'A', 'e', 'E', 'i', 'I', 'o', 'O', 'u', 'U', 'Á', 'à', 'À', 'â', 'Â', 'ä', 'Ä', 'å', 'Å', 'ā', 'Ā', 'Ã', 'ã', 'é', 'É', 'è', 'È', 'ê', 'Ê', 'ë', 'Ë', 'ẽ', 'Ẽ', 'í', 'Í', 'ì', 'Ì', 'î', 'Î', 'ï', 'Ï', 'ĩ', 'Ĩ', 'ó', 'Ó', 'ò', 'Ò', 'ô', 'Ô', 'õ', 'Õ', 'ö', 'Ö', 'ú', 'Ú', 'ù', 'Ù', 'û', 'Û', 'ü', 'Ü', 'ů', 'Ů', 'ū', 'Ū', 'y', 'Y']);
        }, ARRAY_FILTER_USE_KEY);
    }

    public static function obterTabelaHarmoniaConjugal()
    {
        return [
            1 => [
                'harmonia' => '1',
                'vibra_com' => '9',
                'atrai' => '4 e 8',
                'e_oposto' => '6 e 7',
                'e_passivo_em_relação_a' => '2, 3 e 5'
            ],
            2 => [
                'harmonia' => '2',
                'vibra_com' => '8',
                'atrai' => '7 e 9',
                'e_oposto' => '5',
                'e_passivo_em_relação_a' => '1, 3, 4 e 6'
            ],
            3 => [
                'harmonia' => '3',
                'vibra_com' => '7',
                'atrai' => '5, 6 e 9',
                'e_oposto' => '4 e 8',
                'e_passivo_em_relação_a' => '1 e 2'
            ],
            4 => [
                'harmonia' => '4',
                'vibra_com' => '6',
                'atrai' => '1 e 8',
                'e_oposto' => '3 e 5',
                'e_passivo_em_relação_a' => '2, 7 e 9'
            ],
            5 => [
                'harmonia' => '5',
                'vibra_com' => '5',
                'atrai' => '3 e 9',
                'e_oposto' => '2 e 4; 
                profundamente oposto a 6',
                'e_passivo_em_relação_a' => '1, 7 e 8'
            ],
            6 => [
                'harmonia' => '6',
                'vibra_com' => '4',
                'atrai' => '3, 7 e 9',
                'e_oposto' => '1 e 8; 
                profundamente oposto a 5',
                'e_passivo_em_relação_a' => '2'
            ],
            7 => [
                'harmonia' => '7',
                'vibra_com' => '3',
                'atrai' => '2 e 6',
                'e_oposto' => '1 e 9',
                'e_passivo_em_relação_a' => '4, 5 e 8'
            ],
            8 => [
                'harmonia' => '8',
                'vibra_com' => '2',
                'atrai' => '1 e 4',
                'e_oposto' => '3 e 6',
                'e_passivo_em_relação_a' => '5, 7 e 9'
            ],
            9 => [
                'harmonia' => '9',
                'vibra_com' => '1',
                'atrai' => '2, 3, 5 e 6',
                'e_oposto' => '7',
                'e_passivo_em_relação_a' => '4 e 8'
            ],
        ];
    }

    public static function obterCores()
    {
        return [
            1 => ['Todos os tons de amarelo', 'laranja', 'castanho', 'dourado', 'verde', 'creme', 'branco'],
            2 => ['Todos os tons de verde', 'creme', 'branco', 'cinza'],
            3 => ['violeta', 'vinho', 'púrpura', 'vermelho'],
            4 => ['azul', 'cinza', 'púrpura', 'ouro'],
            5 => ['Todos os tons claros', 'cinza', 'prateado'],
            6 => ['rosa', 'azul', 'verde'],
            7 => ['verde', 'amarelo', 'branco', 'cinza', 'azul-claro'],
            8 => ['púrpura', 'cinza', 'azul', 'preto', 'castanho'],
            9 => ['vermelho', 'rosa', 'coral', 'vinho'],
            11 => ['branco', 'violeta', 'cores claras'],
            22 => ['violeta', 'branco', 'cores claras']
        ];
    }

    public static function obterNumerosHarmoncos()
    {
        return  [
            1 => [2, 4, 9],
            2 => [1, 2, 3, 4, 5, 6, 7, 8, 9],
            3 => [2, 3, 6, 8, 9],
            4 => [1, 2, 6, 7],
            5 => [2, 5, 6, 7, 9],
            6 => [2, 3, 4, 5, 6, 9],
            7 => [2, 4, 5, 7],
            8 => [2, 3, 9],
            9 => [1, 2, 3, 5, 6, 8, 9],
        ];
    }

    public static function obterTabelaNumerosFavoraveis()
    {
        return [
            "janeiro" => [
                1 => [1, 5],
                2 => [1, 6],
                3 => [3, 6],
                4 => [1, 5],
                5 => [5, 6],
                6 => [5, 6],
                7 => [1, 7],
                8 => [1, 3],
                9 => [6, 9],
                10 => [1, 5],
                11 => [1, 6],
                12 => [6, 9],
                13 => [1, 5],
                14 => [5, 6],
                15 => [5, 6],
                16 => [1, 5],
                17 => [1, 3],
                18 => [5, 6],
                19 => [1, 5],
                20 => [1, 6],
                21 => [3, 6],
                22 => [1, 5],
                23 => [5, 6],
                24 => [5, 6],
                25 => [1, 5],
                26 => [2, 3],
                27 => [6, 9],
                28 => [2, 7],
                29 => [5, 7],
                30 => [2, 3],
                31 => [2, 7]
            ],
            "fevereiro" => [
                1 => [2, 7],
                2 => [2, 7],
                3 => [3, 6],
                4 => [2, 7],
                5 => [5, 6],
                6 => [3, 6],
                7 => [2, 7],
                8 => [2, 3],
                9 => [3, 6],
                10 => [2, 7],
                11 => [5, 7],
                12 => [5, 6],
                13 => [2, 7],
                14 => [5, 6],
                15 => [3, 6],
                16 => [2, 5],
                17 => [2, 3],
                18 => [3, 6],
                19 => [2, 7],
                20 => [2, 7],
                21 => [3, 6],
                22 => [2, 7],
                23 => [5, 6],
                24 => [5, 6],
                25 => [2, 7],
                26 => [2, 3],
                27 => [6, 9],
                28 => [2, 7],
                29 => [6, 7]
            ],
            "marco" => [
                1 => [1, 7],
                2 => [2, 7],
                3 => [3, 6],
                4 => [1, 7],
                5 => [5, 7],
                6 => [3, 6],
                7 => [2, 7],
                8 => [3, 6],
                9 => [6, 9],
                10 => [1, 7],
                11 => [1, 7],
                12 => [6, 7],
                13 => [1, 5],
                14 => [5, 7],
                15 => [3, 6],
                16 => [1, 2],
                17 => [3, 6],
                18 => [3, 6],
                19 => [1, 7],
                20 => [2, 7],
                21 => [3, 6],
                22 => [1, 7],
                23 => [6, 7],
                24 => [3, 6],
                25 => [2, 7],
                26 => [1, 3],
                27 => [1, 9],
                28 => [5, 9],
                29 => [1, 7],
                30 => [3, 9],
                31 => [1, 7]
            ],
            "abril" => [
                1 => [1, 7],
                2 => [1, 7],
                3 => [3, 9],
                4 => [1, 7],
                5 => [5, 7],
                6 => [3, 6],
                7 => [5, 7],
                8 => [1, 3],
                9 => [3, 9],
                10 => [1, 7],
                11 => [1, 7],
                12 => [1, 9],
                13 => [1, 7],
                14 => [5, 7],
                15 => [3, 6],
                16 => [1, 2],
                17 => [1, 3],
                18 => [1, 3],
                19 => [1, 7],
                20 => [2, 7],
                21 => [1, 3],
                22 => [1, 7],
                23 => [5, 7],
                24 => [3, 5],
                25 => [5, 7],
                26 => [2, 3],
                27 => [3, 6],
                28 => [2, 7],
                29 => [1, 7],
                30 => [3, 6]
            ],
            "maio" => [
                1 => [1, 2],
                2 => [2, 7],
                3 => [3, 6],
                4 => [1, 7],
                5 => [5, 6],
                6 => [5, 6],
                7 => [2, 7],
                8 => [2, 5],
                9 => [5, 9],
                10 => [1, 5],
                11 => [1, 7],
                12 => [2, 6],
                13 => [1, 7],
                14 => [5, 6],
                15 => [5, 6],
                16 => [2, 5],
                17 => [2, 3],
                18 => [5, 6],
                19 => [1, 2],
                20 => [2, 7],
                21 => [3, 6],
                22 => [1, 7],
                23 => [5, 6],
                24 => [5, 6],
                25 => [2, 7],
                26 => [2, 5],
                27 => [5, 9],
                28 => [2, 7],
                29 => [5, 7],
                30 => [5, 6],
                31 => [1, 5]
            ],
            "junho" => [
                1 => [1, 5],
                2 => [2, 7],
                3 => [5, 6],
                4 => [1, 5],
                5 => [5, 6],
                6 => [5, 6],
                7 => [2, 7],
                8 => [3, 5],
                9 => [5, 9],
                10 => [1, 5],
                11 => [5, 7],
                12 => [5, 6],
                13 => [1, 5],
                14 => [5, 6],
                15 => [5, 6],
                16 => [2, 5],
                17 => [2, 5],
                18 => [5, 6],
                19 => [1, 5],
                20 => [2, 7],
                21 => [5, 6],
                22 => [1, 5],
                23 => [5, 6],
                24 => [5, 6],
                25 => [2, 7],
                26 => [2, 5],
                27 => [5, 6],
                28 => [2, 7],
                29 => [1, 7],
                30 => [2, 3]
            ],
            "julho" => [
                1 => [1, 2],
                2 => [2, 7],
                3 => [2, 3],
                4 => [1, 7],
                5 => [5, 7],
                6 => [2, 6],
                7 => [2, 7],
                8 => [2, 3],
                9 => [2, 3],
                10 => [1, 2],
                11 => [1, 7],
                12 => [2, 6],
                13 => [1, 2],
                14 => [5, 7],
                15 => [6, 7],
                16 => [1, 2],
                17 => [2, 3],
                18 => [2, 3],
                19 => [1, 2],
                20 => [2, 7],
                21 => [3, 6],
                22 => [1, 2],
                23 => [5, 7],
                24 => [6, 7],
                25 => [2, 7],
                26 => [2, 3],
                27 => [1, 9],
                28 => [2, 7],
                29 => [1, 7],
                30 => [3, 6],
                31 => [1, 7]
            ],
            "agosto" => [
                1 => [1, 7],
                2 => [1, 7],
                3 => [3, 6],
                4 => [1, 7],
                5 => [5, 6],
                6 => [3, 6],
                7 => [2, 7],
                8 => [2, 3],
                9 => [3, 6],
                10 => [1, 7],
                11 => [1, 7],
                12 => [2, 7],
                13 => [1, 7],
                14 => [5, 6],
                15 => [1, 6],
                16 => [1, 2],
                17 => [3, 6],
                18 => [3, 6],
                19 => [1, 7],
                20 => [2, 7],
                21 => [3, 6],
                22 => [1, 7],
                23 => [5, 7],
                24 => [3, 6],
                25 => [2, 7],
                26 => [2, 3],
                27 => [1, 9],
                28 => [5, 9],
                29 => [1, 7],
                30 => [3, 6],
                31 => [1, 5]
            ],
            "setembro" => [
                1 => [1, 5],
                2 => [1, 6],
                3 => [1, 6],
                4 => [1, 7],
                5 => [5, 6],
                6 => [3, 6],
                7 => [2, 7],
                8 => [3, 6],
                9 => [5, 9],
                10 => [1, 5],
                11 => [5, 7],
                12 => [5, 6],
                13 => [1, 5],
                14 => [5, 6],
                15 => [3, 6],
                16 => [1, 5],
                17 => [2, 3],
                18 => [5, 6],
                19 => [1, 5],
                20 => [1, 7],
                21 => [3, 6],
                22 => [1, 7],
                23 => [5, 6],
                24 => [5, 6],
                25 => [2, 7],
                26 => [2, 3],
                27 => [6, 9],
                28 => [2, 7],
                29 => [5, 7],
                30 => [3, 6]
            ],
            "outubro" => [
                1 => [1, 5],
                2 => [1, 6],
                3 => [1, 6],
                4 => [1, 7],
                5 => [5, 7],
                6 => [3, 6],
                7 => [2, 7],
                8 => [2, 3],
                9 => [5, 9],
                10 => [1, 5],
                11 => [5, 7],
                12 => [5, 6],
                13 => [1, 5],
                14 => [5, 6],
                15 => [3, 6],
                16 => [1, 5],
                17 => [2, 3],
                18 => [3, 6],
                19 => [1, 5],
                20 => [1, 6],
                21 => [3, 6],
                22 => [1, 7],
                23 => [5, 7],
                24 => [3, 6],
                25 => [2, 7],
                26 => [2, 3],
                27 => [6, 9],
                28 => [2, 7],
                29 => [5, 7],
                30 => [3, 6],
                31 => [1, 7]
            ],
            "novembro" => [
                1 => [1, 7],
                2 => [1, 7],
                3 => [1, 6],
                4 => [1, 7],
                5 => [5, 6],
                6 => [3, 6],
                7 => [2, 7],
                8 => [3, 6],
                9 => [5, 9],
                10 => [1, 5],
                11 => [5, 7],
                12 => [5, 6],
                13 => [1, 5],
                14 => [5, 6],
                15 => [3, 6],
                16 => [1, 5],
                17 => [2, 3],
                18 => [3, 6],
                19 => [1, 5],
                20 => [1, 6],
                21 => [3, 6],
                22 => [1, 7],
                23 => [5, 7],
                24 => [3, 6],
                25 => [2, 7],
                26 => [2, 3],
                27 => [6, 9],
                28 => [2, 7],
                29 => [5, 7],
                30 => [3, 6]
            ],
            "dezembro" => [
                1 => [1, 5],
                2 => [1, 6],
                3 => [1, 6],
                4 => [1, 7],
                5 => [5, 7],
                6 => [3, 6],
                7 => [2, 7],
                8 => [2, 3],
                9 => [5, 9],
                10 => [1, 5],
                11 => [5, 7],
                12 => [5, 6],
                13 => [1, 5],
                14 => [5, 6],
                15 => [3, 6],
                16 => [1, 5],
                17 => [2, 3],
                18 => [3, 6],
                19 => [1, 5],
                20 => [1, 6],
                21 => [3, 6],
                22 => [1, 7],
                23 => [5, 7],
                24 => [3, 6],
                25 => [2, 7],
                26 => [2, 3],
                27 => [6, 9],
                28 => [2, 7],
                29 => [5, 7],
                30 => [3, 6],
                31 => [1, 3]
            ]
            //verificar se tabela esta correta de agosto a dezembro
        ];
    }

    public static function obterMeses()
    {
        return [
            "janeiro",
            "fevereiro",
            "março",
            "abril",
            "maio",
            "junho",
            "julho",
            "agosto",
            "setembro",
            "outubro",
            "novembro",
            "dezembro"
        ];
    }

    public static function obterProfissoes()
    {
        return [
            'destino' => [
                1 => ["Advogado", "Ator", "Diretor de Escola", "Empreendedor", "Escritor", "Esotérico", "Executivo", "Fazendeiro", "Inventor", "Marketing Digital", "Político", "Publicitário", "Radialista", "Vendedor"],
                2 => ["Advogado Tributarista", "Arqueólogo", "Assistente Social", "Bibliotecário", "Contador", "Diplomata", "Financista", "Médico Sanitarista", "Pesquisador"],
                3 => ["Apresentador de TV", "Artista", "Designer", "Empresário", "Esportista", "Jornalista", "Marketing Digital", "Modelo", "Professor", "Radialista", "Sociólogo", "Youtuber"],
                4 => ["Arquiteto", "Arquiteto", "Bombeiro", "Contador", "Economista", "Engenheiro", "Escritor", "Historiador", "Matemático", "Mecânico", "Negociante de Antiguidades", "Numerólogo", "Policial"],
                5 => ["Arquiteto", "Designer de Interiores", "Esotérico", "Esportista", "Esteticista", "Humorista", "Orador", "Político", "Radialista", "Repórter", "Servidor Público", "Vendedor", "Viajante"],
                6 => ["Advogado", "Alto Executivo", "Conselheiro", "Diplomata", "Médico", "Missionário", "Professor", "Psicólogo", "Religioso", "Servidor Público", "Vendedor"],
                7 => ["Advogado", "Ciência da Computação", "Escritor", "Farmacêutico", "Físico", "Juiz de Direito", "Marinheiro", "Pesquisador", "Pesquisador", "Químico", "Religioso", "Secretário", "Técnico em Comunicação", "Veterinário"],
                8 => ["Advogado", "Agente Teatral", "Bolsa de Valores (Operador)", "Comerciante", "Empresário", "Financista", "Gerente de Loja", "Político", "Vendedor de Artigos de Luxo"],
                9 => ["Advogado", "Arqueólogo", "Artista Plástico", "Escritor", "Esotérico", "Médico", "Missionário", "Pesquisador", "Professor", "Psicólogo", "Religioso"],
                11 => ["Assistente Social", "Consultor","Diplomata","Embaixador", "Engenheiro", "Escritor", "Esotérico", "Filósofo", "Médico", "Político", "Psicanalista"],
                22 =>["Bruxo", "Diplomata", "Empresário", "Esotérico", "Juiz", "Médico", "Professor", "Radialista", "Relações Públicas", "Religioso", "Vendedor"],
            ],
            'missao' => [
                1 => ["Administrador de Empresas", "Artista", "Empresário", "Esotérico", "Especulador Financista", "Político"],
                2 => ["Advogado", "Assistente Social", "Caixa de Banco", "Diplomata", "Escriturário", "Juiz", "Médico", "Professor"],
                3 => ["Artista", "Designer", "Escritor", "Fotógrafo", "Jornalista", "Músico", "Paisagista", "Radialista"],
                4 => ["Dentista", "Engenheiro Civil", "Financista", "Metalúrgico", "Policial", "Político", "Químico"],
                5 => ["Cientista", "Esportista", "Filósofo", "Político", "Professor", "Religioso", "Trabalhos Humanitários"],
                6 => ["Assistente Social", "Enfermeiro", "Esotérico", "Médico", "Metalúrgico", "Professor", "Radialista", "Religioso"],
                7 => ["Diretor de Escola", "Escritor Metafísico", "Explorador", "Historiador", "Pesquisador", "Pregador Religioso", "Professor", "Psicólogo"],
                8 => ["Advogado", "Banqueiro", "Comerciante", "Empresário", "Executivo", "Político"],
                9 => ["Escritor de Livros", "Historiador", "Humanitário", "Orador", "Pesquisador", "Religioso"],
                11 => ["Aviador", "Diplomata", "Esotérico", "Juiz de Direito", "Juiz de Paz", "Médico", "Político"],
                22 => ["Aviador", "Contador", "Esotérico", "Filantropo", "Filósofo", "Financista", "Médico", "Pesquisador", "Político", "Relações Públicas", "Religioso"],
            ],
            'expressao' => [
                1 => ["Alto Executivo", "Arquiteto", "Artista", "Diretor de Empresas", "Embaixador", "Empresário", "Físico Nuclear", "Inventor", "Marketing Digital", "Político", "Turista", "Youtuber"],
                2 => ["Advogado", "Agrimensor", "Bibliotecário", "Conselheiro", "Contador", "Economista", "Eletricista", "Historiador", "Iluminador", "Maquiador", "Mecânico", "Militar", "Tributarista"],
                3 => ["Apresentador", "Ator", "Cantor", "Designer de Interiores", "Empresário de Moda e Beleza", "Escritor", "Humorista", "Marketing Digital", "Pintor", "Radialista", "Vendedor", "Youtuber"],
                4 => ["Arqueólogo", "Astrólogo", "Contador", "Corretor de Imóveis", "Economista", "Engenheiro", "Físico", "Matemático", "Médico", "Metalúrgico", "Militar"],
                5 => ["Empresário", "Esotérico", "Historiador", "Marketing Digital", "Músico", "Político", "Radialista", "Turista", "Vendedor"],
                6 => ["Empresário ramo Alimentação", "Garçom", "Médico", "Músico", "Nutricionista", "Paisagista", "Pesquisador", "Pintor", "Relações Públicas", "Restaurador", "Sociólogo", "Veterinário"],
                7 => ["Ator", "Construção Civil", "Filósofo", "Físico", "Pesquisador", "Político", "Professor", "Religioso"],
                8 => ["Advogado", "Bolsa de Valores (Operador)", "Comerciante", "Empresário", "Executivo", "Financista", "Juiz"],
                9 => ["Assistente Social", "Bombeiro", "Editor de Livros", "Músico", "Oceanógrafo", "Religioso", "Técnico em Comunicação"],
                11 => ["Administrador de Empresas", "Bruxo", "Diretor de Marketing", "Esotérico", "Militar de Alta Patente", "Político", "Psicólogo", "Psiquiatra", "Sociólogo"],
                22 => ["Advogado", "Aeronauta", "Agente Imobiliário", "Banqueiro", "Bruxo", "Cineasta", "Designer de Interiores", "Diplomata", "Fotógrafo", "Gerente de Banco", "Industrial", "Juiz", "Político", "Professor", "Teatrólogo"],
            ],
            'dataNascimento' => [
                1 => ["Arquiteto", "Artista", "Comerciante", "Designer", "Empresário", "Executivo", "Líder Religioso", "Piloto de Automóvel"],
                2 => ["Advogado", "Atividades Artísticas", "Diplomata", "Escritor", "Professor", "Publicidade", "Relações Públicas", "Sociólogo"],
                3 => ["Administrador de Empresas", "Artista", "Aviador", "Compositor", "Esportista", "Estilista", "Fotógrafo", "Jornalista", "Operador de Telemarketing", "Radialista", "Vendedor"],
                4 => ["Arquitetura", "Construção Civil", "Contador", "Dentista", "Eletricidade", "Indústrias Metalúrgicas/Mecânicas e Químicas", "Segurança", "Técnico em Geral", "Transporte"],
                5 => ["Agente de Viagens", "Artista", "Desenhista", "Esotérico", "Farmacêutico", "Hoteleiro", "Jogador de Futebol", "Jogador de qualquer Esporte de Massa", "Jornalista", "Marinheiro", "Policial", "Publicitário", "Relações Públicas", "Repórter"],
                6 => ["Ator", "Camareiro", "Compositor", "Corretor de Imóveis", "Cozinheiro", "Decorador", "Enfermeiro", "Esotérico", "Floricultor", "Fotógrafo", "Investigador", "Matemático", "Músico", "Nutricionista", "Pecuarista", "Redator", "Religioso", "Servidor Público", "Sociólogo", "Veterinário"],
                7 => ["Advogado", "Analista de Sistemas", "Biólogo", "Cientista", "Cineasta", "Comprador", "Diretor Social", "Editor de Revistas e Jornais", "Escultor", "Filósofo", "Físico", "Juiz de Direito", "Líder Religioso", "Oceanógrafo", "Psicanalista", "Químico", "Secretário"],
                8 => ["Advogado", "Agente Teatral", "Bolsa de Valores (Operador)", "Comerciante de Artigos de Luxo", "Economista", "Executivo", "Financista", "Presidente de Empresas", "Projetista Industrial"],
                9 => ["Advogado", "Bombeiro", "Cientista", "Escultor", "Esotérico", "Filantropo", "Jurista", "Marinheiro", "Metalúrgico", "Professor", "Religioso", "Técnico em Comunicação"],
                10 => ["Arquiteto", "Chefe", "Comerciante", "Consultor", "Diplomata", "Diretor", "Empreiteiro de Obras", "Engenheiro", "Esportista", "Jornalista", "Metalúrgico", "Radialista", "Vendedor"],
                11 => ["Assistente Social", "Consultor", "Diplomata", "Engenheiro", "Escritor", "Esotérico", "Filósofo", "Historiador", "Investigador", "Juiz de Direito", "Médico", "Negociante de Antiguidades", "Político", "Professor", "Psicólogo", "Repórter"],
                12 => ["Administrador de Empresas", "Ator", "Aviador", "Compositor", "Designer", "Escultor", "Esportista", "Estilista", "Músico", "Numerólogo", "Político", "Radialista", "Vendedor"],
                13 => ["Administrador de Empresas", "Arqueólogo", "Ator", "Ator (trabalhar em circo)", "Contador", "Dentista", "Engenheiro Civil", "Engenheiro Eletrônico", "Médico", "Médico Cirurgião", "Militar", "Político", "Químico", "Sociólogo"],
                14 => ["Cantor", "Escritor", "Farmacêutico", "Financista", "Investigador de Polícia", "Jornalista", "Músico", "Negociante", "Político", "Psicoterapeuta", "Psiquiatra", "Relações Públicas", "Repórter", "Sociólogo"],
                15 => ["Administrador Hospitalar", "Ator", "Beleza", "Decorador", "Esotérico", "Estilista", "Floricultor", "Líder Comunitário", "Moda", "Religioso"],
                16 => ["Advogado", "Analista de Sistemas", "Cientista", "Comunicação", "Escritor", "Historiador", "Jornalista", "Matemático", "Pesquisador", "Político", "Professor", "Psicólogo", "Radialista", "Veterinário"],
                17 => ["Advogado Tributarista", "Comerciante", "Comércio Exterior", "Conselheiro", "Consultor de Grandes Empresas", "Contador", "Corretor de Imóveis", "Diplomata", "Economista", "Executivo", "Gerente de Loja", "Político", "Relações Públicas", "Religioso"],
                18 => ["Ambientalista", "Artista", "Cientista", "Esotérico", "Físico Quântico", "Massagista", "Médico Naturalista", "Músico", "Padre", "Pastor", "Psiquiatra", "Religioso", "Veterinário"],
                19 => ["Arqueólogo", "Arquivista", "Bibliotecário", "Comprador", "Diplomata", "Embaixador", "Enfermeiro", "Esotérico", "Financista", "Historiador", "Médico", "Músico", "Psicólogo"],
                20 => ["Cozinheiro", "Decorador", "Enfermeiro", "Estatístico", "Médico", "Músico", "Poeta", "Político", "Professor", "Psicólogo", "Relações Públicas", "Secretário", "Vendedor de Artigos de Luxo", "Veterinário"],
                21 => ["Administrador de Empresas", "Atleta", "Ator Teatral", "Crítico de Arte", "Crítico Literário", "Estilista de Moda", "Fotógrafo", "Jornalista", "Moda", "Radialista", "Telefonista"],
                22 => ["Artista", "Assistente Social", "Aviador", "Cientista", "Comerciante de Artigos de Luxo", "Conferencista", "Embaixador", "Escritor", "Escultor", "Executivo", "Filantropo", "Filósofo", "Inventor", "Líder Religioso", "Político"],
                23 => ["Artista", "Aviador", "Desenhista", "Diplomata", "Escritor", "Escritor Metafísico", "Farmacêutico", "Jornalista", "Mecânico", "Médico", "Político", "Psicólogo", "Psiquiatra", "Radialista", "Relações Públicas", "Repórter", "Terapeuta Holístico", "Vendedor"],
                24 => ["Administrador Hospitalar", "Cozinheiro", "Decorador", "Esotérico", "Floricultor", "Fotógrafo", "Marceneiro", "Mecânico", "Médico", "Mordomo", "Nutricionista", "Professor", "Psicólogo", "Técnico Eletrônico", "Veterinário"],
                25 => ["Advogado", "Astrólogo", "Biólogo", "Cientista", "Cineasta", "Comunicador", "Corretor de Imóveis", "Esotérico", "Filósofo", "Financista", "Marinha", "Oceanógrafo", "Político", "Professor", "Sociólogo"],
                26 => ["Advogado", "Ator Teatral", "Ator", "Comerciante", "Comprador", "Construtor", "Engenheiro Civil", "Esotérico", "Executivo", "Gerente de Loja", "Juiz", "Político", "Professor"],
                27 => ["Advogado", "Aviador", "Biólogo", "Cientista", "Comunicador", "Empreendedor", "Esportista", "Filantropo", "Investidor", "Oficial do Exército", "Polícia Militar", "Policial", "Presidente de Empresa", "Turista", "Vendedor"],
                28 => ["Arquiteto", "Assistente Social", "Consultor", "Diplomata", "Eletricista", "Esportista", "Executivo", "Líder Religioso", "Policial", "Técnico em Comunicação", "Técnico-Eletrônica"],
                29 => ["Advogado", "Comerciante", "Escritor", "Esotérico", "Jornalista", "Juiz de Direito", "Professor", "Publicitário", "Radialista", "Relações Públicas", "Religioso", "Repórter", "Treinador"],
                30 => ["Apresentador", "Ator", "Empresário", "Engenheiro", "Esteticista", "Filantropo", "Jornalista", "Maquiador", "Operador de Telemarketing", "Sociólogo", "Vendedor", "Viajante"],
                31 => ["Arquiteto", "Aviador", "Economista", "Empreiteiro de Obras", "Escultor", "Mecânico", "Militar", "Numerólogo", "Paisagista", "Pintor", "Relações Públicas", "Secretário", "Técnico em Eletrônica"],
            ],
        ];
    }

    public static function obterAnjos()
    {
        return [
            1 => [
                'anjo' => 'Vehuiah',
                'numero' => 1,
                'datas' => ['06 Jan', '20 Mar', '01 Jun', '13 Ago', '25 Out']
            ],
            2 => [
                'anjo' => 'Jeliel',
                'numero' => 2,
                'datas' => ['07 Jan', '21 Mar', '02 Jun', '14 Ago', '26 Out']
            ],
            3 => [
                'anjo' => 'Sitael',
                'numero' => 3,
                'datas' => ['08 Jan', '22 Mar', '03 Jun', '15 Ago', '27 Out']
            ],
            4 => [
                'anjo' => 'Elemiah',
                'numero' => 4,
                'datas' => ['09 Jan', '23 Mar', '04 Jun', '16 Ago', '28 Out']
            ],
            5 => [
                'anjo' => 'Mahasiah',
                'numero' => 5,
                'datas' => ['10 Jan', '24 Mar', '05 Jun', '17 Ago', '29 Out']
            ],
            6 => [
                'anjo' => 'Lelahel',
                'numero' => 6,
                'datas' => ['11 Jan', '25 Mar', '06 Jun', '18 Ago', '30 Out']
            ],
            7 => [
                'anjo' => 'Achaiah',
                'numero' => 7,
                'datas' => ['12 Jan', '26 Mar', '07 Jun', '19 Ago', '31 Out']
            ],
            8 => [
                'anjo' => 'Cahethel',
                'numero' => 8,
                'datas' => ['13 Jan', '27 Mar', '08 Jun', '20 Ago', '01 Nov']
            ],
            9 => [
                'anjo' => 'Haziel',
                'numero' => 9,
                'datas' => ['14 Jan', '28 Mar', '09 Jun', '21 Ago', '02 Nov']
            ],
            10 => [
                'anjo' => 'Aladiah',
                'numero' => 10,
                'datas' => ['15 Jan', '29 Mar', '10 Jun', '22 Ago', '03 Nov']
            ],
            11 => [
                'anjo' => 'Laoviah',
                'numero' => 11,
                'datas' => ['16 Jan', '30 Mar', '11 Jun', '23 Ago', '04 Nov']
            ],
            12 => [
                'anjo' => 'Hahahiah',
                'numero' => 12,
                'datas' => ['17 Jan', '31 Mar', '12 Jun', '24 Ago', '05 Nov']
            ],
            13 => [
                'anjo' => 'Yesalel',
                'numero' => 13,
                'datas' => ['18 Jan', '01 Abr', '13 Jun', '25 Ago', '06 Nov']
            ],
            14 => [
                'anjo' => 'Mebahel',
                'numero' => 14,
                'datas' => ['19 Jan', '02 Abr', '14 Jun', '26 Ago', '07 Nov']
            ],
            15 => [
                'anjo' => 'Hariel',
                'numero' => 15,
                'datas' => ['20 Jan', '03 Abr', '15 Jun', '27 Ago', '08 Nov']
            ],
            16 => [
                'anjo' => 'Hekamiah',
                'numero' => 16,
                'datas' => ['21 Jan', '04 Abr', '16 Jun', '28 Ago', '09 Nov']
            ],
            17 => [
                'anjo' => 'Lauviah',
                'numero' => 17,
                'datas' => ['22 Jan', '05 Abr', '17 Jun', '29 Ago', '10 Nov']
            ],
            18 => [
                'anjo' => 'Caliel',
                'numero' => 18,
                'datas' => ['23 Jan', '06 Abr', '18 Jun', '30 Ago', '11 Nov']
            ],
            19 => [
                'anjo' => 'Leuviah',
                'numero' => 19,
                'datas' => ['24 Jan', '07 Abr', '19 Jun', '31 Ago', '12 Nov']
            ],
            20 => [
                'anjo' => 'Pahaliah',
                'numero' => 20,
                'datas' => ['25 Jan', '08 Abr', '20 Jun', '01 Set', '13 Nov']
            ],
            21 => [
                'anjo' => 'Nelchael',
                'numero' => 21,
                'datas' => ['26 Jan', '09 Abr', '21 Jun', '02 Set', '14 Nov']
            ],
            22 => [
                'anjo' => 'Leiaiel',
                'numero' => 22,
                'datas' => ['27 Jan', '10 Abr', '22 Jun', '03 Set', '15 Nov']
            ],
            23 => [
                'anjo' => 'Melahel',
                'numero' => 23,
                'datas' => ['28 Jan', '11 Abr', '23 Jun', '04 Set', '16 Nov']
            ],
            24 => [
                'anjo' => 'Hahehuiah',
                'numero' => 24,
                'datas' => ['29 Jan', '12 Abr', '24 Jun', '05 Set', '17 Nov']
            ],
            25 => [
                'anjo' => 'Nith-Haiah',
                'numero' => 25,
                'datas' => ['30 Jan', '13 Abr', '25 Jun', '06 Set', '18 Nov']
            ],
            26 => [
                'anjo' => 'Haaiah',
                'numero' => 26,
                'datas' => ['31 Jan', '14 Abr', '26 Jun', '07 Set', '19 Nov']
            ],
            27 => [
                'anjo' => 'Ieratehl',
                'numero' => 27,
                'datas' => ['01 Fev', '15 Abr', '27 Jun', '08 Set', '20 Nov']
            ],
            28 => [
                'anjo' => 'Seheiah',
                'numero' => 28,
                'datas' => ['02 Fev', '16 Abr', '28 Jun', '09 Set', '21 Nov']
            ],
            29 => [
                'anjo' => 'Reyel',
                'numero' => 29,
                'datas' => ['03 Fev', '17 Abr', '29 Jun', '10 Set', '22 Nov']
            ],
            30 => [
                'anjo' => 'Omael',
                'numero' => 30,
                'datas' => ['04 Fev', '18 Abr', '30 Jun', '11 Set', '23 Nov']
            ],
            31 => [
                'anjo' => 'Lecabel',
                'numero' => 31,
                'datas' => ['05 Fev', '19 Abr', '01 Jul', '12 Set', '24 Nov']
            ],
            32 => [
                'anjo' => 'Vasahiah',
                'numero' => 32,
                'datas' => ['06 Fev', '20 Abr', '02 Jul', '13 Set', '25 Nov']
            ],
            33 => [
                'anjo' => 'Lehuiah',
                'numero' => 33,
                'datas' => ['07 Fev', '21 Abr', '03 Jul', '14 Set', '26 Nov']
            ],
            34 => [
                'anjo' => 'Lehahiah',
                'numero' => 34,
                'datas' => ['08 Fev', '22 Abr', '04 Jul', '15 Set', '27 Nov']
            ],
            35 => [
                'anjo' => 'Chavakiah',
                'numero' => 35,
                'datas' => ['09 Fev', '23 Abr', '05 Jul', '16 Set', '28 Nov']
            ],
            36 => [
                'anjo' => 'Menadel',
                'numero' => 36,
                'datas' => ['10 Fev', '24 Abr', '06 Jul', '17 Set', '29 Nov']
            ],
            37 => [
                'anjo' => 'Aniel',
                'numero' => 37,
                'datas' => ['11 Fev', '25 Abr', '07 Jul', '18 Set', '30 Nov']
            ],
            38 => [
                'anjo' => 'Haamiah',
                'numero' => 38,
                'datas' => ['12 Fev', '26 Abr', '08 Jul', '19 Set', '01 Dez']
            ],
            39 => [
                'anjo' => 'Rehael',
                'numero' => 39,
                'datas' => ['13 Fev', '27 Abr', '09 Jul', '20 Set', '02 Dez']
            ],
            40 => [
                'anjo' => 'Ieiazel',
                'numero' => 40,
                'datas' => ['14 Fev', '28 Abr', '10 Jul', '21 Set', '03 Dez']
            ],
            41 => [
                'anjo' => 'Hahahel',
                'numero' => 41,
                'datas' => ['15 Fev', '29 Abr', '11 Jul', '22 Set', '04 Dez']
            ],
            42 => [
                'anjo' => 'Mikael',
                'numero' => 42,
                'datas' => ['16 Fev', '30 Abr', '12 Jul', '23 Set', '05 Dez']
            ],
            43 => [
                'anjo' => 'Veuliah',
                'numero' => 43,
                'datas' => ['17 Fev', '01 Mai', '13 Jul', '24 Set', '06 Dez']
            ],
            44 => [
                'anjo' => 'Yelahiah',
                'numero' => 44,
                'datas' => ['18 Fev', '02 Mai', '14 Jul', '25 Set', '07 Dez']
            ],
            45 => [
                'anjo' => 'Sehaliah',
                'numero' => 45,
                'datas' => ['19 Fev', '03 Mai', '15 Jul', '26 Set', '08 Dez']
            ],
            46 => [
                'anjo' => 'Ariel',
                'numero' => 46,
                'datas' => ['20 Fev', '04 Mai', '16 Jul', '27 Set', '09 Dez']
            ],
            47 => [
                'anjo' => 'Asaliah',
                'numero' => 47,
                'datas' => ['21 Fev', '05 Mai', '17 Jul', '28 Set', '10 Dez']
            ],
            48 => [
                'anjo' => 'Mihael',
                'numero' => 48,
                'datas' => ['22 Fev', '06 Mai', '18 Jul', '29 Set', '11 Dez']
            ],
            49 => [
                'anjo' => 'Vehuel',
                'numero' => 49,
                'datas' => ['23 Fev', '07 Mai', '19 Jul', '30 Set', '12 Dez']
            ],
            50 => [
                'anjo' => 'Daniel',
                'numero' => 50,
                'datas' => ['24 Fev', '08 Mai', '20 Jul', '01 Out', '13 Dez']
            ],
            51 => [
                'anjo' => 'Hahasiah',
                'numero' => 51,
                'datas' => ['25 Fev', '09 Mai', '21 Jul', '02 Out', '14 Dez']
            ],
            52 => [
                'anjo' => 'Imamiah',
                'numero' => 52,
                'datas' => ['26 Fev', '10 Mai', '22 Jul', '03 Out', '15 Dez']
            ],
            53 => [
                'anjo' => 'Nanael',
                'numero' => 53,
                'datas' => ['27 Fev', '11 Mai', '23 Jul', '04 Out', '16 Dez']
            ],
            54 => [
                'anjo' => 'Nithael',
                'numero' => 54,
                'datas' => ['28 Fev', '12 Mai', '24 Jul', '05 Out', '17 Dez']
            ],
            55 => [
                'anjo' => 'Mebaiah',
                'numero' => 55,
                'datas' => ['01 Mar', '13 Mai', '25 Jul', '06 Out', '18 Dez']
            ],
            56 => [
                'anjo' => 'Poiel',
                'numero' => 56,
                'datas' => ['02 Mar', '14 Mai', '26 Jul', '07 Out', '19 Dez']
            ],
            57 => [
                'anjo' => 'Nemamiah',
                'numero' => 57,
                'datas' => ['03 Mar', '15 Mai', '27 Jul', '08 Out', '20 Dez']
            ],
            58 => [
                'anjo' => 'Ieialel',
                'numero' => 58,
                'datas' => ['04 Mar', '16 Mai', '28 Jul', '09 Out', '21 Dez']
            ],
            59 => [
                'anjo' => 'Harael',
                'numero' => 59,
                'datas' => ['05 Mar', '17 Mai', '29 Jul', '10 Out', '22 Dez']
            ],
            60 => [
                'anjo' => 'Mitzrael',
                'numero' => 60,
                'datas' => ['06 Mar', '18 Mai', '30 Jul', '11 Out', '23 Dez']
            ],
            61 => [
                'anjo' => 'Umabel',
                'numero' => 61,
                'datas' => ['07 Mar', '19 Mai', '31 Jul', '12 Out', '24 Dez']
            ],
            62 => [
                'anjo' => 'Iah-hel',
                'numero' => 62,
                'datas' => ['08 Mar', '20 Mai', '01 Ago', '13 Out', '25 Dez']
            ],
            63 => [
                'anjo' => 'Anauel',
                'numero' => 63,
                'datas' => ['09 Mar', '21 Mai', '02 Ago', '14 Out', '26 Dez']
            ],
            64 => [
                'anjo' => 'Mehiel',
                'numero' => 64,
                'datas' => ['10 Mar', '22 Mai', '03 Ago', '15 Out', '27 Dez']
            ],
            65 => [
                'anjo' => 'Damabiah',
                'numero' => 65,
                'datas' => ['11 Mar', '23 Mai', '04 Ago', '16 Out', '28 Dez']
            ],
            66 => [
                'anjo' => 'Manakel',
                'numero' => 66,
                'datas' => ['12 Mar', '24 Mai', '05 Ago', '17 Out', '29 Dez']
            ],
            67 => [
                'anjo' => 'Eyael',
                'numero' => 67,
                'datas' => ['13 Mar', '25 Mai', '06 Ago', '18 Out', '30 Dez']
            ],
            68 => [
                'anjo' => 'Habuhiah',
                'numero' => 68,
                'datas' => ['14 Mar', '26 Mai', '07 Ago', '19 Out', '31 Dez']
            ],
            69 => [
                'anjo' => 'Rochel',
                'numero' => 69,
                'datas' => ['15 Mar', '27 Mai', '08 Ago', '20 Out', '01 Jan']
            ],
            70 => [
                'anjo' => 'Jabamiah',
                'numero' => 70,
                'datas' => ['16 Mar', '28 Mai', '09 Ago', '21 Out', '02 Jan']
            ],
            71 => [
                'anjo' => 'Haiiel',
                'numero' => 71,
                'datas' => ['17 Mar', '29 Mai', '10 Ago', '22 Out', '03 Jan']
            ],
            72 => [
                'anjo' => 'Mumiah',
                'numero' => 72,
                'datas' => ['18 Mar', '30 Mai', '11 Ago', '23 Out', '04 Jan']
            ]
        ];
    }

    public static function sequenciasVibracionais()
    {
        $sequenciasNegativas = ['111', '222', '333', '444', '555', '666', '777', '888', '999'];
        $sequenciasPositivas = ['116', '118', '119', '123', '168', '252', '518', '575', '637','665', '667', '757', '922', '923', '924', '925', '926', '927'];
        return [
            'positivas' => $sequenciasPositivas,
            'negativas' => $sequenciasNegativas
        ];
    }

    public static function obterVibracoesResidencia()
    {
        return [
            1 => 'Individualismo',
            2 => 'Sensibilidade e harmonia',
            3 => 'Expressividade e festas',
            4 => 'Estabilidade e Trabalho',
            5 => 'Movimentação e Mobilidade',
            6 => 'Família e Amor',
            7 => 'Concentração e Introspecção',
            8 => 'Materialismo e justiça',
            9 => 'Humanitarismo e Generosidade'
        ];
    }

    public static function obterAreasDeAtuacao()
    {
        return [
            "Academias" => [1, 3],
            "Agricultura" => [6],
            "Alimentação" => [6],
            "Arte em Geral" => [3, 5, 6],
            "Automobilismo" => [1, 5],
            "Animais" => [6, 7],
            "Aeronáutica" => [3, 5],
            "Construção Civil" => [1, 4],
            "Contabilidade" => [2, 4],
            "Comércio em Geral" => [1, 3, 5, 8],
            "Comunicação" => [3],
            "Couro" => [3, 11],
            "Crianças" => [6, 7, 9],
            "Chefia em Geral" => [1, 8],
            "Decoração" => [2, 3, 6],
            "Direito" => [7, 8, 9],
            "Diversão" => [3, 5],
            "Ecologia" => [2, 6, 9, 11, 22],
            "Eletricidade" => [4],
            "Enfermagem" => [2, 6, 9],
            "Erotismo" => [3, 7, 8, 9],
            "Escolas" => [2, 6, 7, 9],
            "Esoterismo" => [7, 9, 11],
            "Esporte" => [1, 3, 5, 8],
            "Estética e Beleza" => [3, 6],
            "Eletrônica" => [7],
            "Finanças" => [1, 4, 8],
            "Forças Armadas - Exército" => [4],
            "Forças Armadas - Aeronáutica" => [3, 11, 22],
            "Forças Armadas - Marinha" => [5, 9],
            "Gráficas" => [1, 4, 7],
            "Hotelaria" => [2, 6],
            "Idosos" => [6, 7],
            "Indústrias Mecânicas" => [1, 4, 7],
            "Indústrias Metalúrgicas" => [1, 4, 7],
            "Indústrias Químicas" => [1, 4, 7],
            "Informática" => [7],
            "Jardinagem" => [6],
            "Limpeza" => [1, 4],
            "Literatura" => [3, 6, 7, 9],
            "Marketing" => [3, 5],
            "Medicina" => [6, 7, 9, 11],
            "Medicina Alternativa" => [6, 9, 11],
            "Meio Ambiente" => [2, 6, 9],
            "Mercado de Capitais" => [4, 8],
            "Mercado / Hipermercado" => [1, 3, 5, 8],
            "Nutrição" => [6],
            "Odontologia" => [4, 6, 7, 9],
            "Polícia (Segurança)" => [2, 4, 8, 9],
            "Política" => [1, 5, 7, 8, 11, 22],
            "Processamento de Dados" => [7],
            "Recursos Humanos" => [1, 6, 9],
            "Shoppings e Lojas" => [2, 4, 8],
            "Serviços Domésticos" => [2],
            "Serviços Sociais" => [2, 6, 7, 9],
            "Telemarketing" => [3, 5],
            "Terapias Alternativas" => [2, 6, 9],
            "Transporter" => [4, 5, 6, 7],
            "Turismo" => [2, 5]
        ];
    }
}

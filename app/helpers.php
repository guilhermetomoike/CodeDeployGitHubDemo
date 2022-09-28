<?php

use GuzzleHttp\Client;
use Illuminate\Support\Carbon as CarbonAlias;

function normalizePhoneNumber($value)
{
    $phone = str_replace(['+55', '(', ')', ' ', '-'], '', $value);
    if (strlen($phone) === 10) {
        $ddd = substr($phone, 0, 2);
        $n = substr($phone, 2);
        return "{$ddd}9{$n}";
    } else if (strlen($phone) === 11) return $phone;
    dd($phone);
}

function monthLabel($key)
{
    $monthLabel = [
        'Janeiro',
        'Fevereiro',
        'Março',
        'Abril',
        'Maio',
        'Junho',
        'Julho',
        'Agosto',
        'Setembro',
        'Outubro',
        'Novembro',
        'Dezembro'
    ];

    return $monthLabel[$key - 1];
}

if (!function_exists('formata_moeda')) {
    /**
     * Converte um valor float ou int para moeda brasileira
     *
     * @param $value
     *
     * @param bool $with_currency
     *
     * @param string $currency_type
     *
     * @return string|null
     */
    function formata_moeda(float $value, ?bool $with_currency = false, ?string $currency_type = 'R$'): ?string
    {
        $value = number_format($value, 2, ',', '.');

        if ($with_currency) {
            return $value = $currency_type . ' ' . $value;
        }

        return $value;
    }
}

if (!function_exists('formata_moeda_db')) {
    /**
     * Remove os pontos e substitui a virgula pelo ponto
     *
     * Retorna o valor formatado para gravar no banco
     *
     * @param string $value
     *
     * @return float|null
     */
    function formata_moeda_db(string $value): ?float
    {
        $value = preg_replace('/[^\d,\.]/', '', $value);
        $source = ['.', ','];
        $replace = ['', '.'];
        $value = str_replace($source, $replace, $value);

        return floatval($value);
    }
}

/**
 * remove tudo que nao for numero de uma string e retorna int
 *
 * @param $number string
 *
 * @return integer
 */
if (!function_exists('only_numbers')) {
    function only_numbers($number): ?int
    {
        return intval(preg_replace('/[^0-9]/', null, $number));
    }
}

/**
 * converte todos os tipos de caracteres especiais de uma string
 *
 * @param $text string
 *
 * @return string
 */
if (!function_exists('clean_string')) {
    function clean_string(string $text): ?string
    {
        $utf8 = [
            '/[áàâãªä]/u' => 'a',
            '/[ÁÀÂÃÄ]/u' => 'A',
            '/[ÍÌÎÏ]/u' => 'I',
            '/[íìîï]/u' => 'i',
            '/[éèêë]/u' => 'e',
            '/[ÉÈÊË]/u' => 'E',
            '/[óòôõºö]/u' => 'o',
            '/[ÓÒÔÕÖ]/u' => 'O',
            '/[úùûü]/u' => 'u',
            '/[ÚÙÛÜ]/u' => 'U',
            '/ç/' => 'c',
            '/Ç/' => 'C',
            '/ñ/' => 'n',
            '/Ñ/' => 'N',
            '/–/' => '-', // UTF-8 hyphen to "normal" hyphen
            '/[’‘‹›‚]/u' => ' ', // Literally a single quote
            '/[“”«»„]/u' => ' ', // Double quote
            '/ /' => ' ', // nonbreaking space (equiv. to 0x160)
        ];
        return preg_replace(array_keys($utf8), array_values($utf8), $text);
    }
}

if (!function_exists('valorPorExtenso')) {
    /**
     * Recebe um valor de moeda  no formato brasileiro e retorna string do valor por extenso
     *
     * @param int|string $valor
     * @param bool $bolExibirMoeda
     * @param bool $bolPalavraFeminina
     * @return string
     */
    function valorPorExtenso($valor = 0, $bolExibirMoeda = true, $bolPalavraFeminina = false)
    {
        $valor = removerFormatacaoNumero($valor);

        $singular = null;
        $plural = null;

        if ($bolExibirMoeda) {
            $singular = ['centavo', 'real', 'mil', 'milhão', 'bilhão', 'trilhão', 'quatrilhão'];
            $plural = ['centavos', 'reais', 'mil', 'milhões', 'bilhões', 'trilhões', 'quatrilhões'];
        } else {
            $singular = ['', '', 'mil', 'milhão', 'bilhão', 'trilhão', 'quatrilhão'];
            $plural = ['', '', 'mil', 'milhões', 'bilhões', 'trilhões', 'quatrilhões'];
        }

        $c = ['', 'cem', 'duzentos', 'trezentos', 'quatrocentos', 'quinhentos', 'seiscentos', 'setecentos', 'oitocentos', 'novecentos'];
        $d = ['', 'dez', 'vinte', 'trinta', 'quarenta', 'cinquenta', 'sessenta', 'setenta', 'oitenta', 'noventa'];
        $d10 = ['dez', 'onze', 'doze', 'treze', 'quatorze', 'quinze', 'dezesseis', 'dezessete', 'dezoito', 'dezenove'];
        $u = ['', 'um', 'dois', 'três', 'quatro', 'cinco', 'seis', 'sete', 'oito', 'nove'];

        if ($bolPalavraFeminina) {
            if ($valor == 1) {
                $u = ['', 'uma', 'duas', 'três', 'quatro', 'cinco', 'seis', 'sete', 'oito', 'nove'];
            } else {
                $u = ['', 'um', 'duas', 'três', 'quatro', 'cinco', 'seis', 'sete', 'oito', 'nove'];
            }
            $c = ['', 'cem', 'duzentas', 'trezentas', 'quatrocentas', 'quinhentas', 'seiscentas', 'setecentas', 'oitocentas', 'novecentas'];
        }

        $z = 0;

        $valor = number_format($valor, 2, '.', '.');
        $inteiro = explode('.', $valor);

        for ($i = 0; $i < count($inteiro); $i++) {
            for ($ii = mb_strlen($inteiro[$i]); $ii < 3; $ii++) {
                $inteiro[$i] = '0' . $inteiro[$i];
            }
        }

        // $fim identifica onde que deve se dar junção de centenas por "e" ou por "," ;)
        $rt = null;
        $fim = count($inteiro) - ($inteiro[count($inteiro) - 1] > 0 ? 1 : 2);
        for ($i = 0; $i < count($inteiro); $i++) {
            $valor = $inteiro[$i];
            $rc = (($valor > 100) && ($valor < 200)) ? 'cento' : $c[$valor[0]];
            $rd = ($valor[1] < 2) ? '' : $d[$valor[1]];
            $ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : '';

            $r = $rc . (($rc && ($rd || $ru)) ? ' e ' : '') . $rd . (($rd && $ru) ? ' e ' : '') . $ru;
            $t = count($inteiro) - 1 - $i;
            $r .= $r ? ' ' . ($valor > 1 ? $plural[$t] : $singular[$t]) : '';
            if ($valor == '000') {
                $z++;
            } elseif ($z > 0) {
                $z--;
            }

            if (($t == 1) && ($z > 0) && ($inteiro[0] > 0)) {
                $r .= (($z > 1) ? ' de ' : '') . $plural[$t];
            }

            if ($r) {
                $rt = $rt . ((($i > 0) && ($i <= $fim) && ($inteiro[0] > 0) && ($z < 1)) ? (($i < $fim) ? ', ' : ' e ') : ' ') . $r;
            }
        }

        $rt = mb_substr($rt, 1);

        return ($rt ? trim($rt) : 'zero');
    }
}

if (!function_exists('removerFormatacaoNumero')) {
    /**
     * Remove a formatacao de moeda brasileira para float
     * @param $strNumero
     * @return mixed|string
     */
    function removerFormatacaoNumero($strNumero)
    {
        $strNumero = trim(str_replace('R$', null, $strNumero));

        $vetVirgula = explode(',', $strNumero);
        if (count($vetVirgula) == 1) {
            $acentos = ['.'];
            $resultado = str_replace($acentos, '', $strNumero);
            return $resultado;
        } elseif (count($vetVirgula) != 2) {
            return $strNumero;
        }

        $strNumero = $vetVirgula[0];
        $strDecimal = mb_substr($vetVirgula[1], 0, 2);

        $acentos = ['.'];
        $resultado = str_replace($acentos, '', $strNumero);
        $resultado = $resultado . '.' . $strDecimal;

        return $resultado;
    }
}

/**
 * Trata número de whatsapp para o padro do db
 *
 * remove o codigo do pais e adiciona o 9 no inicio após o ddd
 *
 * @param $numero
 *
 * @return string
 */
function cleanWappNum($numero)
{
    $numero = preg_replace('/[^0-9]/', null, $numero);

    // remove o codigo do pais (55)
    $numero = substr($numero, 2);

    // trata se o numero possui o 9 depois do ddd
    if (strlen($numero) == 10) {
        $inicio = substr($numero, 0, 2);
        $fim = substr($numero, 2, 10);
        $numero = $inicio . '9' . $fim;
    };

    return $numero;
}

/**
 * Cria mascara em strings ou inteiros
 *
 * @param $val
 *
 * @param string $mask - ex: ##/##.#./#
 *
 * @return string
 */
function mask($val, string $mask)
{
    if ($val == '') {
        return '';
    }
    $maskared = '';
    $k = 0;
    for ($i = 0; $i <= strlen($mask) - 1; $i++) {
        if ($mask[$i] == '#') {
            if (isset($val[$k])) {
                $maskared .= $val[$k++];
            }
        } else {
            if (isset($mask[$i])) {
                $maskared .= $mask[$i];
            }
        }
    }
    return $maskared;
}

if (!function_exists('date_from_br')) {
    /**
     * Converte string de date no formato brasileiro para o padrao db
     *
     * @param $date
     *
     * @param string $format
     * @return string
     */
    function date_from_br($date, $format = 'Y-m-d')
    {
        return \Carbon\Carbon::createFromFormat('d/m/Y', $date)->format($format);
    }
}

if (!function_exists('is_date_br')) {
    /**
     * Verifica se a data informada está no formato brasileiro
     *
     * @param $date
     *
     * @return string
     */
    function is_date_br($date)
    {
        return (bool)preg_match("/^(0[1-9]|[1-2][0    -9]|3[0-1])\/(0[1-9]|1[0-2])\/[0-9]{4}/", $date);
    }
}

if (!function_exists('date_to_format')) {
    /**
     * Coverte data do formato americano
     *
     * @param $date
     *
     * @param string $format
     *
     * @return string
     */
    function date_to_format($date, $format = 'd/m/Y')
    {
        return \Carbon\Carbon::parse($date)->format($format);
    }
}

if (!function_exists('date_for_human')) {
    /**
     * Recebe uma data brasileira ou americana e retorna uma data no formato '00 de mes de 0000' utilizando a funcao strftime
     *
     * @param null $date
     * @param string $format
     * @return string
     */
    function date_for_human($date = null, $format = '%d de %B de %Y')
    {
        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');

        if ($date && is_date_br($date)) {
            $date = date_from_br($date);
        }

        return strftime($format, strtotime($date ?? 'today'));
    }
}

if (!function_exists('competencia_atual')) {
    /**
     * Retorna a competencia atual no formato Y-m-01
     *
     * @return string
     */
    function competencia_atual()
    {
        return today()->format('Y-m-01');
    }
}

if (!function_exists('competencia_anterior')) {
    /**
     * Retorna a competencia anterior no formato Y-m-01
     *
     * @return string
     */
    function competencia_anterior()
    {
        return today()->subMonth()->format('Y-m-01');
    }
}

if (!function_exists('array_filter_recursive')) {
    /**
     * remove chaves nullas de array recursivamente
     *
     * @param $input
     * @return array
     */
    function array_filter_recursive($input)
    {
        foreach ($input as &$value) {
            if (is_array($value)) {
                $value = array_filter_recursive($value);
            }
        }

        return array_filter($input);
    }
}

if (!function_exists('remove_null_recursive')) {
    /**
     * remove chaves nullas de array recursivamente
     *
     * @param $array
     * @param bool $removeEmpty
     * @param bool $remove_false
     * @return array
     */
    function remove_null_recursive($array, $removeEmpty = false, $remove_false = false)
    {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $array[$key] = remove_null_recursive($array[$key]);
            }

            if ($array[$key] === null) {
                unset($array[$key]);
            }

            if ($removeEmpty && empty($array[$key])) {
                unset($array[$key]);
            }

            if ($remove_false && $array[$key] === false) {
                unset($array[$key]);
            }
        }

        return $array;
    }
}

if (!function_exists('consulta_cpnj1')) {
    /**
     * Consulta CNPJ na api da plugnotas
     *
     * @param $cnpj
     * @return bool
     */
    function consulta_cpnj1($cnpj)
    {
        $token = env('API_KEY_PLUGNOTAS');
        $context = stream_context_create([
            'http' => [
                'method' => 'GET',
                'header' => "Content-Type: application/json \r\n" .
                    "x-api-key: $token\r\n"
            ]
        ]);
        try {
            $contents = file_get_contents("https://api.plugnotas.com.br/cnpj/{$cnpj}", null, $context);
            return json_decode($contents);
        } catch (Exception $e) {
            return false;
        }
    }
}

if (!function_exists('consulta_cpnj2')) {
    /**
     * Consulta CNPJ na api da plugnotas
     *
     * @param $cnpj
     * @return bool
     */
    function consulta_cpnj2($cnpj)
    {
        $token = 'f4a159a95da53582e90eb6750400412f';
        $context = stream_context_create([
            'http' => ['method' => 'GET',]
        ]);
        try {
            $contents = file_get_contents("https://api.cpfcnpj.com.br/$token/6/json/{$cnpj}", null, $context);
            return json_decode($contents);
        } catch (Exception $e) {
            return false;
        }
    }
}

if (!function_exists('consulta_cep1')) {
    /**
     * Consulta CEP na api da plugnotas
     *
     * @param $cep
     * @return array
     */
    function consulta_cep1($cep)
    {
        $cep = only_numbers($cep);
        $token = config('services.plugnotas.token');
        $context = stream_context_create([
            'http' => [
                'method' => 'GET',
                'header' => "x-api-key: $token"
            ]
        ]);
        try {
            $contents = file_get_contents("https://api.plugnotas.com.br/cep/{$cep}", null, $context);
        } catch (Throwable $e) {
            return [];
        }

        return json_decode($contents);
    }
}

if (!function_exists('valida_cnpj')) {
    /**
     * Verifica com logica se o cnpj informado é válido
     * @param $Cnpj
     * @return bool|string
     */
    function valida_cnpj($Cnpj)
    {
        $Cnpj = preg_replace('/[^0-9]/', '', (string)$Cnpj);

        if (strlen($Cnpj) != 14) {
            return 'CNPJ faltando caracteres';
        }

        $invalidos = [
            '00000000000000',
            '00000000000',
            '11111111111111',
            '11111111111',
            '22222222222222',
            '22222222222',
            '33333333333333',
            '33333333333',
            '44444444444444',
            '44444444444',
            '55555555555555',
            '55555555555',
            '66666666666666',
            '66666666666',
            '77777777777777',
            '77777777777',
            '88888888888888',
            '88888888888',
            '99999999999999',
            '99999999999'
        ];

        if (in_array($Cnpj, $invalidos)) {
            return 'CNPJ inválido';
        }

        for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++) {
            $soma += $Cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $resto = $soma % 11;

        if ($Cnpj[12] != ($resto < 2 ? 0 : 11 - $resto)) {
            return 'CNPJ inválido';
        }

        for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++) {
            $soma += $Cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $resto = $soma % 11;

        if ($Cnpj[13] != ($resto < 2 ? 0 : 11 - $resto)) {
            return 'CNPJ inválido';
        }

        return true;
    }
}

if (!function_exists('formata_cnpj_bd')) {
    function formata_cnpj_bd($cnpjEntrada)
    {
        $cnpj = str_replace('-', '', $cnpjEntrada);
        $cnpj = str_replace('/', '', $cnpj);
        $cnpj = str_replace('.', '', $cnpj);

        return $cnpj;
    }
}

if (!function_exists('trimestre')) {
    /**
     * Retorna um array do ultimo trimestre contendo a data de inicio e fim
     *
     * @return array
     */
    function trimestre()
    {
        $competence = CarbonAlias::create(competencia_anterior());

        $year = $competence->year;
        $month = $competence->month;

        if ($month >= 1 && $month <= 3) {
            $initialTrimester = 1;
            $endTrimester = 3;
        }

        if ($month >= 4 && $month <= 6) {
            $initialTrimester = 4;
            $endTrimester = 6;
        }

        if ($month >= 7 && $month <= 9) {
            $initialTrimester = 7;
            $endTrimester = 9;
        }

        if ($month >= 10 && $month <= 12) {
            $initialTrimester = 10;
            $endTrimester = 12;
        }

        $initial = CarbonAlias::createFromDate($year, $initialTrimester, 01)->format('Y-m-d');
        $end = CarbonAlias::createFromDate($year, $endTrimester)->endOfMonth()->format('Y-m-d');

        return [
            'inicio' => $initial,
            'fim' => $end
        ];
    }
}

if (!function_exists('salario_minimo')) {
    /**
     * Retorna o valor do Salario Minimo Brasileiro
     *
     * @return string
     */
    function salario_minimo()
    {
        return 1212;
    }
}

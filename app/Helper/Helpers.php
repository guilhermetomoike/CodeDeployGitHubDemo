<?php

namespace App\Helper;

use Carbon\Carbon;

class Helpers
{

    public static function badgeColorPrioridade($data_vencimento)
    {
        if ($data_vencimento == '') return 'secondary';
        $hoje = new \DateTime();
        $data_vencimento = new \DateTime($data_vencimento);
        $diff = $hoje->diff($data_vencimento);
        $diasRestantes = $diff->days;
        $invert = $diff->invert;

        switch (true) {
            case $invert:
                return 'secondary text-dark';
                break;
            case ($diasRestantes <= 15):
                return 'danger';
                break;
            case ($diasRestantes <= 30):
                return 'warning';
                break;
            default:
                return 'secondary';
        }
    }

    public static function mask($val, $mask)
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

    public static function retiraAcentos($entrada)
    {
        return preg_replace(array("/(á|à|ã|â|ä)/", "/(Á|À|Ã|Â|Ä)/", "/(é|è|ê|ë)/", "/(É|È|Ê|Ë)/", "/(í|ì|î|ï)/", "/(Í|Ì|Î|Ï)/", "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/", "/(ú|ù|û|ü)/", "/(Ú|Ù|Û|Ü)/", "/(ñ)/", "/(Ñ)/"), explode(" ", "a A e E i I o O u U n N"), $entrada);
    }

    public function retiraCaracteresEspeciais($entrada)
    {
        return preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities(trim($entrada)));
    }

    public static function retiraCaracterEspecial($entrada)
    {
        return preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities(trim($entrada)));
    }

    public static function isUrl($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return ($code == 200);
    }

    public static function redirect($caminho)
    {
        echo "<meta http-equiv=refresh content='26;URL=$caminho' />";
        // echo "<script>location.href='$caminho';</script>";
        die();
    }

    public static function formataDataPeriodo($operacao, $data, $periodo, $formato)
    {
        $date = new \DateTime($data); // data
        $date->$operacao(new \DateInterval($periodo)); // 'P10D'

        return $date->format($formato);// 'Y-m-d'
    }

    public static function formataDataPeriod($operacao, $data, $periodo, $formato)
    {
        $date = \DateTime::createFromFormat('d/m/Y', $data);
        $date->$operacao(new \DateInterval($periodo)); // 'P10D'

        return $date->format($formato);
    }

    public static function modificaDataPeriodo($data, $periodo, $formato)
    {
        $date = \DateTime::createFromFormat('Y-m-d', $data);

        return $date->modify($periodo)->format($formato); // '+1 day'
    }

    public static function calculaDiferencaDatas($dataInicial, $dataFinal, $tipoData)
    {
        $dataInicial = new \DateTime($dataInicial);
        $dataFinal = new \DateTime($dataFinal);
        $intervalo = $dataInicial->diff($dataFinal);

        return $intervalo->$tipoData;
    }

    public static function formataDataVencimentoView($diaVencimento, $dataCompetencia)
    {
        $vencimento = $diaVencimento . '/' . $dataCompetencia;

        $vencimento = str_replace('/', '-', $vencimento);
        $date = new \DateTime($vencimento);

        $competencia = \explode('/', $dataCompetencia);

        if ($competencia[0] == '02') {
            $date->add(new \DateInterval('P28D'));
        } else {
            $date->add(new \DateInterval('P1M'));
        }

        return $date->format('d/m/Y');
    }

    public static function isEmpresaDeOutroEscritorio($nome1, $nome2, $nome3)
    {
        return ($nome1 == $nome2 && $nome1 == $nome3);
    }

    public static function formataNomeGuiaEmail($nomeGuia)
    {
        $nomeGuiaFormatado = substr($nomeGuia, strpos($nomeGuia, '-') + 1);
        $nomeGuiaFormatado = str_replace('.pdf', '', $nomeGuiaFormatado);

        return $nomeGuiaFormatado = str_replace('-', ' e ', $nomeGuiaFormatado);
    }

    function formataObservacaoMesmoAnexo($nomeGuiaFormatado)
    {
        if (strpos($nomeGuiaFormatado, 'e') != false) {
            return '(As duas guias estão no mesmo anexo).';
        }

        return '';
    }

    public static function formataNomeGuia($nomeOriginalGuia, $empresasId, $tipoGuia)
    {
        $ext = strtolower(substr($nomeOriginalGuia, -4));
        $nomeGuia = $empresasId . '-' . $tipoGuia . $ext;

        return $nomeGuia;
    }

    public static function formataCpfBd($cpfEntrada)
    {
        $cpf = str_replace("-", "", $cpfEntrada);
        $cpf = str_replace(".", "", $cpf);

        return $cpf;
    }

    public static function formataMoedaView($moeda_entrada)
    {
        return number_format(floatval($moeda_entrada), 2, ',', '.');
    }

    /**
     * Converte data do formato brasileiro para o DB
     * @param $data
     * @return false|string
     */
    public static function formataDataBd($data)
    {
        if ($data == null) return '';

        $data = str_replace('/', '-', $data);
        return date('Y-m-d', strtotime($data));
    }

    /**
     * formata data do db para o padrao brasileiro dd/mm/yyyy
     * @param $data
     * @return false|string
     */
    public static function formataDataView($data)
    {
        if ($data == '') return 'Não definido';

        return implode('/', array_reverse(explode('-',$data)));
//        return date('d/m/Y', strtotime($data));
    }

    public static function formataDataCompetenciaView($data)
    {
        if ($data == '') return '';

        $date = new \DateTime($data);

        return $date->format('m/Y');
    }

    public static function formataDataCompetenciaUrl($data)
    {
        if ($data == '') return '';

        $date = new \DateTime($data);

        return $date->format('m-Y');
    }

    public static function formataDataCompletaView($data)
    {
        $data_saida = str_replace('-', '', $data);

        return date('d/m/Y H:i:s', strtotime($data_saida));
    }

    public function formataDataCompetencia($data)
    {
        $date = date_create($data);

        return date_format($date, "m/Y");
    }

    public function formataDataPasta($data)
    {
        $date = date_create($data);

        return date_format($date, "m-Y");
    }

    public static function formataPisBd($pis_entrada)
    {
        $pis = str_replace('-', '', $pis_entrada);
        $pis = str_replace('.', '', $pis);

        return $pis;
    }

    /**
     * converte valores brasileiros para padrao do db
     * remove os pontos e substitui a virgula pelo ponto
     * @param $get_valor
     * @return mixed
     */
    public static function formataMoedaBd($get_valor)
    {
        $source = array('.', ',');
        $replace = array('', '.');
        $valor = str_replace($source, $replace, $get_valor); //remove os pontos e substitui a virgula pelo ponto

        return $valor; //retorna o valor formatado para gravar no banco
    }

    /**
     * converte valores brasileiros para padrao do db
     * remove os pontos e substitui a virgula pelo ponto
     * @param $get_valor
     * @return mixed
     */
    public static function formataStringMoeda($get_valor)
    {
        $source = array('.', ',');
        $replace = array('', '.');
        $valor = str_replace($source, $replace, $get_valor); //remove os pontos e substitui a virgula pelo ponto

        return $valor; //retorna o valor formatado para gravar no banco
    }

    public static function formataCnpjView($cnpj)
    {
        if (!$cnpj) return '';
        return $str = preg_replace(
            "/([0-9]{2})([0-9]{3})([0-9]{3})([0-9]{4})([0-9]{2})/",
            "$1.$2.$3/$4-$5",
            $cnpj
        );
    }

    public static function formataCpfView($cpf)
    {
        if (!$cpf) return '';
        return $str = preg_replace(
            "/([0-9]{3})([0-9]{3})([0-9]{3})([0-9]{2})/",
            "$1.$2.$3-$4",
            $cpf
        );
    }

    public static function formataCnpjBd($cnpjEntrada)
    {
        if ($cnpjEntrada == '') {
            return '';
        }

        $cnpj = str_replace("-", "", $cnpjEntrada);
        $cnpj = str_replace("/", "", $cnpj);
        $cnpj = str_replace(".", "", $cnpj);

        return $cnpj;
    }

    public static function formataCepBd($cepEntrada)
    {
        $cep = str_replace("-", "", $cepEntrada);

        return $cep;
    }

    public static function formataTelefoneBd($telefone)
    {
        $telefone_celular = str_replace("(", "", $telefone);
        $telefone_celular = str_replace(")", "", $telefone_celular);
        $telefone_celular = str_replace("-", "", $telefone_celular);
        $telefone_celular = str_replace(" ", "", $telefone_celular);

        return $telefone_celular;
    }

    public static function formataNomeArquivoExistente($nomeArquivo)
    {
        $contador = 0;

        // echo $arquivoSemExtensao . '<br>';

        echo $nomeArquivo . '<br>';

        if (\file_exists($nomeArquivo)) {
            $extensaoArquivo = pathinfo($nomeArquivo, PATHINFO_EXTENSION);
            $arquivoSemExtensao = str_replace('.' . $extensaoArquivo, '', $nomeArquivo);
            $arquivoSemExtensao .= '[__' . ++$contador . '__]';
            $arquivoComExtensao = $arquivoSemExtensao . '.' . $extensaoArquivo;


            self::formataNomeArquivoExistente($arquivoComExtensao);
        }

        return $nomeArquivo;
    }

    public static function formataCnaeBd($valorCnae)
    {
        $cnae = str_replace("-", "", $valorCnae);
        $cnae = str_replace("/", "", $cnae);

        return $cnae;
    }

    public static function removeEspacos($string)
    {
        return preg_replace('/\s+/', '', $string);
    }


    public static function removerFormatacaoNumero( $strNumero )
    {

        $strNumero = trim( str_replace( "R$", null, $strNumero ) );

        $vetVirgula = explode( ",", $strNumero );
        if ( count( $vetVirgula ) == 1 )
        {
            $acentos = array(".");
            $resultado = str_replace( $acentos, "", $strNumero );
            return $resultado;
        }
        else if ( count( $vetVirgula ) != 2 )
        {
            return $strNumero;
        }

        $strNumero = $vetVirgula[0];
        $strDecimal = mb_substr( $vetVirgula[1], 0, 2 );

        $acentos = array(".");
        $resultado = str_replace( $acentos, "", $strNumero );
        $resultado = $resultado . "." . $strDecimal;

        return $resultado;

    }

    public static function valorPorExtenso( $valor = 0, $bolExibirMoeda = true, $bolPalavraFeminina = false )
    {

        $valor = self::removerFormatacaoNumero( $valor );

        $singular = null;
        $plural = null;

        if ( $bolExibirMoeda )
        {
            $singular = array("centavo", "real", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
            $plural = array("centavos", "reais", "mil", "milhões", "bilhões", "trilhões","quatrilhões");
        }
        else
        {
            $singular = array("", "", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
            $plural = array("", "", "mil", "milhões", "bilhões", "trilhões","quatrilhões");
        }

        $c = array("", "cem", "duzentos", "trezentos", "quatrocentos","quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
        $d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta","sessenta", "setenta", "oitenta", "noventa");
        $d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze","dezesseis", "dezessete", "dezoito", "dezenove");
        $u = array("", "um", "dois", "três", "quatro", "cinco", "seis","sete", "oito", "nove");


        if ( $bolPalavraFeminina )
        {

            if ($valor == 1)
            {
                $u = array("", "uma", "duas", "três", "quatro", "cinco", "seis","sete", "oito", "nove");
            }
            else
            {
                $u = array("", "um", "duas", "três", "quatro", "cinco", "seis","sete", "oito", "nove");
            }


            $c = array("", "cem", "duzentas", "trezentas", "quatrocentas","quinhentas", "seiscentas", "setecentas", "oitocentas", "novecentas");


        }


        $z = 0;

        $valor = number_format( $valor, 2, ".", "." );
        $inteiro = explode( ".", $valor );

        for ( $i = 0; $i < count( $inteiro ); $i++ )
        {
            for ( $ii = mb_strlen( $inteiro[$i] ); $ii < 3; $ii++ )
            {
                $inteiro[$i] = "0" . $inteiro[$i];
            }
        }

        // $fim identifica onde que deve se dar junção de centenas por "e" ou por "," ;)
        $rt = null;
        $fim = count( $inteiro ) - ($inteiro[count( $inteiro ) - 1] > 0 ? 1 : 2);
        for ( $i = 0; $i < count( $inteiro ); $i++ )
        {
            $valor = $inteiro[$i];
            $rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
            $rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
            $ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";

            $r = $rc . (($rc && ($rd || $ru)) ? " e " : "") . $rd . (($rd && $ru) ? " e " : "") . $ru;
            $t = count( $inteiro ) - 1 - $i;
            $r .= $r ? " " . ($valor > 1 ? $plural[$t] : $singular[$t]) : "";
            if ( $valor == "000")
                $z++;
            elseif ( $z > 0 )
                $z--;

            if ( ($t == 1) && ($z > 0) && ($inteiro[0] > 0) )
                $r .= ( ($z > 1) ? " de " : "") . $plural[$t];

            if ( $r )
                $rt = $rt . ((($i > 0) && ($i <= $fim) && ($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ") . $r;
        }

        $rt = mb_substr( $rt, 1 );

        return($rt ? trim( $rt ) : "zero");

    }
}

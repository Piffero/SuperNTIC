<?php

function character_limiter($str, $n = 500, $end_char = '&#8230;')
{
    if (strlen($str) < $n) {
        return $str;
    }
    
    return substr($str, 0, $n) . $end_char;
}

function replace_newline($string)
{
    return (string) str_replace(array(
        "\r",
        "\r\n",
        "\n"
    ), '', $string);
}

function number_pad($number, $n)
{
    return str_pad((int) $number, $n, "0", STR_PAD_LEFT);
}

function get_date_converter($oldDate)
{
    if ($oldDate) {
        $arr = explode('/', $oldDate);
        return $arr[2] . '-' . $arr[1] . '-' . $arr[0];
    }
}

function get_date_view($oldDate)
{
    $arr = explode('-', $oldDate);
    if ($arr[0] == null) {
        return null;
    } else {
        return $arr[2] . '/' . $arr[1] . '/' . $arr[0];
    }
}

function get_float_converter($oldFloat)
{
    $arr = explode(',', $oldFloat);
    
    if ($arr[0] == null) {
        return '0.00';
    } else {
        return $arr[0] . '.' . $arr[1];
    }
}

function get_float_view($oldFloat)
{
    $arr = explode('.', $oldFloat);
    
    if ($arr[0] == null) {
        return null;
    } else {
        if ($arr[1] == null or $arr[1] == '00') {
            $arr[1] = '00';
            return $arr[0] . ',' . $arr[1];
        } else {
            return $arr[0] . ',' . $arr[1];
        }
    }
}

function corrigeAcentuacao($texto)
{
    return utf8_decode($texto);
}

/**
 *
 * Converte posição de data do Date Timestamp ao
 * retornar do banco de dados
 *
 * @param string $ts            
 */
function convert_timestamp($ts)
{
    $old = explode(' ', $ts);
    $new = get_date_view($old[0]);
    
    return $new . ' ' . $old[1];
}

/**
 * Função que transforma segundos em: minutos, horas, dias, meses e anos
 * através do tipo "$type" (i,h,d,m,y) retornando o valor através
 * do parâmetro passado por "$var" (int em segundos)
 *
 * @param string $type            
 * @param integer $var            
 */
function conTime($type, $var)
{
    if (! empty($type) and ! empty($var)) {
        if (gettype($var) == 'string') {
            settype($var, 'integer');
        }
        
        switch ($type) {
            case 'i':
                return round($var / 60, 1);
                break;
            
            case 'h':
                return round($var / 3600, 1);
                break;
            
            case 'd':
                return round($var / 86400, 1);
                break;
            
            case 'm':
                return round($var / 2592000, 1);
                break;
            
            case 'y':
                return round($var / 31104000, 1);
                break;
            
            default:
                return 'Um dos parâmetros estâo errados';
                break;
        }
    } else {
        return 'Um dos parâmetros é inexistente.';
    }
}

function zerofiller($string)
{
    switch (strlen($string)) {
        case 1:
            return '0000000' . $string;
            break;
        
        case 2:
            return '000000' . $string;
            break;
        
        case 3:
            return '00000' . $string;
            break;
        
        case 4:
            return '0000' . $string;
            break;
        
        case 5:
            return '000' . $string;
            break;
        
        case 6:
            return '00' . $string;
            break;
        
        case 7:
            return '0' . $string;
            break;
        
        case 8:
            return $string;
            break;
        
        default:
            return $string;
            break;
    }
}

function removeAcento($string)
{
    
    // assume $str esteja em UTF-8
    $map = array(
        
        'À' => 'A',
        'Á' => 'A',
        'Â' => 'A',
        'Ã' => 'A',
        'Ä' => 'A',
        'Å' => 'A',
        'Æ' => 'A',
        'Ç' => 'C',
        'È' => 'E',
        'É' => 'E',
        'Ê' => 'E',
        'Ë' => 'E',
        'Ì' => 'I',
        'Í' => 'I',
        'Î' => 'I',
        'Ï' => 'I',
        'Ð' => 'D',
        'Ñ' => 'N',
        'Ò' => 'O',
        'Ó' => 'O',
        'Ô' => 'O',
        'Õ' => 'O',
        'Ö' => 'O',
        'Ø' => 'O',
        'Ù' => 'U',
        'Ú' => 'U',
        'Û' => 'U',
        'Ü' => 'U',
        'Ý' => 'Y',
        'Ŕ' => 'R',
        'Þ' => 's',
        'ß' => 'B',
        'à' => 'a',
        'á' => 'a',
        'â' => 'a',
        'ã' => 'a',
        'ä' => 'a',
        'å' => 'a',
        'æ' => 'a',
        'ç' => 'c',
        'è' => 'e',
        'é' => 'e',
        'ê' => 'e',
        'ë' => 'e',
        'ì' => 'i',
        'í' => 'i',
        'î' => 'i',
        'ï' => 'i',
        'ð' => 'o',
        'ñ' => 'n',
        'ò' => 'o',
        'ó' => 'o',
        'ô' => 'o',
        'õ' => 'o',
        'ö' => 'o',
        'ø' => 'o',
        'ù' => 'u',
        'ú' => 'u',
        'û' => 'u',
        'ý' => 'y',
        'þ' => 'b',
        'ÿ' => 'y',
        'ŕ' => 'r',
        '°' => ' ',
        'º' => ' '
    );
    
    return strtr($string, $map); // funciona corretamente
}

/**
 * Retorna id do usuário logado
 */
function is_logued()
{
    return $this->Employeer->get_logged_in_employee_info();
}

?>
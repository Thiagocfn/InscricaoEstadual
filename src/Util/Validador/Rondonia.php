<?php

namespace Thiagocfn\InscricaoEstadual\Util\Validador;


use Thiagocfn\InscricaoEstadual\Util\ValidadorInteface;

class Rondonia implements ValidadorInteface
{

    /**
     * Verifica se a inscrição estadual é válida para Rondônia (RO)
     * seguindo a regra: http://www.sintegra.gov.br/Cad_Estados/cad_RO.html
     *
     * @param $inscricao_estadual string Inscrição Estadual que deseja validar.
     * @return bool true caso a inscrição estadual seja válida para esse estado, false caso contrário.
     */
    public static function check($inscricao_estadual)
    {
        $valid = true;
        // se não tiver 14 digitos não é valido
        if (strlen($inscricao_estadual) != 14) {
            $valid = false;
        }
        if ($valid && !self::calculaDigito($inscricao_estadual)) {
            $valid = false;
        }
        return $valid;

    }

    /**
     * Valida o dígito da inscrição estadual
     *
     * Pesos:  6 5 4 3 2 9 8 7 6 5 4 3 2 para calculo do dígito verificador
     * @param $inscricao_estadual string inscricao estadual
     * @return bool true caso o digito seja verificado, false caso contrário.
     */
    protected static function calculaDigito($inscricao_estadual)
    {
        $soma = 0;
        $length = strlen($inscricao_estadual);
        $posicao = $length - 1;
        $peso = 6;
        $corpo = substr($inscricao_estadual, 0, $posicao);
        foreach (str_split($corpo) as $item) {
            $soma += $item * $peso;
            $peso--;
            if ($peso == 1) {
                $peso = 9;
            }
        }

        $resto = $soma % 11;

        $dig = 11 - $resto;

        if ($dig >= 10) {
            $dig -= 10;
        }
        return $dig == $inscricao_estadual[$posicao];
    }
}
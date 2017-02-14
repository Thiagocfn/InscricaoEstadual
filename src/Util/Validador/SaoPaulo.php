<?php

namespace Thiagocfn\InscricaoEstadual\Util\Validador;


use Thiagocfn\InscricaoEstadual\Util\ValidadorInteface;

class SaoPaulo implements ValidadorInteface
{

    /**
     * Verifica se a inscrição estadual é válida para o estado de São Paulo (SP)
     * seguindo a regra: http://www.sintegra.gov.br/Cad_Estados/cad_SP.html
     *
     * @param $inscricao_estadual string Inscrição Estadual que deseja validar.
     * @return bool true caso a inscrição estadual seja válida para esse estado, false caso contrário.
     */
    public static function check($inscricao_estadual)
    {
        $valid = true;
        // se não tiver 12 digitos não é valido
        if (strlen($inscricao_estadual) != 12) {
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
     * FORMATO GERAL: NNNNNNNNDNND
     *
     * Onde: 9º E O 12º são os dígitos verificadores
     * @param $inscricao_estadual string inscricao estadual
     * @return bool true caso o digito seja verificado, false caso contrário.
     */
    protected static function calculaDigito($inscricao_estadual)
    {
        $length = strlen($inscricao_estadual);
        $pos_1dig = $length - 4;
        $pos_2dig = $length - 1;

        $_1dig = self::calculaPrimeiroDigito($inscricao_estadual);

        $_2dig = self::calculaSegundoDigito($inscricao_estadual);

        return $_1dig == $inscricao_estadual[$pos_1dig] && $_2dig == $inscricao_estadual[$pos_2dig];
    }

    /**
     * Cálculo do primeiro dígito verificador 9º dígito
     *
     * @param $inscricao_estadual string inscrição estadual
     * @return int dígito verificador
     */
    private static function calculaPrimeiroDigito($inscricao_estadual)
    {
        $corpo = substr($inscricao_estadual, 0, 8);
        $pesos = [1, 3, 4, 5, 6, 7, 8, 10];
        $soma = 0;
        foreach (str_split($corpo) as $i => $item) {
            $soma += ($item * $pesos[$i]);
        }

        $dig = $soma % 11;

        $strDig = $dig . '';
        $length = strlen($strDig);

        return substr($dig, $length - 1, 1);
    }

    /**
     * Cálculo do segundo dígito verificador.
     *
     * @param $inscricao_estadual string inscrição estadual
     * @return int segundo dígito verificador
     */
    private static function calculaSegundoDigito($inscricao_estadual)
    {
        $corpo = substr($inscricao_estadual, 0, 11);
        $peso = 3;
        $soma = 0;
        foreach (str_split($corpo) as $item) {
            $soma += $item * $peso;
            $peso--;
            if ($peso == 1) {
                $peso = 10;
            }
        }

        $dig = $soma % 11;

        $strDig = $dig . '';
        $length = strlen($strDig);

        return substr($dig, $length - 1, 1);
    }
}
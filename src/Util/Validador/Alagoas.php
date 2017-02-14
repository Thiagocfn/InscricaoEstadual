<?php

namespace Thiagocfn\InscricaoEstadual\Util\Validador;


use Thiagocfn\InscricaoEstadual\Util\ValidadorInteface;

class Alagoas implements ValidadorInteface
{

    /**
     * Verifica se a inscrição estadual é válida para o Alagoas (AL)
     * seguindo a regra: http://www.sintegra.gov.br/Cad_Estados/cad_AL.html
     *
     * @param $inscricao_estadual string Inscrição Estadual que deseja validar.
     * @return bool true caso a inscrição estadual seja válida para esse estado, false caso contrário.
     */
    public static function check($inscricao_estadual)
    {
        $valid = true;
        // se não tiver 9 digitos não é valido
        if (strlen($inscricao_estadual) != 9) {
            $valid = false;
        }
        if ($valid && substr($inscricao_estadual, 0, 2) != '24') {
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
     * Pesos: 9 8 7 6 5 4 3 2 para calculo do dígito
     * @param $inscricao_estadual string inscricao estadual
     * @return bool true caso o digito seja verificado, false caso contrário.
     */
    private static function calculaDigito($inscricao_estadual)
    {

        $peso = 9;
        $posicao = 8;
        $soma = 0;
        for ($i = 0; $i < $posicao; $i++) {
            $soma += $inscricao_estadual[$i] * $peso;
            $peso--;
        }
        $produto = $soma * 10;
        $dig = $produto - (((int)($produto / 11)) * 11);
        //se a diferença for 10 ou 11 então o digito é 0

        if ($dig >= 10) {
            $dig = 0;
        }
        return $dig == $inscricao_estadual[$posicao];
    }
}
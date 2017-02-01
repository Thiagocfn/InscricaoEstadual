<?php

namespace Thiagocfn\InscricaoEstadual\Util\Validador;


use Thiagocfn\InscricaoEstadual\Util\ValidadorInteface;

class Roraima implements ValidadorInteface
{

    /**
     * Verifica se a inscrição estadual é válida para Roraima (RR)
     * seguindo a regra: http://www.sintegra.gov.br/Cad_Estados/cad_RR.html
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
        if (substr($inscricao_estadual, 0, 2) != '24') {
            $valid = false;
        }
        if (!$valid || !self::calculaDigito($inscricao_estadual)) {
            $valid = false;
        }
        return $valid;

    }

    /**
     * Valida o dígito da inscrição estadual
     *
     * Pesos: 1 2 3 4 5 6 7 8 para calculo do dígito
     * @param $inscricao_estadual string inscricao estadual
     * @return bool true caso o digito seja verificado, false caso contrário.
     */
    protected static function calculaDigito($inscricao_estadual)
    {
        $soma = 0;
        $length = strlen($inscricao_estadual);
        $posicao = $length - 1;
        $peso = 1;
        $corpo = substr($inscricao_estadual, 0, $posicao);
        foreach (str_split($corpo) as $item) {
            $soma += $item * $peso;
            $peso++;
        }

        $dig = $soma % 9;

        return $dig == $inscricao_estadual[$posicao];
    }
}
<?php

namespace Thiagocfn\InscricaoEstadual\Util\Validador;


use Thiagocfn\InscricaoEstadual\Util\ValidadorInteface;

class Amapa implements ValidadorInteface
{

    /**
     * Verifica se a inscrição estadual é válida para o Amapa (AP)
     * seguindo a regra: http://www.sintegra.gov.br/Cad_Estados/cad_AP.html
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
        if (substr($inscricao_estadual, 0, 2) != '03') {
            $valid = false;
        }
        if (!self::calculaDigito($inscricao_estadual)) {
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

        //verificando informações de "p" e "d"

        // utilizado no calculo do modulo
        $p = 0;
        // utilizado como verificador alternativo
        $d = 0;
        if (3000001 <= $inscricao_estadual && $inscricao_estadual <= 3017000) {
            $p = 5;
            $d = 0;
        } elseif (3017001 <= $inscricao_estadual && $inscricao_estadual <= 3019022) {
            $p = 9;
            $d = 1;
        }

        $soma = $p;
        for ($i = 0; $i < $posicao; $i++) {
            $soma += $inscricao_estadual[$i] * $peso;
            $peso--;
        }
        $dig = 11 - ($soma % 11);
        //se a diferença for 10 o digito é 0, se for 11 o digito será $d
        if ($dig >= 10) {
            $dig = 0;
            if ($dig == 11) {
                $dig = $d;
            }
        }
        return $dig == $inscricao_estadual[$posicao];
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: tsouza
 * Date: 27/01/17
 * Time: 17:54
 */

namespace Thiagocfn\InscricaoEstadual\Util\Validador;


use Thiagocfn\InscricaoEstadual\Util\ValidadorInteface;

class Acre implements ValidadorInteface
{

    /**
     * Verifica se a inscrição estadual é válida para o Acre (AC)
     * seguindo a regra: http://www.sintegra.gov.br/Cad_Estados/cad_AC.html
     *
     * @param $inscricao_estadual string Inscrição Estadual que deseja validar.
     * @return bool true caso a inscrição estadual seja válida para esse estado, false caso contrário.
     */
    public static function check($inscricao_estadual)
    {
        $valid = true;
        // se não tiver 13 digitos não é valido
        if (strlen($inscricao_estadual) != 13) {
            $valid = false;
        }
        if (substr($inscricao_estadual, 0, 2) != '01') {
            $valid = false;
        }
        if (!self::calculaDigito(1, $inscricao_estadual)) {
            $valid = false;
        }
        if (!self::calculaDigito(2, $inscricao_estadual)) {
            $valid = false;
        }
        return $valid;

    }

    /**
     * Valida o dígito da inscrição estadual
     *
     * Pesos: 4 3 2 9 8 7 6 5 4 3 2 para primeiro digito
     * Pesos: 5 4 3 2 9 8 7 6 5 4 3 2 para segundo digito
     * @param $digito integer 1 ou 2
     * @param $inscricao_estadual string inscricao estadual
     * @return bool true caso o digito seja verificado, false caso contrário.
     */
    private static function calculaDigito($digito, $inscricao_estadual)
    {
        if ($digito === 1) {
            $peso = 4;
            $posicao = 11;
        } else {
            $peso = 5;
            $posicao = 12;
        }
        $soma = 0;
        for ($i = 0; $i < $posicao; $i++) {
            $soma += $inscricao_estadual[$i] * $peso;
            $peso--;
            if ($peso == 1) {
                $peso = 9;
            }
        }
        $dig = 11 - ($soma % 11);
        //se a diferença for 10 ou 11 então o digito é 0
        if ($dig >= 10) {
            $dig = 0;
        }
        return $dig == $inscricao_estadual[$posicao];
    }
}
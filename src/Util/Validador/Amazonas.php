<?php

namespace Thiagocfn\InscricaoEstadual\Util\Validador;


use Thiagocfn\InscricaoEstadual\Util\ValidadorInteface;

class Amazonas implements ValidadorInteface
{

    /**
     * Verifica se a inscrição estadual é válida para o Amazonas (AM)
     * seguindo a regra: http://www.sintegra.gov.br/Cad_Estados/cad_AM.html
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
        $soma = 0;
        for ($i = 0; $i < $posicao; $i++) {
            $soma += $inscricao_estadual[$i] * $peso;
            $peso--;
        }
        if ($soma < 11) {
            $dig = 11 - $soma;
        } else {
            $resto = $soma % 11;
            if ($resto <= 0) {
                $dig = 0;
            } else {
                $dig = 11 - $resto;
            }
        }
        return $dig == $inscricao_estadual[$posicao];
    }
}
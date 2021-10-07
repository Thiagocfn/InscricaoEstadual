<?php

namespace Thiagocfn\InscricaoEstadual\Util\Validador;


use Thiagocfn\InscricaoEstadual\Util\ValidadorInteface;

class Goias implements ValidadorInteface
{

    /**
     * Verifica se a inscrição estadual é válida para Goiás (GO)
     * seguindo a regra: http://www.sintegra.gov.br/Cad_Estados/cad_GO.html
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
        $inicio = substr($inscricao_estadual, 0, 2);
        if ($valid && !in_array($inicio, ['10', '11', '15'])) {
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
    protected static function calculaDigito($inscricao_estadual)
    {
        $peso = 9;
        $posicao = 8;
        $soma = 0;
        $length = strlen($inscricao_estadual);
        $corpo = substr($inscricao_estadual, 0, $length - 1);
        foreach (str_split($corpo) as $item) {
            $soma += $item * $peso;
            $peso--;
        }

        $resto = $soma % 11;

        if ($resto == 0 || $resto == 1) {
            if ($resto == 1 && $corpo >= '10103105' && $corpo <= '10119997'){
                $dig = 1;
            } else {
                $dig = 0;
            }
        } else {
            $dig = 11 - $resto;
        }
        return $dig == $inscricao_estadual[$posicao];
    }
}

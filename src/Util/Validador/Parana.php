<?php

namespace Thiagocfn\InscricaoEstadual\Util\Validador;


use Thiagocfn\InscricaoEstadual\Util\ValidadorInteface;

class Parana implements ValidadorInteface
{

    /**
     * Verifica se a inscrição estadual é válida para o Paraná (PR)
     * seguindo a regra: http://www.sintegra.gov.br/Cad_Estados/cad_PR.html
     *
     * @param $inscricao_estadual string Inscrição Estadual que deseja validar.
     * @return bool true caso a inscrição estadual seja válida para esse estado, false caso contrário.
     */
    public static function check($inscricao_estadual)
    {
        $valid = true;
        if (strlen($inscricao_estadual) !== 10) {
            $valid = false;
        }
        if ($valid && !self::calculaDigitos($inscricao_estadual)) {
            $valid = false;
        }
        return $valid;

    }

    /**
     * Valida o dígito da inscrição estadual
     *
     * Pesos: de 2 a 7 da direita para esquerda
     * @param $inscricao_estadual string inscricao estadual
     * @return bool true caso os digitos sejam verificados, false caso contrário.
     */
    private static function calculaDigitos($inscricao_estadual)
    {

        $length = strlen($inscricao_estadual);
        $corpo = substr($inscricao_estadual, 0, $length - 2);

        // Calculando o primeiro dígito
        $_1dig = self::calculaDigito($corpo);
        //adicionando o primeiro dígito no corpo para calcular o segundo dígito
        $_2dig = self::calculaDigito($corpo . $_1dig);

        $pos2dig = strlen($inscricao_estadual) - 1;

        $pos1dig = strlen($inscricao_estadual) - 2;

        return $inscricao_estadual[$pos1dig] == $_1dig && $inscricao_estadual[$pos2dig] == $_2dig;
    }

    /**
     * Informa o digito para o corpo passado
     * @param $corpo
     * @return int dígito
     */
    private static function calculaDigito($corpo)
    {
        $peso = strlen($corpo) - 5;

        $soma = 0;
        foreach (str_split($corpo) as $digito) {
            $soma += $digito * $peso;
            $peso--;
            if ($peso == 1) {
                $peso = 7;
            }
        }

        $modulo = 11;

        $resto = $soma % $modulo;

        $dig = $modulo - $resto;
        if ($dig >= 10) {
            $dig = 0;
        }

        return $dig;
    }
}
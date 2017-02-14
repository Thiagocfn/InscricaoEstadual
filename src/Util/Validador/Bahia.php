<?php

namespace Thiagocfn\InscricaoEstadual\Util\Validador;


use Thiagocfn\InscricaoEstadual\Util\ValidadorInteface;

class Bahia implements ValidadorInteface
{

    /**
     * Verifica se a inscrição estadual é válida para a Bahia (BA)
     * seguindo a regra: http://www.sintegra.gov.br/Cad_Estados/cad_BA.html
     *
     * @param $inscricao_estadual string Inscrição Estadual que deseja validar.
     * @return bool true caso a inscrição estadual seja válida para esse estado, false caso contrário.
     */
    public static function check($inscricao_estadual)
    {

        $valid = true;
        // se não tiver 8 ou 9 digitos não é valido

        $length = strlen($inscricao_estadual);

        if ($length !== 9 && $length !== 8) {
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
     * Pesos: de "x" a "2", onde x é o tamanho do corpo +1
     * @param $inscricao_estadual string inscricao estadual
     * @return bool true caso os digitos sejam verificados, false caso contrário.
     */
    private static function calculaDigitos($inscricao_estadual)
    {

        $length = strlen($inscricao_estadual);
        $corpo = substr($inscricao_estadual, 0, $length - 2);

        // Calculando o segundo dígito
        $_2dig = self::calculaDigito($corpo);
        //adicionando o segundo dígito no corpo para calcular o primeiro dígito
        $_1dig = self::calculaDigito($corpo . $_2dig);

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
        $peso = strlen($corpo) + 1;

        $soma = 0;
        foreach (str_split($corpo) as $digito) {
            $soma += $digito * $peso;
            $peso--;
        }

        $modulo = self::getModulo($corpo);

        $resto = $soma % $modulo;

        $dig = $modulo - $resto;
        if ($dig >= 10) {
            $dig = 0;
        }

        return $dig;
    }

    /**
     * Identifica qual módulo deve ser usado para o calculo dos dígitos verificadores.
     *
     * @param $inscricao_estadual string inscrição estadual a ser verificada
     * @return integer módulo, 10 caso o primeiro dígito da inscrição estadual seja:0,1,2,3,4,5 ou 8. 11 caso: 6,7 ou 9
     */
    private static function getModulo($inscricao_estadual)
    {
        if (in_array(substr($inscricao_estadual, 0, 1), [0, 1, 2, 3, 4, 5, 8], false)) {
            return 10;
        }
        return 11;
    }
}
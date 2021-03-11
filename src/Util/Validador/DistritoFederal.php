<?php

namespace Thiagocfn\InscricaoEstadual\Util\Validador;


use Thiagocfn\InscricaoEstadual\Util\ValidadorInteface;

class DistritoFederal implements ValidadorInteface
{

    /**
     * Verifica se a inscrição estadual é válida para o Distrito Federal (DF)
     * seguindo a regra: http://www.sintegra.gov.br/Cad_Estados/cad_DF.html
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
        // vai começar em 4 quando o digito a ser verificado for o primeiro, e em 5 quando for o segundo
        $peso = strlen($corpo) - 7;

        $soma = 0;
        foreach (str_split($corpo) as $digito) {
            $soma += $digito * $peso;
            $peso--;
            if ($peso == 1) {
                $peso = 9;
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
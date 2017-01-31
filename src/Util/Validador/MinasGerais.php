<?php

namespace Thiagocfn\InscricaoEstadual\Util\Validador;


use Thiagocfn\InscricaoEstadual\Util\ValidadorInteface;

class MinasGerais implements ValidadorInteface
{

    /**
     * Verifica se a inscrição estadual é válida para Minas Gerais (MG)
     * seguindo a regra: http://www.sintegra.gov.br/Cad_Estados/cad_MG.html
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
        if (!$valid || !self::calculaDigito($inscricao_estadual)) {
            $valid = false;
        }
        return $valid;
    }

    /**
     * Valida o dígito da inscrição estadual
     *
     * FORMATO GERAL: AAABBBBBBCCDD
     *
     * Onde: A= Código do Município
     * B= Número da inscrição
     * C= Número de ordem do estabelecimento
     * D= Dígitos de controle
     * @param $inscricao_estadual string inscricao estadual
     * @return bool true caso o digito seja verificado, false caso contrário.
     */
    protected static function calculaDigito($inscricao_estadual)
    {
        $length = strlen($inscricao_estadual);
        $pos_1dig = $length - 2;
        $pos_2dig = $length - 1;

        $corpo = substr($inscricao_estadual, 0, 11);

        $_1dig = self::calculaPrimeiroDigito($corpo);

        $_2dig = self::calculaSegundoDigito($corpo . $_1dig);

        return $_1dig == $inscricao_estadual[$pos_1dig] && $_2dig == $inscricao_estadual[$pos_2dig];
    }

    /**
     * Cálculo do primeiro dígito sobre o corpo de inscricao estadual a ser calculado
     *
     * @param $corpo string inscricao estadual sem os dois dígitos verificadores
     * @return int dígito verificador
     */
    private static function calculaPrimeiroDigito($corpo)
    {
        /**
         * Igualar as casas para o cálculo, o que consiste em inserir o algarismo zero "0" imediatamente após o número de código do município, desprezando-se os dígitos de controle.
         * Exemplo: Número da inscrição: 062 307 904 00 ? ?
         * Número a ser trabalhado: 062 "0" 307904 00 -- --
         */
        $corpo = substr_replace($corpo, '0', 3, 0);
        $concatenacao = "";
        foreach (str_split($corpo) as $i => $item) {
            //se index impar então peso é 1 senão é 2
            $peso = ((($i + 3) % 2) == 0) ? 2 : 1;
            $concatenacao .= ($item * $peso);
        }
        $soma = 0;

        // Soma-se os algarismos (não os produtos) do resultado obtido
        foreach (str_split($concatenacao) as $algarismo) {
            $soma += $algarismo;
        }
        // Subtrai-se o resultado da soma do item anterior, da primeira dezena exata imediatamente superior:
        $strSoma = $soma . '';
        $length = strlen($strSoma);
        $last_char = substr($strSoma, $length - 1, 1);

        return ($last_char == 0) ? 0 : (10 - $last_char);
    }

    /**
     * Cálculo do segundo dígito verificador.
     *
     * @param $corpo string corpo da inscricao estadual acrescido do primeiro dígito verificador correto
     * @return int segundo dígito verificador
     */
    private static function calculaSegundoDigito($corpo)
    {
        $peso = 3;
        $soma = 0;
        foreach (str_split($corpo) as $item) {
            $soma += $item * $peso;
            $peso--;
            if ($peso == 1) {
                $peso = 11;
            }
        }

        $resto = $soma % 11;

        $dig = 11 - $resto;

        if ($dig >= 10) {
            $dig = 0;
        }
        return $dig;
    }
}
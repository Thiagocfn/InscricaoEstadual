<?php

namespace Thiagocfn\InscricaoEstadual\Util\Validador;


class Tocantins extends Ceara
{

    /**
     * Valida se a inscrição estadual para o Estado do Tocantins é válida de acordo com as regras antigas e novas.
     * Bastando atender pelo menos uma das regras para ser considerado válida.
     * @param string $inscricao_estadual
     * @return bool
     */
    public static function check($inscricao_estadual)
    {
        return static::checkAntiga($inscricao_estadual) || static::checkNova($inscricao_estadual);
    }

    /**
     * Verifica se a inscrição estadual é válida para o Tocantins (TO)
     * seguindo a regra: http://www.sintegra.gov.br/Cad_Estados/cad_TO.html (Válida até dezembro de 2.003)
     *
     * @param $inscricao_estadual string Inscrição Estadual que deseja validar.
     * @return bool true caso a inscrição estadual seja válida para esse estado, false caso contrário.
     */
    protected static function checkAntiga($inscricao_estadual)
    {
        $valid = true;
        // se não tiver 11 digitos não é valido
        if (strlen($inscricao_estadual) != 11) {
            $valid = false;
        }
        if ($valid) {
            $categoria = substr($inscricao_estadual, 2, 2);
            if (!in_array($categoria, ['01', '02', '03', '99'])) {
                $valid = false;
            }
            // removo a categoria do calculo de validação
            $corpo = substr_replace($inscricao_estadual, '', 2, 2);
        }

        if ($valid && !self::calculaDigito($corpo)) {
            $valid = false;
        }
        return $valid;

    }

    /**
     * Verifica critérios de avaliação da nova inscrição estadual de Tocantins (Em vigor desde junho de 2.002)
     * seguindo regra: http://www2.sefaz.to.gov.br/Servicos/Sintegra/calinse.htm
     * @param $inscricao_estadual
     * @return bool true se a inscrição estadual for valida segundo a nova regra de validação, falso caso contrário.
     */
    protected static function checkNova($inscricao_estadual)
    {
        // se não tiver 9 digitos não é valido
        return strlen($inscricao_estadual) == 9 && static::calculaDigitoNova($inscricao_estadual);
    }

    /**
     * Valida o dígito da inscrição estadual de Tocantins (Em vigor desde junho de 2.002)
     * seguindo regra: http://www2.sefaz.to.gov.br/Servicos/Sintegra/calinse.htm
     *
     * Pesos: 9 8 7 6 5 4 3 2 para calculo do dígito
     * @param $inscricao_estadual string inscricao estadual
     * @return bool true caso o digito seja verificado, false caso contrário.
     */
    protected static function calculaDigitoNova($inscricao_estadual)
    {
        $peso = 9;
        $soma = 0;
        $length = strlen($inscricao_estadual);
        $posicao = $length - 1;
        $corpo = substr($inscricao_estadual, 0, $length - 1);
        foreach (str_split($corpo) as $item) {
            $soma += $item * $peso;
            $peso--;
        }

        $resto = $soma % 11;

        $dig = 11 - $resto;
        if ($resto < 2) {
            $dig = 0;
        }

        return $dig == $inscricao_estadual[$posicao];
    }
}
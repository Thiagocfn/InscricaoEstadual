<?php

namespace Thiagocfn\InscricaoEstadual\Util\Validador;


class Tocantins extends Ceara
{

    /**
     * Verifica se a inscrição estadual é válida para o Tocantins (TO)
     * seguindo a regra: http://www.sintegra.gov.br/Cad_Estados/cad_TO.html
     *
     * @param $inscricao_estadual string Inscrição Estadual que deseja validar.
     * @return bool true caso a inscrição estadual seja válida para esse estado, false caso contrário.
     */
    public static function check($inscricao_estadual)
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
}
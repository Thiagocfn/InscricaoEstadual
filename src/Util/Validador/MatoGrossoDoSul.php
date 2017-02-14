<?php

namespace Thiagocfn\InscricaoEstadual\Util\Validador;


class MatoGrossoDoSul extends Ceara
{

    /**
     * Verifica se a inscrição estadual é válida para o Mato Grosso do Sul (MS)
     * seguindo a regra: http://www.sintegra.gov.br/Cad_Estados/cad_MS.html
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
        if ($valid && substr($inscricao_estadual, 0, 2) != '28') {
            $valid = false;
        }
        if ($valid && !self::calculaDigito($inscricao_estadual)) {
            $valid = false;
        }
        return $valid;

    }
}
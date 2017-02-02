<?php

namespace Thiagocfn\InscricaoEstadual\Util\Validador;


class Sergipe extends Ceara
{

    /**
     * Verifica se a inscrição estadual é válida para o Estado de Sergipe (SE)
     * seguindo a regra: http://www.sintegra.gov.br/Cad_Estados/cad_SE.html
     *
     * @param $inscricao_estadual string Inscrição Estadual que deseja validar.
     * @return bool true caso a inscrição estadual seja válida para esse estado, false caso contrário.
     */
    public static final function check($inscricao_estadual)
    {
        //Mantido apenas para documentação
        return parent::check((string)$inscricao_estadual);
    }

}
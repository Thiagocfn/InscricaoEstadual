<?php
/**
 * Created by PhpStorm.
 * User: tsouza
 * Date: 27/01/17
 * Time: 17:56
 */

namespace Thiagocfn\InscricaoEstadual\Util;


interface ValidadorInteface
{
    /**
     * Verifica se a inscrição estadual é válida.
     * @param $inscricao_estadual
     * @return boolean
     */
    public static function check($inscricao_estadual);
}
<?php
/**
 * @author   "Thiago Souza" <thiagocfn@msn.com>
 * @version  1.0
 * @link     https://github.com/thiagocfn/InscricaoEstadual
 * @example  https://github.com/thiagocfn/InscricaoEstadual
 * @license  Revised BSD
 */

namespace Thiagocfn\InscricaoEstadual\Util;


use Thiagocfn\InscricaoEstadual\Util\Validador\Acre;
use Thiagocfn\InscricaoEstadual\Util\Validador\Alagoas;
use Thiagocfn\InscricaoEstadual\Util\Validador\Amapa;
use Thiagocfn\InscricaoEstadual\Util\Validador\Amazonas;
use Thiagocfn\InscricaoEstadual\Util\Validador\Bahia;
use Thiagocfn\InscricaoEstadual\Util\Validador\Ceara;
use Thiagocfn\InscricaoEstadual\Util\Validador\DistritoFederal;

class Validador
{

    /**
     * Verifica se a inscrição estadual é válida para o estado a ser consultado
     *
     * @param $estado string UF de dois dígitos
     * @param $inscricao_estadual string Inscrição Estadual que deseja validar.
     * @return bool true caso a inscrição estadual seja válida para esse estado, false caso contrário.
     */
    public static function check($estado, $inscricao_estadual)
    {
        switch ($estado) {
            case Estados::AC:
                $valid = Acre::check($inscricao_estadual);
                break;
            case Estados::AL:
                $valid = Alagoas::check($inscricao_estadual);
                break;
            case Estados::AP:
                $valid = Amapa::check($inscricao_estadual);
                break;
            case Estados::AM:
                $valid = Amazonas::check($inscricao_estadual);
                break;
            case Estados::BA:
                $valid = Bahia::check($inscricao_estadual);
                break;
            case Estados::CE:
                $valid = Ceara::check($inscricao_estadual);
                break;
            case Estados::DF:
                $valid = DistritoFederal::check($inscricao_estadual);
                break;
            default:
                $valid = false;
        }
        return $valid;
    }
}
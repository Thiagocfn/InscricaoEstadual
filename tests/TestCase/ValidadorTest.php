<?php
namespace Thiagocfn\InscricaoEstadual\Test\TestCase;

use PHPUnit\Framework\TestCase;
use Thiagocfn\InscricaoEstadual\Util\Validador;

class ValidadorTest extends TestCase
{
    public function testAcre()
    {
        self::assertTrue(Validador::check("AC", "0108368143017"));
    }

    public function testAcreFalse()
    {
        self::assertFalse(Validador::check("AC", "0187634580933"));
    }

    public function testAlagoas()
    {
        self::assertTrue(Validador::check("AL", "248659758"));
    }

    public function testAlagoasFalse()
    {
        self::assertFalse(Validador::check("AL", "0187634580933"));
    }

    public function testAmapa()
    {
        self::assertTrue(Validador::check("AP", "036029572"));
    }

    public function testAmapaFalse()
    {
        self::assertFalse(Validador::check("AP", "0187634580933"));
    }

    public function testAmazonas()
    {
        self::assertTrue(Validador::check("AM", "036029572"));
    }

    public function testAmazonasFalse()
    {
        self::assertFalse(Validador::check("AM", "0187634580933"));
    }

}
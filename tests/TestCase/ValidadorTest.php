<?php
namespace Thiagocfn\InscricaoEstadual\Test\TestCase;

use PHPUnit\Framework\TestCase;
use Thiagocfn\InscricaoEstadual\Util\Estados;
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
        self::assertFalse(Validador::check("AL", "248659759"));
    }

    public function testAmapa()
    {
        self::assertTrue(Validador::check("AP", "036029572"));
    }

    public function testAmapaFalse()
    {
        self::assertFalse(Validador::check("AP", "036029573"));
    }

    public function testAmazonas()
    {
        self::assertTrue(Validador::check("AM", "036029572"));
    }

    public function testAmazonasFalse()
    {
        self::assertFalse(Validador::check("AM", "036029573"));
    }

    public function testBahia()
    {
        // 8 dígitos
        //// mod 10
        self::assertTrue(Validador::check(Estados::BA, "12345663"), "Bahia. 8 digitos, mod 10 falhou");
        //// mod 11
        self::assertTrue(Validador::check(Estados::BA, "74219145"), "Bahia. 8 digitos, mod 11 falhou");

        // 9 dígitos
        //// mod 10
        self::assertTrue(Validador::check(Estados::BA, "038343081"), "Bahia. 9 digitos, mod 10 falhou");
        self::assertTrue(Validador::check(Estados::BA, "100000306"), "Bahia. 9 digitos, mod 10 falhou");
        //// mod 11
        self::assertTrue(Validador::check(Estados::BA, "778514741"), "Bahia. 9 digitos, mod 11 falhou");
    }

    public function testBahiaFalse()
    {
        // 8 dígitos
        //// mod 10
        self::assertFalse(Validador::check(Estados::BA, "12345636"));
        //// mod 11
        self::assertFalse(Validador::check(Estados::BA, "74219154"));

        // 9 dígitos
        //// mod 10
        self::assertFalse(Validador::check(Estados::BA, "038343001"));
        //// mod 11
        self::assertFalse(Validador::check(Estados::BA, "778514731"));
    }

    public function testCeara()
    {
        self::assertTrue(Validador::check(Estados::CE, "853511942"));
    }

    public function testCearaFalse()
    {
        self::assertFalse(Validador::check(Estados::CE, "853511943"));

        // ie superior a 9 digitos
        self::assertFalse(Validador::check(Estados::CE, "0853511942"));
    }

    public function testDistritoFederal()
    {
        self::assertTrue(Validador::check(Estados::DF, "0754002000176"));
    }

    public function testDistritoFederalFalse()
    {
        self::assertFalse(Validador::check(Estados::DF, "0108368143017"));
    }

    public function testEspiritoSanto()
    {
        self::assertTrue(Validador::check(Estados::ES, "639191444"));
    }

    public function testEspiritoSantoFalse()
    {
        self::assertFalse(Validador::check(Estados::ES, "639191445"));
    }

    public function testGoias()
    {
        // começa com 10 e o digito verificador  é a regra base
        self::assertTrue(Validador::check(Estados::GO, "109161793"));

        // começa com 10 e o dígito verificador é 1, Dentro do intervalo que mantém em 1
        self::assertTrue(Validador::check(Estados::GO, "101031131"));

        // começa com 10 e o dígito verificador é 1, Fora do intervalo que mantém em 1, transformando em 0
        self::assertTrue(Validador::check(Estados::GO, "101030940"));
    }

    public function testGoiasFalse()
    {
        // começa com 10 e o digito verificador  está errado
        self::assertFalse(Validador::check(Estados::GO, "109161794"));

        // não começa com 10, 11 ou 15
        self::assertFalse(Validador::check(Estados::GO, "121031131"));

        // tamanho diferente de 9 difgitos
        self::assertFalse(Validador::check(Estados::GO, "0101030940"));
    }

    public function testMaranhao()
    {
        // Regra convencional
        self::assertTrue(Validador::check(Estados::MA, "120000008"));

        // Digito "11" que é convertido para 0
        self::assertTrue(Validador::check(Estados::MA, "120000040"));

        // Digito "10" que é convertido para 0
        self::assertTrue(Validador::check(Estados::MA, "120000130"));
    }

    public function testMaranhaoFalse()
    {
        // Tamanho diferente de 9 dígitos
        self::assertFalse(Validador::check(Estados::MA, "0120000008"));

        // Não começa com 12
        self::assertFalse(Validador::check(Estados::MA, "109161793"));

        // Digito verificador incorreto
        self::assertFalse(Validador::check(Estados::MA, "120000007"));
    }

    public function testMatoGrosso()
    {
        self::assertTrue(Validador::check(Estados::MT, "00000000000"));
    }

    public function testMatoGrossoFalse()
    {
        // Não tem 11 digitos
        self::assertFalse(Validador::check(Estados::MT, "0000000000"));

        // digito verificador inválido
        self::assertFalse(Validador::check(Estados::MT, "12345678901"));
    }


}
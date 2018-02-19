<?php
namespace Thiagocfn\InscricaoEstadual\Test\TestCase;

use PHPUnit\Framework\TestCase;
use Thiagocfn\InscricaoEstadual\Util\Estados;
use Thiagocfn\InscricaoEstadual\Util\Validador;

class ValidadorTest extends TestCase
{
    public function testEstadoInexistente()
    {
        self::assertFalse(Validador::check("NY", "123456789"));
    }

    public function testAcre()
    {
        // Regra convencional e dígito 10 que virou 0
        self::assertTrue(Validador::check(Estados::AC, "0108368143106"));
    }

    public function testAcreFalse()
    {
        // Segundo dígito verificador incorreto.
        self::assertFalse(Validador::check(Estados::AC, "0187634580933"));

        // Primeiro dígito verificador incorreto.
        self::assertFalse(Validador::check(Estados::AC, "0187634580924"));

        // Não começa com 01
        self::assertFalse(Validador::check(Estados::AC, "0018763458000"));

        // Maior que 13 dígitos
        self::assertFalse(Validador::check(Estados::AC, "01018763458064"));
    }

    public function testAlagoas()
    {
        // Regra convencional
        self::assertTrue(Validador::check(Estados::AL, "248659758"));

        // Dígito 10 convertido para 0
        self::assertTrue(Validador::check(Estados::AL, "247424170"));
    }

    public function testAlagoasFalse()
    {
        // Dígito verificador incorreto
        self::assertFalse(Validador::check(Estados::AL, "248659759"));

        // Não começa com 24
        self::assertFalse(Validador::check(Estados::AL, "258659750"));

        // Não tem 9 digitos
        self::assertFalse(Validador::check(Estados::AL, "2486597584"));
    }

    public function testAmapa()
    {
        // Regra convencional
        self::assertTrue(Validador::check(Estados::AP, "036029572"));

        // IE entre 03000001 e 03017000
        self::assertTrue(Validador::check(Estados::AP, "030123459"));

        // IE entre 03000001 e 03017000 com digito 10 que converte para 0
        self::assertTrue(Validador::check(Estados::AP, "030000080"));

        // IE entre 03000001 e 03017000 com digito 11 que converte para d (0)
        self::assertTrue(Validador::check(Estados::AP, "030000160"));

        // IE entre 03017001 e 03019022
        self::assertTrue(Validador::check(Estados::AP, "030170011"));

        // IE entre 03017001 e 03019022 com digito 10 que converte para 0
        self::assertTrue(Validador::check(Estados::AP, "030170020"));

        // IE entre 03017001 e 03019022 com digito 11 que converte para d (1)
        self::assertTrue(Validador::check(Estados::AP, "030170071"));
    }

    public function testAmapaFalse()
    {
        // digito verificador incorreto
        self::assertFalse(Validador::check(Estados::AP, "036029573"));

        // mais de 9 digitos
        self::assertFalse(Validador::check(Estados::AP, "0306029570"));

        // Não começa com 03
        self::assertFalse(Validador::check(Estados::AP, "003060292"));
    }

    public function testAmazonas()
    {
        // Regra convencional
        self::assertTrue(Validador::check("AM", "036029572"));

        // soma inferior a 11
        self::assertTrue(Validador::check("AM", "000000019"));

        // Digito 11 convertido para 0
        self::assertTrue(Validador::check("AM", "046893830"));


    }

    public function testAmazonasFalse()
    {
        // Digito verificador incorreto
        self::assertFalse(Validador::check("AM", "036029573"));

        // mais de 9 dígitos
        self::assertFalse(Validador::check("AM", "0036029572"));
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
        // Casos que reproduziam bugs
        //// 9 digitos começando com 0
        self::assertTrue(Validador::check(Estados::BA, "078771760"), "Bahia. 9 digitos");
        self::assertTrue(Validador::check(Estados::BA, "039474751"), "Bahia. 9 digitos");
        self::assertTrue(Validador::check(Estados::BA, "090529323"), "Bahia. 9 digitos");
        //// 8 digitos começando com 0
        self::assertTrue(Validador::check(Estados::BA, "04772253"), "Bahia. 8 digitos");


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

        // diferente de 8 ou 9 digitos
        self::assertFalse(Validador::check(Estados::BA, "0012345636"));
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
        // Regra convencional
        self::assertTrue(Validador::check(Estados::DF, "0754002000176"));

        // Digito 10 que é convertido para 0
        self::assertTrue(Validador::check(Estados::DF, "0754002000508"));
    }

    public function testDistritoFederalFalse()
    {
        // Não começa com 07
        self::assertFalse(Validador::check(Estados::DF, "0108368143017"));


        // Não tem 13 dígitos
        self::assertFalse(Validador::check(Estados::DF, "07008368143094"));
        //Digito incorreto
        self::assertFalse(Validador::check(Estados::DF, "0754002000175"));
    }

    public function testEspiritoSanto()
    {
        self::assertTrue(Validador::check(Estados::ES, "639191444"));
    }

    public function testEspiritoSantoFalse()
    {
        // Dígito verificador incorreto
        self::assertFalse(Validador::check(Estados::ES, "639191445"));

        // IE superior a 9 digitos
        self::assertFalse(Validador::check(Estados::ES, "0639191444"));
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

    public function testMatoGrossoDoSul()
    {
        // Regra convencional
        self::assertTrue(Validador::check(Estados::MS, "280000006"));

        // Digito "10" que é convertido para 0
        self::assertTrue(Validador::check(Estados::MS, "280000090"));

        // Digito "11" que é convertido para 0
        self::assertTrue(Validador::check(Estados::MS, "280000030"));
    }

    public function testMatoGrossoDoSulFalse()
    {
        // Tamanho diferente de 9 dígitos
        self::assertFalse(Validador::check(Estados::MS, "0280000006"));

        // Digito verificador verdadeiro, mas não inicia com 28
        self::assertFalse(Validador::check(Estados::MS, "853511942"));

        // Digito verificador inválido
        self::assertFalse(Validador::check(Estados::MS, "280000031"));
    }

    public function testMinasGerais()
    {
        // Regra convencional
        self::assertTrue(Validador::check(Estados::MG, "4333908330177"));

        // Digito "10" que é convertido para 0
        self::assertTrue(Validador::check(Estados::MG, "4333908330410"));

        // Digito "11" que é convertido para 0
        self::assertTrue(Validador::check(Estados::MG, "4333908332560"));
    }

    public function testMinasGeraisFalse()
    {
        // Tamanho diferente de 13 dígitos
        self::assertFalse(Validador::check(Estados::MG, "04333908330177"));

        // Segundo digito verificador invalido
        self::assertFalse(Validador::check(Estados::MG, "4333908330176"));

        // Primeiro digito verificador invalido
        self::assertFalse(Validador::check(Estados::MG, "4333908330167"));
    }

    public function testPara()
    {
        // Regra convencional
        self::assertTrue(Validador::check(Estados::PA, "150000006"));

        // Digito "11" que é convertido para 0
        self::assertTrue(Validador::check(Estados::PA, "150000030"));

        // Digito "10" que é convertido para 0
        self::assertTrue(Validador::check(Estados::PA, "150000260"));
    }

    public function testParaFalse()
    {
        // Tamanho diferente de 9 dígitos
        self::assertFalse(Validador::check(Estados::PA, "0150000006"));

        // Não começa com 15
        self::assertFalse(Validador::check(Estados::PA, "120000008"));

        // Digito verificador incorreto
        self::assertFalse(Validador::check(Estados::PA, "150000007"));
    }

    public function testParaiba()
    {
        // Regra convencional
        self::assertTrue(Validador::check(Estados::PB, "853511942"));

        // Digito "11" que é convertido para 0
        self::assertTrue(Validador::check(Estados::PB, "853511950"));

        // Digito "10" que é convertido para 0
        self::assertTrue(Validador::check(Estados::PB, "853512230"));
    }

    public function testParaibaFalse()
    {
        // Dígito verificador incorreto
        self::assertFalse(Validador::check(Estados::PB, "853511943"));

        // ie superior a 9 digitos
        self::assertFalse(Validador::check(Estados::PB, "0853511942"));
    }

    public function testParana()
    {
        // Regra convencional e quando o digito é "10" ou "11"
        self::assertTrue(Validador::check(Estados::PR, "4447953604"));
    }

    public function testParanaFalse()
    {
        // Dígito verificador incorreto
        self::assertFalse(Validador::check(Estados::PR, "4447953640"));

        // IE superior a 10 digitos
        self::assertFalse(Validador::check(Estados::PR, "04447953604"));
    }

    public function testPernambuco()
    {
        // Regra convencional e quando o digito é "10" ou "11"
        self::assertTrue(Validador::check(Estados::PE, "288625706"));
    }

    public function testPernambucoFalse()
    {

        // Dígitos verificadores invertidos
        self::assertFalse(Validador::check(Estados::PE, "925870101"));

        // IE superior a 9 digitos
        self::assertFalse(Validador::check(Estados::PE, "0925870110"));
    }

    public function testPiaui()
    {
        self::assertTrue(Validador::check(Estados::PI, "052364534"));
    }

    public function testRioDeJaneiro()
    {
        // Regra convencional
        self::assertTrue(Validador::check(Estados::RJ, "62545372"));

        // Digito "11" que é convertido para 0
        self::assertTrue(Validador::check(Estados::RJ, "62545380"));

        // Digito "10" que é convertido para 0
        self::assertTrue(Validador::check(Estados::RJ, "62545470"));
    }

    public function testRioDeJaneiroFalse()
    {
        // Dígito verificador incorreto
        self::assertFalse(Validador::check(Estados::RJ, "20441620"));

        // IE superior a 8 digitos
        self::assertFalse(Validador::check(Estados::RJ, "020441623"));
    }

    public function testRioGrandeDoNorte()
    {
        // Regra convencional
        self::assertTrue(Validador::check(Estados::RN, "2007693232"));

        // Digito "10" que é convertido para 0
        self::assertTrue(Validador::check(Estados::RN, "2003569880"));

        // IE antiga
        self::assertTrue(Validador::check(Estados::RN, "203569881"));
    }

    public function testRioGrandeDoNorteFalse()
    {
        // Não começa com 20
        self::assertFalse(Validador::check(Estados::RN, "0203569881"));

        // Não tem 9 ou 10 dígitos (dígito verificador "correto")
        self::assertFalse(Validador::check(Estados::RN, "20356988104"));

        // Dígito verificador incorreto
        self::assertFalse(Validador::check(Estados::RN, "2007693231"));
    }

    public function testRioGrandeDoSul()
    {
        // Regra convencional
        self::assertTrue(Validador::check(Estados::RS, "0305169149"));

        // Digito "10" que é convertido para 0
        self::assertTrue(Validador::check(Estados::RS, "1202762660"));

        // Digito "11" que é convertido para 0
        self::assertTrue(Validador::check(Estados::RS, "1202762120"));
    }

    public function testRioGrandeDoSulFalse()
    {
        // IE superior a 10 dígitos (dígito verificador "correto")
        self::assertFalse(Validador::check(Estados::RS, "02007693230"));

        // Dígito verificador incorreto
        self::assertFalse(Validador::check(Estados::RS, "2007693232"));
    }

    public function testRondonia()
    {

        // Regra convencional
        self::assertTrue(Validador::check(Estados::RO, "01078042249629"));

        // Digito "10" que é convertido para 0
        self::assertTrue(Validador::check(Estados::RO, "01078042249670"));

        // Digito "11" que é convertido para 1
        self::assertTrue(Validador::check(Estados::RO, "01078042249751"));

    }

    public function testRondoniaFalse()
    {
        // IE superior a 14 dígitos (dígito verificador "correto")
        self::assertFalse(Validador::check(Estados::RO, "001078042249627"));

        // Digito verificador incorreto (calculado sem os zeros a esquerda)
        self::assertFalse(Validador::check(Estados::RO, "01078042249756"));
    }

    public function testRoraima()
    {
        // Regra convencional
        self::assertTrue(Validador::check(Estados::RR, "240061536"));
    }

    public function testRoraimaFalse()
    {
        // Não começa com 24
        self::assertFalse(Validador::check(Estados::RR, "024006150"));

        // IE superior a 9 dígitos (dígito verificador "correto")
        self::assertFalse(Validador::check(Estados::RR, "2400615366"));

        // Dígito verificador incorreto
        self::assertFalse(Validador::check(Estados::RR, "240061537"));
    }

    public function testSantaCatarina()
    {
        // Regra Convencional
        self::assertTrue(Validador::check(Estados::SC, "330430572"));
    }

    public function testSaoPaulo()
    {
        // Regra convencional
        self::assertTrue(Validador::check(Estados::SP, "110042490114"));
    }

    public function testSaoPauloFalse()
    {
        // IE superior a 12 dígitos (dígito verificador "correto")
        self::assertFalse(Validador::check(Estados::SP, "1110042494114"));

        // Segundo digito incorreto
        self::assertFalse(Validador::check(Estados::SP, "110042490113"));

        // primeiro digito incorreto (segundo dígito "correto")
        self::assertFalse(Validador::check(Estados::SP, "110042498113"));
    }

    public function testSergipe()
    {

        // Regra Convencional
        self::assertTrue(Validador::check(Estados::SE, "017682606"));
    }

    public function testTocantins()
    {
        // Regra convencional Antiga
        self::assertTrue(Validador::check(Estados::TO, "01027737427"));

        // Regra nova (junho de 2003)*
        static::assertTrue(Validador::check(Estados::TO, "294467696"));
        // digito zero
        static::assertTrue(Validador::check(Estados::TO,"294150870"));
    }

    public function testTocantinsFalse()
    {
        ////Regra Antiga
        // Categoria invalida (dígito "correto")
        self::assertFalse(Validador::check(Estados::TO, "01047737427"));

        // IE com mais de 11 digitos (dígito "correto")
        self::assertFalse(Validador::check(Estados::TO, "099999916599"));

        // Dígito verificador incorreto
        self::assertFalse(Validador::check(Estados::TO, "99999916598"));

        //// Regra Nova
        // Digito verificador incorreto
        static::assertFalse(Validador::check(Estados::TO, "294467690"));
    }
}
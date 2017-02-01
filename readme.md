# Inscrição Estadual


[![Build Status](https://travis-ci.org/Thiagocfn/InscricaoEstadual.svg?branch=master)](https://travis-ci.org/Thiagocfn/InscricaoEstadual)
[![Total Downloads](https://img.shields.io/packagist/dt/thiagocfn/InscricaoEstadual.svg?style=flat-square)](https://packagist.org/packages/friendsofcake/CakePdf)
[![License](https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)](https://packagist.org/packages/thiagocfn/InscricaoEstadual)
Biblioteca de validação de inscrição estadual para todos os estados brasileiros.
Atenção!! Incompleto.

## Coverage
[![Coverage](https://codecov.io/gh/Thiagocfn/InscricaoEstadual/branch/master/graphs/sunburst.svg)](https://codecov.io/gh/Thiagocfn/InscricaoEstadual/branch/master)


## Requerimentos

* PHP 5.4.16+

## Observações

* Acredito que todas as IE do estado do Amapá sejam válidas pelas regras de validação 
do estado do Amazonas
* A regra de validação do Ceará é a mesma do Espirito Santo e da Paraíba
* A regra de validação de Goiás é muito proxima de Ceará e Espirito Santo, devem ter uns 75% das IEs validas de Goiás devem ser equivalentes a Ceará e Espirito Santo.
* A regra de validação do Maranhão é identica a de Ceará, contudo deve começar pela string "12"
* Pela regra de validação de Mato Grosso valida a IE 00000000000
* A regra de validação do Paraná é muito parecida com a regra da Bahia, mudando elementos como pesos e quantidade de dígitos, por exemplo.
* A regra de validação de Pernambuco é muito parecida com a regra do Paraná, mudando apenas quantidade de dígitos e pesos utilizados. Pode ser interessante diminuir duplicação de código.

## Links úteis
* Gerador de Inscrições estaduais - [http://www.geradoruniversal.com/gerador-de-inscricao-estadual](http://www.geradoruniversal.com/gerador-de-inscricao-estadual);
* Site nacional do Sintegra (contendo todas as regras de validação) - [http://www.sintegra.gov.br/insc_est.html](http://www.sintegra.gov.br/insc_est.html)
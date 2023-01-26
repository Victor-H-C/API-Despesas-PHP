# Dependências
Composer
dompdf -> run composer require dompdf/dompdf
MySQL 
PHP 7.*

# Como consumir a API

## Configurar

Preencher valores das constantes do config.php

Rodar o arquivo db.sql para criação da base de dados a ser consumida

## Caminhos

* /api/despesas/all [GET] -> retorna lista de despesas geral

* /api/despesas  [GET] -> retorna lista de despesas do mês atual

* /api/despesas?IdDespesa=3  [GET] -> retorna lista de despesas com determinado ID

* /api/despesas [POST] -> cadastra despesa
    params:
        $_POST['valor'])
        $_POST['data'])
        $_POST['idcategoria'])
        $_POST['idpagamento'])
        $_POST['cep']

* /api/despesas [POST] -> remove despesa
    params:
        $_POST['method'] = 'delete'
        $_POST['id]
* /api/despesas [POST] -> Atualiza despesa
    params:
        $_POST['method'] = 'update'
        $_POST['id]
        $_POST['valor'])
        $_POST['data'])
        $_POST['idcategoria'])
        $_POST['idpagamento'])
        $_POST['cep']

* /api/despesas/categorias [GET] -> retorna lista de categorias

* /api/despesas/categorias [POST] -> insere categoria
    params:
        $_POST['nome']
        $_POST['descricao']
        
* /api/despesas/tipo -> retorna tipos de pagamento

* /api/despesas/excel -> retorna um excel com despesas do mês atual
* /api/despesas/pdf?DataInicio=2022-10-01&DataFim=2022-12-30 -> retornar pdf com base nas datas
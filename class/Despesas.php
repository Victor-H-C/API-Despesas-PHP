<?php

require "vendor/autoload.php";

use Dompdf\Dompdf;
use Dompdf\Options;

class Despesas extends DbConnect
{

    public static $obj = [
        'data' => [],
        'success' => true
    ];

    public static function getAll()
    {
        $errorObj = json_encode([
            'data' => [],
            'success' => false
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        $sql = DbConnect::Connect()->prepare('SELECT despesa.Id, despesa.Valor, despesa.DataCompra, tipo.Tipo, categoria.Nome, categoria.Descricao, despesa.CEP
                                            FROM TB_Despesas despesa
                                            INNER JOIN TB_TipoPagamento tipo ON
                                            despesa.IdTipoPagamento = tipo.IdTipoPagamento
                                            INNER JOIN TB_Categorias categoria ON
                                            despesa.IdCategorias = categoria.IdCategorias');
        $sql->execute();
        $data = $sql->FetchAll();

        if(!$data){
            return $errorObj;
        }

        foreach ($data as $despesa) {
     
            if($despesa['CEP'] != null){
            
                $json = file_get_contents('https://viacep.com.br/ws/'.$despesa['CEP'].'/json/');
                $response = json_decode($json);
        
                $despesa = [
                    'id' => $despesa['Id'],
                    'valor' => $despesa['Valor'],
                    'dataCompra' => $despesa['DataCompra'],
                    'tipo' => $despesa['Tipo'],
                    'nome' => $despesa['Nome'],
                    'descricao' => $despesa['Descricao'],
                    'CEP' => $despesa['CEP'],
                    'endereco' => $response
                ];

            }else{
                $despesa = [
                    'id' => $despesa['Id'],
                    'valor' => $despesa['Valor'],
                    'dataCompra' => $despesa['DataCompra'],
                    'tipo' => $despesa['Tipo'],
                    'nome' => $despesa['Nome'],
                    'descricao' => $despesa['Descricao'],
                    'CEP' => $despesa['CEP']
                ];
            }
            array_push(self::$obj['data'], $despesa);
        }

        return (json_encode(self::$obj, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }

    public static function getDespesas()
    {

        $errorObj = json_encode([
            'data' => [],
            'success' => false
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        $sql = DbConnect::Connect()->prepare('SELECT despesa.Id, despesa.Valor, despesa.DataCompra, tipo.Tipo, categoria.Nome, categoria.Descricao, despesa.CEP
                                            FROM TB_Despesas despesa
                                            INNER JOIN TB_TipoPagamento tipo ON
                                            despesa.IdTipoPagamento = tipo.IdTipoPagamento
                                            INNER JOIN TB_Categorias categoria ON
                                            despesa.IdCategorias = categoria.IdCategorias WHERE MONTH(DataCompra) = MONTH(NOW());');
        $sql->execute();
        $data = $sql->FetchAll();

        if(!$data){
            return $errorObj;
        }

        foreach ($data as $despesa) {
     
            if($despesa['CEP'] != null){
            
                $json = file_get_contents('https://viacep.com.br/ws/'.$despesa['CEP'].'/json/');
                $response = json_decode($json);
        
                $despesa = [
                    'id' => $despesa['Id'],
                    'valor' => $despesa['Valor'],
                    'dataCompra' => $despesa['DataCompra'],
                    'tipo' => $despesa['Tipo'],
                    'nome' => $despesa['Nome'],
                    'descricao' => $despesa['Descricao'],
                    'CEP' => $despesa['CEP'],
                    'endereco' => $response
                ];

            }else{
                $despesa = [
                    'id' => $despesa['Id'],
                    'valor' => $despesa['Valor'],
                    'dataCompra' => $despesa['DataCompra'],
                    'tipo' => $despesa['Tipo'],
                    'nome' => $despesa['Nome'],
                    'descricao' => $despesa['Descricao'],
                    'CEP' => $despesa['CEP']
                ];
            }
            array_push(self::$obj['data'], $despesa);
        }

        return (json_encode(self::$obj, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }

    public static function getDespesasById($id)
    {

        $errorObj = json_encode([
            'data' => [],
            'success' => false
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        $sql = DbConnect::Connect()->prepare('SELECT despesa.Id, despesa.Valor, despesa.DataCompra, tipo.Tipo, categoria.Nome, categoria.Descricao, despesa.CEP
                                            FROM TB_Despesas despesa
                                            INNER JOIN TB_TipoPagamento tipo ON
                                            despesa.IdTipoPagamento = tipo.IdTipoPagamento
                                            INNER JOIN TB_Categorias categoria ON
                                            despesa.IdCategorias = categoria.IdCategorias WHERE despesa.Id = ?;');
        $sql->execute(array($id));
        $data = $sql->Fetch();
        
        if(!$data){
            return $errorObj;
        }

        if($data['CEP'] != null){
            
            $json = file_get_contents('https://viacep.com.br/ws/'.$data['CEP'].'/json/');
            $response = json_decode($json);
    
            $despesa = [
                'id' => $data['Id'],
                'valor' => $data['Valor'],
                'dataCompra' => $data['DataCompra'],
                'tipo' => $data['Tipo'],
                'nome' => $data['Nome'],
                'descricao' => $data['Descricao'],
                'CEP' => $data['CEP'],
                'endereco' => $response
            ];

        }else{
            $despesa = [
                'id' => $data['Id'],
                'valor' => $data['Valor'],
                'dataCompra' => $data['DataCompra'],
                'tipo' => $data['Tipo'],
                'nome' => $data['Nome'],
                'descricao' => $data['Descricao'],
                'CEP' => $data['CEP']
            ];
        }

        self::$obj['data'] = $despesa;

        return (json_encode(self::$obj, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }
    
    public static function getDespesasByDate($DataInicio, $DataFim){
        $errorObj = json_encode([
            'data' => [],
            'success' => false
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        $sql = DbConnect::Connect()->prepare('SELECT despesa.Id, despesa.Valor, despesa.DataCompra, tipo.Tipo, categoria.Nome, categoria.Descricao, despesa.CEP
                                            FROM TB_Despesas despesa
                                            INNER JOIN TB_TipoPagamento tipo ON
                                            despesa.IdTipoPagamento = tipo.IdTipoPagamento
                                            INNER JOIN TB_Categorias categoria ON
                                            despesa.IdCategorias = categoria.IdCategorias WHERE DataCompra > ? AND DataCompra < ?');
        $sql->execute(array($DataInicio, $DataFim));
        $data = $sql->FetchAll();

        if(!$data){
            return $errorObj;
        }

        foreach ($data as $despesa) {

            file_get_contents('');

            $despesa = [
                'id' => $despesa['Id'],
                'valor' => $despesa['Valor'],
                'dataCompra' => $despesa['DataCompra'],
                'tipo' => $despesa['Tipo'],
                'nome' => $despesa['Nome'],
                'descricao' => $despesa['Descricao'],
                'CEP' => $despesa['CEP']
            ];
            array_push(self::$obj['data'], $despesa);
        }

        return (json_encode(self::$obj, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }

    public static function getTipos(){
        $sql = DbConnect::Connect()->prepare('SELECT IdTipoPagamento, Tipo FROM TB_TipoPagamento;');

        $sql->execute();
        $data = $sql->FetchAll();

        foreach ($data as $tipo) {
        $tipo = [
        'id' => $tipo['IdTipoPagamento'],
        'tipo' => $tipo['Tipo'],
        ];
        array_push(self::$obj['data'], $tipo);
        }

        return (json_encode(self::$obj, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }

    public static function getCategorias(){
        $sql = DbConnect::Connect()->prepare('SELECT IdCategorias, Nome, Descricao FROM TB_Categorias;');

        $sql->execute();
        $data = $sql->FetchAll();
        
        foreach ($data as $categoria) {
        $categoria = [
            'id' => $categoria['IdCategorias'],
            'nome' => $categoria['Nome'],
            'descricao' => $categoria['Descricao']
        ];
        array_push(self::$obj['data'], $categoria);
        }

        return (json_encode(self::$obj, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }


    public static function excelDespesas(){
        require('views/excelFile.php');
        return;
    }


    public static function pdfDespesas($DataInicio, $DataFim){
        $json = self::getDespesasByDate($DataInicio, $DataFim);
        $response = json_decode($json);

        $dompdf = new Dompdf();
        $html = '<table style="width:100%" border="1">
                    <tr>
                    <th>Valor</th>
                    <th>Categoria</th>
                    <th>Descrição</th>
                    <th>Tipo de pagamento</th>
                    <th>Data</th>
                </tr>';
        foreach($response->data as $despesa){
                    $html .= "
                    <tr>
                    <td>$despesa->valor</td>
                    <td>$despesa->nome</td>
                    <td>$despesa->descricao</td>
                    <td>".ucfirst(strtolower($despesa->tipo))."</td>
                    <td>$despesa->dataCompra</td>
                    </tr>
                    ";
        }
        $html .= '</table>';

        $dompdf->loadHtml($html);
        $dompdf->render();
        $dompdf->stream();
    }

    public static function setDespesas($valor, $data, $idcategoria, $idpagamento)
    {
        $sql = DbConnect::Connect()->prepare('INSERT INTO TB_Despesas(Valor, DataCompra, IdCategorias, IdTipoPagamento) VALUES(?, ?, ?, ?);');
        $sql->execute(array($valor, $data, $idcategoria, $idpagamento));

        $verify = DbConnect::Connect()->prepare('SELECT Id FROM TB_Despesas ORDER BY Id DESC');
        $verify->execute();
        $data = $verify->Fetch();
        self::$obj['data'] = $data['0'];

        return (json_encode(self::$obj, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }

    public static function delete($id){

        $sql = DbConnect::Connect()->prepare('DELETE FROM TB_Despesas WHERE Id = ?');
        $sql->execute(array($id));

        self::$obj['data'] = $id;

        return (json_encode(self::$obj, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }

    public static function update($id, $valor, $data, $idcategoria, $idpagamento){

        $sql = DbConnect::Connect()->prepare('SELECT ID FROM TB_Despesas WHERE Id = ?');

        $sql = DbConnect::Connect()->prepare('UPDATE Tb_Despesas SET Valor = ?, DataCompra = ?, IdCategorias = ?, IdTipoPagamento = ? WHERE Id = ?');
        $sql->execute(array($valor, $data, $idcategoria, $idpagamento, $id));

        self::$obj['data'] = $id;

        return (json_encode(self::$obj, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

    }

    public static function setCategoria($nome, $descricao)
    {
        $sql = DbConnect::Connect()->prepare('INSERT INTO TB_Categorias(Nome, Descricao) VALUES(?, ?);');
        $sql->execute(array($nome, $descricao));

        $verify = DbConnect::Connect()->prepare('SELECT * FROM TB_Categorias ORDER BY IdCategorias DESC LIMIT 1');
        $verify->execute();
        $data = $verify->Fetch();
        self::$obj['data'] = [
            "id" => $data['IdCategorias'],
            "nome" => $data['Nome'],
            "descrica" => $data['Descricao']
        ];

        return (json_encode(self::$obj, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }

}

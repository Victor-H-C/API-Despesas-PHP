<?php

    header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=despesasMensais.xls");

    $CurrentMonth =getdate()["mon"];

    $months = [
        "1"=> "Janeiro",
        "2"=> "Fevereiro",
        "3"=> "Março",
        "4"=> "Abril",
        "5"=> "Maio",
        "6"=> "Junho",
        "7"=> "Julho",
        "8"=> "Agosto",
        "9"=> "Setembro",
        "10"=> "Outubro",
        "11"=> "Novembro",
        "12"=> "Dezembro",
    ]
?>


    <h1>Despesas: <?php echo $months[$CurrentMonth] . "/" . getdate()["year"]; ?></h1>

    <table style="width:100%" border='1'>
        <tr>
        <th>Valor</th>
        <th>Categoria</th>
        <th>Descrição</th>
        <th>Tipo de pagamento</th>
        <th>Data</th>
    </tr>

    <?php

        $json = file_get_contents(PATH.'/api/despesas');
        $response = json_decode($json);

        foreach($response->data as $despesa){
            echo "
            <tr>
            <td>$despesa->valor</td>
            <td>$despesa->nome</td>
            <td>$despesa->descricao</td>
            <td>".ucfirst(strtolower($despesa->tipo))."</td>
            <td>$despesa->dataCompra</td>
            </tr>
            ";
        }

    ?>

    </table>
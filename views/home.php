<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/style.css">
    <title>Despesas</title>
</head>
<body>
    
    <header>
        <h1>Despesas</h1>
    </header>
    <main class="container">

        <button>
            <a href='despesas/inserir'>Inserir</a>
        </button>

        <table>
            <thead>
                <th>Valor</th>
                <th>Categoria</th>
                <th>Descrição</th>
                <th>Tipo de pagamento</th>
                <th>Data</th>
                <th>Ações</th>
            </thead>
            <tbody>
                <?php
                
                    $json = file_get_contents(PATH.'/api/despesas');
                    $response = json_decode($json);

                    $indice = isset($_GET['indice']) ? $_GET['indice'] : 0;

                    if($indice == 0){
                        $limit = 1;
                    }

                    if($indice >= 1){
                        $limit = ($indice * 10);
                    }

                        for($despesa = ($limit); $despesa < $limit + 10 && $despesa < count($response->data); $despesa++){
                            echo "
                                <tr>
                                    <td>".$response->data[$despesa]->valor."</td>
                                    <td>".$response->data[$despesa]->nome."</td>
                                    <td>".$response->data[$despesa]->descricao."</td>
                                    <td>".$response->data[$despesa]->tipo."</td>
                                    <td>".$response->data[$despesa]->dataCompra."</td>
                                    <td class='d-flex justify-space-between'>   
                                        <form action='".PATH."/api/despesas' method='POST'>
                                            <input type='hidden' name='method' value='delete'>
                                            <input type='hidden' name='id' value='".$response->data[$despesa]->id."'>
                                            <input class='pointer' type='submit' value='Excluir'>
                                        </form>
                                    </td>
                                </tr>
                            ";
    
                        }

                    
                
                ?>
            </tbody>
        </table>

        <?php
        
            if($indice >= 1){
                echo '<a href="?indice='.($indice - 1).'">Anterior</a> - ';
            }

            if(count($response->data) > 10){
                echo ($indice + 1);
            }


            if(count($response->data) > 10){
                $indice = isset($_GET['indice']) ? $_GET['indice'] + 1 : 1;
                if($indice * 10 < count($response->data)){
                    echo ' - <a href="?indice='.$indice.'">Próximo</a>';
                }
            }

        ?>

    </main>

</body>
</html>
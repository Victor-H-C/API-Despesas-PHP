<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/style.css">
    <title>Despesas</title>
</head>
<body>
    <header>
        <h1>Despesas</h1>
    </header>
    <main class="container">

        <button>
            <a href='<?php echo PATH?>/despesas'>Voltar</a>
        </button>
        <form class="mx-auto max-width-700" action="<?php echo PATH?>/api/despesas" method="post">

            <label for="valor">Valor:</label>
            <input class="w-100" type="number" name="valor" id="valor" step="0.01" required>
            <label for="data">Data:</label>
            <input class="w-100" type="datetime-local" id="data" name="data" required>
            <div class="w-100 d-flex justify-content-between">
                <div class="w-50 mr-1">
                    <label for="idcategoria">Categoria:</label>
                    <select class="w-100" name="idcategoria" required>
                        <?php 
                            $json = file_get_contents(PATH.'/api/despesas/categorias');
                            $response = json_decode($json);
    
                            foreach($response->data as $categoria){
                                echo '<option value="'.$categoria->id.'">'.$categoria->nome.'</option>';
                            }
    
                        ?>
                    </select>
                </div>
                <div class="w-50 mr-1">
                    <label for="idpagamento">Forma de pagamento:</label>
                    <select class="w-100" name="idpagamento" required>
                        <?php 
                            $json = file_get_contents(PATH.'/api/despesas/tipo');
                            $response = json_decode($json);

                            foreach($response->data as $tipo){
                                echo '<option value="'.$tipo->id.'">'.$tipo->tipo.'</option>';
                            }
                        
                        ?>
                    </select>
                </div>
            </div>

            <input class="w-100 pointer" type="submit" name="submit" value="Cadastrar">

        </form>

    </main>

</body>
</html>
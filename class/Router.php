<?php

class Router{

    public static function load(){

        // Separa a URL em partes para que possam ser interpretadas
        $url =  isset($_GET['url']) ? explode('/', $_GET['url']) : $url[0] = 'despesas';

        if($url[0] == 'despesas' || $url == 'despesas'){
            self::listarDespesas();
            return; 
        }

        if($url[0] == 'api' && !isset($url[1])){
            return;            
        }

        if($url[0] == 'api' && $url[1] == 'despesas'){
            echo self::API();
            return;            
        }

        echo 'Caminho inválido!';
        return;

    }


    public static function API(){

        header('Content-type: application/json');

        $errorObj = json_encode([
            'data' => [],
            'success' => false
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $url =  explode('/', $_GET['url']);

            if(isset($url[2]) && $url[2] == 'categorias'){

                if(!isset($_POST['nome']) || !isset($_POST['descricao'])){
                    return $errorObj;
                }

                return Despesas::setCategoria($_POST['nome'], $_POST['descricao']);

            }

            $id = isset($_POST['id']) ? $_POST['id'] : false;
            $valor = isset($_POST['valor']) ? $_POST['valor'] : '';
            $data = isset($_POST['data']) ? $_POST['data'] : ''; 
            $idcategoria = isset($_POST['idcategoria']) ? $_POST['idcategoria'] : ''; 
            $idpagamento = isset($_POST['idpagamento']) ? $_POST['idpagamento'] : '';

            if($id != false){

                if($_POST['method'] == 'delete'){
                    return Despesas::delete($id);

                }

                if($_POST['method'] == 'update'){
                    return Despesas::update($id, $valor, $data, $idcategoria, $idpagamento, $_POST['cep']);
                }

                return $errorObj;

            }

            var_dump($_POST);

            if(!isset($_POST["valor"]) ||
               !isset($_POST['data']) ||
               !isset($_POST['idcategoria']) ||
               !isset($_POST['idpagamento']) ||
               !isset($_POST['cep']))
               {
                return $errorObj;
            }
            return Despesas::setDespesas($valor, $data, $idcategoria, $idpagamento, $_POST['cep']);
        };

        if($_SERVER['REQUEST_METHOD'] == 'GET'){
            
			$url =  explode('/', $_GET['url']);

            if(isset($url[2]) && $url[2] == 'tipo'){
				echo Despesas::getTipos();
                return;
            }

            if(isset($url[2]) && $url[2] == 'categorias'){
				echo Despesas::getCategorias();
				return;
			}

			if(isset($url[2]) && $url[2] == 'excel'){
				Despesas::excelDespesas();
				return;
			}

            if(isset($url[2]) && $url[2] == 'all'){
				Despesas::getAll();
				return;
			}            

            if(isset($url[2]) && $url[2] == 'pdf'){
				$inicio = isset($_GET['DataInicio']) ? $_GET['DataInicio'] : '2000-01-01'; 
                $fim = isset($_GET['DataInicio']) ? $_GET['DataFim'] : '2100-01-01';
                Despesas::pdfDespesas($inicio, $fim);
				return;
			}


            if(isset($_GET['IdDespesa'])){
                return Despesas::getDespesasById($_GET['IdDespesa']);
            }

            return Despesas::getDespesas();

        }

        return $errorObj;

    }

    public static function listarDespesas(){

        $url = [];
        isset($_GET['url']) ? $url = explode('/', $_GET['url']) : $url[0] = 'despesas';


		if($url[0] == 'despesas' && !isset($url[1])){
			require('views/home.php');
			return;
		}

        if($url[1] == 'inserir'){
            require('views/inserir.php');
            return;
        };

        if($url[1] == 'editar'){
            require('views/editar.php');
            return;
        };

    }

}   

?>
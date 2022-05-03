<?php


class Conexao {

	//criar atributos da classe
	private $host = 'localhost';
	private $dbname = 'php_com_pdo';
	private $user = 'root';
	private $pass = '';

	//metodo da classe
	public function conectar(){
		try{

			//criar um objeto nativo que é o PDO, atribuindo a uma variavel.
			//Passar paramentros (data source name, usuario, senha)
			$conexao = new PDO(
				"mysql:host=$this->host;dbname=$this->dbname",
				"$this->user",
				"$this->pass"
			);

			return $conexao;

		} catch (PDOExeption $e) { //se der erro, recupera o erro e mostra qual a mensagem dele.
			echo '<p>'.$e->getMessage().'</p>';
		}
	}

}

?>
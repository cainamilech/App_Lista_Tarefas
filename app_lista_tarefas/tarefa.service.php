<?php 
	
	//CRUD (create, read, update, delete)
	class TarefaService {

		private $conexao;
		private $tarefa;

		public function __construct(Conexao $conexao,Tarefa $tarefa)//tipar pela classe, para que se vier algo que nao seja baseado nas classes, dar erro.
		{	//ao receber o objeto conexao, executar o metodo conectar do PDO
			$this->conexao = $conexao->conectar();
			$this->tarefa = $tarefa;
		}

		public function inserir(){ //para fazer a inserção no banco de dados
			$query = 'insert into tb_tarefas(tarefa)values(:tarefa)';
			//para nao ter problemas de SQL INJETCTION (codigos inseridos pelo usuario nos formularios, atulizamos o prepare, recuperando o pdo statement.
			$stmt = $this->conexao->prepare($query);
			$stmt->bindValue(':tarefa', $this->tarefa->__get('tarefa')); //atribuir o valor dentro da query :tarefa //o objeto criado em tarefa.model possui ja esse metodo get que recupera um atributo //atributo que foi setado em tarefa controler
			$stmt->execute(); //executar a query
		}

		public function recuperar(){
			$query = '
				select
					t.id, s.status, t.tarefa
				from 
					tb_tarefas as t
					left join tb_status as s on (t.id_status = s.id)
			';
			//mesmo nao tendo formularios a ser preenchidos possibilitando sql injection, estamos fazendo o prepare, recuperando o pdo statement.
			$stmt = $this->conexao->prepare($query);
			$stmt->execute();
			//retornar um array de objetos
			return $stmt->fetchAll(PDO::FETCH_OBJ);
		}

		public function atualizar (){

			$query = "update tb_tarefas set tarefa = :tarefa where id = :id";
			$stmt= $this->conexao->prepare($query);
			$stmt->bindValue(':tarefa', $this->tarefa->__get('tarefa'));
			$stmt->bindValue(':id', $this->tarefa->__get('id'));
			return $stmt->execute();

		}

		public function remover(){

			$query = 'delete from tb_tarefas where id = :id';
			$stmt = $this->conexao->prepare($query);
			$stmt->bindValue(':id', $this->tarefa->__get('id'));
			$stmt->execute();


		}

		public function marcarRealizada(){
			//outro jeito de codar as querys e bindvalue
			//update em dt tarefas, setando idstatus = ao parametro passado(id_status), onde o id = id passado por parametro(id)
			$query = "update tb_tarefas set id_status = ? where id = ?";
			$stmt= $this->conexao->prepare($query);
			$stmt->bindValue(1, $this->tarefa->__get('id_status'));
			$stmt->bindValue(2, $this->tarefa->__get('id'));
			return $stmt->execute();

		}

		public function recuperarTarefasPendentes(){
			$query = '
				select
					t.id, s.status, t.tarefa
				from 
					tb_tarefas as t
					left join tb_status as s on (t.id_status = s.id)
				where
					t.id_status = :id_status
			';
			
			$stmt = $this->conexao->prepare($query);
			$stmt->bindValue('id_status', $this->tarefa->__get('id_status'));
			$stmt->execute();
			//retornar um array de objetos
			return $stmt->fetchAll(PDO::FETCH_OBJ);
		}

	}

?>
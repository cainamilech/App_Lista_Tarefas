<?php

//recupera todas classes e metodos de cada arquivo

	require "../../app_lista_tarefas/tarefa.model.php";
	require "../../app_lista_tarefas/tarefa.service.php";
	require "../../app_lista_tarefas/conexao.php";

//apartir do get, recuperar o parametro setado no formulario do html nova tarefa
//o isset serve para saber se esta setado, e se for = inserir, daremos inicio a logica.

//teste: recuperar a variavel $acao, se tiver setado algo, vamos atribuir o valor a variavel acao. caso o contrario ( : ) a aplicao vai esperar uma variavel chamada acao ja declarada (que foi declarada no todas_tarefas antes do require)

	$acao = isset($_GET['acao']) ? $_GET['acao'] : $acao;

	//instancia do objeto tarefa
	if($acao == 'inserir' ) {
		$tarefa = new Tarefa();
		//setar via post, do name do form, o atributo tarefa do objeto. (atributo, valor)
		$tarefa->__set('tarefa', $_POST['tarefa']);

		//criar uma instancia de conexao
		$conexao = new Conexao();

		//criar instancia de tarefa service, que vai realizar as operações junto ao banco de dados
		$tarefaService = new TarefaService($conexao, $tarefa);
		//ao executar, recupera as informações da funcao inserir, no tarefa service
		$tarefaService->inserir();

		//após o processo de inclusao, redirecionar atraves do metodo header, novamente para nova_tarefa.php mas 
		//recebendo por parametro via get(?) inclusao=1, para que possamos afetar a pagina formando um feedback pro usuario
		header('Location: nova_tarefa.php?inclusao=1');
	
	} else if($acao == 'recuperar') {
		
		$tarefa = new Tarefa();
		$conexao = new Conexao();

		$tarefaService = new TarefaService($conexao, $tarefa);
		$tarefas = $tarefaService->recuperar();
	
	} else if($acao == 'atualizar') {

		$tarefa = new Tarefa();
		//setar o seu respectivo id, cujo valor vai ser o indice id da POST, setar a descrição tb
		$tarefa->__set('id', $_POST['id'])
			->__set('tarefa', $_POST['tarefa']);

		$conexao = new Conexao();

		$tarefaService = new TarefaService($conexao, $tarefa);
		//executar. e se o valor for true, que é o caso do sucesso, redirecionar 
		//mas apenas se o indice pag nao tiver set ou for diferente de index
		if($tarefaService->atualizar()) {
			
			if( isset($_GET['pag']) && $_GET['pag'] == 'index') {
				header('location: index.php');	
			} else {
				header('location: todas_tarefas.php');
			}
		}


	} else if($acao == 'remover') {

		$tarefa = new Tarefa();
		$tarefa->__set('id', $_GET['id']);

		$conexao = new Conexao();

		$tarefaService = new TarefaService($conexao, $tarefa);
		$tarefaService->remover();

		//redireciona pra mesma pagina sem passar nenhum parametro, voltando ao fluxo comum, no qual a acao = recuperar
		if( isset($_GET['pag']) && $_GET['pag'] == 'index') {
			header('location: index.php');	
		} else {
			header('location: todas_tarefas.php');
		}
	
	} else if($acao == 'marcarRealizada') {

		$tarefa = new Tarefa();
		//mudar o status
		$tarefa->__set('id', $_GET['id'])->__set('id_status', 2);

		$conexao = new Conexao();

		$tarefaService = new TarefaService($conexao, $tarefa);
		$tarefaService->marcarRealizada();

		if( isset($_GET['pag']) && $_GET['pag'] == 'index') {
			header('location: index.php');	
		} else {
			header('location: todas_tarefas.php');
		}
	
		//setar no id status, como tarefa pendente(1)
	} else if($acao == 'recuperarTarefasPendentes') {
		$tarefa = new Tarefa();
		$tarefa->__set('id_status', 1);
		
		$conexao = new Conexao();

		$tarefaService = new TarefaService($conexao, $tarefa);
		$tarefas = $tarefaService->recuperarTarefasPendentes();
	}


?>
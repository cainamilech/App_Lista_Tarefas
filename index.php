<?php 

$acao = 'recuperarTarefasPendentes';
require 'tarefa_controller.php';

?>

<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>App Lista Tarefas</title>

		<link rel="stylesheet" href="css/estilo.css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

	<script>
			function editar(id, txt_tarefa){

				//criar um form de edição
				let form = document.createElement('form')
				//destino do formulario com um parametro, que é acao atualizar, para utilizar em mais um else la no controller
				form.action = 'index.php?pag=index&acao=atualizar'
				form.method = 'post'
				form.className = 'row'


				//criar um input para entrada do texto
				let inputTarefa = document.createElement('input')
				inputTarefa.type = 'text'
				inputTarefa.name = 'tarefa'
				inputTarefa.className = 'col-9 form-control'
				//manter o mesmo texto que ja tinha, para editar melhor
				inputTarefa.value = txt_tarefa

				//criar um input hidden(oculto) para guardar o id da tarefa	
				let inputId = document.createElement('input')
				inputId.type = 'hidden'
				inputId.name = 'id'
				//valor, é o id recebido por parametro
				inputId.value = id


				//criar um button para envio do form
				let button = document.createElement('button')
				button.type = 'submit'
				button.className = 'col-3 btn btn-info'
				//texto interno, encapsulado pelo button
				button.innerHTML = 'Atualizar'

				//incluir inputTarefa no form
				form.appendChild(inputTarefa)

				//incluir inputId no form
				form.appendChild(inputId)

				//incluir button no form
				form.appendChild(button)

				//selecionar a div tarefa
				let tarefa = document.getElementById('tarefa_'+id)

				//limpar o texto da tarefa para inclusao do form. (recuperar a variavel selecionada, e atraves do inner atribuir um valor vazio)
				tarefa.innerHTML = ''

				//incluir form na pagina
				//insertbefore é usado para inserir um novo nó antes do nó existente
				//insert before espera 2 parametros, qual elemento sera selecionado e depois seleciona qual elemento filho, no caso o primeiro, pois tarefa nao tem nenhum 
				tarefa.insertBefore(form, tarefa[0])

			}

			function remover(id){ //redirecionar pra mesma pagina, mas passando a acao e o id
				location.href = 'index.php?pag=index&acao=remover&id='+id;
			}

			function marcarRealizada(id){
				//redirecionar pra mesma pagina, mas passando a acao e o id
				location.href = 'index.php?pag=index&acao=marcarRealizada&id='+id;
			}
		</script>
	</head>

	<body>
		<nav class="navbar navbar-light bg-light">
			<div class="container">
				<a class="navbar-brand" href="#">
					<img src="img/logo.png" width="30" height="30" class="d-inline-block align-top" alt="">
					App Lista Tarefas
				</a>
			</div>
		</nav>

		<div class="container app">
			<div class="row">
				<div class="col-md-3 menu">
					<ul class="list-group">
						<li class="list-group-item active"><a href="#">Tarefas pendentes</a></li>
						<li class="list-group-item"><a href="nova_tarefa.php">Nova tarefa</a></li>
						<li class="list-group-item"><a href="todas_tarefas.php">Todas tarefas</a></li>
					</ul>
				</div>

				<div class="col-md-9">
					<div class="container pagina">
						<div class="row">
							<div class="col">
								<h4>Tarefas pendentes</h4>
								<hr />

								<!--abrir php, e percorrer o array de tarefas pelo foreach recuperando o indice acessando cada uma das tarefas, fazendo a impressao.-->
								<?php
								foreach ($tarefas as $indice => $tarefa){
								?>

								<div class="row mb-3 d-flex align-items-center tarefa">
									<!--concatenado em cada interação o atributo id do objeto tarefa pra dar ao nome ao id dessa div-->
									<div class="col-sm-9" id="tarefa_<?= $tarefa->id ?>"> 
										<!--recupera o atributo tarefa do objeto tarefa, o atributo status do objeto tarefa-->
										<?= $tarefa->tarefa ?>
									</div>
									<div class="col-sm-3 mt-2 d-flex justify-content-between">
										<!--onclick com a funcao remover passando o id da tarefa-->
										<i class="fas fa-trash-alt fa-lg text-danger" onclick="remover(<?= $tarefa->id ?>)"></i>
										
										<!--botao de editar, quando for clicado, executar o metodo editar, passando o ID da tarefa, e no segundo parametro, sera mantido dentro do form o mesmo texto que já havia-->
										<i class="fas fa-edit fa-lg text-info" onclick="editar(<?= $tarefa->id ?>, '<?= $tarefa->tarefa ?>')"></i>
										<i class="fas fa-check-square fa-lg text-success" onclick="marcarRealizada(<?= $tarefa->id ?>)"></i>
										
									</div>
								</div>

								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
<?php
	
	require_once('./inc/functions.php');
	require_once('./controller/clotheController.php');

	$functions = new Functions();
	$clotheController = new clotheController();

	//pega todas as peças de roupa disponíveis
	$clothes = json_decode($clotheController->getAll());
	shuffle($clothes);

	//realiza a "compra" de uma peça de roupa
	if(isset($_GET['clothe_id'])){
		$id = $_GET['clothe_id'];

		$clotheController->buy($id);
	}

	//limpa a lista de comprados
	if (isset($_GET['clean'])) {
		$clotheController->destroy();
	}

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Home</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="view/style.css">
	</head>
	<body>
		<h1 class="title">Peças Disponíveis em Estoque</h1>
		<a href="?clean" class="clean">Limpar lista de compra</a>
		<div id="clothes" class="container">

			<?php
				for ($i=0; $i < count($clothes); $i++) { 
			?>

					<div class="clothe-card">
						<img src="<?= $clothes[$i]->image ?>" alt="<?= $clothes[$i]->name ?>" />
						<h5><?= $clothes[$i]->name ?></h5>

					<?php
						if($functions->alreadyPurchased($clothes[$i]->id)){
							echo "<p class='purchased'>Comprado</p>";
						}else{
							echo "<a href='?p=final&clothe_id=".$clothes[$i]->id."'>Comprar</a>";
						}
					?>

								
						<div class="info">
							<p>Gênero - <?= $clothes[$i]->gender ?></p>
							<p>Material - <?= $clothes[$i]->material ?></p>
							<p>Cor - <?= $clothes[$i]->color ?></p>
							<p>Origem - <?= $clothes[$i]->origin ?></p>
							<p>Tipo - <?= $clothes[$i]->type ?></p>
						</div>
					</div>
					

			<?php
				}
			?>
		</div>

		<footer>
		</footer>
	</body>
</html>
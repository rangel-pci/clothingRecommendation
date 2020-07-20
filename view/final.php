<?php
	require_once('./inc/functions.php');
	require_once('./controller/clotheController.php');

	$functions = new Functions();
	$clotheController = new clotheController();

	if(!isset($_GET['clothe_id'])){

		exit();
	}
	//pega a peça de id igual a $_GET['clothe_id']
	$clothePurchased = json_decode($clotheController->getclothe($_GET['clothe_id']));

	//realiza a "compra"
	$clotheController->buy($clothePurchased->id);

	//realiza a recomendação de 3 peças de roupa
	$top3 = $functions->getRecommendation($clothePurchased);	

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Final</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="view/style.css">
	</head>
	<body>
		<h1 class="title">Compra Efetuada</h1>

		<div id="final" class="container">
			<div class="clothe-card">
				<img src="<?=$clothePurchased->image ?>" alt="<?= $clothePurchased->name ?>" />
				<h5><?= $clothePurchased->name ?></h5>

				<div class="purchased-info">
					<p>Gênero - <?= $clothePurchased->gender ?></p>
					<p>Material - <?= $clothePurchased->material ?></p>
					<p>Cor - <?= $clothePurchased->color ?></p>
					<p>Origem - <?= $clothePurchased->origin ?></p>
					<p>Tipo - <?= $clothePurchased->type ?></p>
				</div>
			</div>

			<p>O item <strong><?= $clothePurchased->name ?></strong> foi adicionado a sua lista de compras.</p>
			<a href="?p=home">Voltar</a>					
		</div>

		<?php echo ($top3)? "<h2 class='title'>Complete seu visual</h2>": '' ?>

		<div id="recommendation">
			<?php
			if ($top3) {

				foreach ($top3 as $clotheRecommended) {
			?>
				<div class="clothe-card">
					<img src="<?=$clotheRecommended->image ?>" alt="<?= $clotheRecommended->name ?>" />
					<h5><?= $clotheRecommended->name ?></h5>

					<div class="info">
						<p>Gênero - <?= $clotheRecommended->gender ?></p>
						<p>Material - <?= $clotheRecommended->material ?></p>
						<p>Cor - <?= $clotheRecommended->color ?></p>
						<p>Origem - <?= $clotheRecommended->origin ?></p>
						<p>Tipo - <?= $clotheRecommended->type ?></p>
					</div>
					
					<?php
						if($functions->alreadyPurchased($clotheRecommended->id)){
							echo "<p class='purchased'>Comprado</p>";
						}else{
							echo "<a href='?p=final&clothe_id=".$clotheRecommended->id."'>Comprar</a>";
						}
					?>

				</div>
			<?php
				}
			}else{
				?>
				<h2 style="color: #000;">Poucas peças disponíveis para recomendação</h2>
				<?php
			}
			?>
		</div>

		<footer>
		</footer>
	</body>
</html>
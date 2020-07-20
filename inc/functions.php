<?php
	require_once('./controller/clotheController.php');
	
	Class Functions
	{

		public function alreadyPurchased($id)
		{

			$clotheController = new clotheController();

			$list = json_decode($clotheController->showAllPurchased());

			foreach ($list as $clothe) {
				if($clothe->id == $id){
					return  true;
				}
			}
		}

		public function getRecommendation($clothePurchased)
		{
			$clotheController = new clotheController();
			
			$available = json_decode($clotheController->getAll());
			
			//faz recomendações se tiver no mínino três peças de roupas disponíveis
			$purchasedCount = 0;
			foreach ($available as $clothe) {
				if ($this->alreadyPurchased($clothe->id)) {
					$purchasedCount++;
				}
			}
			$availableToRecommend = count($available) - $purchasedCount;
			if ($availableToRecommend < 3) {
				return false;
			}
			

			$points = [];
			$y = 0;
			//pontua as peças
			//as peças com maior quantidade de pontos são recomendadas
			do{
				$tempPts = 0;
				$tempId = 999;
				$tempIndex = 999;
				$i = 0;

				foreach ($available as $clothe) {
					if($clothePurchased->id != $clothe->id && !$this->alreadyPurchased($clothe->id)){
						$pts = 0;
						$pts += ($clothePurchased->gender == $clothe->gender)? 3 : 0;
						$pts += ($clothePurchased->material == $clothe->material)? 2 : 0;
						$pts += ($clothePurchased->color == $clothe->color)? 1 : 0;
						$pts += ($clothePurchased->origin == $clothe->origin)? 1 : 0;
						$pts += ($clothePurchased->type != $clothe->type)? 1 : 0;

						if($pts > $tempPts){
							$tempPts = $pts;
							$tempId = $clothe->id;
							$tempIndex = $i;
						}
					}
					$i++;
				}
				array_push($points, $tempId);
				
				unset($available[$tempIndex]);

				$available = array_values($available);
			
				$y++;
				
			}while($y < 3);

			$top3 = [];

			$clothe1 = json_decode($clotheController->getclothe($points[0]));
			$clothe2 = json_decode($clotheController->getclothe($points[1]));
			$clothe3 = json_decode($clotheController->getclothe($points[2]));

			array_push($top3, $clothe1, $clothe2, $clothe3);

			return $top3;
		}
	}

?>
<?php
	
	//peça de roupa
	Class Clothe
	{
		public function showAll(){
			
			$clothes = file_get_contents('./assets/storage/clothes.json');
			return $clothes;
		}

		public function getAllPurchased(){
			
			$clothes = file_get_contents('./assets/storage/purchased.json');
			return $clothes;
		}

		public function findById($id){
			
			$jsonClothes = Clothe::showAll();
			$clothes = json_decode($jsonClothes);

			$clothePurchased = json_encode($clothes[$id]);

			return $clothePurchased;
		}

		public function addToList($id){
			//adiciona a peça de roupa a lista de comprados

			$clothePurchased = json_decode(Clothe::findById($id));

			$list = json_decode(file_get_contents('./assets/storage/purchased.json'));

			$ok = true;
			foreach ($list as $clothe) {
				if ($clothePurchased->id == $clothe->id) {
						$ok = false;
				}
			}

			if($ok){
				array_push($list, $clothePurchased);

				$jsonList = json_encode($list);

				file_put_contents('./assets/storage/purchased.json', $jsonList);
			}
		}

		public function removeAllPurchased(){

			file_put_contents('./assets/storage/purchased.json', '[]');
		}

	}

?>
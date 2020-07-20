<?php
	
	require_once('./model/clothe.php');

	Class clotheController
	{
		public function getAll(){
			$clothe = new clothe();

			$resp = $clothe->showAll();
			return $resp;
		}

		public function showAllPurchased(){
			$clothe = new clothe();

			$resp = $clothe->getAllPurchased();
			return $resp;
		}		

		public function getclothe($id){
			$clothe = new clothe();

			$resp = $clothe->findById($id);
			return $resp;
		}

		public function buy($id){
			$clothe = new clothe();

			$clothe->addToList($id);
		}

		public function destroy(){
			$clothe = new clothe();

			$clothe->removeAllPurchased();
		}
	}

?>
<?php

namespace App\Services;

use App\Repositories\CardPersonRepository;
use App\Repositories\ShareRepository;
use Illuminate\Http\Request;

class CardPersonService {

	public function __construct(CardPersonRepository $repository, ShareRepository $shareRepository) {
		$this->repository = $repository;
		$this->shareRepository = $shareRepository;
	}

	public function index($id) {
		return $this->repository->all($id);
	}

	public function create($request) {
		$cardPerson = $this->repository->create($request);
		$checkCard = $this->shareRepository->checkOrderCard($request['share'], 'card_people'.$request["order"]);
		if($checkCard) {
			return response()->json([
                'success' => false,
                'message' => 'Tarjeta '.$request['orderDetail'].' ha sido registrada'
            ])->setStatusCode(400);
		}
		$body = array('card_people'.$request["order"] => $cardPerson->id);
		$this->shareRepository->update($request['share'], $body);
		return $cardPerson;
	}

	public function update($request, $id) {
      return $this->repository->update($id, $request);
	}

	public function read($id) {
     return $this->repository->find($id);
	}

	public function delete($request, $id) {
		$body = array('card_people'.$request["order"] => NULL);
		$this->shareRepository->update($request['share'], $body);
		return $this->repository->delete($id);
	}

	/**
	 *  Search resource from repository
	 * @param  object $queryFilter
	*/
	public function search($queryFilter) {
		return $this->repository->search($queryFilter);
	 }
	 
	 public function getCardStatistics() {
		return $this->repository->getCardStatistics();
	  }
}
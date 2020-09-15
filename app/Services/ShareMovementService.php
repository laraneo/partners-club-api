<?php

namespace App\Services;

use App\Repositories\ShareMovementRepository;
use App\Repositories\ShareRepository;
use App\Repositories\PersonRepository;
use Illuminate\Http\Request;

class ShareMovementService {

	public function __construct(
		ShareMovementRepository $model, 
		ShareRepository $shareRepository,
		PersonRepository $personRepository

		) {
		$this->model = $model ;
		$this->shareRepository = $shareRepository ;
		$this->personRepository = $personRepository ;
	}

	public function index($perPage) {
		return $this->model->all($perPage);
	}

		public function getList() {
		return $this->model->getList();
	}

	public function create($request) {
		//$oldPersons = $this->shareRepostory->findByShareId($request['share_id']);
		$body = array('id_persona' => $request['people_id'], 'id_titular_persona' => $request['id_titular_persona'] );
		$this->shareRepository->update($request['share_id'], $body);
		$attr = array('isPartner' => 1);
		$this->personRepository->update($request['people_id'],$attr);
		return $this->model->create($request);
	}

	public function update($request, $id) {
      return $this->model->update($id, $request);
	}

	public function read($id) {
     return $this->model->find($id);
	}

	public function delete($id) {
      return $this->model->delete($id);
	}

	/**
	 *  Search resource from repository
	 * @param  object $queryFilter
	*/
	public function search($queryFilter) {
		return $this->model->search($queryFilter);
	 }
	 
	public function getLastMovement($share) {
		$data = $this->shareRepository->findByShare($share);
		return $this->model->getLastMovement($data->id);
	}
}
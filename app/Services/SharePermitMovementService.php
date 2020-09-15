<?php

namespace App\Services;

use App\Repositories\SharePermitMovementRepository;
use App\Repositories\ShareRepository;
use Illuminate\Http\Request;

use Carbon\Carbon;

class SharePermitMovementService {

	public function __construct(
        SharePermitMovementRepository $repository,
        ShareRepository $shareRepository
        ) {
		$this->repository = $repository;
		$this->shareRepository = $shareRepository;
	}

	public function index($perPage) {
		return $this->repository->all($perPage);
	}

	public function getList() {
		return $this->repository->getList();
	}

	public function create($request) {
		if ($this->repository->checkRecord($request['desc'])) {
            return response()->json([
                'success' => false,
                'message' => 'El registro ya existe'
            ])->setStatusCode(400);
        }
        $user = auth()->user();
        $request['user_id'] = $user->id;
        $attr = [ 'permit' => 1 ];
        $share = $this->shareRepository->update($request['share_id'], $attr);
		return $this->repository->create($request);
	}

	public function update($request, $id) {
		$user = auth()->user();
		$shareMovement = $this->repository->find($id);

		$user = auth()->user();
        $request['user_id'] = $user->id;
        $attr = [ 'permit' => 0 ];
        $share = $this->shareRepository->update($shareMovement->share_id, $attr);
		
	  	$attr = [ 
		  'status' => $request['status'],
		  'date_cancelled' => Carbon::now(),
		  'userid_cancelled' => $user->id,
		];
      return $this->repository->update($id, $attr);
	}

	public function read($id) {
     return $this->repository->find($id);
	}

	public function delete($id) {
      return $this->repository->delete($id);
	}

	/**
	 *  Search resource from repository
	 * @param  object $queryFilter
	*/
	public function search($queryFilter) {
		return $this->repository->search($queryFilter);
 	}
}
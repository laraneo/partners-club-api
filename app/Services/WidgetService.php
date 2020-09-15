<?php

namespace App\Services;

use App\Repositories\WidgetRepository;
use App\Repositories\WidgetRoleRepository;
use Illuminate\Http\Request;

class WidgetService {

	public function __construct(
		WidgetRepository $repository,
		WidgetRoleRepository $widgetRoleRepository
		) {
		$this->repository = $repository;
		$this->widgetRoleRepository = $widgetRoleRepository;
	}

	public function index($perPage) {
		return $this->repository->all($perPage);
	}

	public function getList() {
		return $this->repository->getList();
	}

	public function create($request) {
		if ($this->repository->checkRecord($request['description'])) {
            return response()->json([
                'success' => false,
                'message' => 'El registro ya existe'
            ])->setStatusCode(400);
		}
		
		$data = $this->repository->create($request);
		if ($request['roles']) {
			$roles = $request['roles'];
			if(count($roles['itemsToAdd'])) {
				foreach ($roles['itemsToAdd'] as $itemsToAdd) {
					$widgetRole = $this->widgetRoleRepository->find($data->id, $itemsToAdd['id']);
					if(!$widgetRole) {
						$attr = ['widget_id' => $data->id, 'role_id' => $itemsToAdd['id']];
						$this->widgetRoleRepository->create($attr);
					}
				}
			}
		}

		return $data;
	}

	public function update($request, $id) {
		if ($request['roles']) {
			$roles = $request['roles'];
			if(count($roles['itemsToAdd'])) {
				foreach ($roles['itemsToAdd'] as $itemsToAdd) {
					$widgetRole = $this->widgetRoleRepository->find($id, $itemsToAdd['id']);
					if(!$widgetRole) {
						$data = ['widget_id' => $id, 'role_id' => $itemsToAdd['id']];
						$this->widgetRoleRepository->create($data);
					}
				}
			}
	
			if(count($roles['itemsToRemove'])) {
				foreach ($roles['itemsToRemove'] as $itemsToRemove) {
					$widgetRole = $this->widgetRoleRepository->find($id, $itemsToRemove['id']);
					if($widgetRole) {
						$this->widgetRoleRepository->delete($widgetRole->id);
					}
				}
			}
		}
      return $this->repository->update($id, $request);
	}

	public function read($id) {
     return $this->repository->find($id);
	}

	public function delete($id) {
      return $this->repository->delete($id);
	}
}
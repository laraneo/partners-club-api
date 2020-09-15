<?php

namespace App\Services;

use App\MenuItem;
use App\Repositories\MenuRepository;
use Illuminate\Http\Request;

class NewMenuService {

	public function __construct( MenuRepository $repository ) {
		$this->repository = $repository;
	}

    public function findMenuItem($menuItem, $menu) {
        return MenuItem::query()->where('id', $menuItem)->where('menu_id', $menu)->first();
    }
	
	public function updateMenuItem($id, array $attributes) {
		return MenuItem::find($id)->update($attributes);
	  }
	

	public function index($perPage) {
		return $this->repository->all($perPage);
	}

	public function getList() {
		return $this->repository->getList();
	}

	public function getMenuList() {
		return $this->repository->getMenuList();
	}

	public function create($request) {
		if ($this->repository->checkRecord($request['description'])) {
            return response()->json([
                'success' => false,
                'message' => 'El registro ya existe'
            ])->setStatusCode(400);
        }
		$data = $this->repository->create($request);
		if ($request['items']) {
			$items = $request['items'];
			if(count($items['itemsToAdd'])) {
				foreach ($items['itemsToAdd'] as $itemsToAdd) {
					$menuItem = $this->findMenuItem($itemsToAdd['id'], $data->id );
					if(!$menuItem) {
						$attr = ['menu_id' => $data->id];
						$this->updateMenuItem($itemsToAdd['id'], $attr);
					}
				} 
			}
		}
		return $data;
	}

	public function update($request, $id) {
		if ($request['items']) {
			$items = $request['items'];
			if(count($items['itemsToAdd'])) {
				foreach ($items['itemsToAdd'] as $itemsToAdd) {
					$menuItem = $this->findMenuItem($itemsToAdd['id'], $request['id']);
					if(!$menuItem) {
						$data = ['menu_id' => $request['id']];
						$this->updateMenuItem($itemsToAdd['id'], $data);
					}
				}
			}
	
			if(count($items['itemsToRemove'])) {
				foreach ($items['itemsToRemove'] as $itemsToRemove) {
					$menuItem = $this->findMenuItem($itemsToRemove['id'], $request['id']);
					if($menuItem) {
						$data = ['menu_id' => null];
						$this->updateMenuItem($itemsToRemove['id'], $data);
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
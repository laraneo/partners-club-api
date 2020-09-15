<?php

namespace App\Http\Controllers;

use App\Menu;
use App\MenuItem;
use Illuminate\Http\Request;
use App\Repositories\MenuItemRoleRepository;

class MenuItemController extends Controller
{
    public function __construct(
        MenuItem $model, 
        Menu $menuModel,
        MenuItemRoleRepository $menuItemRoleRepository
        )
	{
		$this->model = $model;
		$this->menuModel = $menuModel;
		$this->menuItemRoleRepository = $menuItemRoleRepository;
    }
    // /**
    //  * Display a listing of the resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    public function index(Request $request)
    {
        $data = $this->model->query()->select([
            'id',
            'name', 
            'slug', 
            'description', 
            'route',
            'icon',
            'parent',
            'order',
            'enabled',
            'menu_id',
            'menu_item_icon_id',
        ])->with(['main', 'father', 'icons'])
            ->orderBy('menu_id', 'ASC')
            ->orderBy('parent', 'ASC')
            ->orderBy('order', 'ASC')
            ->paginate($request->query('perPage'));
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getList(Request $request)
    {
        $data =$this->model->query()->select([     
            'id',
            'name',
            'description', 
            'slug', 
            'route',
            'icon',
            'parent',
            'order',
            'enabled',
            'menu_id'])->get();
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
     public function store(Request $request)
     {
         $attributes = $request->all();
         $data = $this->model->create($attributes);
         if ($request['roles']) {
			$roles = $request['roles'];
			if(count($roles['itemsToAdd'])) {
				foreach ($roles['itemsToAdd'] as $itemsToAdd) {
					$itemRole = $this->menuItemRoleRepository->find($data->id, $itemsToAdd['id']);
					if(!$itemRole) {
						$attr = ['menu_item_id' => $data->id, 'role_id' => $itemsToAdd['id']];
						$this->menuItemRoleRepository->create($attr);
					}
				}
			}
		}
         return response()->json([
            'success' => true,
            'data' => $data
        ]);
     }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    public function show($id)
    {
        $data =$this->model->query()->select([
            'id',
            'name', 
            'slug', 
            'description', 
            'route',
            'icon',
            'parent',
            'order',
            'enabled',
            'menu_id',
            'menu_item_icon_id',
            ])->where('id',$id)->with('roles')->first();
        if($data) {
            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        }
    }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    public function update(Request $request, $id)
    {
        $attributes = $request->all();
        if ($request['roles']) {
			$roles = $request['roles'];
			if(count($roles['itemsToAdd'])) {
				foreach ($roles['itemsToAdd'] as $itemsToAdd) {
					$menuRole = $this->menuItemRoleRepository->find($id, $itemsToAdd['id']);
					if(!$menuRole) {
						$data = ['menu_item_id' => $id, 'role_id' => $itemsToAdd['id']];
						$this->menuItemRoleRepository->create($data);
					}
				}
			}
	
			if(count($roles['itemsToRemove'])) {
				foreach ($roles['itemsToRemove'] as $itemsToRemove) {
					$menuRole = $this->menuItemRoleRepository->find($id, $itemsToRemove['id']);
					if($menuRole) {
						$this->menuItemRoleRepository->delete($menuRole->id);
					}
				}
			}
		}
        $bank = $this->model->find($id)->update($attributes);
        if($bank) {
            return response()->json([
                'success' => true,
                'data' => $bank
            ]);
        }
    }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    public function destroy($id)
    {
        $menuItem = $this->model->find($id);
        $menuItem->roleMenu()->delete();
        $menuItem->delete();
        return response()->json([
            'success' => true,
            'data' => $menuItem
        ]);
    }

    // /**
    //  * Get the specified resource by search.
    //  *
    //  * @param  string $term
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    public function search(Request $request) {
        $search;
      if($request->query('term') === null) {
        $search = $this->model->all();  
      } else {
        $search = $this->model->where('description', 'like', '%'.$request->query('term').'%')
        ->with(['main', 'father', 'icons'])
        ->orderBy('menu_id', 'ASC')
        ->orderBy('parent', 'ASC')
        ->orderBy('order', 'ASC')
        ->paginate($request->query('perPage'));
      }
        if($search) {
            return response()->json([
                'success' => true,
                'data' => $search
            ]);
        }
    }

        //  * Display a listing of the resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    public function getParents(Request $request)
    {
        $data = $this->model->query()->select(['id', 'description'])->where('parent', '=', 0)->get();
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}

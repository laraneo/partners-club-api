<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

use Storage;

class UserService {

		public function __construct(UserRepository $repository) {
			$this->repository = $repository ;
		}

		public function index() {
			return $this->repository->all();
		}
		
		public function create($request) {
			$request['password'] = bcrypt($request['password']);
			return $this->repository->create($request);
		}

		public function update($request, $id) {
			$user = $this->repository->find($id);
			$user->revokeAllRoles();
			$user = $this->repository->find($id);
			$roles = json_decode($request['roles']);
			
			if(count($roles)) {
				foreach ($roles as $role) {
					$user->assignRole($role);
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

		public function checkUser($user) {
			return $this->repository->checkUser($user);
		}

		public function checkLogin() {
			Storage::disk('partners')->put('testfile.txt','ContentTest');
			if (Auth::check()) {
				$user = auth()->user();
				$user->roles = auth()->user()->getRoles();
				return response()->json([
					'success' => true,
					'data' => $user
				]);
			}
			return response()->json([
                'success' => false,
                'message' => 'You must login first'
            ])->setStatusCode(401);
		}

		public function forcedLogin(string $username) {
			Storage::disk('partners')->put('testfile.txt','ContentTest');
			$user =  $this->repository->forcedLogin($username);
			if($user) {
				$auth = Auth::login($user);
				$token = auth()->user()->createToken('TutsForWeb')->accessToken;
				$user = auth()->user();
				$user->roles = auth()->user()->getRoles();
					return ['token' => $token, 'user' =>  $user];
				}
			return false;
		}

		public function search($query) {
			return $this->repository->search($query);
		}

		public function updatePassword($request) {

			$user = auth()->user();
			$check = \Hash::check($request['prevPassword'],$user->password);
			
			if(!$check) {
				return response()->json([
					'success' => false,
					'message' => 'Los datos de usuario no coinciden, intente de nuevo'
				])->setStatusCode(400);
			}

			$attr = [ 'password' => $request['password'] ];
			$data = $this->repository->update($user->id, $attr);
			return response()->json([
				'success' => true,
				'data' => $data
			]);

		}
}
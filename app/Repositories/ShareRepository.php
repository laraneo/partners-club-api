<?php

namespace App\Repositories;

use App\Share;
use App\Person;
use App\ShareMovement;
use App\ShareType;
use App\Repositories\ParameterRepository;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ShareRepository  {
  
    protected $post;

    public function __construct(
      Share $model, 
      Person $personModel,
      ShareMovement $shareMovementModel,
      ShareType $shareTypeModel,
      ParameterRepository $parameterRepository
      ) {
      $this->model = $model;
      $this->personModel = $personModel;
      $this->shareMovementModel = $shareMovementModel;
      $this->shareTypeModel = $shareTypeModel;
      $this->parameterRepository = $parameterRepository;
    }

    public function all($perPage) {
      return $this->model->query()->select(
        'id', 
        'share_number', 
        'father_share_id', 
        'payment_method_id', 
        'id_persona', 
        'id_titular_persona',
        'id_factura_persona',
        'id_fiador_persona',
        'share_type_id',
        'status',
        'permit'
        )->with([
          'fatherShare' => function($query){
          $query->select('id', 'share_number'); 
          }, 
          'partner' => function($query){
          $query->select('id', 'name', 'last_name'); 
          }, 
          'titular' => function($query){
          $query->select('id', 'name', 'last_name'); 
          },
          'paymentMethod' => function($query){
          $query->select('id', 'description'); 
          }, 
          'shareType' => function($query){
          $query->select('id', 'description', 'code'); 
          }, 
     ])->paginate($perPage);
    }

        // $search = $this->model->with('shares')->where(function($q) use($requestData, $searchQuery) {
    //   foreach ($requestData as $field) {
    //      $q->orWhere($field, 'like', "%{$searchQuery}%");
    //   }
    //   $persons = $this->shareModel->query()->where('share_number','like', '%'.$this->share.'%')->get();
    //   if(count($persons)) {
    //     foreach ($persons as $key => $value) {
    //       $q->orWhere('id', $value->id_persona);
    //     }
    //   }
    // })->whereIn('isPartner', [1,2])->paginate(8);

    public function filter($queryFilter, $isPDF = false) {
      $shares = $this->model->query()->select(
        'id', 
        'share_number',
        'status',
        'father_share_id', 
        'payment_method_id', 
        'id_persona', 
        'id_titular_persona',
        'id_factura_persona',
        'id_fiador_persona',
        'share_type_id',
        'permit'
        )->with([
          'shareMovements' => function($query) {
            $query->with([
              'share' => function($query){
                  $query->select('id', 'share_number'); 
              }, 
              'transaction' => function($query){
                  $query->select('id', 'description');
              }, 
              'partner' => function($query){
                  $query->select('id', 'name', 'last_name');
              },
              'titular' => function($query){
                $query->select('id', 'name', 'last_name');
              },
              'rateCurrency' => function($query){
                $query->select('id', 'description');
              },
              'saleCurrency' => function($query){
                $query->select('id', 'description');
              },
           ]);
          },
          'fatherShare' => function($query){
            $query->select('id', 'share_number'); 
          }, 
          'partner' => function($query){
            $query->select('id', 'name', 'last_name'); 
          }, 
          'titular' => function($query){
            $query->select('id', 'name', 'last_name'); 
          },
          'facturador' => function($query){
            $query->select('id', 'name', 'last_name'); 
          },
          'fiador' => function($query){
            $query->select('id', 'name', 'last_name'); 
          },
          'paymentMethod' => function($query){
            $query->select('id', 'description'); 
          }, 
          'shareType' => function($query){
            $query->select('id', 'description', 'code'); 
          }, 
      ]);
      if ($queryFilter->query('share') !== NULL) {
        $shares->where('share_number', 'like', '%'.$queryFilter->query('share').'%');
      }

      if ($queryFilter->query('father_share') !== NULL) {
        $filter = $queryFilter->query('father_share');
        $shares->whereHas('fatherShare', function($q) use($filter) {
          $q->where('share_number','like',"%{$filter}%");
        }); 
      }

      if ($queryFilter->query('payment_method_id') !== NULL) {
        $shares->where('payment_method_id', $queryFilter->query('payment_method_id'));
      }

      if ($queryFilter->query('share_type') !== NULL) {
        $shares->where('share_type', $queryFilter->query('share_type'));
      }
      
      if ($queryFilter->query('status') !== NULL) {
        $shares->where('status', $queryFilter->query('status'));
      }

      if ($queryFilter->query('persona') !== NULL) {
          $filter = $queryFilter->query('persona');
          $shares->whereHas('partner', function($q) use($filter) {
            $q->where('name','like',"%{$filter}%")->orWhere('last_name','like',"%{$filter}%");
          });
      }

      if ($queryFilter->query('titular') !== NULL) {
        $filter = $queryFilter->query('titular');
        $shares->whereHas('titular', function($q) use($filter) {
          $q->where('name','like',"%{$filter}%")->orWhere('last_name','like',"%{$filter}%");
        });
      }

      if ($queryFilter->query('facturador') !== NULL) {
        $filter = $queryFilter->query('facturador');
        $shares->whereHas('facturador', function($q) use($filter) {
          $q->where('name','like',"%{$filter}%")->orWhere('last_name','like',"%{$filter}%");
        });
      }

      if ($queryFilter->query('fiador') !== NULL) {
        $filter = $queryFilter->query('fiador');
        $shares->whereHas('fiador', function($q) use($filter) {
          $q->where('name','like',"%{$filter}%")->orWhere('last_name','like',"%{$filter}%");
        });
      }

      if ($isPDF) {
        Log::info('Filters PDF Share Report: '.json_encode($queryFilter->all()).' --- PDF Query Share Report: '.$shares->toSql());
        return  $shares->get();
      }
      Log::info('Filters Share Report: '.json_encode($queryFilter->all()).' --- Query Share Report: '.$shares->toSql());
      return $shares->paginate($queryFilter->query('perPage'));
    }


    public function find($id) {
      return $this->model->query()->where('id', $id)->with(['titular', 'facturador', 'fiador', 'tarjetaPrimaria', 'tarjetaSecundaria', 'tarjetaTerciaria', 'shareType' ])
      ->with(['tarjetaPrimaria' => function($query){
          $query->with(['bank','card']);
        }
      ])->with([ 'tarjetaSecundaria' => function($query){
        $query->with(['bank','card']);
        }
      ])->with([ 'tarjetaTerciaria' => function($query){
        $query->with(['bank','card']);
        }
      ])->first();
    }

    public function create($attributes) {
      return $this->model->create($attributes);
    }

    public function update($id, array $attributes) {
      return $this->model->find($id)->update($attributes);
    }

    public function delete($id) {
     return $this->model->find($id)->delete();
    }

    public function checkRecord($name)
    {
      $data = $this->model->where('description', $name)->first();
      if ($data) {
        return true;
      }
      return false; 
    }

        /**
     * get banks by query params
     * @param  object $queryFilter
    */
    public function search($queryFilter) {
      if($queryFilter->query('term') === null) {
        return  $this->model->with([
          'fatherShare' => function($query){
          $query->select('id', 'share_number'); 
          }, 
          'partner' => function($query){
          $query->select('id', 'name', 'last_name'); 
          }, 
          'titular' => function($query){
          $query->select('id', 'name', 'last_name'); 
          },
          'paymentMethod' => function($query){
          $query->select('id', 'description'); 
          }, 
          'shareType' => function($query){
          $query->select('id', 'description', 'code'); 
          }, 
     ])->paginate(8);  
      } else {
          $requestData = $queryFilter->query('term');
          $search = $this->model->query()->where(function($q) use($requestData) {
                      
            $q->orWhere('share_number','like', '%'.$requestData.'%');

            $term = $requestData;
            $q->orWhereHas('fatherShare', function($query) use($term) {
              $query->where('share_number','like', '%'.$term.'%');
            });

            $q->orWhereHas('partner', function($query) use($term) {
              $query->where('name', 'like', '%'.$term.'%')->orWhere('last_name', 'like', '%'.$term.'%');
            });

            $q->orWhereHas('titular', function($query) use($term) {
              $query->where('name', 'like', '%'.$term.'%')->orWhere('last_name', 'like', '%'.$term.'%');
            });
                      
      })->with([
        'fatherShare' => function($query){
        $query->select('id', 'share_number'); 
        }, 
        'partner' => function($query){
        $query->select('id', 'name', 'last_name'); 
        }, 
        'titular' => function($query){
        $query->select('id', 'name', 'last_name'); 
        },
        'paymentMethod' => function($query){
        $query->select('id', 'description'); 
        }, 
        'shareType' => function($query){
        $query->select('id', 'description', 'code'); 
        }, 
      ])->paginate(8);
    }
    return $search;
    }

            /**
     * get banks by query params
     * @param  object $queryFilter
    */
    public function singleSearch($queryFilter) {
      if($queryFilter->query('term') === null) {
        return  $this->model->with('titular')->get();  
      } else {
        $search = $this->model->query();
        $search->where('share_number', 'like', '%'.$queryFilter->query('term').'%')->with('titular');
        $fathers = $this->model->where('father_share_id', '>',0)->where('share_number', 'like', '%'.$queryFilter->query('term').'%')->get();
        if(count($fathers)) {
          foreach ($fathers as $key => $value) {
            $search->orWhere('father_share_id', $value->id);
           }
        }

        $persons = $this->personModel->query()->where('isPartner', 1)->where('name', 'like', '%'.$queryFilter->query('term').'%')->get();
        if(count($persons)) {
          foreach ($persons as $key => $value) {
            $search->orWhere('id_persona', $value->id);
           }
        }

        if(count($persons)) {
          foreach ($persons as $key => $value) {
            $search->orWhere('id_titular_persona', $value->id);
           }
        }
        return $search->get();
      }
    }

    
            /**
     * get banks by query params
     * @param  object $queryFilter
    */
    public function singleShareSearch($queryFilter) {
      if($queryFilter->query('term') === null) {
        return  $this->model->with('titular')->get();  
      } else {      
        $searchQuery = $queryFilter->query('term');
        $search = $this->model->query()->where(function($q) use($searchQuery) {
          $q->orWhere('share_number','like', '%'.$searchQuery.'%');
          $q->orWhereHas('fatherShare', function($query) use($searchQuery) {
            $query->where('share_number','like', '%'.$searchQuery.'%');
          });

          $q->orWhereHas('partner', function($query) use($searchQuery) {
            $query->where('name','like', '%'.$searchQuery.'%');
          });

          $q->orWhereHas('titular', function($query) use($searchQuery) {
            $query->where('name','like', '%'.$searchQuery.'%');
          });

        })->where('status',1)->with('titular')->get();

        return $search;
      }
    }

                /**
     * get banks by query params
     * @param  object $queryFilter
    */
    public function getSharesBySearch($queryFilter) {
      if($queryFilter->query('term') === null) {
        return  $this->model->with('titular')->get();  
      } else {      
        $parameter = $this->parameterRepository->findByParameter('CODIGO_ACCION_BAJA');
        $parameter = $parameter ? $parameter ->value : '';
        $searchQuery = $queryFilter->query('term');
        $search = $this->model->query()->where(function($q) use($searchQuery) {
          $q->orWhere('share_number','like', '%'.$searchQuery.'%');
          $q->orWhereHas('fatherShare', function($query) use($searchQuery) {
            $query->where('share_number','like', '%'.$searchQuery.'%');
          });

          $q->orWhereHas('partner', function($query) use($searchQuery) {
            $query->where('name','like', '%'.$searchQuery.'%');
          });

          $q->orWhereHas('titular', function($query) use($searchQuery) {
            $query->where('name','like', '%'.$searchQuery.'%');
          });

        })->where('status',1)->whereHas('shareType', function($q) use($parameter){
          $q->where('code','!=', $parameter);
        })->with('titular')->get();

        return $search;
      }
    }

    /**
     * get banks by query params
     * @param  object $queryFilter
    */
    public function getDisableShares($queryFilter) {
      if($queryFilter->query('term') === null) {
        return  $this->model->with('titular')->get();  
      } else {      
        $searchQuery = $queryFilter->query('term');
        $parameter = $this->parameterRepository->findByParameter('CODIGO_ACCION_BAJA');
        $parameter = $parameter ? $parameter ->value : '';
        $search = $this->model->query()->where(function($q) use($searchQuery) {
          $q->orWhere('share_number','like', '%'.$searchQuery.'%');
          $q->orWhereHas('fatherShare', function($query) use($searchQuery) {
            $query->where('share_number','like', '%'.$searchQuery.'%');
          });

          $q->orWhereHas('partner', function($query) use($searchQuery) {
          $query->where('name','like', $searchQuery.'%');
          });

          $q->orWhereHas('titular', function($query) use($searchQuery) {
            $query->where('name','like', '%'.$searchQuery.'%');
          });

        })->whereHas('shareType', function($q) use($parameter ) {
          $q->where('code', $parameter);
        })->where('status', 1)->with('titular')->get();

        return $search;
      }
    }

    public function getByPartner($id) {
      return $this->model->query()->select([
        'id',
        'share_number',
        'father_share_id',
        'status',
        'payment_method_id',
        'card_people1',
        'card_people2',
        'card_people3',
        'id_persona',
        'id_titular_persona',
        'id_factura_persona',
        'id_fiador_persona',
        'share_type_id',
        'permit',
    ])->where('id_persona', $id)->with(['titular', 'facturador', 'fiador','paymentMethod'])->with([ 'tarjetaPrimaria' => function($query){
        $query->with(['bank','card']);
        }
        ])->with([ 'tarjetaSecundaria' => function($query){
          $query->with(['bank','card']);
          }
        ])->with([ 'tarjetaTerciaria' => function($query){
          $query->with(['bank','card']);
          }
        ])->get();
    }

            /**
     * get banks by query params
     * @param  object $queryFilter
    */
    public function searchToAssign($queryFilter) {
      if($queryFilter->query('term') === null) {
        return  $this->model->with([
          'fatherShare' => function($query){
          $query->select('id', 'share_number'); 
          }, 
          'partner' => function($query){
          $query->select('id', 'name', 'last_name'); 
          }, 
          'titular' => function($query){
          $query->select('id', 'name', 'last_name'); 
          },
          'paymentMethod' => function($query){
          $query->select('id', 'description'); 
          }, 
          'shareType' => function($query){
          $query->select('id', 'description', 'code'); 
          }, 
     ])->get();  
      } else {
        $search = $this->model->query()->with([
          'fatherShare' => function($query){
          $query->select('id', 'share_number'); 
          }, 
          'partner' => function($query){
          $query->select('id', 'name', 'last_name'); 
          }, 
          'titular' => function($query){
          $query->select('id', 'name', 'last_name'); 
          },
          'paymentMethod' => function($query){
          $query->select('id', 'description'); 
          }, 
          'shareType' => function($query){
          $query->select('id', 'description', 'code'); 
          }, 
     ]);
        $search->where('share_number', 'like', '%'.$queryFilter->query('term').'%');
        $fathers = $this->model->where('father_share_id', '>',0)->where('share_number', 'like', '%'.$queryFilter->query('term').'%')->get();
        if(count($fathers)) {
          foreach ($fathers as $key => $value) {
            $search->orWhere('father_share_id', $value->id);
           }
        }

        $persons = $this->personModel->query()->where('isPartner', 1)->where('name', 'like', '%'.$queryFilter->query('term').'%')->get();
        if(count($persons)) {
          foreach ($persons as $key => $value) {
            $search->orWhere('id_persona', $value->id);
           }
        }

        if(count($persons)) {
          foreach ($persons as $key => $value) {
            $search->orWhere('id_titular_persona', $value->id);
           }
        }
        return $search->get();
      }
    }

    public function getListByPartner($id) {
      $parameter = $this->parameterRepository->findByParameter('CODIGO_ACCION_BAJA');
      $parameter = $parameter ? $parameter ->value : '';
      return $this->model->query()->select('id', 'share_number')->where('status', 1)->whereHas('shareType', function($q) use($parameter) {
        $q->where('code', '!=', $parameter);
      })->where('id_persona', $id)->get();
    }

    public function findByShare($share) {
      return $this->model->where('share_number', $share)->with([
        'partner' => function($q) {
          $q->select('id', 'name', 'last_name', 'rif_ci', 'card_number');
        }
        ])->first();
    }

    public function findByShareId($share) {
      return $this->model->where('id', $share)->first();
    }

    public function checkOrderCard($share, $column) {
      return $this->model->where('id', $share)->where($column, '>',0)->first();
    }

    public function buildDisableShare($share) {
      if($share === null) {
        return 'B-0001';
      } else {
        $number = str_replace('B-','', $share);
        $number = str_replace('0','', $number);
        $number = (int)$number + 1;
        $number = sprintf("%'.04d", $number);
        return 'B-'.$number;
      }
    }

    public function disableShare($request) {
      $currentShare = $this->model->query()->where('id', $request['share_id'])->with(['partner'])->first();
      $user = auth()->user();
      $currentDisableShare = \DB::select("SELECT MAX(share_number) AS share from shares where share_type_id = (SELECT TOP 1 id from share_types where code='B')");
      
      if($currentDisableShare && $currentDisableShare[0]->share) {
        $newShare = $this->buildDisableShare($currentDisableShare[0]->share);
      } else {
        $newShare = $this->buildDisableShare(null);
      }

      // Se desactiva la actual accion
      $this->model->find($request['share_id'])->update([ 'status' => 0 ]);

      $shareType = $this->shareTypeModel->query()->where('code','B')->first();

      // Se crea la nueva accion tipo Baja

      $newShareBody = [
        'share_number' => $newShare,
        'father_share_id' => $request['share_id'],
        'status' => 1,
        'payment_method_id' => null, 
        'card_people1' => null, 
        'card_people2' => null, 
        'card_people3' => null, 
        'id_persona' => $currentShare->id_persona, 
        'id_titular_persona' => $currentShare->id_persona,
        'id_factura_persona' => null,
        'id_fiador_persona' => null,
        'share_type_id' => $shareType->id,
        'permit' => null,
      ];

     $createShare = $this->model->create($newShareBody);

      // Se crea el movimiento para la accion que se creo
      $body = [
        'description'  => 'Dar de baja accion '.$currentShare->share_number.' y asignando accion de baja '.$newShare.' por '.$user->id.'  '.$user->name,
        'currency_rate_id' => 1,
        'rate' => 0,
        'currency_sale_price_id' => 1,
        'number_sale_price' => 0 ,
        'currencie_id' => 1,
        'share_id' => $createShare->id,
        'transaction_type_id' =>  $request['transaction_type_id'],
        'people_id' => $currentShare->id_persona,
        'id_titular_persona' => $currentShare->id_persona,
        'created' => Carbon::now(),
      ];

      return [
        'data' => $this->shareMovementModel->create($body),
        'message' => "La accion ".$createShare->share_number." fue asignada al socio ".$currentShare->partner->name." ".$currentShare->partner->last_name.""
      ];
    }

    public function backupShare($request) {
      $user = auth()->user();
      $currentShare = $this->model->query()->where('id', $request['share_id'])->with(['partner','fatherShare'])->first();

      // Se activa la actual accion
      $this->model->find($request['share_id'])->update([ 'status' => 0 ]);
      $this->model->find($currentShare->father_share_id)->update([ 'status' => 1 ]);

      // Se crea el movimiento para la accion que se creo
      $body = [
        'description'  => 'Removiendo accion de baja '.$currentShare->share_number.' y activando accion '.$currentShare->fatherShare->share_number.' por '.$user->id.'  '.$user->name,
        'currency_rate_id' => 1,
        'rate' => 0,
        'currency_sale_price_id' => 1,
        'number_sale_price' => 0 ,
        'currencie_id' => 1,
        'share_id' => $currentShare->father_share_id,
        'transaction_type_id' =>  $request['transaction_type_id'],
        'people_id' => $currentShare->id_persona,
        'id_titular_persona' => $currentShare->id_persona,
        'created' => Carbon::now(),
      ];

      return [
        'data' => $this->shareMovementModel->create($body),
        'message' => "La accion ".$currentShare->fatherShare->share_number." fue activada al socio ".$currentShare->partner->name." ".$currentShare->partner->last_name.""
      ];
    }
}
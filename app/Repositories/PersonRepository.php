<?php

namespace App\Repositories;

use App\Person;
use App\Share;
use App\AccessControl;
use App\PersonRelation;
use App\PersonProfession;
use App\PersonSport;
use App\Repositories\ShareRepository;
use App\Repositories\RelationTypeRepository;
use App\Repositories\PersonRelationRepository;
use App\Repositories\AccessControlRepository;
use App\Repositories\ParameterRepository;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Builder;

class PersonRepository  {

    public function __construct(
      Person $model,
      PersonRelationRepository $personRelationRepository,
      RelationTypeRepository $relationTypeRepository,
      ShareRepository $shareRepository,
      AccessControlRepository $accessControlRepository,
      Share $shareModel,
      PersonRelation $personRelationModel,
      ParameterRepository $parameterRepository
      )
      {
      $this->model = $model;
      $this->personRelationRepository = $personRelationRepository;
      $this->relationTypeRepository = $relationTypeRepository;
      $this->shareRepository = $shareRepository;
      $this->accessControlRepository = $accessControlRepository;
      $this->shareModel = $shareModel;
      $this->personRelationModel = $personRelationModel;
      $this->parameterRepository = $parameterRepository;
    }

    public function find($id) {
      $person = $this->model->where('id', $id)->with([
        'professions',
        'creditCards',
        'shares',
        'countries',
        'sports',
        'lockers',
        'company',
        'relationship',
        ])->first();
      if($person->picture !== null){
        $person->picture = url('storage/partners/'.$person->picture);
      }
      
      if($person->isPartner === "2") {
        $relations = $this->personRelationModel->where('related_id', $person->id)->with(['base','relationType'])->get();
          foreach ($relations as $key => $value) {
            $partner = $value->base()->with('shares')->first();
            $relations[$key]->id = $partner->id;
            $relations[$key]->shares = $this->parseShares($partner->shares()->get());
        }
        $person->relations = $relations;
      } else {
        $person->relations = [];
      }
      return $person;
    }

    public function create($attributes) {
      return $this->model->create($attributes);
    }

    public function update($id, array $attributes) {
      return $this->model->find($id)->update($attributes);
    }

    public function reportAll() {
      return $this->model->all();
    }

    public function all($perPage) {
      $parameter = $this->parameterRepository->findByParameter('CODIGO_ACCION_BAJA');
      $parameter = $parameter ? $parameter ->value : '';
      $persons = $this->model->query()->with('shares')->paginate($perPage);
      foreach ($persons as $key => $value) {
        unset($persons[$key]->shares);
        $persons[$key]->shares = $this->parseShares($value->shares()->where('status', 1)->whereHas('shareType', function($q) use($parameter) {
          $q->where('code', '!=', $parameter);
        })->get());
      }
      return $persons;
    }

    public function getAllGuest($perPage) {
      return $this->model->query()->where('isPartner', 3)->paginate($perPage);
    }


    public function delete($id) {
     return $this->model->find($id)->update(['status_person_id' => 0]);
    }

    public function checkPerson($name)
    {
      $person = $this->model->where('rif_ci', $name)->first();
      if ($person) {
        return $person;
      }
      return false;
    }

    /**
     * get persons by query params
     * @param  object $queryFilter
    */
    public function search($queryFilter) {
      $search;
      
      if($queryFilter->query('term') === null) {
        $search = $this->model->all();
      } else {
        $searchQuery = trim($queryFilter->query('term'));
        $requestData = ['name', 'last_name', 'rif_ci'];
        $this->share = $queryFilter->query('term');
        $search = $this->model->with('shares')->where(function($q) use($requestData, $searchQuery) {
                    foreach ($requestData as $field) {
                      $q->orWhere($field, 'like', "%{$searchQuery}%");
                    }
                    $persons = $this->shareModel->query()->where('share_number','like', $this->share.'%')->get();
                    if(count($persons)) {
                      foreach ($persons as $key => $value) {
                        $q->orWhere('id', $value->id_persona);
                      }
                    }
        })->whereIn('isPartner', [1,2])->paginate(8);
        $parameter = $this->parameterRepository->findByParameter('CODIGO_ACCION_BAJA');
        $parameter = $parameter ? $parameter->value : '';
        foreach ($search as $key => $value) {
          unset($search[$key]->shares);
          $shares = $value->shares()->whereHas('shareType', function($q) use($parameter) {
            $q->where('code', '!=', $parameter);
          })->get();
          $search[$key]->shares = $this->parseShares($shares);
        }

      }
     return $search;
    }

        /**
     * get persons by query params
     * @param  object $queryFilter
    */
    public function searchByGuest($queryFilter) {
      $search;
      if($queryFilter->query('term') === null) {
        $search = $this->model->query()->where('isPartner', 3)->paginate(8);
      } else {
        $searchQuery = trim($queryFilter->query('term'));
        $requestData = ['name', 'last_name', 'rif_ci'];
        $search = $this->model->where(function($q) use($requestData, $searchQuery) {
                    foreach ($requestData as $field)
                      $q->orWhere($field, 'like', "%{$searchQuery}%");
                  })->where('isPartner', 3)->paginate(8);
      }
     return $search;
    }

    /**
     * get persons by query params
     * @param  object $queryFilter
    */
    public function filter($queryFilter, $isPDF = false) {
      $searchQuery = $queryFilter;
      $search = $this->model->query()->with(['statusPerson', 'maritalStatus', 'gender', 'country','professions', 'shares',
      'relationship' => function($query){
        $query->select('id', 'related_id', 'base_id', 'relation_type_id')->with('relationType');
      },])->where(function($q) use($searchQuery) {

        if ($searchQuery->query('isPartner') !== NULL) {
          $q->where('isPartner', $searchQuery->query('isPartner'));
        }

        if ($searchQuery->query('name') !== NULL) {
          $q->where('name', 'like', "%{$searchQuery->query('name')}%")
          ->orWhere('last_name', 'like', "%{$searchQuery->query('name')}%");
        }

        if ($searchQuery->query('rif_ci') !== NULL) {
          $q->where('rif_ci', 'like', "%{$searchQuery->query('rif_ci')}%");
        }

        if ($searchQuery->query('passport') !== NULL) {
          $q->where('passport', 'like', "%{$searchQuery->query('passport')}%");
        }

        if ($searchQuery->query('type_person') !== NULL) {
          $q->where('type_person', 'like', "%{$searchQuery->query('type_person')}%");
        }

        if ($searchQuery->query('gender_id') !== NULL) {
          $q->where('gender_id', 'like', "%{$searchQuery->query('gender_id')}%");
        }

        if ($searchQuery->query('status_person_id') !== NULL) {
          $q->where('status_person_id', 'like', "%{$searchQuery->query('status_person_id')}%");
        }

        if ($searchQuery->query('card_number') !== NULL) {
          $q->where('card_number', 'like', "%{$searchQuery->query('card_number')}%");
        }

        if ($searchQuery->query('primary_email') !== NULL) {
          $q->where('primary_email', 'like', "%{$searchQuery->query('primary_email')}%");
        }

        if ($searchQuery->query('telephone1') !== NULL) {
          $q->where('telephone1', 'like', "%{$searchQuery->query('telephone1')}%");
        }

        if ($searchQuery->query('phone_mobile1') !== NULL) {
          $q->where('phone_mobile1', 'like', "%{$searchQuery->query('phone_mobile1')}%");
        }

        if ($searchQuery->query('expiration_start') !== NULL && $searchQuery->query('expiration_end') !== NULL) {
          $q->whereBetween('expiration_date', [$searchQuery->query('expiration_start'),$searchQuery->query('expiration_end')]);
        }

        if ($searchQuery->query('birth_start') !== NULL && $searchQuery->query('birth_end') !== NULL) {
          $q->whereBetween('birth_date', [$searchQuery->query('birth_start'),$searchQuery->query('birth_end')]);
        }

        if ($searchQuery->query('age_start') !== NULL && $searchQuery->query('age_end') !== NULL) {
          $birth_start = Carbon::today()->subYears($searchQuery->query('age_start'))->year.'-12-31';
          $birth_end = Carbon::today()->subYears($searchQuery->query('age_end'))->year.'-01-01';
          $q->whereBetween('birth_date', [$birth_end, $birth_start]);
        }

        if ($searchQuery->query('relation_type_id') !== NULL) {
          $queryId = $searchQuery->query('relation_type_id');
          $q->whereHas('relationship', function($query) use($queryId) {
            $query->where('relation_type_id', $queryId);
          });
        }

        if ($searchQuery->query('profession_id') !== NULL) {
          $queryId = $searchQuery->query('profession_id');
          $q->whereHas('professions', function($query) use($queryId) {
            $query->where('profession_id', $queryId);
          });
        }

        if ($searchQuery->query('sport_id') !== NULL) {
          $queryId = $searchQuery->query('sport_id');
          $q->whereHas('sports', function($query) use($queryId) {
            $query->where('sports_id', $queryId);
          });
        }

      });

      if($isPDF) {
        $persons = $search->get();
        foreach ($persons as $key => $person) {
          if(count($person->relationship()->get())) {
            $relation = $person->relationship()->with('relationType')->first();
            $persons[$key]->relation = $relation->relationType->description;
          } else {
            $persons[$key]->relation = '';
          }
          if(count($person->shares()->get())) {
            $shareList = $this->parseShares($person->shares()->get());
            $persons[$key]->shareList = $shareList;
          } else {
            $persons[$key]->shareList = "";
          }
        }
        Log::info('Filters PDF General Report: '.json_encode($queryFilter->all()).' --- PDF Query General Report: '.$search->toSql());
        return $persons;
      }
      Log::info('Filters General Report: '.json_encode($queryFilter->all()).' --- Single Query General Report: '.$search->toSql());
      return $search->paginate($queryFilter->query('perPage'));
  }

        /**
     * seatch persons by query params
     * @param  object $queryFilter
    */
    public function searchToAssign($queryFilter) {
      $search;
      if($queryFilter->query('term') === null) {
        $search = $this->model->all();
      } else {

        $searchQuery = trim($queryFilter->query('term'));
        $requestData = ['name', 'last_name', 'rif_ci'];
        $search = $this->model->where(function($q) use($requestData, $searchQuery) {
                    foreach ($requestData as $field)
                      $q->orWhere($field, 'like', "%{$searchQuery}%");
                  })->get();
      }
     return $search;
    }

    /**
     * get persons by query params
     * @param  object $queryFilter
    */
    public function searchByCompany($queryFilter) {
      $search;
      if($queryFilter->query('term') === null) {
        $search = $this->model->all();
      } else {
        $search = $this->model->where('type_person', 2)->where('description', 'like', '%'.$queryFilter->query('term').'%')->get();
      }
     return $search;
    }
    /**
     * get persons by query params
     * @param  object $queryFilter
    */
    public function searchPersonsToAssign($queryFilter) {
      $search;
      if($queryFilter->query('term') === null) {
        $search = $this->model->query()->where('id', '!=', $queryFilter->query('id'))->where('type_person', 1)->paginate($queryFilter->query('perPage'));
      } else {
        $searchQuery = trim($queryFilter->query('term'));
        $requestData = ['name', 'last_name', 'rif_ci', 'passport'];
        $search = $this->model->where(function($q) use($requestData, $searchQuery) {
          foreach ($requestData as $field)
          $q->orWhere($field, 'like', "{$searchQuery}%");
        })->where('type_person', 1)->paginate($queryFilter->query('perPage'));
      }
     return $search;
    }

        /**
     * get persons by query params
     * @param  object $queryFilter
    */
    public function searchFamilyByPerson($queryFilter) {
       if($queryFilter->query('id') !== null) {
        return \DB::select("SELECT p.id, r.base_id, r.status, r.related_id , p.name, p.last_name, p.rif_ci, p.card_number, r.relation_type_id,  t.description 
        FROM person_relations r, people p, relation_types t
        WHERE r.base_id=".$queryFilter->query('id')."
        AND r.related_id=p.id 
        AND t.id=r.relation_type_id
        ORDER  BY t.item_order ASC");
       }
       return [];
        // return $this->personRelationModel->where('base_id',$queryFilter->query('id'))->with([
        //   'relationType',
        //   'person'
        //   ])->get();
      // return  \DB::table('person_relations r , people p , ')
      // ->select()
      // ->join('people', 'people.id', '=', 'person_relations.related_id')
      // ->join('relation_types', 'relation_types.id', '=', 'person_relations.relation_type_id')
      // ->where('person_relations.base_id ',1)->get();
      //   $person = $this->model->query()->where('id', $queryFilter->query('id'))->with('family')->first();
      //   $familys = $person->family()->get();
      //   foreach ( $familys as $key => $family) {
      //     $currentPerson = PersonRelation::query()->where('base_id', $queryFilter->query('id'))->where('related_id', $family->id)->first();
      //     $relation = $this->relationTypeRepository->find($currentPerson->relation_type_id);
      //     $familys[$key]->relationType = $relation;
      //     $familys[$key]->id = $currentPerson->id;
      //     $familys[$key]->status = $currentPerson->status;
      //   }
      //  return $person->family = $familys;
  }

    public function assignPerson($attributes) {
      return $this->personRelationRepository->create($attributes);
    }

    public function getReportByPartner($id) {
        $person = $this->model->query()->where('id', $id)->with(['family', 'statusPerson', 'maritalStatus', 'gender', 'country','professions'])->first();
        $person['professionList'] = $this->parseProfessions($person->professions()->get());
        if($person->family()) {
          $familys = $person->family()->with(['statusPerson', 'maritalStatus', 'gender', 'country','professions'])->get();
          foreach ( $familys as $key => $family) {
            $professions = $this->parseProfessions($family->professions()->get());
            $currentPerson = PersonRelation::query()->where('base_id', $id)->where('related_id', $family->id)->first();
            $relation = $this->relationTypeRepository->find($currentPerson->relation_type_id);
            $familys[$key]->relationType = $relation;
            $familys[$key]->id = $currentPerson->id;
            $familys[$key]->professionList = $professions;
          }
          $person['familyMembers'] = $familys;
        }
        return $person;
    }

    public function parseProfessions($professions) {
      $str = '';
      $count = 0;
      foreach ( $professions as $profession) {
        $count = $count + 1;
        $coma = count($professions) == $count ? '' : ', ';
        $str .= $profession->description.''.$coma;
      }
      return $str;
    }

    public function parseShares($shares) {
      $str = '';
      $count = 0;
      foreach ( $shares as $share) {
        $count = $count + 1;
        $coma = count($shares) == $count ? '' : ', ';
        $str .= $share->share_number.''.$coma;
      }
      return $str;
    }

    public function getFamiliesPartnerByCard($card) {
      $cardNumber = $card;
      $person = $this->model->query()->select('id', 'isPartner', 'name', 'last_name')->where('rif_ci', $cardNumber)->orWhere('card_number', $cardNumber)->first();

      if($person) {
        if($person->isPartner == 1 || $person->isPartner == 2) {
          if($person && $person->isPartner == 2) {
            $partner = $this->personRelationRepository->findPartner($person->id);
            $partner = $this->model->query()->select('id', 'card_number')->where('id', $partner->base_id)->first();
            $cardNumber = $partner->card_number;
          }
          $person = $this->model->query()->select('id', 'name', 'last_name', 'card_number', 'picture')
          ->where('isPartner', 1)
          ->where('card_number', $cardNumber)->orWhere('rif_ci', $cardNumber)->with([
            'family' => function($query) {
              $query->with([
                'statusPerson',
                'relationship' => function($query){
                  $query->select('id', 'related_id', 'base_id', 'relation_type_id')->with('relationType');
                },
              ]);
            },
            'statusPerson'
            ])->first();
          if($person) {
            $shares = $this->shareRepository->getListByPartner($person->id);
            if (count($shares)) {
              $person['shares'] = $shares;
            } else {
              $person['shares'] = null;
            }
    
            $familyMembers = \DB::select("SELECT p.id, r.base_id, r.status, r.related_id   , p.name, p.last_name, p.rif_ci, p.picture, p.card_number, r.relation_type_id,  t.description as relation 
            FROM person_relations r, people p, relation_types t
            WHERE r.base_id=".$person->id."
            AND r.related_id=p.id 
            AND t.id=r.relation_type_id
            ORDER  BY t.item_order ASC");
    
            $partner = \DB::select("SELECT p.id, r.base_id, r.status, r.related_id   , p.name, p.last_name, p.rif_ci, p.picture, p.card_number, r.relation_type_id,  t.description as relation 
            FROM person_relations r, people p, relation_types t
            WHERE r.base_id=".$person->id."
            AND r.base_id=p.id 
            AND t.id=r.relation_type_id
            ORDER  BY t.item_order ASC");
            if($partner) {
              $partner  = $partner[0];
              unset($partner->relation);
              $partner->relation = 'Socio';
              array_unshift($familyMembers,$partner);
            }

            foreach ($familyMembers as $key => $value) {
              if($familyMembers[$key]->card_number === $card ) {
                $familyMembers[$key]->selectedFamily = true;
              } else {
                $familyMembers[$key]->selectedFamily = false;
              }
              $familyMembers[$key]->profilePicture = url('storage/partners/'.$value->picture);
            }
    
            $person['familyMembers'] = $familyMembers;
            $person['picture'] =  url('storage/partners/'.$person['picture']);
            // if($person->family()) {
            //   $familys = $person->family()->with([
            //     'statusPerson' => function($query) {
            //       $query->select('id', 'description');
            //     },
            //     'gender' => function($query) {
            //       $query->select('id', 'description');
            //     }])->get();
            //   foreach ( $familys as $key => $family) {
            //     $professions = $this->parseProfessions($family->professions()->get());
            //     $currentPerson = PersonRelation::query()->where('base_id', $person->id)->where('related_id', $family->id)->first();
            //     $relation = $this->relationTypeRepository->find($currentPerson->relation_type_id);
            //     $familys[$key]->relationType = $relation->description;
            //     $familys[$key]->id = $currentPerson->id;
            //     $familys[$key]->profilePicture = url('storage/partners/'.$family->picture);
            //     if($familys[$key]->card_number === $card ) {
            //       $familys[$key]->selectedFamily = true;
            //     } else {
            //       $familys[$key]->selectedFamily = false;
            //     }
            //   }
            //   $person['familyMembers'] = $familys;
            //   $person['picture'] =  url('storage/partners/'.$person['picture']);
            // }
            return $person;
          }
        }
        $status = Config::get('partners.ACCESS_CONTROL_STATUS.SOCIO_FAMILIAR_INCORRECTO');
        $attr = [
          'status' => - pow($status,1),
          'created' => Carbon::now(),
          'people_id' => $person->id,
        ];
        AccessControl::create($attr);
        return 0;
      }
      return 1;
  }

  public function getGuestByPartner($identification){
    $person = $this->model->query()
    ->select('id','name','last_name', 'picture', 'primary_email', 'telephone1', 'isPartner')->where('rif_ci', $identification)
    ->first();
    if($person) {
      if($person->isPartner == 3) {
        $person->picture = url('storage/partners/'.$person->picture);
        return $person;
      }
      if($person->isPartner !== 3) {
        $status = Config::get('partners.ACCESS_CONTROL_STATUS.INVITADO_INCORRECTO');
        $attr = [
          'status' => - pow($status,1),
          'created' => Carbon::now(),
          'people_id' => $person->id,
        ];
        AccessControl::create($attr);
        return 1;
      }

    }
    return $person;
  }

  public function getLockersByLocation($request) {
    $lockerLocation = $request['location'];
    if($request['location'] == 0) {
      $lockerLocation = \DB::table('person_lockers')
      ->select('lockers.id', 'lockers.description', 'lockers.locker_location_id')
      ->join('lockers', 'lockers.id', '=', 'person_lockers.locker_id')
      ->join('people', 'people.id', '=', 'person_lockers.people_id')
      ->where('people.id', $request['id'])
      ->first();
      $lockerLocation = $lockerLocation->locker_location_id;
    }

   $data = \DB::table('person_lockers')
    ->select('lockers.id', 'lockers.description', 'lockers.locker_location_id')
    ->join('lockers', 'lockers.id', '=', 'person_lockers.locker_id')
    ->join('people', 'people.id', '=', 'person_lockers.people_id')
    ->where('people.id', $request['id'])
    ->where('lockers.locker_location_id', $lockerLocation)
    ->get();
    return $data;
  }

  public function getLockersByPartner($id){
    return $this->model->where('id', $id)->with([
      'lockers' => function($query) {
        $query->with(['location'])->orderBy('locker_location_id', 'asc');
      }
      ])->first();
  }

  public function getCountPersons(){
    $count = $this->model->whereIn('isPartner', [1, 2, 3])->count();
    $months = $this->accessControlRepository->getAllMonths();
    return array('count' => $count, 'months' => $months);
  }

  public function getCountPersonByIsPartner($isPartner){
    $count = $this->model->where('isPartner', $isPartner)->count();
    $months = $this->accessControlRepository->getMonthsByIsPartner($isPartner);
    return array('count' => $count, 'months' => $months);
  }

  public function getCountBirthdays(){
    $birth =  $this->model->whereIn('isPartner', [1, 2])->whereMonth('birth_date',date('m'))->count();
    return array('count' => $birth ? $birth : 0);
  }

  public function getFamilyByPartner($id) {
      $data = $this->model->where('id', $id)->with(['family'])->first();
      $array = array();
      $partner = $this->model->where('id', $id)->with(['relationship'])->first();
      $families = $data->family()->with([
        'relationship' => function($q) {
          $q->with([
            'relationType' => function($q) {
              $q->select('id', 'description');
            }
            ]);
        }
        ])->get();
      array_push($array, $partner);
      foreach ($families as $key => $family) {
        array_push($array, $family);
      }
      return $array;
  }

    /**
     * get persons by query params
     * @param  object $queryFilter
    */
    public function searchCompanyPersonToAssign($queryFilter) {
      $search;
      if($queryFilter->query('term') === null) {
        $search = $this->model->query()->where('type_person', 2)->get();
      } else {
        $searchQuery = trim($queryFilter->query('term'));
        $requestData = ['name', 'last_name', 'rif_ci'];
        $search = $this->model->where(function($q) use($requestData, $searchQuery) {
                    foreach ($requestData as $field)
                      $q->orWhere($field, 'like', "%{$searchQuery}%");
                  })
                  ->where('id', '!=', $queryFilter->query('id'))
                  ->where('type_person', 2)
                  ->get();
        }
      return $search;
    }

        /**
     * get persons by query params
     * @param  object $queryFilter
    */
    public function searchPersonsByType($queryFilter) {
      $search;
      if($queryFilter->query('term') === null) {
        $search = $this->model->query()->where('type_person', $queryFilter->query('typePerson'))->get();
      } else {
        $searchQuery = trim($queryFilter->query('term'));
        $requestData = ['name', 'last_name', 'rif_ci'];
        $typePerson =  $queryFilter->query('typePerson') === "3" ? [1,2] : [(int)$queryFilter->query('typePerson')];
        $search = $this->model->where(function($q) use($requestData, $searchQuery) {
                    foreach ($requestData as $field)
                      $q->orWhere($field, 'like', "%{$searchQuery}%");
                  })->whereIn('type_person', $typePerson)->get();
        // $search = $this->model->where('type_person', $queryFilter->query('typePerson'))
        // ->where('name', 'like', $queryFilter->query('term').'%')
        // ->orWhere('last_name', 'like', $queryFilter->query('term').'%')
        // ->orWhere('rif_ci', 'like', $queryFilter->query('term').'%')
        // ->get();
      }
     return $search;
    }

    public function birthdayPersonsReport($queryFilter, $isPdf) {
     $persons = $this->model->query()
     ->whereIn('isPartner', [1, 2])
     ->whereMonth('birth_date',$queryFilter->query('month'))
     ->with([
       'shares', 
       'relationship' => function($query){
          $query->select('id', 'related_id', 'base_id', 'relation_type_id')->with('relationType');
        },
       ])
     ->orderBy('birth_date', 'asc')
     ->paginate($queryFilter->query('perPage'));
      foreach ($persons as $key => $value) {
        if($value->shares) {
          $persons[$key]->shareList = $this->parseShares($value->shares()->get());
        }
        if($value->relationship) {
          $relation = $value->relationship()->first();
          $persons[$key]->relation = $relation->relationType()->first()->description;     
        }
      }
      return $persons;
    }

    function getMonthName($monthNumber) {
      setlocale(LC_TIME, 'es_ES');
      $fecha = \DateTime::createFromFormat('!m', $monthNumber);
      return strftime("%B", $fecha->getTimestamp());
    }

    public function birthdayPersonsReportPDF($queryFilter) {

      $persons = $this->model->query()
      ->whereIn('isPartner', [1, 2])
      ->whereMonth('birth_date',$queryFilter->query('month'))
      ->with([
        'shares', 
        'relationship' => function($query){
           $query->select('id', 'related_id', 'base_id', 'relation_type_id')->with('relationType');
         },
        ])
      ->orderBy('birth_date', 'asc')
      ->get();
       foreach ($persons as $key => $value) {
         if($value->shares) {
           $persons[$key]->shareList = $this->parseShares($value->shares()->get());
         }
         if($value->relationship) {
           $relation = $value->relationship()->first();
           $persons[$key]->relation = $relation->relationType()->first()->description;     
         }
       }
       return (object) ['data' => $persons, 'month' => $this->getMonthName($queryFilter->query('month'))];
     }
  
}
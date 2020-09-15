<?php

namespace App\Services;

use App\Person;
use App\Repositories\ShareRepository;
use App\Repositories\ShareTypeRepository;
use App\Repositories\AccessControlRepository;
use App\Repositories\ParameterRepository;
use App\Repositories\RecordRepository;
use App\Services\SoapService;
use App\Helpers\AccessControlHelper;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Config;

class AccessControlService {

	public function __construct(
		AccessControlRepository $repository,
		Person $personModel,
		ShareRepository $shareRepository,
		ParameterRepository $parameterRepository,
		RecordRepository $recordRepository,
		SoapService $soapService,
		AccessControlHelper $accessControlHelper,
		ShareTypeRepository $shareTypeRepository
		) 
		{
		$this->repository = $repository;
		$this->personModel = $personModel;
		$this->shareRepository = $shareRepository;
		$this->parameterRepository = $parameterRepository;
		$this->recordRepository = $recordRepository;
		$this->soapService = $soapService;
		$this->accessControlHelper = $accessControlHelper;
		$this->shareTypeRepository = $shareTypeRepository;
	}

	public function index($perPage) {
		return $this->repository->all($perPage);
	}

	public function getList() {
		return $this->repository->getList();
	}

	public function filter($queryFilter, $isPDF = false) {
		return $this->repository->filter($queryFilter, $isPDF);
	}

	public function legacyAccesControlIngration($person, $type) {
		$person = $this->personModel->where('isPartner', $person)->first();
		if($person && $person->isPartner === $type) {
			return 1;
		}
		return 0;
	}

	public function checkPersonStatus($id) {
		$person = $this->personModel->where('id', $id)->with(['statusPerson'])->first();
		$status = $person->statusPerson()->first();
		return $person->statusPerson ? $status->description : '';
	}

	//Funcion para validar a el miembro familiar incluyendo el socio
	function validateMember($member, $shareId, $balance) {
		$status = 1; // se inicializa el status y luego cambia si entra en las condiciones de bloqueo
		$message = '';

		if($balance < 0) {
			$balanceStatus = Config::get('partners.ACCESS_CONTROL_STATUS.SOCIO_ACCION_SALDO_DEUDOR'); // Archivo config
			// $status = $this->accessControlHelper->getAccesControlStatus($balanceStatus,$status);
			$status = $status - $balanceStatus;
		}

		$records = $this->recordRepository->getBlockedRecord($member);
		if(count($records)) {
			foreach ($records as $key => $value) {
				$recordStatus = Config::get('partners.ACCESS_CONTROL_STATUS.SOCIO_BLOQUEO_EXPEDIENTE');
				// $status = $this->accessControlHelper->getAccesControlStatus($recordStatus,$status);
				$status = $status - $recordStatus;
				$message .= 'Bloqueo activo por expediente :'.$value->id.',  hasta la fecha  '.$value->expiration_date.'<br>';
			}
		}

		$share = $this->shareRepository->find($shareId);

		if($share && $share->shareType && $share->shareType()->first()->access == 0) {
			$shareStatus = Config::get('partners.ACCESS_CONTROL_STATUS.SOCIO_ACCION_INACTIVA');
			$status = $status - $shareStatus;
			$message .= '* La Accion no posee acceso <br>';
		}


		if($share && $share->permit == 1) {
			$shareStatus = Config::get('partners.ACCESS_CONTROL_STATUS.SOCIO_ACCION_INACTIVA');
			$status = $status - $shareStatus;
			$message .= '* La accion '.$share->share_number.' tiene un permiso activo y no puede ingresar <br>';
		}
		if($share->status === 0) {
			$shareStatus = Config::get('partners.ACCESS_CONTROL_STATUS.SOCIO_ACCION_INACTIVA');
			// $status = $this->accessControlHelper->getAccesControlStatus($shareStatus,$status);
			$status = $status - $shareStatus;
			$message .= '* Accion Inactiva <br>';
		}

		$personStatus = $this->checkPersonStatus($member);
		if($personStatus === "Inactivo"){
			$personStatus = Config::get('partners.ACCESS_CONTROL_STATUS.SOCIO_INACTIVO');
			// $status = $this->getAccesControlStatus($personStatus,$status);
			$status = $status - $personStatus;
			$message .= '* Socio Inactivo <br>';
		}
		if($message !== '') {
			$currentPerson = $this->personModel->query(['name', 'last_name', 'rif_ci', 'card_number'])->where('id', $member)->first();
			$name = '<strong>'.$currentPerson->name.' '.$currentPerson->last_name.'</strong> Carnet: '.$currentPerson->card_number;
			$message = '<br><div><div>'.$name.'</div><div>'.$message.'</div></div>';
		}
		// se retorna el mensaje de error y el estatus , estos valores son usados para el registro final de cada miembro
		return (object)[ 'message' => $message, 'status' => $status ];
	}

	public function validateGuest($request, $balance) {
		if($request['guest_id'] !== "") {
			$guestRequest = $request;
			$status = 1; // se inicializa el status y luego cambia si entra en las condiciones de bloqueo
			$message = '';
			
			if($balance < 0) {
				$balanceStatus = Config::get('partners.ACCESS_CONTROL_STATUS.SOCIO_ACCION_SALDO_DEUDOR');
				// $status = $this->accessControlHelper->getAccesControlStatus($balanceStatus,$status);
				$status = $status - $balanceStatus;
			}

			$personStatus = $this->checkPersonStatus($guestRequest['guest_id']);
			if($personStatus === "Inactivo"){
				$inactiveStatus = Config::get('partners.ACCESS_CONTROL_STATUS.INVITADO_INACTIVO');
				// $status = $this->accessControlHelper->getAccesControlStatus($inactiveStatus,$status);
				$status = $status - $inactiveStatus;
				$message .= '* Invitado Inactivo <br>';
			}

			$parameter = $this->parameterRepository->findByParameter('MAX_MONTH_VISITS_GUEST');
			$visits = $this->repository->getVisitsByMont($guestRequest['guest_id']);
			if(count($visits) >= $parameter->value) {
				$visitStatus = Config::get('partners.ACCESS_CONTROL_STATUS.INVITADO_VISITAS_POR_MES');
				// $status = $this->accessControlHelper->getAccesControlStatus($visitStatus,$status);
				$status = $status - $visitStatus;
				$message .= '* Excede cantidad Maxima de visitas por Mes permitida : '.$parameter->value.'<br>';
			}

			$guestRequest['people_id'] = $guestRequest['selectedPersonToAssignGuest'];
			$guestRequest['status'] = $status;
			// En el caso del invitado solo se hace un solo registro por esta razon no esta dentro del arreglo como los miembros familiares
			$this->repository->create($guestRequest);
			return $message;
		}
	}

	public function create($request) {
		//A-2104 esta accion es para hacer pruebas con el WS de produccion
		$share = $this->shareRepository->find($request['share_id']);
		$shareBalance = $this->soapService->getSaldo($share->share_number);
		$message = '';
		// $validatePartnerMessage = $this->validatePartner($request);
		// if($validatePartnerMessage !== '') {
		// 	$message.= '<strong>- Socio</strong>: <br>
		// 	'.$validatePartnerMessage.'
		// 	';
		// } else {
		// 	$this->legacyAccesControlIngration($request['people_id'], 1);
		// }


		//Registro de Invitado
		if($request['guest_id'] !== null) {
			$validateGuestMessage = $this->validateGuest($request, $shareBalance[0]->status);
			$currentGuestPerson = $this->personModel->query(['name', 'last_name', 'rif_ci'])->where('id',$request['guest_id'])->first();
			$nameGuestPerson = $currentGuestPerson->name.' '.$currentGuestPerson->last_name.' CI: '.$currentGuestPerson->rif_ci;
			if($validateGuestMessage !== '') {
			$message.= '<br><strong>- Invitado</strong>: '.$nameGuestPerson.' <br>
			'.$validateGuestMessage.'
			';
		} else {
			$this->legacyAccesControlIngration($request['guest_id'], 3);
		}
		}

		//Reguistro de familiares incluyendo el socio
		if(count($request['family'])) {
			$familyMessage = '';
			foreach ($request['family'] as $element) {
				if($request['selectedPersonToAssignGuest'] !== $element) {
					$validatePartnerMessage = $this->validateMember($element, $request['share_id'], $shareBalance[0]->status);
					$familyMessage .= $validatePartnerMessage->message;
					$request['people_id'] = $element;
					$request['status'] = $validatePartnerMessage->status;
					$request['guest_id'] = NULL;
					$this->repository->create($request);
				}
				
			}
			$message .= $familyMessage;
		}

		$balanceMessage = $shareBalance[0]->status < 0 ? '<div>* <strong>ATENCION:</strong> Accion N° '.$share->share_number.' presenta Saldo Deudor a la fecha</div><br>' : '';
		if($message !== '' || $balanceMessage !== "") {
			$generalMessage = $message !== '' ? '<div>Error de Ingreso para las siguientes personas:<div/> <div>'.$message.'</div>' : '';
			$body = '<div style="color: black">
			'.$balanceMessage.'
			'.$generalMessage.'
			</div>';
			return response()->json([
				'success' => false,
				'message' => $body,
			])->setStatusCode(400);
		}
		return response()->json([
			'success' => true,
			'message' => 'Access Created',
		])->setStatusCode(200);
	}

	public function update($request, $id) {
      return $this->repository->update($id, $request);
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
	 
	 public function getPartnersFamilyStatistics() {
		return $this->repository->getPartnersFamilyStatistics();
	}

	public function getGuestStatistics() {
		return $this->repository->getGuestStatistics();
	}

	public function getMonthlyIncomeStatistics() {
		return $this->repository->getMonthlyIncomeStatistics();
	}

	public function getPartnerAgeStatistics() {
		return $this->repository->getPartnerAgeStatistics();
	}

	public function getSonsMoreThan30Statistics() {
		return $this->repository->getSonsMoreThan30Statistics();
	}
}
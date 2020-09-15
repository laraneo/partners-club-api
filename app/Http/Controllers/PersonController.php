<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Maatwebsite\Excel\Facades\Excel;

use App\Services\PersonService;
use App\Exports\GeneralReportExport;

class PersonController extends Controller
{
    public function __construct(PersonService $service)
	{
		$this->service = $service;
    }
    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $persons = $this->service->index($request->query('perPage'));
        return response()->json([
            'success' => true,
            'data' => $persons
        ]);
    }

        /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getAllGuest(Request $request)
    {
        $persons = $this->service->getAllGuest($request->query('perPage'));
        return response()->json([
            'success' => true,
            'data' => $persons
        ]);
    }

        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function report()
    {
        $persons = $this->service->reportAll();
        return $persons;
        $data = [
            'data' => $persons
        ];
        $pdf = PDF::loadView('reports/expiration_cards', $data);
        return $pdf->download('archivo.pdf');
    }


        /**
     * PDF Report.
     *
     * @return \Illuminate\Http\Response
     */
    public function partnerReport()
    {
        $persons = $this->service->reportAll();
        $data = [
            'data' => $persons
        ];
        
        $pdf = PDF::loadView('reports/partner', $data);
        return $pdf->download('archivo.pdf');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $personRequest = $request->all();
        $person = $this->service->create($personRequest);
        return $person;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $person = $this->service->read($id);
        if($person) {
            return response()->json([
                'success' => true,
                'data' => $person
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $personRequest = $request->all();
        $person = $this->service->update($personRequest, $id);
        if($person) {
            return response()->json([
                'success' => true,
                'data' => $person
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $person = $this->service->delete($id);
        if($person) {
            return response()->json([
                'success' => true,
                'data' => $person
            ]);
        }
    }

    /**
     * Get the specified resource by search.
     *
     * @param  string $term
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request) {
        $person = $this->service->search($request);
        if($person) {
            return response()->json([
                'success' => true,
                'data' => $person
            ]);
        }
    }

        /**
     * Get the specified resource by search.
     *
     * @param  string $term
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function searchByGuest(Request $request) {
        $person = $this->service->searchByGuest($request);
        if($person) {
            return response()->json([
                'success' => true,
                'data' => $person
            ]);
        }
    }

            /**
     * Get the specified resource by search.
     *
     * @param  string $term
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function searchCompanyPersonToAssign(Request $request) {
        $person = $this->service->searchCompanyPersonToAssign($request);
        if($person) {
            return response()->json([
                'success' => true,
                'data' => $person
            ]);
        }
    }

                /**
     * Get the specified resource by search.
     *
     * @param  string $term
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function searchPersonsByType(Request $request) {
        $person = $this->service->searchPersonsByType($request);
        if($person) {
            return response()->json([
                'success' => true,
                'data' => $person
            ]);
        }
    }

    /**
     * Get the specified resource by search.
     *
     * @param  string $term
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request) {
        $person = $this->service->filter($request);
        if($person) {
            return response()->json([
                'success' => true,
                'data' => $person
            ]);
        }
    }

    /**
     * Get the specified resource by search.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filterReport(Request $request) {
        $partner = $this->service->filter($request, true);
        $data = [
            'data' => $partner
        ];

        if($request['type'] == 'pdf') {
            $pdf = PDF::loadView('reports/persons', $data);
            return $pdf->download('general.pdf');
        }

        if($request['type'] == 'csv') {
            return Excel::download(new GeneralReportExport($data), 'list.csv');
        }
        
    }


    /**
     * Get the specified resource by search.
     *
     * @param  string $term
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function searchPersonsToAssign(Request $request) {
        $person = $this->service->searchPersonsToAssign($request);
        if($person) {
            return response()->json([
                'success' => true,
                'data' => $person
            ]);
        }
    }

    /**
     * create relation type.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function assignPerson(Request $request)
    {
        $personRequest = $request->all();
        $person = $this->service->assignPerson($personRequest);
        return $person;
    }

    /**
     * Get the specified family by person
     *
     * @param  string $term
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function searchFamilyByPerson(Request $request) {
        $person = $this->service->searchFamilyByPerson($request);
            return response()->json([
                'success' => true,
                'data' => $person
            ]);
    }

        /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getReportByPartner(Request $request)
    {
        $requestBody = $request->all();
        $partner = $this->service->getReportByPartner($requestBody['id']);
        $data = [
            'data' => $partner
        ];
        
        $pdf = PDF::loadView('reports/partner', $data);
        return $pdf->download('archivo.pdf');
    }

            /**
     * Get the specified resource by search.
     *
     * @param  string $term
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function searchToAssign(Request $request) {
        $data = $this->service->searchToAssign($request);
        if($data) {
            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        }
    }


    /**
     * Get the specified partner by card.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getFamiliesPartnerByCard(Request $request) {
        $data = $this->service->getFamiliesPartnerByCard($request['card']);
        if($data === 0) {
            return response()->json([
                'success' => false,
                'message' => 'Persona no es un Socio/Familiar'
            ])->setStatusCode(400);
        }
        if($data === 1) {
            return response()->json([
                'success' => false,
                'message' => "La Cedula/Carnet {$request['card']} no existe"
            ])->setStatusCode(400);
        }
        if($data) {
            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        }
        
    }

    /**
     * Get the specified guest by identification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getGuestByPartner(Request $request) {
        $data = $this->service->getGuestByPartner($request['identification']);
        if($data === 1) {
            return response()->json([
                'success' => false,
                'message' => 'La cedula no pertenece a un invitado, intente con otra'
            ])->setStatusCode(400);
        }
        if($data) {
            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        }
    }

    /**
     * Get the specified family by person
     *
     * @param  string $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getLockersByLocation(Request $request) {
        $person = $this->service->getLockersByLocation($request);
        if($person) {
            return response()->json([
                'success' => true,
                'data' => $person
            ]);
        }
    }

        /**
     * Get the specified family by person
     *
     * @param  string $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getLockersByPartner(Request $request) {
        $data = $this->service->getLockersByPartner($request['id']);
        if($data) {
            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        }
    }

    /**
     * Get count persons by isPartner column value
     *
     * @param  string $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getCountPersonByIsPartner(Request $request) {
        $data = $this->service->getCountPersonByIsPartner($request['isPartner']);
        if($data) {
            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        }
    }

    /**
     * Get the count persons
     *
     * @param  string $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getCountPersons() {
        $data = $this->service->getCountPersons();
        if($data) {
            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        }
    }

        /**
     * Get persons exception statistics
     *
     * @param  string $id
     * @return \Illuminate\Http\Response
     */
    public function getExceptionStatistics() {
        $data = $this->service->getExceptionStatistics();
        if($data) {
            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        }
    }

            /**
     * Get count birthdays
     *
     * @param  string $id
     * @return \Illuminate\Http\Response
     */
    public function getCountBirthdays() {
        $data = $this->service->getCountBirthdays();
        if($data) {
            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        }
    }

        /**
     * Get the specified partner by card.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getFamilyByPartner(Request $request) {
        $share = auth()->user()->username;
        $data = $this->service->getFamilyByPartner($share);
            return response()->json([
                'success' => true,
                'data' => $data
            ]);
    }

            /**
     * Get the specified partner by card.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getInverseRelationById(Request $request) {
        $data = $this->service->getInverseRelationById($request['id']);
            return response()->json([
                'success' => true,
                'data' => $data
            ]);
    }

        /**
     * Get the specified resource by search.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function birthdayPersons(Request $request) {
       return $this->service->birthdayPersonsReport($request,false);
    }

    /**
     * Get the specified resource by search.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function birthdayPersonsReport(Request $request) {
         $data = $this->service->birthdayPersonsReportPDF($request);
         $data = [
             'data' => $data->data,
             'month' => $data->month,
         ];
         $pdf = PDF::loadView('reports/birthdayPersonsReport', $data);
         return $pdf->download('birthdayPersonsReport.pdf');
     }
 

}

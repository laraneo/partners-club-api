<?php

namespace App\Services;

use App\Repositories\RecordRepository;
use Illuminate\Http\Request;

use Storage;
use Carbon\Carbon;

class RecordService {

	public function __construct(RecordRepository $repository) {
		$this->repository = $repository ;
	}

	public function index($perPage) {
		return $this->repository->all($perPage);
	}

	public function getList() {
		return $this->repository->getList();
	}

	public function validateFile($file) {

		$fileToParse = preg_replace('/^data:application\/\w+;base64,/', '', $file);
		$ext = explode(';', $file)[0];
		$ext = explode('/', $ext)[1];

		$find = 'data:application/vnd.openxmlformats-officedocument.wordprocessingml.document;base64,';
		$pos = strpos($file, $find);
		if($pos !== false) {
			$fileToParse = str_replace('data:application/vnd.openxmlformats-officedocument.wordprocessingml.document;base64,', '', $file);
			$ext = 'docx';
		}
		$base64File = base64_decode($fileToParse);
		
		return (object)['ext' => $ext, 'content' => $base64File];
	}

	public function updateFile($id, $exp, $column) {
		$date = Carbon::now();
		$parseFile = $this->validateFile($exp);
		$filename = $id.'-'.$column.'-'.$date->year.'.'.$parseFile->ext;
		$indice = rand(1,10);
		$filename = str_pad($id,10,"0",STR_PAD_LEFT).'-'.$column.'-'.str_pad($indice,2,"0",STR_PAD_LEFT).".".$parseFile->ext;


		Storage::disk('records')->put($filename,$parseFile->content);
		$attr = [ 'file'.$column => $filename];
		$this->repository->update($id, $attr);
	}
	
	public function create($request) {
		
		if ($this->repository->checkRecord($request['description'])) {
            return response()->json([
                'success' => false,
                'message' => 'El registro ya existe'
            ])->setStatusCode(400);
		}		
		// $file = url('records/test9.docx');'
		$request['user_id'] = auth()->user()->id;
		$request['userupdate_id'] = auth()->user()->id;
		$data = $this->repository->create($request);

		if($request['exp1'] !== null) $this->updateFile($data->id, $request['exp1'], '1');
		if($request['exp2'] !== null) $this->updateFile($data->id, $request['exp2'], '2');
		if($request['exp3'] !== null) $this->updateFile($data->id, $request['exp3'], '3');
		if($request['exp4'] !== null) $this->updateFile($data->id, $request['exp4'], '4');
		if($request['exp5'] !== null) $this->updateFile($data->id, $request['exp5'], '5');
		return $data;
	}

	public function update($request, $id) {
      $request['userupdate_id'] = auth()->user()->id;
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
	 
	/**
	 *  Search resource from repository
	 * @param  object $queryFilter
	*/
	public function getByPerson($queryFilter) {
		return $this->repository->getByPerson($queryFilter);
	 }
	 
	 	/**
	 *  Search resource from repository
	 * @param  object $queryFilter
	*/
	public function getRecordsStatistics() {
		return $this->repository->getRecordsStatistics();
 	}
}
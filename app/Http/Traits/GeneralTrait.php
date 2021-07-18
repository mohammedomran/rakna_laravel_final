<?php

namespace App\Http\Traits;

trait GeneralTrait {

	public function returnErrorMsg($msg) {
		return response()->json([
			"status"=> false,	
			"code"=> 400,
			"message"=> $msg
		]);
	}

	public function returnSuccess($msg) {
		return response()->json([
			"status"=> true,	
			"code"=> 200,
			"message"=> $msg
		]);
	}

	public function returnData($msg, $key, $value) {
		return response()->json([
			"status"=> true,	
			"code"=> 200,
			"message"=> $msg,
			$key=> $value
		]);
	}

}
<?php

namespace App\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Controllers\Controller;
use App\Models\Local;

class LocalController extends Controller {
	public function create(Request $request, Response $response)
	{
		$local = new Local;
		$local->address = $request->getParam('address');
		$local->save();
		return $response->withJson($local, 201);
	}

	public function all(Request $request, Response $response)
	{
		$locals = Local::all();
		return $response->withJson($locals, 201);
	}
}
<?php

namespace App\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Controllers\Controller;
use App\Models\Provider;

class ProviderController extends Controller {

	public function create(Request $request, Response $response)
	{
		$provider = new Provider;
		$provider->name = ucwords(strtolower($request->getParam('name')));
		$provider->save();
		return $response->withJson($provider, 201);
	}

	public function all(Request $request, Response $response)
	{
		$providers = Provider::all();
		return $response->withJson($providers, 201);
	}

	public function update(Request $request, Response $response)
	{
		$provider = null;
		try {
			$provider = Provider::findOrFail($request->getParam('id'));
		} catch (ModelNotFoundException $e) {
			return $response->withJson(["message" => "Proveedor no encontrado"], 404);
		}
		$provider->name = ($request->getParam('name') != null) ? ucwords(strtolower($request->getParam('name'))) : $provider->name;
		$provider->save();
		return $response->withJson(["message" => "Se actualizó el registro"], 200);
	}

	public function delete(Request $request, Response $response)
	{
		$provider = null;
		try {
			$provider = Provider::findOrFail($request->getParam('id'));
		} catch (ModelNotFoundException $e) {
			return $response->withJson(["message" => "Proveedor no encontrado"], 404);
		}
		$provider->delete();
		return $response->withJson(["message" => "Se eliminó el registro"], 200);
	}
}
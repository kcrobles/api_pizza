<?php

namespace App\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Controllers\Controller;
use App\Models\Item;
use App\Models\Provider;

class ItemController extends Controller {

	public function show(Request $request, Response $response)
	{
		$id = $request->getAttribute('id');
		$item = null;
		try {
			$item = Item::findOrFail($id)->with('provider')->get();
		} catch (ModelNotFoundException $e) {
			$data = ["message" => "Producto no encontrado."];
			return $response->withJson($data, 404);
		}
		return $response->withJson($item, 200);
	}

	public function all(Request $request, Response $response)
	{
		$items = Item::with('provider')->get();
		if(count($items) < 1)
		{
			return $response->withJson([
				"status" => "error",
				"message" => "No hay productos registrados"
			], 404);
		}
		return $response->withJson($items, 200);
	}

	public function delete(Request $request, Response $response)
	{
		$id = $request->getAttribute('id');
		$item = null;
		try {
			$item = Item::findOrFail($id);
		} catch (ModelNotFoundException $e) {
			$data = [
			"message" => "Producto no encontrado"
			];
			return $response->withJson($data, 404);
		}
		$item->delete();
		$data = [
			"status" => "success",
			"message" => "El producto ha sido eliminado"
		];
		return $response->withJson($data, 200);
	}

	public function create(Request $request, Response $response)
	{
		/* description, price, provider_id */
		if ($request->getAttribute('has_errors')) {
			$errors = $request->getAttribute('errors');
			return $response->withJson(["message" => $errors], 400);
  		}
  		$item = new Item;
  		$item->description = ucwords(strtolower($request->getParam('description')));
  		$item->price = $request->getParam('price');
  		try {
			$provider = Provider::findOrFail($request->getParam('provider_id'));
			$item->provider_id = $request->getParam('provider_id');
		} catch (ModelNotFoundException $e) {
			$data = [
			"message" => "Proveedor no encontrado"
			];
			return $response->withJson($data, 404);
		}
		$item->save();	
		return $response->withJson($item, 200);
  	}

  	public function update(Request $request, Response $response)
  	{
  		/* description, price, provider_id */
		if ($request->getAttribute('has_errors')) {
			$errors = $request->getAttribute('errors');
			return $response->withJson(["message" => $errors], 400);
  		}
  		$id = $request->getAttribute('id');
		$item = null;
		try {
			$item = Item::findOrFail($id);
		} catch (ModelNotFoundException $e) {
			$data = ["message" => "Producto no encontrado."];
			return $response->withJson($data, 404);
		}
		try {
			$provider = Provider::findOrFail($request->getParam('provider_id'));
			if ($request->getParam('provider_id') !== $item->provider_id) {
				$item->provider_id = $request->getParam('provider_id');
			}		
		} catch (ModelNotFoundException $e) {
			$data = [
			"message" => "Proveedor no encontrado"
			];
			return $response->withJson($data, 404);
		}
		$item->description = ucwords(strtolower($request->getParam('description')));
  		$item->price = $request->getParam('price');
		$item->save();	
		return $response->withJson($item, 200);
  	}
}


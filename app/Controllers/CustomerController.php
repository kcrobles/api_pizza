<?php

namespace App\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Controllers\Controller;
use App\Models\Customer;

class CustomerController extends Controller {

	public function show(Request $request, Response $response)
	{
		$id = $request->getAttribute('id');
		$customer = null;
		try {
			$customer = Customer::findOrFail($id);
		} catch (ModelNotFoundException $e) {
			$data = ["message" => "Cliente no encontrado."];
			return $response->withJson($data, 404);
		}
		return $response->withJson($customer, 200);
	}

	public function all(Request $request, Response $response)
	{
		$customers = Customer::all();
		if(count($customers) < 1)
		{
			return $response->withJson([
				"status" => "error",
				"message" => "No hay clientes registrados"
			], 404);
		}
		return $response->withJson($customers, 200);
	}

	public function delete(Request $request, Response $response)
	{
		$id = $request->getAttribute('id');
		$customer = null;
		try {
			$customer = Customer::findOrFail($id);
		} catch (ModelNotFoundException $e) {
			$data = [
			"message" => "Cliente no encontrado"
			];
			return $response->withJson($data, 404);
		}
		$customer->delete();
		$data = [
			"status" => "success",
			"message" => "El cliente ha sido eliminado"
		];
		return $response->withJson($data, 200);
	}

	public function create(Request $request, Response $response)
	{
		/* name, email, password, address, phone */
		if ($request->getAttribute('has_errors')) {
			$errors = $request->getAttribute('errors');
			return $response->withJson(["message" => $errors], 400);
  		}
		$customer = new Customer;
		$customer->name = ucwords(strtolower($request->getParam('name')));
		$customer->email = strtolower($request->getParam('email'));
		$customer->password = password_hash($request->getParam('password'), PASSWORD_DEFAULT);
		$customer->address = ucwords(strtolower($request->getParam('address')));
		$customer->phone = $request->getParam('phone');
		$customer->save();
		return $response->withJson($customer, 201);
	}

	public function update(Request $request, Response $response)
	{
		/* fistname, lastname, email, password, dni, sexo, role_id, local_id */
		if ($request->getAttribute('has_errors')) {
			$errors = $request->getAttribute('errors');
			return $response->withJson(["message" => $errors], 400);
  		}
		$id = $request->getAttribute('id');
		$customer = null;
		try {
			$customer = Customer::findOrFail($id);
		} catch (ModelNotFoundException $e) {
			$data = [
				"message" => "Cliente no encontrado"
			];
			return $response->withJson($data, 404);
		}
		$email = $request->getParam('email');

		if (strcasecmp($customer->email, $email) !== 0 && $email !== null && Customer::where('email', $email)->count() < 1) {

			$customer->email = $email;
			$customer->name = ($request->getParam('name') !== null) ? ucwords(strtolower($request->getParam('name'))) : $customer->lastName;
			$customer->password = ($request->getParam('password') !== null) ? password_hash($request->getParam('password'), PASSWORD_DEFAULT) : $customer->password;
			$customer->address = ($request->getParam('address') !== null) ? strtolower($request->getParam('address')) : $customer->address;
			$customer->phone = ($request->getParam('phone') !== null) ? $request->getParam('phone') : $customer->phone;
			$customer->save();
			return $response->withJson($user, 200);
		}	

		return $response->withJson([
			"status" => "error",
			"message" => ["email" => "El email ya se encuentra registrado"]
		], 400);
	}
}
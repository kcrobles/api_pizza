<?php

namespace App\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Controllers\Controller;
use App\Models\User;
use App\Models\Customer;
use App\Models\Item;
use App\Models\Invoice;

class InvoiceController Extends Controller {
	/* Prop: user_id, customer_id */
	/* Details: invoice_id, item_id, quantity */

	public function show(Request $request, Response $response)
	{
		$id = $request->getAttribute('id');
		$invoice = null;
		try {
			$invoice = Invoice::findOrFail($id)->with('items')->get();
		} catch (ModelNotFoundException $e) {
			$data = ["message" => "Registro de venta no encontrado."];
			return $response->withJson($data, 404);
		}
		return $response->withJson($invoice, 200);
	}

	public function all(Request $request, Response $response)
	{
		$invoices = Invoice::with('items')->get();
		if(count($invoices) < 1)
		{
			return $response->withJson([
				"status" => "error",
				"message" => "No hay registros de ventas"
			], 404);
		}
		return $response->withJson($invoices, 200);
	}

	public function delete(Request $request, Response $response)
	{
		$id = $request->getAttribute('id');
		$invoice = null;
		try {
			$invoice = Invoice::findOrFail($id);
		} catch (ModelNotFoundException $e) {
			$data = [
			"message" => "Registro de venta no encontrado"
			];
			return $response->withJson($data, 404);
		}
		$invoice->delete();
		$data = [
			"status" => "success",
			"message" => "El registro de venta ha sido eliminado"
		];
		return $response->withJson($data, 200);
	}

	public function create(Request $request, Response $response)
	{
		/* Prop: user_id, customer_id */
		/* Details: invoice_id, item_id, quantity */
		if ($request->getAttribute('has_errors')) {
			$errors = $request->getAttribute('errors');
			return $response->withJson(["message" => $errors], 400);
  		}
  		//var_dump($request->getParam('user_id'));
  		//die();
  		$invoice = new Invoice;//Buscamos el usuario q registra la venta
		try {
			$user = User::findOrFail($request->getParam('user_id'));
			$invoice->user_id = $request->getParam('user_id');
		} catch (ModelNotFoundException $e) {
			$data = [
			"message" => "Usuario no encontrado"
			];
			return $response->withJson($data, 404);
		}
		//Cliente q hace el pedido
		try {
			$customer = Customer::findOrFail($request->getParam('customer_id'));
			$invoice->customer_id = $request->getParam('customer_id');
		} catch (ModelNotFoundException $e) {
			$data = [
			"message" => "Cliente no encontrado o registrado"
			];
			return $response->withJson($data, 404);
		}
		//dsps de agregar atributos del invoice (empleado_id, cliente_id)
		$invoice->save();
		$items = $request->getParam('items'); //array de items en el pedido

		$invoice->items()->attach([ 3 => ['quantity' => 1], 7 => ['quantity' => 1] ]);
		
		// $invoice = Invoice::find($invoice->id)->with('items')->get();
		return $response->withJson($invoice, 201);
	}

	public function update(Request $request, Response $response)
	{
		/* Prop: user_id, customer_id */
		/* Details: invoice_id, item_id, quantity */
		$id = $request->getAttribute('id');
		$invoice = null;
		try {
			$invoice = Invoice::findOrFail($id)->with('items')->get();
		} catch (ModelNotFoundException $e) {
			$data = ["message" => "Registro de venta no encontrado."];
			return $response->withJson($data, 404);
		}
		try {
			$customer = Customer::findOrFail($request->getParam('customer_id'));
			$item->customer_id = $request->getParam('customer_id');
		} catch (ModelNotFoundException $e) {
			$data = [
			"message" => "Cliente no encontrado o registrado"
			];
			return $response->withJson($data, 404);
		}
		$invoice->items->delete();
		$invoice->items()->sync($request->getParam('items'));
		$invoice->save();
		return $response->withJson($invoice, 200);
	}
}

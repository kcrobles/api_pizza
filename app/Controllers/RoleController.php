<?php

namespace App\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Controllers\Controller;
use App\Models\Role;

class RoleController extends Controller {

	public function create(Request $request, Response $response)
	{
		$role = new Role;
		$role->role_name = ucwords(strtolower($request->getParam('role_name')));
		$role->save();
		return $response->withJson($role, 201);
	}

	public function all(Request $request, Response $response)
	{
		$roles = Role::all();
		return $response->withJson($roles, 201);
	}

	public function update(Request $request, Response $response)
	{
		$role = null;
		try {
			$role = Role::findOrFail($request->getParam('id'));
		} catch (ModelNotFoundException $e) {
			return $response->withJson(["message" => "Rol no encontrado"], 404);
		}
		$role->role_name = ($request->getParam('role_name') != null) ? ucwords(strtolower($request->getParam('role_name'))) : $role->role_name;
		$role->save();
		return $response->withJson(["message" => "Se actualizó el registro"], 200);
	}

	public function delete(Request $request, Response $response)
	{
		$role = null;
		try {
			$role = Role::findOrFail($request->getParam('id'));
		} catch (ModelNotFoundException $e) {
			return $response->withJson(["message" => "Rol no encontrado"], 404);
		}
		$role->delete();
		return $response->withJson(["message" => "Se eliminó el registro"], 200);
	}
}
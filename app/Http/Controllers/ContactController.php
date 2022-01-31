<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Http\Requests\ContactRequest;
use App\Services\ContactService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ContactController extends Controller
{

    public function index()
    {
        //
    }

    public function store(ContactRequest $request): JsonResponse
    {
        $parameters = $request->validated();

        $response = ContactService::store($parameters['contacts'], $parameters['columns']);
        return response()->json($response, $response['success'] ? 200 : 400);
    }

    public function getRecords(): JsonResponse
    {
        return response()->json(Contact::with('customAttributes')->simplePaginate('10'));
    }
}

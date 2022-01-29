<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    
    public function index()
    {
        //
    }
    
    public function store(ContactRequest $request)
    {
        $parameters = $request->validated();

        $contacts = [];

        foreach ($parameters['contacts'] as $keyContact => $contact) {

            $columnsNames = [];

            foreach ($parameters['columns'] as $keyColumn => $column) {
                $columnsNames[] = $column['column-'.($keyColumn + 1)];
            }

            foreach ($columnsNames as $keyColumnName => $columnName) {
                $contacts[$keyContact][$columnName] = $contact[$keyColumnName];
            }
        }

        $contact = Contact::create($contacts);

        return response()->json([
            'success' => true
        ]);
    }
    
}

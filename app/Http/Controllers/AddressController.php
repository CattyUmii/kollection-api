<?php

namespace App\Http\Controllers;

use App\Http\Resources\AddressCollection;
use App\Http\Resources\AddressResource;
use App\Models\Address;
use Illuminate\Http\JsonResponse;

class AddressController extends Controller {

    public function index(): JsonResponse {

        $addresses = Address::with(["user", "postal"])->get();
        return response()->json(new AddressCollection($addresses));
    }

    public function show($id): JsonResponse {

        $address = new AddressResource(Address::with(["user", "postal"])->findOrFail($id));
        return response()->json($address);
    }
}

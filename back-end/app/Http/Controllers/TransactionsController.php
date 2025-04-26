<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidateOriginTransactionsRequest;
use App\Services\Transactions\TransactionsService;

class TransactionsController
{
    public function notification(ValidateOriginTransactionsRequest $request)
    {
        $validatedData = $request->validated();
        $service = new TransactionsService;
        $service->receiving($validatedData);
        return response()->json([
            'success' => true,
        ], 200);
    }
}

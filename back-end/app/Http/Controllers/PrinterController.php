<?php

namespace App\Http\Controllers;

use App\Models\Printers;
use App\Models\Suppliers\UserSupplier;
use App\Utils\Utils;
use Illuminate\Http\Request;

class PrinterController
{
    public function get(Request $request)
    {
        $user     = $request->user();
        $supplier = UserSupplier::where('user_id', $user->id)->first()->supplier;
        $printer  = Printers::where('supplier_id', $supplier->id)->first();
        return response()->json(['data' => $printer], 200);
    }
    
    public function configPrinter(Request $request)
    {
        $user          = $request->user();
        $validatedData = $request->validate([
            'ip'                => 'required|string',
            'name'              => 'required|string',
            'system_driverinfo' => 'required|string',
        ]);

        $supplier                     = UserSupplier::where('user_id', $user->id)->first()->supplier;
        $validatedData['supplier_id'] = $supplier->id;
        $validatedData['id']          = Utils::uuid();

        Printers::updateOrCreate([
            'supplier_id' => $validatedData['supplier_id'],
        ], $validatedData);

        return response()->json(['message' => 'Impressora configurada com sucesso!'], 201);
    }
}

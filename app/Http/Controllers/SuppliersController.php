<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWorkingHoursRequest;
use App\Models\Suppliers\SupplierConfig;
use App\Models\Suppliers\Suppliers;
use App\Models\Suppliers\UserSupplier;
use App\Models\Suppliers\WorkingHours;
use App\Models\User\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SuppliersController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'contact_name' => 'nullable|string|max:255',
            'email' => 'required|email|unique:suppliers,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:255',
            'user' => 'required|array',
            'user.email' => 'required|string|email|max:255',
            'user.name' => 'required|string|max:255',
            'user.password' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $validatedData = $validator->validated();
        $supplier = Suppliers::create($validatedData);

        $supplier->token = $this->createAdmin($validatedData['user'], $supplier->id);
        return response()->json($supplier, 201);
    }

    public function createAdmin($data, $supplier_id)
    {
        $user = new User($data);
        $user->save();
        $user->assignRole('admin');

        $userSupplier = new UserSupplier();
        $userSupplier->user_id = $user->id;
        $userSupplier->supplier_id = $supplier_id;
        $userSupplier->save();

        return $user->createToken('user')->plainTextToken;
    }

    public function createConfig(StoreWorkingHoursRequest $request)
    {
        DB::beginTransaction();
        try {
            $validatedData = $request->validated();
            $userConfig = new SupplierConfig($validatedData);
            $userConfig->save();

            foreach ($validatedData['working_hours'] as $day) {
                $opening_time = new DateTime($day['opening_time']);
                $formatted_opening_time = $opening_time->format('H:i:s');

                $closing_time = new DateTime($day['closing_time']);
                $formatted_closing_time = $closing_time->format('H:i:s');

                WorkingHours::updateOrCreate(
                    ['day_of_week' => $day['day_of_week'], 'supplier_id' => $validatedData['supplier_id']],
                    [
                        'opening_time' => $formatted_opening_time,
                        'closing_time' => $formatted_closing_time,
                        'is_closed' => $day['is_closed'],
                    ]
                );
            }
            DB::commit();
            return response()->json(['message' => 'Configuração criada com sucesso!'], 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['success' => false,
                'error' => $th->getMessage(),
            ], 500);
        }
    }
}

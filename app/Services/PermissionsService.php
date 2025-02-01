<?php

namespace App\Services;

use App\Models\Suppliers\UserSupplier;

class PermissionsService
{
    public static function UserAssociatedWithSupplier($user, $supplierId)
    {
        if (!$user) {
            return false;
        }

        $isUserAssociatedWithSupplier = UserSupplier::where('user_id', $user->id)
            ->where('supplier_id', $supplierId)
            ->exists();

        return $isUserAssociatedWithSupplier;
    }

    
}
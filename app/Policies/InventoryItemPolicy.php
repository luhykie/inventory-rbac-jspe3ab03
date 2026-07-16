<?php

namespace App\Policies;

use App\Models\InventoryItem;
use App\Models\User;

class InventoryItemPolicy
{
    
    public function viewAny(User $user): bool
    {
        return true;
    }

    
    public function view(User $user, InventoryItem $inventoryItem): bool
    {
        return $user->hasPermission('can_view');
    }

    
    public function create(User $user): bool
    {
        return $user->hasPermission('can_create');
    }

   
    public function update(User $user, InventoryItem $inventoryItem): bool
    {
        return $user->hasPermission('can_update');
    }

    
    public function delete(User $user, InventoryItem $inventoryItem): bool
    {
        return $user->hasPermission('can_remove');
    }
}
<?php

namespace App\Policies;

use App\Models\Satker;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SatkerPolicy
{
    use HandlesAuthorization;

    // View
    public function view(User $user, Satker $satker)
    {
        if ($user->isSuperAdmin() || $user->isManager()) return true;
        if ($user->isItwil()) return $user->wilayah_id === $satker->wilayah_id;
        if ($user->isSatker()) return $user->satker_id === $satker->id;
        return false;
    }

    // Create
    public function create(User $user)
    {
        if ($user->isSuperAdmin()) return true;
        if ($user->isManager()) return false; // Read only
        if ($user->isItwil() || $user->isSatker()) return true; // Bisa tambah isu
        return false;
    }

    // Update
    public function update(User $user, Satker $satker)
    {
        if ($user->isSuperAdmin()) return true;
        if ($user->isManager()) return false; // Read only
        if ($user->isItwil()) return $user->wilayah_id === $satker->wilayah_id; // CRUD wilayah terkait
        if ($user->isSatker()) return $user->satker_id === $satker->id; // CRU satker terkait
        return false;
    }

    // Delete
    public function delete(User $user, Satker $satker)
    {
        if ($user->isSuperAdmin()) return true;
        if ($user->isManager()) return false;
        if ($user->isItwil()) return $user->wilayah_id === $satker->wilayah_id;
        if ($user->isSatker()) return false; // Satker hanya CRU (Tidak boleh delete)
        return false;
    }
}
<?php

namespace App\Policies;

use App\Models\Template;
use App\Models\User;

class TemplatePolicy
{
    private function isAdmin(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, Template $template): bool
    {
        return $this->isAdmin($user) || $user->id === $template->user_id;
    }

    public function update(User $user, Template $template): bool
    {
        return $this->isAdmin($user) || $user->id === $template->user_id;
    }

    public function delete(User $user, Template $template): bool
    {
        return $this->isAdmin($user) || $user->id === $template->user_id;
    }
}

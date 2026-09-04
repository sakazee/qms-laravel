<?php
namespace App\Policies;
use App\Models\Partner;
use App\Models\User;
class PartnerPolicy {
    public function view(User $user, Partner $partner): bool { return $user->id === $partner->user_id; }
    public function update(User $user, Partner $partner): bool { return $user->id === $partner->user_id; }
    public function delete(User $user, Partner $partner): bool { return $user->id === $partner->user_id; }
}

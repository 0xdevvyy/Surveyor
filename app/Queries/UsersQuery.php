<?php

declare(strict_types=1);

namespace App\Queries;

use App\Enum\RoleEnum;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class UsersQuery
{
    /**
     * @return Builder<User>
     */
    public function queryForAdmin(
        ?RoleEnum $role = null,
        ?string $search = null,
    ): Builder {
        return User::query()
            ->select([
                'id',
                'name',
                'email',
                'role',
                // 'avatar_path',
                'email_verified_at',
                'created_at',
            ])
            ->with([
                'personalInformation:id,user_id',
                'households:id,user_id,household_number,barangay_id',
                'households.barangay:id,name',
            ])
            ->withExists('personalInformation')
            ->where('role', '!=', RoleEnum::ADMIN->value)
            ->when(
                $role !== null,
                fn (Builder $query) => $query->where('role', $role->value),
            )
            ->when(
                $search !== null,
                fn (Builder $query) => $query->where(
                    function (Builder $query) use ($search): void {
                        $query
                            ->where('name', 'like', "%{$search}%")
                            ->orWhereHas(
                                'households',
                                fn (Builder $households) => $households
                                    ->where(
                                        'household_number',
                                        'like',
                                        "%{$search}%",
                                    )
                                    ->orWhereHas(
                                        'barangay',
                                        fn (Builder $barangay) => $barangay
                                            ->where(
                                                'name',
                                                'like',
                                                "%{$search}%",
                                            ),
                                    ),
                            );
                    },
                ),
            );
    }
}

<?php

namespace App\Shop\Schools\Repositories\Interfaces;

use Jsdecena\Baserepo\BaseRepositoryInterface;
use App\Shop\Schools\School;
use Illuminate\Support\Collection;

interface SchoolRepositoryInterface extends BaseRepositoryInterface
{
    public function listSchools(string $order = 'id', string $sort = 'desc'): Collection;

    public function createSchool(array $params) : School;

    public function findSchoolById(int $id) : School;

    public function updateSchool(array $params): bool;

    public function syncRoles(array $roleIds);

    public function listRoles() : Collection;

    public function hasRole(string $roleName) : bool;

    public function isAuthUser(School $employee): bool;

    public function deleteSchool() : bool;
}

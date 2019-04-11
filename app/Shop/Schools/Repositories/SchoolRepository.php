<?php

namespace App\Shop\Schools\Repositories;

use Jsdecena\Baserepo\BaseRepository;
use App\Shop\Schools\School;
use App\Shop\Schools\Exceptions\SchoolNotFoundException;
use App\Shop\Schools\Repositories\Interfaces\SchoolRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SchoolRepository extends BaseRepository implements SchoolRepositoryInterface
{
    /**
     * SchoolRepository constructor.
     *
     * @param School $employee
     */
    public function __construct(School $employee)
    {
        parent::__construct($employee);
        $this->model = $employee;
    }

    /**
     * List all the employees
     *
     * @param string $order
     * @param string $sort
     *
     * @return Collection
     */
    public function listSchools(string $order = 'id', string $sort = 'desc'): Collection
    {
        return $this->all(['*'], $order, $sort);
    }

    /**
     * Create the employee
     *
     * @param array $data
     *
     * @return School
     */
    public function createSchool(array $data): School
    {
        $data['password'] = Hash::make($data['password']);
        return $this->create($data);
    }

    /**
     * Find the employee by id
     *
     * @param int $id
     *
     * @return School
     */
    public function findSchoolById(int $id): School
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new SchoolNotFoundException;
        }
    }

    /**
     * Update employee
     *
     * @param array $params
     *
     * @return bool
     */
    public function updateSchool(array $params): bool
    {
        if (isset($params['password'])) {
            $params['password'] = Hash::make($params['password']);
        }

        return $this->update($params);
    }

    /**
     * @param array $roleIds
     */
    public function syncRoles(array $roleIds)
    {
        $this->model->roles()->sync($roleIds);
    }

    /**
     * @return Collection
     */
    public function listRoles(): Collection
    {
        return $this->model->roles()->get();
    }

    /**
     * @param string $roleName
     *
     * @return bool
     */
    public function hasRole(string $roleName): bool
    {
        return $this->model->hasRole($roleName);
    }

    /**
     * @param School $employee
     *
     * @return bool
     */
    public function isAuthUser(School $employee): bool
    {
        $isAuthUser = false;
        if (Auth::guard('employee')->user()->id == $employee->id) {
            $isAuthUser = true;
        }
        return $isAuthUser;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function deleteSchool() : bool
    {
        return $this->delete();
    }
}

<?php

namespace App\Shop\Students\Repositories\Interfaces;

use Jsdecena\Baserepo\BaseRepositoryInterface;
use App\Shop\Students\Student;
use Illuminate\Support\Collection;

interface StudentRepositoryInterface extends BaseRepositoryInterface
{
    public function listStudents(string $order = 'id', string $sort = 'desc'): Collection;
    
    public function listStudentsByProfessor(string $order = 'id', int $professor_id = null): Collection;

    public function createStudent(array $params) : Student;
    
    public function createStudentByProfessor(array $params, int $school_id = null, int $professor_id = null): Student;

    public function findStudentById(int $id) : Student;

    public function updateStudent(array $params): bool;

    public function syncRoles(array $roleIds);

    public function listRoles() : Collection;

    public function hasRole(string $roleName) : bool;

    public function isAuthUser(Student $employee): bool;

    public function deleteStudent() : bool;
}

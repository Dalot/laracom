<?php

namespace App\Shop\Students\Repositories;

use Jsdecena\Baserepo\BaseRepository;
use App\Shop\Students\Student;
use App\Shop\Professors\Professor;
use App\Shop\Students\Exceptions\StudentNotFoundException;
use App\Shop\Students\Repositories\Interfaces\StudentRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StudentRepository extends BaseRepository implements StudentRepositoryInterface
{
    /**
     * StudentRepository constructor.
     *
     * @param Student $student
     */
    public function __construct(Student $student)
    {
        parent::__construct($student);
        $this->model = $student;
    }

    /**
     * List all the students
     *
     * @param string $order
     * @param string $sort
     *
     * @return Collection
     */
    public function listStudents(string $order = 'id', string $sort = 'desc'): Collection
    {
        
        return $this->all(['*'], $order, $sort);
    }
    
    /**
     * List all the students by single Professor
     *
     * @param string $order
     * @param string $sort
     *
     * @return Collection
     */
    public function listStudentsByProfessor(string $order = 'id', int $professor_id = null) : Collection
    {
        return Professor::find($professor_id)->students->sortByDesc($order);
    }

    /**
     * Create the student
     *
     * @param array $data
     *
     * @return Student
     */
    public function createStudent(array $data): Student
    {
         try {
            return $this->create($data);
        } catch (QueryException $e) {
            throw new CreateStudentErrorException($e);
        }
    }
    
    /**
     * Create the student by a Professor
     *
     * @param array $data
     *
     * @return Student
     */
     public function createStudentByProfessor(array $params, int $school_id = null, int $professor_id = null): Student
     {
         $params['school_id'] = (string) $school_id;
         try {
            
            return Professor::find($professor_id)->students()->create($params);
        } catch (QueryException $e) {
            throw new CreateStudentErrorException($e);
        }
     }

    /**
     * Find the student by id
     *
     * @param int $id
     *
     * @return Student
     */
    public function findStudentById(int $id): Student
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new StudentNotFoundException;
        }
    }

    /**
     * Update student
     *
     * @param array $params
     *
     * @return bool
     */
    public function updateStudent(array $params): bool
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
     * @param Student $student
     *
     * @return bool
     */
    public function isAuthUser(Student $student): bool
    {
        $isAuthUser = false;
        if (Auth::guard('student')->user()->id == $student->id) {
            $isAuthUser = true;
        }
        return $isAuthUser;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function deleteStudent() : bool
    {
        return $this->delete();
    }
}

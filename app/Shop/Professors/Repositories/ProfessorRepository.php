<?php

namespace App\Shop\Professors\Repositories;

use App\Shop\Addresses\Address;
use Jsdecena\Baserepo\BaseRepository;
use App\Shop\Professors\Professor;
use App\Shop\Professors\Exceptions\CreateProfessorInvalidArgumentException;
use App\Shop\Professors\Exceptions\ProfessorNotFoundException;
use App\Shop\Professors\Exceptions\ProfessorPaymentChargingErrorException;
use App\Shop\Professors\Exceptions\UpdateProfessorInvalidArgumentException;
use App\Shop\Professors\Repositories\Interfaces\ProfessorRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection as Support;

class ProfessorRepository extends BaseRepository implements ProfessorRepositoryInterface
{
    /**
     * ProfessorRepository constructor.
     * @param Professor $professor
     */
    public function __construct(Professor $professor)
    {
        parent::__construct($professor);
        $this->model = $professor;
    }

    /**
     * List all the employees
     *
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return \Illuminate\Support\Collection
     */
    public function listProfessors(string $order = 'id', string $sort = 'desc', array $columns = ['*']) : Support
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * Create the professor
     *
     * @param array $params
     * @return Professor
     * @throws CreateProfessorInvalidArgumentException
     */
    public function createProfessor(array $params) : Professor
    {
        try {
            $data = collect($params)->except('password')->all();

            $professor = new Professor($data);
            if (isset($params['password'])) {
                $professor->password = bcrypt($params['password']);
            }

            $professor->save();

            return $professor;
        } catch (QueryException $e) {
            throw new CreateProfessorInvalidArgumentException($e->getMessage(), 500, $e);
        }
    }

    /**
     * Update the professor
     *
     * @param array $params
     *
     * @return bool
     * @throws UpdateProfessorInvalidArgumentException
     */
    public function updateProfessor(array $params) : bool
    {
        try {
            return $this->model->update($params);
        } catch (QueryException $e) {
            throw new UpdateProfessorInvalidArgumentException($e);
        }
    }

    /**
     * Find the professor or fail
     *
     * @param int $id
     *
     * @return Professor
     * @throws ProfessorNotFoundException
     */
    public function findProfessorById(int $id) : Professor
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new ProfessorNotFoundException($e);
        }
    }

    /**
     * Delete a professor
     *
     * @return bool
     * @throws \Exception
     */
    public function deleteProfessor() : bool
    {
        return $this->delete();
    }

    /**
     * @param Address $address
     * @return Address
     */
    public function attachAddress(Address $address) : Address
    {
        $this->model->addresses()->save($address);
        return $address;
    }

    /**
     * Find the address attached to the professor
     *
     * @return mixed
     */
    public function findAddresses() : Support
    {
        return $this->model->addresses;
    }

    /**
     * @param array $columns
     * @param string $orderBy
     *
     * @return Collection
     */
    public function findOrders($columns = ['*'], string $orderBy = 'id') : Collection
    {
        return $this->model->orders()->get($columns)->sortByDesc($orderBy);
    }

    /**
     * @param string $text
     * @return mixed
     */
    public function searchProfessor(string $text = null) : Collection
    {
        if (is_null($text)) {
            return $this->all();
        }
        return $this->model->searchProfessor($text)->get();
    }

    /**
     * @param int $amount
     * @param array $options
     * @return \Stripe\Charge
     * @throws ProfessorPaymentChargingErrorException
     */
    public function charge(int $amount, array $options)
    {
        try {
            return $this->model->charge($amount * 100, $options);
        } catch (\Exception $e) {
            throw new ProfessorPaymentChargingErrorException($e);
        }
    }
}

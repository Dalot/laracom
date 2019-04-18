<?php

namespace App\Shop\Professors\Repositories\Interfaces;

use App\Shop\Addresses\Address;
use Jsdecena\Baserepo\BaseRepositoryInterface;
use App\Shop\Professors\Professor;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as Support;

interface ProfessorRepositoryInterface extends BaseRepositoryInterface
{
    public function listProfessors(string $order = 'id', string $sort = 'desc', array $columns = ['*']) : Support;

    public function createProfessor(array $params) : Professor;

    public function updateProfessor(array $params) : bool;

    public function findProfessorById(int $id) : Professor;

    public function deleteProfessor() : bool;

    public function attachAddress(Address $address) : Address;

    public function findAddresses() : Support;

    public function findOrders() : Collection;

    public function searchProfessor(string $text) : Collection;

    public function charge(int $amount, array $options);
}

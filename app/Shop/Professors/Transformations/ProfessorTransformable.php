<?php

namespace App\Shop\Professors\Transformations;

use App\Shop\Professors\Professor;

trait ProfessorTransformable
{
    protected function transformProfessor(Professor $professor)
    {
        $prop = new Professor;
        $prop->id = (int) $professor->id;
        $prop->name = $professor->name;
        $prop->email = $professor->email;
        $prop->status = (int) $professor->status;

        return $prop;
    }
}

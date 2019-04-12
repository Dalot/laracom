<?php

namespace App\Shop\Schools\Transformations;

use App\Shop\Schools\School;

trait SchoolTransformable
{
    protected function transformSchool(School $school)
    {
        $prop = new School;
        $prop->id = (int) $school->id;
        $prop->name = $school->name;
        $prop->email = $school->email;
        $prop->status = (int) $school->status;

        return $prop;
    }
}

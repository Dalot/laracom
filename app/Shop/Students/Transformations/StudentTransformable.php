<?php

namespace App\Shop\Students\Transformations;

use App\Shop\Students\Student;

trait StudentTransformable
{
    protected function transformStudent(Student $student)
    {
        $prop = new Student;
        $prop->id = (int) $student->id;
        $prop->name = $student->name;
        $prop->email = $student->email;
        $prop->status = (int) $student->status;

        return $prop;
    }
}

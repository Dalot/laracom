<?php

namespace App\Shop\Students\Transformations;

use App\Shop\Students\Student;

trait StudentProfessorTransformable
{
    protected function transformStudentProfessor(Student $student)
    {
        $prop = new Student;
        $prop->id = (int) $student->id;
        $prop->name = $student->name;
        $prop->email = $student->email;
        $prop->status = (int) $student->status;
        $prop->professor = $prop->professor->first();
        return $prop;
    }
}

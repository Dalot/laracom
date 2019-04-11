<?php

namespace App\Shop\Schools\Exceptions;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SchoolNotFoundException extends NotFoundHttpException
{

    /**
     * SchoolNotFoundException constructor.
     */
    public function __construct()
    {
        parent::__construct('School not found.');
    }
}

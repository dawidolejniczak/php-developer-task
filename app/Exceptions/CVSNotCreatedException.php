<?php
/**
 * Created by PhpStorm.
 * User: dawid
 * Date: 20/03/2019
 * Time: 14:47
 */

namespace App\Exceptions;


class CVSNotCreatedException extends \Exception
{
    /**
     * ModelDoesNotExistException constructor.
     */
    public function __construct()
    {
        parent::__construct("Couldn't export a CSV file", 400);
    }
}
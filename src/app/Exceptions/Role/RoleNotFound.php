<?php

namespace App\Exceptions\Role;



use Illuminate\Http\Response;

class RoleNotFound extends RoleException
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.role.not-found'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}

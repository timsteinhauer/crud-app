<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as ContractsLoginResponse;

class LoginResponse implements ContractsLoginResponse
{
    public function toResponse($request): \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response
    {
        // here i am checking if the currently logout in users has a role_id of 2 which make him a regular user and then redirect to the users dashboard else the admin dashboard
        if (auth()->user()->is_operator) {
            return redirect()->intended(config('fortify.admin.home'));
        }
        return redirect()->intended(config('fortify.home'));
    }
}

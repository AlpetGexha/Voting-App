<?php

namespace App\Traits;

trait WithAuthRedirects
{
    public function redirectToLogin()
    {
        return $this->redirectTo('login');
    }

    public function redirectToRegister()
    {
        return $this->redirectTo('register');
    }

    public function redirectTo($routeName)
    {
        redirect()->setIntendedUrl(url()->previous());

        return to_route($routeName);
    }
}

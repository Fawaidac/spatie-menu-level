<?php

use App\Support\SessionUser;

if (! function_exists('session_user')) {
    function session_user(): ?SessionUser
    {
        return SessionUser::current();
    }
}


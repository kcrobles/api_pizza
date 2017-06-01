<?php

namespace App\Authentication;

use App\Models\User;

class Auth
{
    public function attempt($email, $password, $staff = false)
    {
        $subject = false;        
        if (!$staff) {
            $subject = User::where('email', $email)->first();
        } else {
            $subject = Customer::where('email', $email)->first();
        }

        if(!$subject)
        {            
            return false;
        }

        if(password_verify($password, $subject->password))
        {
            return $subject;
        }

        return false;
    }
}

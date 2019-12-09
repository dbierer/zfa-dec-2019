<?php
namespace Login\Security;

use Zend\Crypt\Password\Bcrypt;

class Password
{
	//*** PASSWORD LAB: return a Bcrypt hash
    public static function createHash($plainText)
    {
        //*** place your code here
    }
	//*** PASSWORD LAB: verify a password against a hash
    public static function verify($plainText, $hash)
    {
        //*** place your code here
    }
}

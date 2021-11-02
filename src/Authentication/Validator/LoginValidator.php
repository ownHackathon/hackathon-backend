<?php declare(strict_types=1);

namespace Authentication\Validator;

use App\Validator\Input\PasswordInput;
use App\Validator\Input\UsernameInput;
use Laminas\InputFilter\InputFilter;

class LoginValidator extends InputFilter
{
    public function __construct(
        private UsernameInput $usernameInput,
        private PasswordInput $passwordInput,
    ) {
        $this->add($this->usernameInput);
        $this->add($this->passwordInput);
    }
}

<?php

interface IValidate {

    public function validate($email);
}

class IsValidEmail implements IValidate {

    public function validate($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

}

class IsValidDomain implements IValidate {

    public function validate($email) {
        $domain = substr($email, strpos($email, '@') + 1);
        return checkdnsrr($domain);
    }

}

class IsMailExist implements IValidate {

    public function validate($email) {
          include_once 'class.verifyEmail.php';
         $vmail = new verifyEmail();
        return $vmail->check($email);

    }

}

class NoRepeatedCharacters implements IValidate {

    public function validate($email) {
        $validator = new notIncludeRegex('/(.)\1{2,}/');
        return $validator->validate($email);
    }

}

class NotIncludeRegex implements IValidate {

    protected $regex;

    public function __construct($regex) {
        $this->regex = $regex;
    }

    public function validate($email) {
        if (is_array($this->regex)) {
            foreach ($this->regex as $reg) {
                if (preg_match("/$reg/", $email)) {
                    return FALSE;
                }
            }
            return TRUE;
        }
        return !preg_match($this->regex, $email);
    }

}

class NotEqualTo implements IValidate {

    protected $regex;

    public function __construct($valeu) {
        $this->valeu = $valeu;
    }

    public function validate($email) {
        if (is_array($this->valeu)) {
            foreach ($this->valeu as $item) {
                if ($item == $email) {
                    return FALSE;
                }
            }
            return TRUE;
        }
        return $email != $this->valeu;
    }

}

class NotContainDomain implements IValidate {

    protected $valeu;

    public function __construct($valeu) {
        $this->valeu = $valeu;
    }

    public function validate($email) {
        $domain = substr($email, strpos($email, '@') + 1);
        if (is_array($this->valeu)) {
            foreach ($this->valeu as $item) {
                if ($item == $domain) {
                    return FALSE;
                }
            }
            return TRUE;
        }
        return $domain != $this->valeu;
    }

}

//The Validator below accepts multiple Validators, which will allow you to create a Filter Chain.

class EmailValidator implements IValidate {

    protected $_validators;

    public function addValidator(IValidate $validator) {
        $this->_validators[] = $validator;
        return $this;
    }

    public function validate($value) {
        foreach ($this->_validators as $validator) {
            if ($validator->validate($value) === FALSE) {
                return FALSE;
            }
        }
        return TRUE;
    }

}

?>
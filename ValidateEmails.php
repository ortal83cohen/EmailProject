<?php
include('classes/EmailValidator.php');
include('classes/ForbiddenLists.php');

$forbiddenLists = ForbiddenLists::getInstance();
$validator = new EmailValidator;
$validator->addValidator(new IsValidEmail)
        ->addValidator(new IsValidDomain)
        ->addValidator(new NoRepeatedCharacters)
        ->addValidator(new NotIncludeRegex(array("ortc", "ortt")))
        ->addValidator(new NotIncludeRegex($forbiddenLists->getCharacters()))
        ->addValidator(new NotEqualTo("ortal83cohen@gmail.c"))
        ->addValidator(new NotEqualTo($forbiddenLists->getEmails()))
        ->addValidator(new NotContainDomain($forbiddenLists->getDomains()))
        ->addValidator(new IsMailExist());

$mailsList = array();
$flieName = $argv[1];
$handle = fopen(__DIR__ . "/" . $flieName, "r");

if ($handle) {
    while (($email = fgets($handle)) !== false) {
        $email = trim($email);
        if (!$validator->validate($email)) {
            echo "$email - not valid \n";
        } else {
            $mailsList[] = $email;
        }
    }
} else {
    echo "Error opening the file.";
}

echo "\nValid mails list:\n";
print_r($mailsList);

?>
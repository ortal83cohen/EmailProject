<?php

class ForbiddenLists {

    private static $instance;
    private $domains = array();
    private $emails = array();
    private $characters = array();

    private function __construct() { //This is example for data layer ,now it's from file, but it easy to change it and get this data from DB-PDO/cache
        $this->domains = $this->getListFromFile("forbiddenDomains.txt");
        $this->emails = $this->getListFromFile("forbiddenEmails.txt");
        $this->characters = $this->getListFromFile("forbiddenCharacters.txt");
    }

    public static function getInstance() {

        if (!(self::$instance instanceof self)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getDomains() {

        return $this->domains;
    }

    public function getEmails() {
        return $this->emails;
    }

    public function getCharacters() {
        return $this->characters;
    }

    private function getListFromFile($flieName) {
        $handle = fopen(__DIR__ . "/../" . $flieName, "r");
        $itemsList = array();
        if ($handle) {
            while (($item = fgets($handle)) !== false) {
                $itemsList[] = trim($item);
            }
        } else {
            echo "error opening the file $flieName.";
        }
        return $itemsList;
    }

}

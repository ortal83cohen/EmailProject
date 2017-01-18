THE CODE PURPOSE
The goal of the code is to analyze a text file containing a list of emails (Each line consists of one address) and to define if the email is “valid” or “invalid”, by the list of following definitions:
- The email is a valid regex ( XXX@XXX.XXX)
- The email did not arrive from a list of domain that is defined locally (In the code or an outer source) and can be easily be updated
- The email address does not contain words from a list of predefined words locally (In the code or an outer source) and can be easily be updated
- The email address has no space, unfitting characters etc.
- The email address does not have a sequence of 3 or more repeating characters (for example “fff”)
- The email address does not have a sequence of repeating characters that is predefined.
- *Check the email address really exists.


to run with command line:
php ortalEmailProject\ValidateEmails.php emailsList.txt

Comments:
Edit the file emailList.txt, write in it the list of emails you would like to check, email per line.
For the list of invalid emails please edit the files (1 Item per line):
forbiddenDomains.txt
forbiddenEmails.txt
forbiddenCharacters.txt
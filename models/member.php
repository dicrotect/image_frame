
<?php
    class member {
        
        private $plural_resource = '';
        public function __construct($plural_resource){
          $this->plural_resource = $plural_resource;
        }

        public function find_login_id($email,$password){
            $sql = sprintf('SELECT * FROM %s WHERE email="%s" AND password="%s"',
                $this->plural_resource,
                $email,
                sha1($password)
            );
            return $sql;
        }
        public function create($member,$file){
          $sql = sprintf(
              'INSERT INTO members SET name="%s", email="%s", password="%s", image="%s",created=NOW()',
              $member["name"],
              $member["email"],
              sha1($member["password"]),
              $file
          );
          return $sql;
        }
    }
?>


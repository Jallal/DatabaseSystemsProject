<?php

/**
 * Manage users in our system.
 */
class Users extends Table {

    /**
     * Constructor
     * @param $site Site object
     */
    public function __construct(Site $site) {
        parent::__construct($site, "User");
    }

    /**
     * Test for a valid login.
     * @param $user User id or email
     * @param $password Password credential
     * @returns User object if successful, null otherwise.
     */
    public function login($user, $password) {
        $sql =<<<SQL
SELECT * from $this->tableName
where userid=? or email=?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($user, $user));
        if($statement->rowCount() === 0) {
            return null;
        }

        $row = $statement->fetch(PDO::FETCH_ASSOC);

        // Get the encrypted password and salt from the record
        $hash = $row['password'];
        $salt = $row['salt'];

        // Ensure it is correct
        if($hash !== hash("sha256", $password . $salt)) {
            return null;
        }

        return new User($row);
    }

    /**
     * Get a user based on the id
     * @param $id int ID of the user
     * @returns User object if successful, null otherwise.
     */
    public function get($id) {
        $sql =<<<SQL
SELECT * from $this->tableName
where id=?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($id));
        if($statement->rowCount() === 0) {
            return null;
        }

        return new User($statement->fetch(PDO::FETCH_ASSOC));
    }

    /**
     * Determine if a user exists in the system.
     * @param $user user ID or a email address.
     * @returns true if $user is an existing user ID or email address
     */
    public function exists($user) {
        $sql =<<<SQL
SELECT * from $this->tableName
where userid=? or email=?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($user, $user));
        if($statement->rowCount() === 0) {
            return false;
        }

        return true;
    }

    /**
     * Create a new user.
     * @param $userid string user ID
     * @param $name string user name
     * @param $email string user email address
     * @param $password1 string new password
     * @param $password2 string new password second copy
     * @param $city string city where user is from
     * @param $state string state initials where the user is from
     * @param $privacy string privacy setting for the user
     * @param $birthyear string year of birth for the user
     * @returns string Error message or null if no error
     */
    public function newUser($userid, $name, $email, $password1, $password2, $city, $state, $privacy, $birthyear)
    {
        // Ensure the passwords are valid and equal
        if (strlen($password1) < 8) {
            return "Passwords must be at least 8 characters long";
        }

        if ($password1 !== $password2) {
            return "Passwords are not equal";
        }

        // Ensure we have no duplicate user ID or email address
        $users = new Users($this->site);
        if ($users->exists($userid)) {
            return "User ID already exists. Please choose another one.";
        }

        if ($users->exists($email)) {
            return "Email address already exists.";
        }

        // Check if user entered state initials
        if (strlen($state) > 2 || strlen($state) < 2) {
            return "Enter the state initials.";
        }

        // Check for valid Birth Year
        if ((intval($birthyear) < 1900 || intval($birthyear) > 3000) || !is_numeric($birthyear)) {
            return "Enter a valid birth year.";
        }

        // Create salt and encrypted password
        $salt = self::random_salt();
        $hash = hash("sha256", $password1 . $salt);

        // Add a record to the User table
        $sql = <<<SQL
INSERT INTO $this->tableName(userid, name, email, password, city, state, privacy, birthyear, salt)
values(?, ?, ?, ?, ?, ?, ?, ?, ?)
SQL;

        $statement = $this->pdo()->prepare($sql);
        $statement->execute(array($userid, $name, $email, $hash, $city, $state, $privacy, $birthyear, $salt));
    }

    /**
     * @brief Generate a random salt string of characters for password salting
     * @param $len int Length to generate, default is 16
     * @returns string Salt string
     */
    public static function random_salt($len = 16) {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789`~!@#$%^&*()-=_+';
        $l = strlen($chars) - 1;
        $str = '';
        for ($i = 0; $i < $len; ++$i) {
            $str .= $chars[rand(0, $l)];
        }
        return $str;
    }
}
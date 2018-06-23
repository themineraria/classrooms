<?php
// Users class example
class Users {
    public static function add($pseudo, $password, $mail = NULL, $bestMonster = NULL) {
        $db = Db::getInstance();
        // User existence verification
        $req = $db->prepare('SELECT u_pseudo FROM users WHERE u_pseudo=:u_pseudo');
        $req->execute(array('u_pseudo' => $pseudo));
        if($req->rowCount() != 0) {
            // This user already exist
            return false;
        }

        // Hachage du mot de passe
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $req = $db->prepare('INSERT INTO users (u_pseudo, u_hash, u_mail) VALUES (:u_pseudo, :u_hash, :u_mail)');
        $ret = $req->execute(array('u_pseudo' => $pseudo,
                                    'u_hash' => $hash,
                                    'u_mail' => $mail));
        return !$ret ? false : $db->lastInsertId();
    }
    public static function getByName($pseudo) {
        $db = Db::getInstance();
        $req = $db->prepare('SELECT * FROM users WHERE u_pseudo=:u_pseudo');
        $ret = $req->execute(array('u_pseudo' => $pseudo));
        return !$ret ? false : $req->fetch();
    }
}
?>

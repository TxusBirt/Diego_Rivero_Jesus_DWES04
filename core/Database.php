<?php
ini_set('display_errors', 'On');

class Database {
    private $config = [];
    public static function connect() {
        $db= new PDO('mysql:host=localhost;dbname=taud04;charset=utf8','root','');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $equipo = $db->query("SELECT * FROM equipo");
        $equipo = $equipo->fetchAll(PDO::FETCH_ASSOC);
        return $equipo;

    }
        

    public static function loadConfig() {
        $json_file = file_get_contents('./db_config.json');
        $config = json_decode($json_file, true);
        $db_host = $config['host'];
        $db_user = $config['user'];
        $db_pass = $config['password'];
        $db_bd = $config['db_name'];

        
    }
}

echo Database::loadConfig();
echo '<pre>' . var_dump(Database::connect()) . '</pre>';
?>

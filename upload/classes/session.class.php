<?php
defined('_VALID') or die('Restricted Access!');

class Session
{
    private static $_sess_db;

    public static function open() {
        global $config;    
    
        if (self::$_sess_db = mysql_connect($config['db_host'], $config['db_user'], $config['db_pass'])) {
            return mysql_select_db($config['db_name'], self::$_sess_db);
        }
        
        return false;
    }

    public static function close() {
        return mysql_close(self::$_sess_db);
    }

    public static function read($session_id) {
        $sql = sprintf("SELECT `session_data` FROM `sessions` WHERE `session_id` = '%s'", mysql_real_escape_string($session_id));
        if ($result = mysql_query($sql, self::$_sess_db)) {
            if (mysql_num_rows($result)) {
                $record = mysql_fetch_assoc($result);
                return $record['session_data'];
            }
        }

        return '';
    }

    public static function write($session_id, $session_data)
    {
	    $sql = sprintf("REPLACE INTO `sessions` VALUES('%s', '%s', '%s')", mysql_real_escape_string($session_id),
						mysql_real_escape_string(time()), mysql_real_escape_string($session_data) );
		
        return mysql_query($sql, self::$_sess_db);
	}

    public static function destroy( $session_id )
    {
	    $sql = sprintf("DELETE FROM `sessions` WHERE `session` = '%s'", $session_id);
		return mysql_query($sql, self::$_sess_db);
	}
    
    public static function gc($max) {
	    $sql = sprintf("DELETE FROM `sessions` WHERE `session_expires` < '%s'", mysql_real_escape_string(time() - $max));
		return mysql_query($sql, self::$_sess_db);
	}
}
?>

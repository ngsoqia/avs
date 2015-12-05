<?php
defined('_VALID') or die('Restricted Access!');

class VValidation
{
    public function username( $username )
    {
        if ( !preg_match('/^[a-zA-Z0-9_]*$/', $username) ) {
            return false;
        } elseif ( preg_match('/^[_]*$/', $username) ) {
            return false;
        }
        
        $users_blocked = array('edit', 'prefs', 'blocks', 'delete', 'avatar');
        if ( in_array($username, $users_blocked) ) {
            return false;
        }
        
        return true;
    }
    
    public function usernameExists( $username )
    {
        global $conn;
        
        $sql    = "SELECT UID FROM signup WHERE username = '" .mysql_real_escape_string($username). "' LIMIT 1";
        $conn->execute($sql);
        
        return $conn->Affected_Rows();
    }
    
    public function email( $email )
    {
        if ( !ereg('^[^@]{1,64}@[^@]{1,255}$', $email) ) {
            return false;
        }
        
        $email_array = explode('@', $email); 
        $local_array = explode('.', $email_array['0']);
        for ( $i = 0; $i < sizeof($local_array); $i++ ) { 
            if ( !ereg("^(([A-Za-z0-9!#$%&#038;'*+/=?^_`{|}~-][A-Za-z0-9!#$%&#038;'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$", $local_array[$i]) ) {
                return false;
            }
        }
        
        if ( !ereg("^\[?[0-9\.]+\]?$", $email_array['1']) ) {
            $domain_array = explode('.', $email_array['1']);
            if (sizeof($domain_array) < 2) {
                return false;
            }
            
            for ( $i = 0; $i < sizeof($domain_array); $i++ ) {
                if ( !ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$", $domain_array[$i]) ) {
                    return false;
                }
            }
        }
        
        return true;
    }
    
    public function emailExists( $email, $uid=NULL )
    {
        global $conn;
        
        
        $sql_add    = ( isset($uid) ) ? " AND UID != " .intval($uid) : NULL;
        $sql        = "SELECT UID FROM signup WHERE email = '" .mysql_real_escape_string($email). "'" .$sql_add. " LIMIT 1";
        $conn->execute($sql);

        return $conn->Affected_Rows();
    }
    
    public function date( $month, $day, $year )
    {        
        return checkdate($month, $day, $year);
    }
    
    public function age( $month, $day, $year, $years )
    {        
        $age        = mktime(0, 0, 0, $month, $day, $year);
        $real_age   = mktime(0, 0, 0, date('m'), date('d'), (date('Y')-$years));
        if ( $age <= $real_age ) {
            return true;
        }
        
        return false;
    }
    
    public function zip( $code, $country='US' ) {
        if ( !ctype_digit($code) ) {
            return false;
        }
        
        $length = VString::strlen($code);
        switch ( $country ) {
            case 'UK':
            case 'CA':
                if ( $length <> 6 ) {
                    return true;
                }
            default:
                if ( $length >= 5 && $lenght <= 9 ) {
                    return true;
                }
        }
        
        return false;
    }
    
    public function ip( $ip )
    {
        if ( !ip2long($ip) ) {
            return false;
        }
    }
}
?>

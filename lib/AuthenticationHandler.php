<?php
function do_authenticate()
{
    ob_start();
    $is_curl = true;
    $cookie_val = "";
    if (isset($_COOKIE['isin']))
    {
        $cookie_val = $_COOKIE['isin'];
    }
    elseif(isset($_REQUEST["is_curl"]))
    {
        $is_curl = true;
    }

    if (!isset($_SERVER['PHP_AUTH_USER']) || ($cookie_val != "1" && !$is_curl)) {
        header('WWW-Authenticate: Basic realm="Super Secret Place"');
        header('HTTP/1.0 401 Unauthorized');
        setcookie ("isin", "1");
        die('<a href="http://www.jabberwocky.com/carroll/walrus.html">...keep it secret, keep it safe</a>');
    } 
    else {
        if($_SERVER['PHP_AUTH_USER'] == "USER" &&  $_SERVER['PHP_AUTH_PW']== "PASSWORD") {
            //we're golden
        }
        else {
            setcookie ("isin", "", time() - 3600);
            $url=$_SERVER['PHP_SELF'];
            header("location: $url");
        }

        if (isset($_GET['action']))
        {
            if($_GET['action'] == "logout") {
                do_logout();
            }
        }
    }
    ob_end_flush();
}

function do_logout()
{
    setcookie ("isin", "", time() - 3600);
    $url=$_SERVER['PHP_SELF'];
    header("location: $url");    
}

?>
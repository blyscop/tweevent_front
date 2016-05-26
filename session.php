<?php
    session_start();
    if(isset($_POST['username']) && isset($_POST['password']))
    {
        if(test_user($_POST['username'],$_POST['password']))
        {
            $_SESSION['username'] = $_POST['username'];
            $_SESSION['user_type']   = 'regular';
            $_SESSION['time']     = time();
            echo '<script language="Javascript">
                    document.location.replace("Actualite.php");
                </script>';
        }
        else
        {
            echo '<script language="Javascript">
                    document.location.replace("index.html#login_error");
                    </script>';
        }
    }
    else
    {
        echo var_dump($_SESSION);
    }

    function test_user($_usr,$_pwd)
    {
        $salt = "bonjour";
        $url = 'http://martinfrouin.fr/projets/tweevent/q/req.php?action=Utilisateur_SELECT&username='.$_POST['username'].'&password='.md5($salt.$_POST['password']);
        $obj = json_decode(file_get_contents($url), true);
        if($obj["message"]=="Utilisateur recupere !")
        {
            return true;
        };
        return false;
    }
    
?>
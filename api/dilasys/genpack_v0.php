<?

function ListDir($dir) {
    if ($handle = opendir($dir)) {
        while (false !== ($file = readdir($handle))) { 
            if (is_dir($dir."/".$file) && $file != "." && $file != "..") {
                ListDir($dir."/".$file);
            }
            if (!is_dir($dir."/".$file) && $file != "." && $file != "..") {
                $date = filemtime($dir."/".$file);
                $data = "$dir/$file|";
                $data .= filesize($dir."/".$file);
                $data .= "|";
                $data .= $date;
                $data .= "|";
                $data .= date ("Y/m/d H:i:s.", $date);
                $data .="<br>";           
                echo $data;
            }          
        }
        closedir($handle);
    }
}

$liste = ListDir(".");

?>
 
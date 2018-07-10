<?PHP 
require_once 'config.php';

//подключение бд
$db = 'mysql:host='.$config[host].';dbname='.$config[dbname]; 

require_once $_SERVER['DOCUMENT_ROOT'].'/engine/lib/rb.php';
R::setup( $db, $config[dbuser], $config[dbpassword] );
//R::freeze(true);

?>
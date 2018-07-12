<?PHP 
require_once 'config.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/classes/rb.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/classes/db.class.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/data/session.php';

//подключение бд
$db = 'mysql:host='.$config[host].';dbname='.$config[dbname]; 

R::setup( $db, $config[dbuser], $config[dbpassword] );
$db = new database('testtitle', 'questions', 'answers' ,'users');

?>
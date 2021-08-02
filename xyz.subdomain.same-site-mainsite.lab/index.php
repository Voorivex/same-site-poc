<?php
include('header.php');
echo '<pre>';
echo 'Tell me your name, are you <a href="?name=Jack">Jack</a><br>';
echo '<a href=http://same-site-mainsite.lab/get_cookie target="_blank">Click on me to navigate</a>';
echo '<br><br>';

if (isset($_GET['name'])){
    print($_GET['name']);
}

include('footer.php');

?>
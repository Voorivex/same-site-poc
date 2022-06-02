<?php
session_set_cookie_params([
    'samesite' => 'Lax'
]);
session_start();

// login form
function display_login_form() {
    echo '
<h2>Login Form</h2>
<form action="/login" method="post">
<label for="username">username</label>
<input type="text" name="username" id="username"><br>
<label for="password">password</label>
<input type="password" name="password" id="password"><br>
<input type="submit" name="submit" value="submit">
</form><br>';
}
// information update form
function display_data_form() {
    echo '
<form action="/change_information" method="post">
<label for="sensitive_data">Sensitive data</label>
<input type="text" name="sensitive_data" id="sensitive_data">
<input type="submit" name="submit" value="submit">
</form>';
}

// Include router class
include('route.php');
include('header.php');

// startpage
Route::add('/',function(){
    echo '<h2>Welcome, SecurityFlow</h2>';

    echo 'To set cookie please <a href="/set_cookie">click here</a><br>';
    echo 'To see the cookies please <a href="/get_cookie">click here</a><br>';
    echo 'To delete the cookies please <a href="/delete_cookie">click here</a><br>';
    echo 'To login please <a href="/login">click here</a>';

    echo "<br><br><br><br><p><a href='https://securityflow.io' target='_blank'>SecurityFlow.io</a></p>";
});

// get_cookie displays all cookies
Route::add('/get_cookie', function(){
    echo "<pre>";
    echo "<h2>Cookies</h2>";
    foreach ($_COOKIE as $key => $value) {
        echo "$key -> $value <br>";
    }
});

// set_cookies sets two cookies, Lax and Strict
Route::add('/set_cookie', function(){
    echo "<pre>";
    echo "Please watch the header to see the response and set-cookie header";

    setcookie('normal-test', 'SecurityFlow-Lax-cookie', [
        'expires' => time() + 86400,
        'path' => '/',
        'secure' => false,
        'httponly' => true,
        'samesite' => 'None',
    ]);

    setcookie('lax-test', 'SecurityFlow-Lax-cookie', [
        'expires' => time() + 86400,
        'path' => '/',
        'secure' => false,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);

    setcookie('strict-test', 'SecurityFlow-Strict-cookie', [
        'expires' => time() + 86400,
        'path' => '/',
        'secure' => false,
        'httponly' => true,
        'samesite' => 'Strict',
    ]);
});

// delete_cookie deletes all cookies
Route::add('/delete_cookie', function(){
// unset cookies
    echo "<pre>";
    echo "Done";

    if (isset($_SERVER['HTTP_COOKIE'])) {
        $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
        foreach($cookies as $cookie) {
            $parts = explode('=', $cookie);
            $name = trim($parts[0]);
            setcookie($name, '', time() - 3600, '/');
        }
    }
});

// showing the panel
Route::add('/panel',function(){

    if (isset($_SESSION['auth'])===True){
        display_data_form();
    }else{
        header('HTTP/1.0 403 Unauthorized');
        echo 'not authorized';
    }
},'get');

// showing login form
Route::add('/login',function(){
    display_login_form();
},'get');

// login path, taking username and password
Route::add('/login',function(){
    if ($_POST['username'] == 'security' && $_POST['password'] == 'flow'){
        //IF USERNAME AND PASSWORD ARE CORRECT SET THE LOG-IN SESSION
        $_SESSION["auth"] = True;
        header("Location: /panel");
        } else {
        display_login_form();
        echo '<p>Username or password is invalid</p>';
    }
},'post');

// change information form display
Route::add('/change_information',function(){
    if (isset($_SESSION['auth'])===True){
        echo "The data updated";
    }else{
        header('HTTP/1.0 403 Unauthorized');
        echo 'not authorized';
    }
},'post');

// running
Route::run('/');

include('footer.php');

?>
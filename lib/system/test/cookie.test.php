<?php
// Login page
require_once($_SERVER['DOCUMENT_ROOT'].'/autoload.php');

$db = new System\Database;
$account = new System\Account($db);
$session = new System\Session($db);
$tables = new System\Tables($db);
$cookie = new System\Cookies($db);
$crypt = new System\Crypt;

//$account->activateAccount('M6o/fW+7SAIy9ZrL5hE1mH$M6DZ0LB8uyC4A');

function sendToken($email, $token){
  $to = $email;
  $subject = 'Activation token';
  $message = '
  <html>
  <head>
    <title>Activate your account by clicking the link bellow</title>
  </head>
  <body>
  <a href="'.$token.'">'.$token.'</a>
    <p>Here are the birthdays upcoming in August!</p>
    <table>
      <tr>
        <th>Person</th><th>Day</th><th>Month</th><th>Year</th>
      </tr>
      <tr>
        <td>Johny</td><td>10th</td><td>August</td><td>1970</td>
      </tr>
      <tr>
        <td>Sally</td><td>17th</td><td>August</td><td>1973</td>
      </tr>
    </table>
  </body>
  </html>
  ';
  $headers[] = 'MIME-Version: 1.0';
  $headers[] = 'Content-type: text/html; charset=iso-8859-1';
  mail($to, $subject, $message, implode("\r\n", $headers));
}

// Load Remembered User
if(isset($_COOKIE) && isset($_COOKIE['elephant-id'])){
  $cookie->is_valid(); // load session
}
// Logged User
if(isset($_SESSION) && isset($_SESSION['user_id'])){
  $account->loadSigned();
}

echo $account->getUsername();

// Sign In
if(isset($_POST['signin'])){
  echo "<h2>SIGN USER</h2>";
  $token = $account->signin(); // receive token
  // Email token
  sendToken( $account->getEmail(), $token);
  // debug
  var_dump($token);
}

// Log In
if(isset($_POST['login'])){
  echo "<h2>LOGIN USER</h2>";
  if($user = $account->login()){
    if(isset($_POST['remember'])){
      $cookie->create();
    }
  }
  else{
    // could not load user
  }
  header("Location: http://blank/lib/system/test/cookie.test.php");
}

// Activate
if(isset($_GET['activate'])){
  if($account->activateAccount($_GET['activate'])){
    header("Location: http://blank/lib/system/test/cookie.test.php");
  }
}
// Reset Password
if(isset($_POST['reset'])){

}
if(isset($_GET['logout'])){
  session_destroy();
  $_SESSION = [];
  $cookie->remove();
  $_COOKIE = [];
  header("Location: http://blank/lib/system/test/cookie.test.php");

}


$users = $db->query("SELECT * FROM ml_account");
$sessions = $db->query("SELECT * FROM ml_sessions");

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
  </head>
  <body>

<h1>LOGIN ELEPHANT</h1>
<? if(empty($_GET)):?>
<div id="login">


<form action="http://blank/lib/system/test/cookie.test.php" method="post">
  <h2>Sign In</h2>
  <input type="hidden" name="signin">
  <label>Username:<input name="username" type="text" placeholder="Username"/></label>
  <label>Email:<input name="email" type="text" placeholder="Username"/></label>
  <label >Password:<input name="password" type="password" placeholder="Password"/></label>

  <button type="submit" value="token" name="button">Submit</button>

</form>


<form action="http://blank/lib/system/test/cookie.test.php" method="post">
  <h2>Log In</h2>
  <input type="hidden" name="login">
  <label>Username or Email:<input  name="logname" type="text" placeholder="Username"/></label>
  <label >Password:<input name="password" type="password" placeholder="Password"/></label>
  <label >Remember Me <input type="radio" name="remember" value="true"></label>
  <button type="submit" name="button">Submit</button>
</form>
</div>
<? endif; ?>

<a href="http://blank/lib/system/test/cookie.test.php">Login</a>
<a href="http://blank/lib/system/test/cookie.test.php?reset">Forgot Password</a>
<a href="http://blank/lib/system/test/cookie.test.php?logout">Log Out</a>


<?php if(isset($_GET['reset'])): ?>
<h1>Reset Password</h1>
<form action="http://blank/lib/system/test/cookie.test.php" method="post">
  <input type="hidden" name="resetRequest">
  <label>Username or Email:<input name="userdata" type="text" placeholder="Username or Email"/></label>
  <button type="submit" value="token" name="button">Submit</button>

</form>
<? endif; ?>

<?php if(isset($_SESSION['username']) && isset($_GET['newpassword'])): ?>
<form action="http://blank/lib/system/test/cookie.test.php" method="post">
  <h2>New Password for <?php $_SESSION['username']; ?></h2>
  <input type="hidden" name="reset">
  <label >Password:<input name="pass" type="password" placeholder="Password"/></label>
  <label >Password Again:<input name="passAgain" type="password" placeholder="Password Again"/></label>
  <button type="submit" value="token" name="button">Submit</button>

</form>
<? endif; ?>

<div class="block">
  <h4>USERS</h4>
<?  foreach($users as $user):?>
  <div class="line">
    <span class="name"><? echo $user['username'];?> </span><span class="email"><? echo $user['email'] ?></span> <? echo $user['state'] ?>
  </div>
<? endforeach;?>
</div>

<div class="block">
  <? if(isset($_SESSION)):?>
  <h4>POST</h4>
  <?  foreach($_POST as $key => $value):?>
    <div class="line">
      <span class="key"><? echo $key;?> </span><span class="value"><? echo $value ?></span>
    </div>
  <? endforeach;?>
  <? endif; ?>
</div>

<div class="block">
  <? if(isset($_SESSION)):?>
  <h4>SESSION</h4>
  <?  foreach($_SESSION as $key => $value):?>
    <div class="line">
      <span class="key"><? echo $key;?> </span><span class="value"><? echo $value ?></span>
    </div>
  <? endforeach;?>
  <? endif; ?>
</div>

<div class="block">
  <? if(isset($sessions)):?>
  <h4>SESSIONS</h4>
  <?  foreach($sessions as $session):?>
    <div class="line">
      <span class="name"><? echo $session['id'];?> </span><span class="email"><? echo $session['data'] ?></span>
    </div>
  <? endforeach;?>
  <? endif; ?>
</div>

<div class="block">
<? if(isset($_COOKIE['elephant-id'])):?>
<h4>COOKIE</h4>
<div class="line">
  <? echo $_COOKIE['elephant-id']; ?>
</div>
<? endif; ?>
</div>

</body>
</html>
<?php ?>

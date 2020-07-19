<?php
	require_once "config.php";

	//if (isset($_SESSION['access_token'])) {
		header('Location: ../register.php');
		exit();
	//}
	
	//Redirect url for after login 
	$redirectURL = "http://localhost:8080/fw/fbtest/fb-callback.php";
	$permissions = ['email'];
	//facebook login url for  login a href 
	$loginURL = $helper->getLoginUrl($redirectURL, $permissions);
?>

<style>

/* login with facebook btn Shared */
.loginBtn {
  box-sizing: border-box;
  position: relative;
  width: 13em;  - apply for fixed size ;
  margin: 10px;
  padding: 9px  15px 9px 46px;
  border: none;
  text-align: center;
  white-space: nowrap;
  border-radius: 0.2em;
  font-size: 16px;
  color: #FFF;
  text-decoration : none;
}

.loginBtn:before {
  content: "";
  box-sizing: border-box;
  position: absolute;
  top: 0;
  left: 0;
  width: 34px;
  height: 100%;
}
.loginBtn:focus {
  outline: none;
}
.loginBtn:active {
  box-shadow: inset 0 0 0 32px rgba(0,0,0,0.1);
}


/* Facebook */
.loginBtn--facebook {
  background-color: #4C69BA;
  background-image: linear-gradient(#4C69BA, #3B55A0);
  /*font-family: "Helvetica neue", Helvetica Neue, Helvetica, Arial, sans-serif;*/
  text-shadow: 0 -1px 0 #354C8C;
}
.loginBtn--facebook:before {
  border-right: #364e92 1px solid;
  background: url('https://s3-us-west-2.amazonaws.com/s.cdpn.io/14082/icon_facebook.png') 6px 6px no-repeat;
}
.loginBtn--facebook:hover,
.loginBtn--facebook:focus {
  background-color: #5B7BD5;
  background-image: linear-gradient(#5B7BD5, #4864B1);
}

</style>

<h1>بسم الله الرحمن الرحيم </h1>

<a  href="<?php echo $loginURL ?>" class="loginBtn loginBtn--facebook"> تسجيل الدخول عبر فيسبوك </a>

 

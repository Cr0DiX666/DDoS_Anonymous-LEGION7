<?

  require_once "config.php";

  session_start();

  if (isset($_SESSION['auth'])) header("location: index.php");

  if (isset($_POST['login']) && isset($_POST['pass']))
  {
        if ($_POST['login'] == $opt['admin_login'] && $_POST['pass'] == $opt['admin_pass'])
        {
              $_SESSION['auth'] = true;
              header("location: index.php");
        }
  }


?>

<html>
<head>
<title>:: Botnet control</title>
<LINK href=style.css type=text/css rel=StyleSheet>
</head>
<body bgcolor=#151d32>
<script>

         function wnd( url )
         {
                window.open( url, "", "statusbar=no,menubar=no,toolbar=no,scrollbars=yes,resizable=no,width=400,height=200");
         }

</script>
<table width='70%' align='center' bgcolor='#1B2541'>
 <tr>
 <td align='center'>
  <table><tr><td>
    <table><tr><td>
    <table cellspacing='1' class='ITEM'>
    <tr height='20'><td class='HEADER'><b>Auth please</b></td></tr>
    <tr class='ITEM'>
    <td>
    <table callspacing='0'>
    <tr><td colspan='2'><td></tr>
    <form action='auth.php' method='POST'>
    <tr><td align="right">login: </td><td><input type='text' name='login' size=20></td></tr>
    <tr><td align="right">password: </td><td><input type='password' name='pass' size=20></td></tr>
    <tr><td></td><td><input type='submit' value='submit'></td></tr>
    </form>
    </td>
    </tr>
    </table>
    </table>
  </td></tr></table>
 </td></tr></table>
</body>
</html>
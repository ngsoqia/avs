<?php
define('_VALID', 1);
define('_ENTER', true);
$basedir    = dirname(dirname(__FILE__));
require $basedir. '/include/config.php';
require $basedir. '/include/function_video.php';

$vdoname    = $_SERVER['argv']['1'];
$vid        = $_SERVER['argv']['2'];
$video_path = $_SERVER['argv']['3'];

if ( $vdoname != '' && $vid != '' && $video_path != '' ) {
    $ext                = strtolower(substr($vdoname, strrpos($vdoname, '.') + 1));
    $ofps               = ( $ext == 'wmv' ) ? '-ofps 25000/1001' : NULL;
    $mencoder_version   = '1.0rc1';
    exec($config['mencoder'], $mencoder_check);
    if ( isset($mencoder_check['0']) ) {
        if ( !strstr($mencoder_check['0'], 'MEncoder 1.0rc1') ) {
            $mencoder_version = '1.0rc2';
        }
    }
    $options            = ( $mencoder_version == '1.0rc1' ) ? '-lavfopts i_certify_that_my_video_stream_does_not_use_b_frames' : NULL;
    $options            = $options. ' ' .$ofps;
    $vf                 = ( $mencoder_version == '1.0rc1' ) ? '-vop' : '-vf';
    
    if ( $config['vresize'] == 1 ) {
        $cmd            = $config['mencoder']. ' ' .$video_path. ' -o ' .$config['FLVDO_DIR']. '/' .$vid. 'x.flv -of lavf -oac mp3lame -lameopts abr:br=56 -ovc lavc -lavcopts vcodec=flv:vbitrate=' .$config['vbitrate']. ':mbd=2:mv0:trell:v4mv:keyint=10:cbp:last_pred=3 ' .$vf. ' scale=' .$config['vresize_x']. ':' .$config['vresize_y']. ' -srate ' .$config['sbitrate']. ' ' .$options;        
    } else {
        $cmd            = $config['mencoder']. ' ' .$video_path. ' -o ' .$config['FLVDO_DIR']. '/' .$vid. 'x.flv -of lavf -oac mp3lame -lameopts abr:br=56 -ovc lavc -lavcopts vcodec=flv:vbitrate=' .$config['vbitrate']. ':mbd=2:mv0:trell:v4mv:keyint=10:cbp:last_pred=3 -srate ' .$config['sbitrate']. ' ' .$options;        
    }    
    log_conversion($config['LOG_DIR']. '/' .$vid. '.log', $cmd);
    if ( $config['vresize'] != 1 && $ext == 'flv' ) {
        copy($video_path, $config['FLVDO_DIR']. '/' .$vid. 'x.flv');
    } else {
        exec($cmd. ' 2>&1', $output);
    }
    log_conversion($config['LOG_DIR']. '/' .$vid. '.log', implode("\n", $output));
    
    // update flv meta tags
    if ( $config['meta_tool'] == 'flvtool2' ) {
        $cmd = $config['metainject']. ' -Uv ' .$config['FLVDO_DIR']. '/' .$vid. 'x.flv ' .$config['FLVDO_DIR']. '/' .$vid. '.flv';
    } elseif ( $config['meta_tool'] == 'yamdi' ) {
        $cmd = $config['yamdi']. ' -i ' .$config['FLVDO_DIR']. '/' .$vid. 'x.flv -o ' .$config['FLVDO_DIR']. '/' .$vid. '.flv';
    } else {
        log_conversion($config['LOG_DIR']. '/' .$vid. '.log', 'Invalid meta tool..must be yamdi or flvtool2');
    }
    exec($cmd, $output);
    log_conversion($config['LOG_DIR']. '/' .$vid. '.log', implode("\n", $output));
    
	//change permissions to 666 for lighty
	@chmod($config['FLVDO_DIR']. '/' .$vid. '.flv', 0666);
	
    // delete temporary flv file
    @unlink($config['FLVDO_DIR']. '/' .$vid. 'x.flv');
    
    //extract video thumbs
    extract_video_thumbs($video_path, $vid);
    
    //activate video
    if ( file_exists($config['FLVDO_DIR']. '/' .$vid. '.flv') && filesize($config['FLVDO_DIR']. '/' .$vid. '.flv') > 10 ) {
	$add = NULL;
	if ($config['multi_server'] == '1') {
		require $config['BASE_DIR']. '/include/function_server.php';
		$server = get_server();
		update_server_used($server);
		upload_video($config['FLVDO_DIR']. '/' .$vid. '.flv', $server['server_ip'], $server['ftp_username'], $server['ftp_password'], $server['ftp_root']);
		update_server($server);
		$add = ", server = '".mysql_real_escape_string($server['url'])."'";
	}
        $active = ( $config['approve'] == '1' ) ? '0' : '1';
        $sql = "UPDATE video SET active = '" .$active. "'".$add." WHERE VID = " .intval($vid). " LIMIT 1";
        $conn->execute($sql);
        @unlink($config['TMP_DIR']. '/logs/' .$vid. '.log');
    }
    
    //delete original video
    if ( $config['del_original_video'] == '1' )  {
        if(filesize($config['FLVDO_DIR']. '/' .$vid. '.flv') > 100 && file_exists($config['FLVDO_DIR']. '/' .$vid. '.flv')) {
            chmod($video_path, 0777);
            unlink($video_path);
        }
    }
    
    //delete temporary thumb files
	@unlink($config['TMP_DIR']. '/thumbs/' .$vid. '/00000001.jpg');
    @unlink($config['TMP_DIR']. '/thumbs/' .$vid. '/00000002.jpg');
    for( $i=1; $i<=20; $i++ ) {
        @unlink($config['TMP_DIR']. '/thumbs/' .$vid. '/' .$i. '.jpg');
	}
    
    @unlink($config['TMP_DIR']. '/thumbs/' .$vid. '/default.jpg');
    @rmdir($config['TMP_DIR']. '/thumbs/' .$vid);
}
?>

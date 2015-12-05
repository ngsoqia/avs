<?php
/*|-------------------------------------------------
|*|	AVS Conversion Functions
|*| Convert SD (flv) , HD (flv), iPod (mp4)
|*|-------------------------------------------------
|*/	

function get_mediainfo_data($videofile){
	global $config;
	$varr = array();
	$output1 = array();
	$output2 = array();
	$media_general = $config['BASE_DIR']."/scripts/media_general.txt";
	$media_video = $config['BASE_DIR']."/scripts/media_video.txt";
	if (!preg_match("/mediainfo$/is", $config['mediainfo'])){
		$error = 'Mediainfo error';
	}else{
		$command1 = $config['mediainfo']." --Inform=file://".$media_general." ".$videofile;
		exec($command1,$output1);
		$command2 = $config['mediainfo']." --Inform=file://".$media_video." ".$videofile;
		exec($command2,$output2);
		$error = '';
	}
	$varr['error'] = $error;
	$varr['media_gen_cmd'] = $command1;
	$varr['media_vid_cmd'] = $command2;
	$varr['media_gen_out'] = $output1;
	$varr['media_vid_out'] = $output2;
	return $varr;
}

function getDimensions($encoding,$width,$height){
	global $config;
	$dim = array();
	if($encoding['resize_base'] == "area"){
		$area_max = $encoding['resize_width'] * $encoding['resize_height'];
		$area = $width * $height;
		if($area <= $area_max){
			$dim['width'] = $width;
	        $dim['height'] = $height;
		}else{
			$dim['width'] = round( sqrt($area_max/$area) * $width );
			$dim['height'] = round( $dim['width'] * $height/$width );
		}
	}elseif($encoding['resize_base'] == "width"){
		if($width <= $encoding['resize_width']){
			$dim['width'] = $width;
	        $dim['height'] = $height;
		}else{
			$dim['width'] = $encoding['resize_width'];
			$dim['height'] = round( $height * $encoding['resize_width']/$width );
		}
	}
	elseif($encoding['resize_base'] == "height"){
		if($height <= $encoding['resize_height']){
			$dim['width'] = $width;
	        $dim['height'] = $height;
		}else{
			$dim['height'] = $encoding['resize_height'];
			$dim['width'] = round( $width * $encoding['resize_height']/$height );
		}
	}
	elseif($encoding['resize_base'] == "both"){
		if($width <= $encoding['resize_width'] && $height <= $encoding['resize_height']){
			$dim['width'] = $width;
	        $dim['height'] = $height;
		}elseif($encoding['resize_width']/$width <= $encoding['resize_height']/$height ) {
			$dim['width'] = $encoding['resize_width'];
			$dim['height'] = round( $height * $encoding['resize_width']/$width );
		}else{
			$dim['height'] = $encoding['resize_height'];
			$dim['width'] = round( $width * $encoding['resize_height']/$height );
		}	
	}elseif($encoding['resize_base'] == "crop"){
		$dim['width'] = $encoding['resize_width'];
		$dim['height'] = $encoding['resize_height'];
	}
	return $dim;
}

function getBitrate($encoding, $width, $height){
	if($encoding['ref_type'] == "fix"){
		$vbitrate = $encoding['ref_bitrate'];
	}
	elseif($encoding['ref_type'] == "linear"){
		$area = $width * $height;
		$ref_area = $encoding['ref_width'] * $encoding['ref_height'];
		$vbitrate = round($encoding['ref_bitrate'] * $area/$ref_area);
	}elseif($encoding['ref_type'] == "log"){
		$area = $width * $height;
		$ref_area = $encoding['ref_width'] * $encoding['ref_height'];
		$vbitrate = round(log($area/$ref_area + 1)/log(2) * $encoding['ref_bitrate']);
	}elseif($encoding['ref_type'] == "sqrt"){
		$area = $width * $height;
		$ref_area = $encoding['ref_width'] * $encoding['ref_height'];
		$vbitrate = round(sqrt($area/$ref_area) * $encoding['ref_bitrate']);
	}elseif($encoding['ref_type'] == "standard"){
		$area = $width * $height;
		$ref_area = $encoding['ref_width'] * $encoding['ref_height'];
		$vbitrate = round((1/2 * $area/$ref_area + 1/2 * sqrt($area/$ref_area)) * $encoding['ref_bitrate']);
	}
	return $vbitrate;
}

function print_log($txt){
	global $config;
	if ($config['log_conversion']){
		print ($txt);
	}
}

function modproc($cmd){
	$cmd = str_replace(" ;", " 2>&1 ;", $cmd)." 2>&1";
	$nl = "=========================================================\n";
	echo "\n".$nl."Command:\n".$nl.$cmd."\n\n";
	exec($cmd,$out);
	foreach($out as $outd){
		$outs .= $outd."\n";
	}
	echo "Output:\n".$outs."\n\n";
}

function getEncodings($fn_video_type,$fn_aspect,$fn_vinfo,$hd_overwrite){
	global $config, $conn;
	$encodings = array();
	$sql = "SELECT * FROM encoding_avs"
		."  WHERE video_type = '".mysql_real_escape_string($fn_video_type)."'"
		."  AND (aspect = 'all' OR aspect = '".mysql_real_escape_string($fn_aspect)."')"
		."  ORDER BY encode_seq DESC"
	."";
	$i=1;
	$rs = array();
	$rs = $conn->execute($sql);
	while (!$rs->EOF){
		$row = array();
		$row = $rs->fields;
		$sql = "SELECT * FROM encoding_condition"
			."  WHERE video_type = '".mysql_real_escape_string($row['video_type'])."'"
			."  AND aspect = '".mysql_real_escape_string($row['aspect'])."'"
			."  AND encode_seq = ".(int) $row['encode_seq']
		."";
		$cond = true;
		$rsc = array();
		$rsc = $conn->execute($sql);
		while (!$rsc->EOF && $cond){
			$cRow = array();
			$cRow = $rsc->fields;
			if (!checkCondition($cRow['condition_type'], $cRow['condition_operator'], $cRow['condition_value'], $fn_vinfo)){
				$cond = false;
			}
			$rsc->MoveNext();
		}
		if ($cond || $hd_overwrite) $encodings[] = $row;
		$rs->MoveNext();
	}
	return $encodings;
}

function checkCondition($condition_type, $condition_operator, $condition_value, $vDim){
	
	if ($condition_type == "area"){
		$local_value = $vDim['Video_Width'] * $vDim['Video_Height'];
	}elseif ($condition_type == "width"){
		$local_value = $vDim['Video_Width'];
	}elseif ($condition_type == "height"){
		$local_value = $vDim['Video_Height'];
	}
	switch ($condition_operator){
		case "eq":	return ($local_value == $condition_value);
		case "gt": 	return ($local_value > $condition_value);
		case "gte":	return ($local_value >= $condition_value);
		case "lt": 	return ($local_value < $condition_value);
		case "lte":	return ($local_value <= $condition_value);
		case "ne":	return ($local_value != $condition_value);
	}
	return false;
}

function convert($e,$vinfo,$vid,$vdo_path,$vdoname,$keyint,$lavfopts,$ofps,$mc,$demuxer,$aspect){
	global $config;
	$nl = "=========================================================\n";
	// Display :: Arr
	echo "\n".$nl."Array Data:\n".$nl;
	foreach($e as $key => $val){
		if(!(int)$key) echo "\$e['".$key."'] = '".$val."';\n";
	}
	// Action :: Prep
	if ($e['action'] != "copy_only"){
		$crop = "";
		$bb = "";		
		$dim = getDimensions($e,$vinfo['Video_Width'],$vinfo['Video_Height']);
		$width_new = $dim['width'];
		$height_new = $dim['height'];
		// Crop	
		if($e['resize_base'] == 'crop' && ($width_new < $vinfo['Video_Width'] || $height_new < $vinfo['Video_Height'])){
			if(($width_new + 1)/($height_new - 1) < $vinfo['Video_Width']/$vinfo['Video_Height']){
				$crop_width = round($vinfo['Video_Height'] * $width_new/$height_new * $vinfo['Original_Width']/$vinfo['Video_Width']);
				$crop_height = $vinfo['Video_Height'];
				$crop_x = max(round(($vinfo['Original_Width'] - $crop_width)/2), 0);
				$crop_y = 0;
			}elseif(($width_new - 1)/($height_new + 1) > $vinfo['Video_Width']/$vinfo['Video_Height']){
				$crop_width = $vinfo['Original_Width'];
				$crop_height = round($vinfo['Video_Width'] * $height_new/$width_new);
				$crop_x = 0;
				$crop_y = max(round(($vinfo['Video_Height'] - $crop_height)/2), 0);
			}
			if(($width_new + 1)/($height_new - 1) < $vinfo['Video_Width']/$vinfo['Video_Height'] || ($width_new - 1)/($height_new + 1) > $vinfo['Video_Width']/$vinfo['Video_Height'] ){
				$crop = "crop=".(int) $crop_width.":".(int) $crop_height.":".($crop_x == 0 ? "0" : (int) $crop_x).":".($crop_y == 0 ? "0" : (int) $crop_y).",";
			}
		}
		$compare_width = $e['resize_width'];	
		$divby = 2;
		$width_new_divby = round($width_new/$divby) * $divby;
		$height_new_divby = round($height_new/$divby) * $divby;	
		// Blackbars	
		if($e['blackbars'] && $crop == ""){
			if(($width_new - 1)/($height_new + 1) > 4/3 ){
				$width_expand = $width_new_divby;
				$height_expand = round($width_expand * 3/4/$divby) * $divby;
			}elseif(($width_new + 1)/($height_new - 1) < 4/3 ){
				$height_expand = $height_new_divby;
				$width_expand = round($height_expand * 4/3/$divby) * $divby;
			}
			if ((($width_new - 1)/($height_new + 1) > 4/3 && $height_expand > $height_new_divby) || (($width_new + 1)/($height_new - 1) < 4/3 && $width_expand > $width_new_divby) ){
				$bb = "expand=".(int) $width_expand.":".(int) $height_expand.",";
			}
		}
		// Interlaced	
		$dif = "";
		if($vinfo['Scan_Type'] == "Interlaced"){
			$dif = "yadif,";
		}
		// Bitrate	
		$vbitrate = getBitrate($e, $width_new_divby, $height_new_divby);
		$scale = "";
		if($width_new_divby != $vinfo['Original_Width'] || $height_new_divby != $vinfo['Video_Height']){
			$scale = "scale=".(int) $width_new_divby.":".(int) $height_new_divby.",";
		}
		// VF		
		$vf = " -vf ".$crop.$dif.$scale.$bb."harddup";	
	}
	
	// Output :: Vars
	echo "\n".$nl."Conversion Config:\n".$nl;
	echo "encode_seq: ".$e['encode_seq']."\n";
	echo "action: ".$e['action']."\n";
	echo "resize_base: ".$e['resize_base']."\n";
	echo "resize_width: ".$e['resize_width']."\n";
	echo "resize_height: ".$e['resize_height']."\n";
	echo "ref_bitrate: ".$e['ref_bitrate']."\n";
	echo "ref_type: ".$e['ref_type']."\n";
	echo "ref_width: ".$e['ref_width']."\n";
	echo "ref_height: ".$e['ref_height']."\n";
	echo "blackbars: ".$e['blackbars']."\n";
	echo "nameext: ".$e['nameext']."\n";
	echo "encodepass: ".$e['encodepass']."\n";
	echo "neroAacEnc: ".$config['neroaacenc']."\n";
	echo "MP4Box: ".$config['mp4box']."\n\n";
	
	echo "\n".$nl."Conversion Parameters:\n".$nl;
	echo "width_new: $width_new_divby\n";
	echo "height_new: $height_new_divby\n";
	echo "vbitrate: $vbitrate\n";
	echo "vf: $vf\n\n";


	// Action Profiles
	$search = array('{vbitrate}', '{keyint}');
	$replace = array(strval($vbitrate), strval($keyint));
	// h263 ----------------------------------------------------
	$ovc_profile['encode_h263']['standard']['1pass'] = " -ovc lavc -lavcopts vcodec=flv:vbitrate={vbitrate}:mbd=2:mv0:trell:v4mv:keyint={keyint}:cbp:last_pred=3:predia=4:dia=4:preme=2:vmax_b_frames=0:vb_strategy=1";
	$ovc_profile['encode_h263']['standard']['2pass'][1] = " -ovc lavc -lavcopts vcodec=flv:vbitrate={vbitrate}:mbd=2:mv0:trell:v4mv:keyint={keyint}:cbp:last_pred=3:predia=4:dia=4:preme=2:vmax_b_frames=0:vb_strategy=1:vpass=1";
	$ovc_profile['encode_h263']['standard']['2pass'][2] = " -ovc lavc -lavcopts vcodec=flv:vbitrate={vbitrate}:mbd=2:mv0:trell:v4mv:keyint={keyint}:cbp:last_pred=3:predia=4:dia=4:preme=2:vmax_b_frames=0:vb_strategy=1:vpass=2";
	// ipod ----------------------------------------------------
	$ovc_profile['encode_ipod']['standard']['1pass'] = " -ovc x264 -x264encopts bitrate={vbitrate}:nocabac:vbv_maxrate=1500:vbv_bufsize=2000:level_idc=30:global_header:frameref=2:mixed_refs:me=umh:subq=6:partitions=all:threads=auto:bframes=0";
	$ovc_profile['encode_ipod']['standard']['2pass'][1] = " -ovc x264 -x264encopts turbo=1:bitrate={vbitrate}:nocabac:vbv_maxrate=1500:vbv_bufsize=2000:level_idc=30:global_header:frameref=2:mixed_refs:me=umh:subq=6:partitions=all:threads=auto:bframes=0:pass=1";
	$ovc_profile['encode_ipod']['standard']['2pass'][2] = " -ovc x264 -x264encopts bitrate={vbitrate}:nocabac:vbv_maxrate=1500:vbv_bufsize=2000:level_idc=30:global_header:frameref=2:mixed_refs:me=umh:subq=6:partitions=all:threads=auto:bframes=0:pass=2";
	// h264 ----------------------------------------------------
	$ovc_profile['encode_x264']['quality']['1pass'] = " -ovc x264 -x264encopts bitrate={vbitrate}:frameref=8:mixed_refs:partitions=all:8x8dct:me=umh:subq=6:trellis=2:threads=auto";
	$ovc_profile['encode_x264']['quality']['2pass'][1] = " -ovc x264 -x264encopts bitrate={vbitrate}:turbo=1:frameref=8:mixed_refs:partitions=all:8x8dct:me=umh:subq=6:trellis=2:threads=auto:pass=1";
	$ovc_profile['encode_x264']['quality']['2pass'][2] = " -ovc x264 -x264encopts bitrate={vbitrate}:frameref=8:mixed_refs:partitions=all:8x8dct:me=umh:subq=6:trellis=2:threads=auto:pass=2";
	// h264 ----------------------------------------------------
	$ovc_profile['encode_x264']['standard']['1pass'] = " -ovc x264 -x264encopts bitrate={vbitrate}:frameref=2:mixed_refs:8x8dct:me=hex:subq=5:trellis=2:threads=auto";
	$ovc_profile['encode_x264']['standard']['2pass'][1] = " -ovc x264 -x264encopts bitrate={vbitrate}:turbo=1:frameref=2:mixed_refs:8x8dct:me=hex:subq=5:trellis=2:threads=auto:pass=1";
	$ovc_profile['encode_x264']['standard']['2pass'][2] = " -ovc x264 -x264encopts bitrate={vbitrate}:frameref=2:mixed_refs:8x8dct:me=hex:subq=5:trellis=2:threads=auto:pass=2";
	// h264 ----------------------------------------------------
	$ovc_profile['encode_x264']['nightfly']['1pass'] = " -ovc x264 -x264encopts  bitrate={vbitrate}:frameref=12:me=umh:subq=9:mixed_refs:trellis=2:8x8dct:threads=auto:bframes=4:b_pyramid:b_adapt:direct_pred=auto:weight_b:partitions=all:ratetol=5.7:ip_factor=1.41:pb_factor=1.25:qcomp=0.70";
	$ovc_profile['encode_x264']['nightfly']['2pass'][1] = " -ovc x264 -x264encopts  bitrate={vbitrate}:frameref=12:me=umh:subq=9:mixed_refs:trellis=2:8x8dct:threads=auto:bframes=4:b_pyramid:b_adapt:direct_pred=auto:weight_b:partitions=all:ratetol=5.7:ip_factor=1.41:pb_factor=1.25:qcomp=0.70:pass=1";
	$ovc_profile['encode_x264']['nightfly']['2pass'][2] = " -ovc x264 -x264encopts  bitrate={vbitrate}:frameref=12:me=umh:subq=9:mixed_refs:trellis=2:8x8dct:threads=auto:bframes=4:b_pyramid:b_adapt:direct_pred=auto:weight_b:partitions=all:ratetol=5.7:ip_factor=1.41:pb_factor=1.25:qcomp=0.70:pass=2";
	// h264 ----------------------------------------------------
	$ovc_profile['encode_x264']['massanti']['1pass'] = " -ovc x264 -x264encopts bitrate={vbitrate}:frameref=8:bframes=3:b_adapt:b_pyramid:weight_b:partitions=all:8x8dct:me=umh:subq=6:trellis=2:threads=auto:analyse=all";
	$ovc_profile['encode_x264']['massanti']['2pass'][1] = " -ovc x264 -x264encopts bitrate={vbitrate}:frameref=8:bframes=3:b_adapt:b_pyramid:weight_b:partitions=all:8x8dct:me=umh:subq=6:trellis=2:threads=auto:analyse=all:pass=1";
	$ovc_profile['encode_x264']['massanti']['2pass'][2] = " -ovc x264 -x264encopts bitrate={vbitrate}:frameref=8:bframes=3:b_adapt:b_pyramid:weight_b:partitions=all:8x8dct:me=umh:subq=6:trellis=2:threads=auto:analyse=all:pass=2";
	


	// Source Video Path info
	$src = $config['VDO_DIR']."/".$vdoname;
	
	// HD Paths info
	$tmpX = $config['HD_DIR']."/". $vid."x.mp4";
	$tmpM4v = $config['HD_DIR']."/".$vid.".m4v";
	$tmp264 = $config['HD_DIR']."/".$vid."_temp.264";
	$tmpWav = $config['HD_DIR']."/".$vid."_temp.wav";
	$tmpMp4 = $config['HD_DIR']."/".$vid."_temp.mp4";
	$tmpL = $config['HD_DIR']."/". $vid."_temp.log";
	$hdTmp = $config['HD_DIR']."/".$vid."_temp.".$e['fileext'];
	$hdFile = $config['HD_DIR']."/".$vid.".".$e['fileext'];
	
	// Flv Paths info
	$sdFile = $config['FLVDO_DIR']."/".$vid.".".$e['fileext'];
	$sdTmp = $config['FLVDO_DIR']."/".$vid."_temp.".$e['fileext'];
	$sdLog = $config['FLVDO_DIR']."/".$vid.".log";
	
	// iPod Paths info
	$podFile = $config['IPHONE_DIR']."/".$vid.".".$e['fileext'];		
	$podTmp = $config['IPHONE_DIR']."/".$vid."_tmp.".$e['fileext'];	
	$podLog = $config['IPHONE_DIR']."/".$vid.".log";

		
	// Main Switch
	switch ($e['action']){
		
		/*|----------------------------------------------------------------------
		|*| Copy uplaoded file only
		|*|----------------------------------------------------------------------
		| case "copy_only":
		
			if($vinfo['General_Format'] == "Flash Video" && $vinfo['Video_Format'] == "H.263"){
				$cmd = $config['metainject'].' -Uv '.$src.' '.$sdFile;
			}else{
				$cmd = "cp $vdo_path ".$hdFile;
			}
			modproc($cmd);			
			break;
		*/
		
		
		/*|----------------------------------------------------------------------
		|*| Convert to SD (Standard Flv)
		|*|----------------------------------------------------------------------
		|*/ case "encode_h263":
				if ($config['flv_convert'] == '1') {
				// Flagged to copy only, but we check if 
				// file is already copied to hd folder first
				if($config['copyd']){
					$cvert = false;
					$hdFile2 = $config['HD_DIR']."/".$vid.".mp4";
					echo "HD FILE: ".$hdFile2;
					if(file_exists($hdFile2)) {
						$cvert = true;
					}else{
						if(@copy($src,$sdTmp)){
							//$cmd = $config['metainject'].' -Uv '.$sdTmp.' '.$sdFile;
								if ( $config['meta_tool'] == 'flvtool2' ) {
									$cmd = $config['metainject']. ' -Uv ' .$sdTmp. ' '.$sdFile;
								} elseif ( $config['meta_tool'] == 'yamdi' ) {
									$cmd = $config['yamdi']. ' -i ' .$sdTmp. ' -o ' .$sdFile;
								} else {
										$nl = "=======================Meta Injection Info===============================\n";
										echo "\n".$nl."Command:\n".$nl.$cmd."\n\n";
								}
							modproc($cmd);
							$width_new_divby = $vinfo['Video_Width'];
							$height_new_divby = $vinfo['Video_Height'];
						}
					}
				}
				
				// Encode h263 section
				if(!$config['copyd'] || $cvert){
					if(function_exists("verify_exec_path"))
					verify_exec_path($config['mencoder'], "mencoder", 6);
					if($e['encodepass'] == '1'){
						// Single Pass
						$ovc = str_replace($search, $replace, $ovc_profile[$e['action']][$e['ovc_profile']]['1pass']);
						$cmd = $config['mencoder']
							." ".$src
							." -o ".$sdTmp
							.$ovc
							." -of lavf"
							." -oac mp3lame"
							." -lameopts abr:br=".$e['audio_bitrate']
							." -srate ".$e['audio_sampling']
							.$lavfopts
							.$ofps
							.$vf
							.$mc
							.$demuxer
						."";
					}else{
						// Pass 1
						$ovc = str_replace($search, $replace, $ovc_profile[$e['action']][$e['ovc_profile']]['2pass'][1]);
						$cmd1 = $config['mencoder']
							." ".$src
							." -o ".$sdTmp
							." -passlogfile ".$sdLog
							.$ovc
							." -of lavf"
							." -oac mp3lame"
							." -lameopts abr:br=".$e['audio_bitrate']
							." -srate ".$e['audio_sampling']
							.$lavfopts
							.$ofps
							.$vf
							.$mc
							.$demuxer
						."";
						// Pass 2
						$ovc = str_replace($search, $replace, $ovc_profile[$e['action']][$e['ovc_profile']]['2pass'][2]);
						$cmd2 = $config['mencoder']
							." ".$src
							." -o ".$sdTmp
							." -passlogfile ".$sdLog
							.$ovc
							." -of lavf"
							." -oac mp3lame"
							." -lameopts abr:br=".$e['audio_bitrate']
							." -srate ".$e['audio_sampling']
							.$lavfopts
							.$ofps
							.$vf
							.$mc
							.$demuxer
						."";
						$cmd = $cmd1." ; ".$cmd2;
					}
					modproc($cmd);
					// Meta Injection

				if ( $config['meta_tool'] == 'flvtool2' ) {
					$cmd = $config['metainject']. ' -Uv ' .$sdTmp. ' '.$sdFile;
				} elseif ( $config['meta_tool'] == 'yamdi' ) {
					$cmd = $config['yamdi']. ' -i ' .$sdTmp. ' -o ' .$sdFile;
				} else {
						$nl = "=======================Meta Injection Info===============================\n";
						echo "\n".$nl."Command:\n".$nl.$cmd."\n\n";
				}
				modproc($cmd);
				}
				// Remove Temp Files
				if(file_exists($sdTmp)) @unlink($sdTmp);
				if(file_exists($sdLog)) @unlink($sdLog);
				
				if (file_exists($sdFile) && filesize($sdFile) > 100){
					$sql = "UPDATE video SET"
						." aspect_sd = '".$aspect."'"
						.", width_sd = '".$width_new_divby."'"
						.", height_sd = '".$height_new_divby."'"
						.", flvdoname = '".(int)$vid.".flv'" 
						." WHERE VID = '".(int)$vid."'"
					."";
					executeQuery($sql);
					//$conn->execute($sql);				
					echo "\n".$nl."SQL:\n".$nl.$sql."\n\n";
				}	
			}
			break;


		/*|----------------------------------------------------------------------
		|*| Convert to HD
		|*|----------------------------------------------------------------------
		|*/ case "encode_x264":
			if ($config['hd_convert'] == '1') {
				
				if($config['copyd']){
					// Is Youtube Mp4 (Already prepped) [Flv low quality no copy]
					if(($vinfo['General_FileExtension'] == "flv" || $vinfo['General_FileExtension'] == "mp4") && $vinfo['General_Format'] == "MPEG-4" && $vinfo['Video_Format'] == "AVC"){
						if(@copy($src,$hdFile)){
							$width_new_divby = $vinfo['Video_Width'];
							$height_new_divby = $vinfo['Video_Height'];
						}
					}elseif (($vinfo['General_FileExtension'] == "flv" || $vinfo['General_FileExtension'] == "mp4") && $vinfo['General_Format'] == "MPEG-4" && $vinfo['General_CodecID'] == "M4V" && $vinfo['Video_Format'] == "AVC"){
						if(@copy($src,$hdFile)){
							$width_new_divby = $vinfo['Video_Width'];
							$height_new_divby = $vinfo['Video_Height'];
						}
					}					
					
					
					
				}else{	
					if(function_exists("verify_exec_path"))
					verify_exec_path($config['mencoder'], "mencoder", 5);
					if($e['encodepass'] == 1){
						// Single Pass
						$ovc = str_replace($search, $replace, $ovc_profile[$e['action']][$e['ovc_profile']]['1pass']);
						$cmd = $config['mencoder']
							." ".$src
							." -o ".$tmp264
							." -passlogfile ".$tmpL
							.$ovc
							." -of rawvideo"
							." -nosound"
							.$ofps
							.$vf
							.$demuxer
						."";
					}
					elseif($e['encodepass'] == 2){
						// Pass 1
						$ovc = str_replace($search, $replace, $ovc_profile[$e['action']][$e['ovc_profile']]['2pass'][1]);
						$cmd1 = $config['mencoder']
							." ".$src
							." -o /dev/null"
							." -passlogfile ".$tmpL
							.$ovc
							." -nosound"
							.$ofps
							.$vf
							.$demuxer
						."";
						// Pass 2
						$ovc = str_replace($search, $replace, $ovc_profile[$e['action']][$e['ovc_profile']]['2pass'][2]);
						$cmd2 = $config['mencoder']
							." ".$src
							." -o ".$tmp264
							." -passlogfile ".$tmpL
							.$ovc
							." -of rawvideo"
							." -nosound"
							.$ofps
							.$vf
							.$demuxer
						."";
						$cmd = $cmd1." ; ".$cmd2;
					}
					modproc($cmd);
					// Sampling Rate
					$cmd = $config['mplayer']
						." ".$src
						." -af resample=".$e['audio_sampling'].":0:0,volnorm=1:0.25"
						." -ao pcm:file=".$tmpWav
						." -vc dummy"
						." -vo null"
						.$demuxer
					."";
					modproc($cmd);
					// Nero => Also sets sbitrate here 
					$cmd = $config['neroaacenc']
						." -br ".($e['audio_bitrate'] * 1024)
						." -he"
						." -if ".$tmpWav
						." -of ".$tmpMp4
					."";
					modproc($cmd);		
					// Mp4box Step 1
					$cmd1 = "cd ".$config['HD_DIR'];
					$cmd2 = $config['mp4box']." -add ".$vid."_temp.264#video:fps=".$vinfo['Video_FrameRate']." ".$vid.".m4v";
					$cmd = $cmd1." ; ".$cmd2;
					modproc($cmd);
					// Mp4box Step 2
					$cmd1 = "cd ".$config['HD_DIR'];
					$cmd2 = $config['mp4box']." -add ".$vid."_temp.mp4#audio ".$vid.".m4v";
					$cmd = $cmd1." ; ".$cmd2;
					modproc($cmd);
					// Mp4box Step 3
					$cmd1 = "cd ".$config['HD_DIR'];
					$cmd2 = $config['mp4box']." -inter 500 -itags album=na:artist=na:comment=na:created=na:name=na -lang English ".$vid.".m4v";
					$cmd = $cmd1." ; ".$cmd2;
					modproc($cmd);		
					// Rename m4v to Final file
					echo "\n".$nl."Command:\n".$nl."rename('".$tmpM4v."' , '".$hdFile."');\n\n";
					rename($tmpM4v, $hdFile);
					if(file_exists($tmpL)) @unlink($tmpL);
					if(file_exists($tmp264)) @unlink($tmp264);
					if(file_exists($tmpWav)) @unlink($tmpWav);
					if(file_exists($tmpMp4)) @unlink($tmpMp4);
					
				}
				
				if (file_exists($hdFile) && filesize($hdFile) > 100){
					$sql = "UPDATE video SET"
						." aspect_hd = '".$aspect."'"
						.", width_hd = '".$width_new_divby."'"
						.", height_hd = '".$height_new_divby."'"
						.", hd = '1'"
						.", hd_filename = '".(int)$vid.".mp4'" 
						." WHERE VID = '".(int)$vid."'"
					."";
					executeQuery($sql);
					//$conn->execute($sql);				
					echo "\n".$nl."SQL:\n".$nl.$sql."\n\n";
				}
				
			}
			break;
	
	
	
		/*|----------------------------------------------------------------------
		|*| Convert to iPod / iPhone
		|*|----------------------------------------------------------------------
		|*/ case "encode_ipod":
			if ($config['iphone_convert'] == '1') {
				if (function_exists("verify_exec_path"))
				verify_exec_path($config['mencoder'], "mencoder", 5);	
				$lavfopts = ($lavfopts == '') ? ' -lavfopts format=ipod' : $lavfopts.'';
				if ($e['encodepass'] == '1'){
					$ovc = str_replace($search, $replace, $ovc_profile[$e['action']][$e['ovc_profile']]['1pass']);
					$cmd = $config['mencoder']
						." ".$src
						." -o ".$podFile
						.$ovc 
						." -af resample=".$e['audio_sampling'].":0:0,volnorm=1:0.25"
						." -oac faac"
						." -faacopts mpeg=4:object=2:raw:br=".$e['audio_bitrate']
						." -of lavf"
						.$lavfopts
						.$ofps
						.$vf
						.$demuxer
					."";
				}elseif ($e['encodepass'] == '2'){
					// Pass 1
					$ovc = str_replace($search, $replace, $ovc_profile[$e['action']][$e['ovc_profile']]['2pass'][1]);
					$cmd1 = $config['mencoder']
						." ".$src
						." -o /dev/null"
						." -passlogfile ".$podLog
						.$ovc
						." -af resample=".$e['audio_sampling'].":0:0,volnorm=1:0.25"
						." -oac faac"
						." -faacopts mpeg=4:object=2:raw:br=".$e['audio_bitrate']
						." -of lavf"
						.$lavfopts
						.$ofps
						.$vf
						.$demuxer
					."";
					// Pass 2
					$ovc = str_replace($search, $replace, $ovc_profile[$e['action']][$e['ovc_profile']]['2pass'][2]);
					$cmd2 = $config['mencoder']
						." ".$src
						." -o ".$podFile
						." -passlogfile ".$podLog
						.$ovc
						." -af resample=".$e['audio_sampling'].":0:0,volnorm=1:0.25"
						." -oac faac"
						." -faacopts mpeg=4:object=2:raw:br=".$e['audio_bitrate']
						." -of lavf"
						.$lavfopts
						.$ofps
						.$vf
						.$demuxer
					."";
					$cmd = $cmd1." ; ".$cmd2;
				}
				modproc($cmd);		
				
				if (file_exists($podTmp)) @unlink($podTmp);
				if (file_exists($podLog)) @unlink($podLog);
				
				if (file_exists($podFile) && filesize($podFile) > 100){
					$cmd1 = "cd ".$config['IPHONE_DIR'];
					$cmd2 = $config['mp4box']." -inter 500 -itags album=na:artist=na:comment=na:created=na:name=na -lang English ".$podFile;
					$cmd = $cmd1." ; ".$cmd2;
					modproc($cmd);
				}
				
				if (file_exists($podFile) && filesize($podFile) > 100){

					if ($config['flv_convert'] == '1') {
						$sql_add = "";
					} else {
						$sql_add = 	", aspect_sd = '".$aspect."'"
									.", width_sd = '".$width_new_divby."'"
									.", height_sd = '".$height_new_divby."'"
									.", flvdoname = ''";
					}				
				
					$sql = "UPDATE video SET"
						." ipod_filename = '".(int)$vid.".mp4'" 
						.", iphone = '1'"
						.$sql_add						
						." WHERE VID = '".(int)$vid."'"
					."";
					executeQuery($sql);
					//$conn->execute($sql);
					echo "\n".$nl."SQL:\n".$nl.$sql."\n\n";

				} else {					
					//use ffmpeg to ouput mp4 if mencoder failed
					$cmd = $config['ffmpeg']." -i ".$src." -y -vcodec libx264 -vpre slow -vpre baseline -b 1000k -bt 750k -acodec libfaac -ac 2 -ar ".$e['audio_sampling']." -ab ".$e['audio_bitrate']." -s 640x360 -aspect 16:9 ".$podFile;
					modproc($cmd);
					//mp4box to fix fast start
					$cmd = $config['mp4box']. " -add ".$podFile." -isma ".$podFile.".atom";
					modproc($cmd);
					$cmd = "rm -f ".$podFile;
					modproc($cmd);
					$cmd = "mv ".$podFile.".atom ".$podFile;
					modproc($cmd);


					if ($config['flv_convert'] == '1') {
						$sql_add = "";
					} else {
						$sql_add = 	", aspect_sd = '".$aspect."'"
						.", width_sd = '".$width_new_divby."'"
						.", height_sd = '".$height_new_divby."'"
						.", flvdoname = ''";
					}				

					$sql = "UPDATE video SET"
						  ." ipod_filename = '".(int)$vid.".mp4'" 
    					  .", iphone = '1'"
						  .$sql_add						
						  ." WHERE VID = '".(int)$vid."'"
						  ."";
					executeQuery($sql);
					echo "\n".$nl."SQL:\n".$nl.$sql."\n\n";
				}
			}
			break;			
	}		
}

function postThumbs($vid,$src){
	global $config;
		
	$hdFile = $config['HD_DIR'].'/'.$vid.'.mp4';
	$flFile = $config['FLVDO_DIR'].'/'.$vid.'.flv';
	
	// Thumbs from HD first then flv if not found
	if(file_exists($src) && filesize($src) > 100){
		extract_video_thumbs($src, $vid);
	}elseif(file_exists($hdFile) && filesize($hdFile) > 100){
		extract_video_thumbs($hdFile, $vid);
	}else{
		extract_video_thumbs($flFile, $vid);
	}
}

function postConversion($vid,$src){
	global $config;
		
	$nl = "=========================================================\n";
	$flFile = $config['FLVDO_DIR'].'/'.$vid.'.flv';
        if ($config['approve'] == '0'){
	      $sql = "UPDATE video SET active = '1' WHERE VID = '".(int)$vid."'";
        }

        if ($config['approve'] == '1'){
	      $sql = "UPDATE video SET active = '0' WHERE VID = '".(int)$vid."'";
        }
	executeQuery($sql);
	echo "\n".$nl."SQL:\n".$nl.$sql."\n\n";
	
	// Delete original video?
	if($config['del_original_video'] == 1){
		if(file_exists($flFile) && filesize($flFile) > 100){
			@chmod($src, 0777);
			@unlink($src);
		}
	}	
}

function videoInfo($vi){
	foreach($vi['media_gen_out'] as $line){
		if (preg_match("/^(General_|Video_).+?\=.*/", $line)){
			$line_arr = explode("=", $line);
			$vinfo[$line_arr[0]] = $line_arr[1];
		}
	}
	foreach($vi['media_vid_out'] as $line){
		if (preg_match("/^(General_|Video_).+?\=.*/", $line)){
			$line_arr = explode("=", $line);
			$vinfo[$line_arr[0]] = $line_arr[1];
		}
	}	
	echo "\n".$nl."Media Descriptors Commands\n".$nl;
	echo "Comand 1: ".$vi['media_gen_cmd']."\n";
	echo "Comand 2: ".$vi['media_vid_cmd']."\n";
	echo "\n".$nl."Media Info\n".$nl;
	foreach ($vinfo as $key => $val){
		echo "\$vinfo['".$key."'] = '".$val."';\n";
	}
	return $vinfo;
}


/*|*****************************************
|*| Function :: DB SELECTOR
|*|*****************************************
|*/ function executeQuery($query){
		global $config;
		$link = mysql_connect($config['db_host'], $config['db_user'], $config['db_pass'], true);
		if($link){	
			mysql_select_db($config['db_name']);
			$result = mysql_query($query);
			if($result){
				$id = mysql_insert_id();
			}
			$err = mysql_error();
			mysql_close($link);
		}else{
			$err = 'Could not connect to '.$dbs.': ' . mysql_error();
		}
		$result = (intval($id) > 0) ? $id : $result;
		$result = ($err != "") ? "Sql Error :: ".$err."<br/>" : $result;
		return $result;
	}
	
	
?>


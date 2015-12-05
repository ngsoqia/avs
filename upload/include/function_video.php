<?php
defined('_VALID') or die('Restricted Access!');
require_once ($config['BASE_DIR']. '/include/function_thumbs.php');

function get_video_duration($video_path, $video_id)
{
    global $config;
    $cmd = $config['mplayer']. ' -quiet -nolirc -vo null -ao null -frames 0 -identify "' .$video_path. '"';
    log_conversion($config['LOG_DIR']. '/' .$video_id. '.log', $cmd);
    exec($cmd, $output);
    log_conversion($config['LOG_DIR']. '/' .$video_id. '.log', implode("\n", $output));
    while ( list($k,$v) = each($output) ) {
        if ( $length = strstr($v, 'ID_LENGTH=') ) {
            break;
        }
    }
    
    if ( isset($length) ) {
        $lx = explode('=', $length);
        
        return $lx['1'];
    }
    
    return '0';
}

function extract_video_thumbs ($video_path, $video_id) {

	global $config, $conn;
  
	// Logfile
	$logfile = $config['LOG_DIR'].'/'.$video_id.'.thumbs.log';
	@chmod($logfile,0777);
	@unlink($logfile);   
  
	// Default Thumbs Width & Height
	$thumb_width = $config['img_max_width'];
	$thumb_height = $config['img_max_height'];  
  
	// Get Duration of Video from Database
	$duration = get_video_duration($video_path, $video_id);

	// Only continue if source video exists
	if (file_exists($video_path)) {
  	
		// Temp & Final Thumbnails Directories
		$temp_thumbs_folder = $config['TMP_DIR'].'/thumbs/'.$video_id;
		$final_thumbs_folder = get_thumb_dir($video_id);

		// Create Thumbs Directories
		@mkdir($temp_thumbs_folder, 0777);
		@mkdir($final_thumbs_folder, 0777);

		// Duration - set se = start/end
		if ($duration > 5) {
			$seconds = $duration - 4;
			$se = 2;
		} elseif ($duration > 3) {
			$seconds = $duration - 2;
			$se = 1;
		} elseif ($duration > 2) {
			$seconds = $duration - 1;
			$se = 0.5;
		} else {
			$seconds = $duration;
			$se = 0;
		}

		// Divided by 20 thumbs
		$timeseg = $seconds/20;

		// Loop for 20 thumbs
		for ($i=0;$i<=20;$i++) {

			if ($i==0) {
				// Thumbnail Size
				$mplayer_scale = "scale=640:360";
				$ffmpeg_scale = "640x360";
				// Destination
				$final_thumbnail = $final_thumbs_folder.'/default.jpg';
				// Get Seek Time
				$ss = (5 * $timeseg) + $se;
			} else {
				// Thumbnail Size
				$mplayer_scale = "scale=".$thumb_width.":".$thumb_height."";
				$ffmpeg_scale = $thumb_width."x".$thumb_height;
				// Destination
				$final_thumbnail = $final_thumbs_folder.'/'.$i.'.jpg';
				// Get Seek Time
				$ss = ($i * $timeseg) + $se;
			}

			// Work out seconds to hh:mm:ss format
			$hms = "";
			$hours = intval($ss / 3600); 
			$hms .= str_pad($hours, 2, "0", STR_PAD_LEFT). ':';
			$minutes = intval(($ss / 60) % 60); 
			$hms .= str_pad($minutes, 2, "0", STR_PAD_LEFT). ':';
			$secs = intval($ss % 60); 
			$hms .= str_pad($secs, 2, "0", STR_PAD_LEFT);	
			$seek = $hms;			

			// Temporary filename convention. used by ffmpeg only.
			$temp_thumbs = $temp_thumbs_folder.'/%08d.jpg'; 

			// Temporary Thumbnail File
			$temp_thumb_file = $temp_thumbs_folder.'/00000001.jpg'; 


			// Set Permission and Delete Temporary Thumbnail File
			@chmod($temp_thumb_file,0777);
			@unlink($temp_thumb_file);			

			// Thumbnails extraction commands
			if ( $config['thumbs_tool'] == 'ffmpeg' ) {
				// FFMPEG Command
				$cmd = $config['ffmpeg']." -ss ".$seek." -i '".$video_path."' -r 1 -s ".$ffmpeg_scale." -vframes 1 -an -vcodec mjpeg -y ".$temp_thumbs;
			} else {      
				// Mplayer Command
				$cmd = $config['mplayer']." -zoom ".$video_path." -ss ".$seek." -nosound -frames 1 -vf ".$mplayer_scale." -vo jpeg:outdir=".$temp_thumbs_folder;
			}

			// Send data to logfile
			log_conversion($logfile, $cmd);

			// Execute Command
			exec($cmd, $output);

			// Send data to logfile
			log_conversion($logfile, implode("\n", $output));

			// Check if file exists
			if (file_exists($temp_thumb_file)) {
				copy($temp_thumb_file, $final_thumbnail);
				// Set permission
				@chmod($temp_thumb_file,0777);
			}

		}

		// Delete Temporary Thumbnail
		delete_directory($temp_thumbs_folder);

		// Figure out which was last thumb
		$i = 20;

		// Update Thumbs count in database
		$sql = "UPDATE video SET thumb = '1', thumbs = '".$i."' WHERE VID = '".$video_id."' LIMIT 1";
		$conn->execute($sql);
	}
  
	return;
}


function log_conversion($file_path, $text)
{   
    $file_dir = dirname($file_path);
    if( !file_exists($file_dir) or !is_dir($file_dir) or !is_writable($file_dir) ) {
        return false;
    }
                    
    $write_mode = 'w';
    if( file_exists($file_path) && is_file($file_path) && is_writable($file_path) ) {
        $write_mode = 'a';
    }
                                
    if( !$handle = fopen($file_path, $write_mode) ) {
        return false;
    }
                                                
    if( fwrite($handle, $text. "\n") == FALSE ) {
        return false;
    }
                                                            
    @fclose($handle);
}                                                        
?>

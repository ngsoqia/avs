<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();

if ( isset($_POST['submit_media']) ) {
    $filter                     = new VFilter();
    $phppath			        = $filter->get('phppath');
	$mencoder			        = $filter->get('mencoder');
	$mplayer			        = $filter->get('mplayer');
	$ffmpeg				        = $filter->get('ffmpeg');
	$metainject			        = $filter->get('metainject');
    $yamdi                      = $filter->get('yamdi');
	$thumbs_tool			    = $filter->get('thumbs_tool');
    $meta_tool                  = $filter->get('meta_tool');
 	//--mod--
 	$mp4box			    		= $filter->get('mp4box');
    $neroaacenc					= $filter->get('neroaacenc');
    $mediainfo			    	= $filter->get('mediainfo');
 	//--end--   
	$img_max_width			    = $filter->get('img_max_width', 'INTEGER');
	$img_max_height			    = $filter->get('img_max_height', 'INTEGER');
	$video_max_size			    = $filter->get('video_max_size', 'INTEGER');
	$video_allowed_extensions	= $filter->get('video_allowed_extensions');
    $video_allowed_extensions   = str_replace(' ', '', $video_allowed_extensions);
    $video_allowed_extensions   = str_replace("\r", '', $video_allowed_extensions);
    $video_allowed_extensions   = str_replace("\n", '', $video_allowed_extensions);
	$post_max_size			    = str_replace('M', '', ini_get('post_max_size'));
	$upload_max_filesize		= str_replace('M', '', ini_get('upload_max_filesize'));
    
	if ( $phppath == '' )
		$errors[] = 'Path to PHP CLI binary cannot be left blank!';
	if ( $mencoder == '' )
		$errors[] = 'Path to Mencoder binary cannot be left blank!';
	if ( $ffmpeg == '' )
		$errors[] = 'Path to ffmpeg binary cannot be left blank!';
	if ( $mplayer == '' )
		$errors[] = 'Path to MPlayer binary cannot be left blank!';
	if ( $metainject == '' && $meta_tool == 'flvtool2' )
		$errors[] = 'Path to FLVTool2 binary cannot be left blank!';
	if ( $yamdi == '' && $meta_tool == 'yamdi' )
		$errors[] = 'Path to Yamdi binary cannot be left blank!';
	if ( $img_max_width == '' )
		$errors[] = 'Max thumbnail width (in pixels) cannot be left blank!';
	elseif ( !is_numeric($img_max_width) )
		$errors[] = 'Max thumbnail width (in pixels) must have a numeric value!';
	if ( $img_max_height == '' )
		$errors[] = 'Max thumbnail height (in pixels) cannot be left blank!';
	elseif ( !is_numeric($img_max_height) )
		$errors[] = 'Max thumbnail height (in pixels) must have a numeric value!';
	if ( $video_max_size == '' )
		$errors[] = 'Video max size field cannot be blank!';
	else {
		settype($video_max_size, 'integer');
		settype($post_max_size, 'integer');
		settype($upload_max_filesize, 'integer');
		if ( $video_max_size > $post_max_size || $video_max_size > $upload_max_filesize )
			$errors[] = 'Video maximum size cannot be bigger then the php values for \'post_max_size\' or \'upload_max_filesize\'.<br> Please edit php settings (php.ini) and increase the post_max_size and upload_max_filesize values!';
	}
	if ( $video_allowed_extensions == '' )
		$errors[] = 'Video allowed extensions field cannot be empty!';
	elseif ( !preg_match('/^[a-zA-Z0-9, ]*$/', $video_allowed_extensions) )
		$errors[] = 'Video allowed extensions field can only contain alpha-numeric characters, comas and spaces!';
	else {
		$video_allowed_extensions = str_replace(' ', '', $video_allowed_extensions);
	}
    	
	if ( !$errors ) {
        $config['phppath']                  = $phppath;
        $config['mplayer']                  = $mplayer;
        $config['mencoder']                 = $mencoder;
        $config['ffmpeg']                   = $ffmpeg;
        $config['metainject']               = $metainject;
        $config['yamdi']                    = $yamdi;
        $config['thumbs_tool']              = $thumbs_tool;
        $config['meta_tool']                = $meta_tool;
        $config['img_max_width']            = $img_max_width;
        $config['img_max_height']           = $img_max_height;
        $config['video_max_size']           = $video_max_size;
        //--mod--
        $config['mp4box']                  = $mp4box;
		$config['mediainfo']               = $mediainfo;
		$config['neroaacenc']              = $neroaacenc;
        //--end--
        $config['video_allowed_extensions'] = $video_allowed_extensions;
		update_config($config);
        update_smarty();
		$messages[] = 'Conversion settings updated successfully!';
	}
}
?>

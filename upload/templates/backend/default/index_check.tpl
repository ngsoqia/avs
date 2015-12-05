     <div id="rightcontent">
        {include file="errmsg.tpl"}
        <div id="right">
        <div align="center">
        <h2>System Check</h2>
        <div class="check">FLV VIDEO Directory</div>
        <div class="check_output"><b>{$paths.flvideo}</b> ({$paths_perms.flvideo}) ({$flvideo_dir})</div><br>
        <div class="check">VIDEO Directory</div>
        <div class="check_output"><b>{$paths.video}</b> ({$paths_perms.video}) ({$video_dir})</div>
        <div class="check">THUMBS Directory</div>
        <div class="check_output"><b>{$paths.thumbs}</b> ({$paths_perms.thumbs}) ({$thumbs_dir})</div>
		<div class="check">ALBUMS Directory</div>
		<div class="check_output"><b>{$paths.albums_dir}</b> ({$paths_perms.albums_dir}) ({$albums_dir})</div>
		<div class="check">PHOTOS Directory</div>
		<div class="check_output"><b>{$paths.photo_dir}</b> ({$paths_perms.photo_dir}) ({$photo_dir})</div>
		<div class="check">PHOTOS Thumbs Directory</div>
		<div class="check_output"><b>{$paths.photo_tmb_dir}</b> ({$paths_perms.photo_tmb_dir}) ({$photo_tmb_dir})</div>
		<div class="check">GAMES Directory</div>
		<div class="check_output"><b>{$paths.game_dir}</b> ({$paths_perms.game_dir}) ({$game_dir})</div>
		<div class="check">GAMES Thumbs Directory</div>
		<div class="check_output"><b>{$paths.game_tmb_dir}</b> ({$paths_perms.game_tmb_dir}) ({$game_tmb_dir})</div>
		<div class="check">AVATARS Directory</div>
		<div class="check_output"><b>{$paths.avatars_dir}</b> ({$paths_perms.avatars_dir}) ({$avatars_dir})</div>
		<div class="check">AVATARS Orig Directory</div>
		<div class="check_output"><b>{$paths.avatars_o_dir}</b> ({$paths_perms.avatars_o_dir}) ({$avatars_o_dir})</div>
		<div class="check">VIDEO Categories Directory</div>
		<div class="check_output"><b>{$paths.video_cat}</b> ({$paths_perms.video_cat}) ({$video_cat_dir})</div>
		<div class="check">PHOTO Categories Directory</div>
		<div class="check_output"><b>{$paths.photo_cat}</b> ({$paths_perms.photo_cat}) ({$photo_cat_dir})</div>
		<div class="check">GAME Categories Directory</div>
		<div class="check_output"><b>{$paths.game_cat}</b> ({$paths_perms.game_cat}) ({$game_cat_dir})</div>
        <div class="check">TMP Albums Directory</div>
        <div class="check_output"><b>{$paths.albums}</b> ({$paths_perms.albums}) ({$tmp_dir}/albums)</div>
        <div class="check">TMP Avatars Directory</div>
        <div class="check_output"><b>{$paths.avatars}</b> ({$paths_perms.avatars}) ({$tmp_dir}/avatars)</div>
        <div class="check">TMP Downloads Directory</div>
        <div class="check_output"><b>{$paths.downloads}</b> ({$paths_perms.downloads}) ({$tmp_dir}/downloads)</div>
        <div class="check">TMP Logs Directory</div>
        <div class="check_output"><b>{$paths.logs}</b> ({$paths_perms.logs}) ({$tmp_dir}/logs)</div>
        <div class="check">TMP Sessions Directory</div>
        <div class="check_output"><b>{$paths.sessions}</b> ({$paths_perms.sessions}) ({$tmp_dir}/sessions)</div>
        <div class="check">TMP Thumbs Directory</div>
        <div class="check_output"><b>{$paths.thumbs}</b> ({$paths_perms.thumbs}) ({$tmp_dir}/thumbs)</div>
        <div style="clear: both;"></div>
        <br>
        <div class="check">Safe Mode</div>
        <div class="check_output">{if $restrictions.safe_mode == ''}passed{else}{$restrictions.safe_mode}{/if}&nbsp;</div>
        <div class="check">Open Basedir</div>
        <div class="check_output">{if $restrictions.open_basedir == ''}passed{else}{$restrictions.open_basedir}{/if}&nbsp;</div>
        <div style="clear: both;"></div>
        <br>
        <div class="check">Maximum Upload Filesize</div>
        <div class="check_output"><b>{$upload.max_upload_size}</b> (max_upload_filesize)</div>
        <div class="check">Maximum Post Filesize</div>
        <div class="check_output"><b>{$upload.max_post_size}</b> (max_post_size)</div>
        <div style="clear: both;"></div>
        <br>
        <div class="check">PHP CLI</div>
        <div class="check_output"><b>{$binaries.php}</b> ({$phppath})</div>
        <div class="check">MEncoder</div>
        <div class="check_output"><b>{$binaries.mencoder}</b> ({$mencoder})</div>
        <div class="check">MPlayer</div>
        <div class="check_output"><b>{$binaries.mplayer}</b> ({$mplayer})</div>
        <div class="check">FFMpeg</div>
        <div class="check_output"><b>{$binaries.ffmpeg}</b> ({$ffmpeg})</div>
        <div class="check">FLVTool2</div>
        <div class="check_output"><b>{$binaries.metainject}</b> ({$metainject})</div>
        

        <div class="check">Mediainfo</div>
        <div class="check_output"><b>{$binaries.mediainfo}</b> ({$mediainfo})</div>
        <div class="check">MP4Box</div>
        <div class="check_output"><b>{$binaries.MP4Box}</b> ({$mp4box})</div>
        <div class="check">NeroAacEnc</div>
        <div class="check_output"><b>{$binaries.neroAacEnc}</b> ({$neroaacenc})</div>
        
        {if $formats_error == '' }
        <div style="clear: both;"></div>
        <br>
        <div class="check">JPEG Support</div>
        <div class="check_output"><b>{$formats.jpeg}</b> ({$formats_paths.jpeg})</div>
        <div class="check">LAME Support</div>
        <div class="check_output"><b>{$formats.lame}</b> ({$formats_paths.lame})</div>
        <div class="check">XVID Support</div>
        <div class="check_output"><b>{$formats.xvid}</b> ({$formats_paths.xvid})</div>
        <div class="check">THEORA Support</div>
        <div class="check_output"><b>{$formats.theora}</b> ({$formats_paths.theora}</div>
        <div class="check">X264 Support</div>
        <div class="check_output"><b>{$formats.x264}</b> ({$formats_paths.x264})</div>
        <div class="check">FAAC Support</div>
        <div class="check_output"><b>{$formats.faac}</b> ({$formats_paths.faac})</div>
        <div style="clear:both;"></div>
        {else}
		<div style="clear: both;"></div>
		<br/>
        <div id="errorbox" style="width: 808px;">{$formats_error}</div>
        {/if}
		<br/><br/>
        </div>
        </div>
     </div>
     

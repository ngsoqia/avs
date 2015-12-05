     <div id="rightcontent">
        {include file="errmsg.tpl"}
        <div id="right">
        <div align="center">
        <h2>Video Conversion Configuration</h2>
        <div id="simpleForm">
        <form name="media_settings" method="POST" action="index.php?m=media">
        <fieldset>
        <legend>Paths &amp; Settings</legend>
            <label for="phppath" style="width: 35%;">PHP CLI Path: </label>
            <input type="text" name="phppath" value="{$phppath}" class="large"><br>
            <label for="mplayer" style="width: 35%;">MPlayer Path: </label>
            <input type="text" name="mplayer" value="{$mplayer}" class="large"><br>
            <label for="mencoder" style="width: 35%;">Mencoder Path: </label>
            <input type="text" name="mencoder" value="{$mencoder}" class="large"><br>
            <label for="ffmpeg" style="width: 35%;">FFMpeg Path: </label>
            <input type="text" name="ffmpeg" value="{$ffmpeg}" class="large"><br>
            <label for="metainject" style="width: 35%;">FLVtool2 Path: </label>
            <input type="text" name="metainject" value="{$metainject}" class="large"><br>
            <label for="yamdi" style="width: 35%;">Yamdi Path: </label>
            <input type="text" name="yamdi" value="{$yamdi}" class="large"><br>
            
            <label for="mp4box" style="width: 35%;">MP4box Path: </label>
            <input type="text" name="mp4box" value="{$mp4box}" class="large"><br>
            <label for="neroaacenc" style="width: 35%;">neroAccEnc Path: </label>
            <input type="text" name="neroaacenc" value="{$neroaacenc}" class="large"><br>  
            <label for="mediainfo" style="width: 35%;">mediainfo Path: </label>
            <input type="text" name="mediainfo" value="{$mediainfo}" class="large"><br>             
            <br /><small>Please use System Check to verify if the above modules are installed or if their paths are correct.</small><br /><br />
            <label for="thumbs_tool" style="width: 35%;">Thumbnail Generation Tool: </label>
            <select name="thumbs_tool">
            <option value="mplayer"{if $thumbs_tool == 'mplayer'} selected="selected"{/if}>MPlayer</option>
            <option value="ffmpeg"{if $thumbs_tool == 'ffmpeg'} selected="selected"{/if}>FFMpeg</option>
            </select><br>
            <label for="meta_tool" style="width: 35%;">META Injection Tool: </label>
            <select name="meta_tool">
            <option value="flvtool2"{if $meta_tool == 'flvtool2'} selected="selected"{/if}>FLVTool2</option>
            <option value="yamdi"{if $meta_tool == 'yamdi'} selected="selected"{/if}>Yamdi</option>
            </select><br>           
            <label for="img_max_width" style="width: 35%;">Max thumbnail width (in pixels): </label>
            <input type="text" name="img_max_width" value="{$img_max_width}" class="small"><br>
            <label for="img_max_height" style="width: 35%;">Max thumbnail height (in pixels): </label>
            <input type="text" name="img_max_height" value="{$img_max_height}" class="small"><br>
            <label for="allowed_extensions" style="width: 35%;">Allowed video extensions (coma separated): </label>
            <textarea rows="4" name="video_allowed_extensions" style="overflow: hidden;">{$video_allowed_extensions|wordwrap:48:"\n":true}</textarea><br>
            <label for="video_max_size" style="width: 35%;">Max upload video filesize (in MB): </label>
            <input type="text" name="video_max_size" value="{$video_max_size}" class="small"><br>
        </fieldset>
        <div style="text-align: center;">
            <input type="submit" name="submit_media" value="Update Conversion Settings" class="button">
        </div>
        </form>
        </div>
        </div>
        </div>
     </div>

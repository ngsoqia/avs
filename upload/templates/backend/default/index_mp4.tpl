     <div id="rightcontent">
        {include file="errmsg.tpl"}
        <div id="right">
        <div align="center">
        <h2>HD (High Definition / MP4 / H.264) Conversion Settings</h2>
        <div id="simpleForm">
        <form name="media_settings" method="POST" action="index.php?m=mp4">
        <fieldset>
        <legend>HD Configuration</legend>
            <label for="hd_convert" style="width: 35%;">HD Video Conversion: </label>
            <select name="hd_convert">
            <option value="0"{if $hd_convert eq "0"} selected="selected"{/if}>Disabled</option>
            <option value="1"{if $hd_convert eq "1"} selected="selected"{/if}>Enabled</option>
            </select><small>HD conversion process is VERY resource-intensive.</small><br>
         </fieldset>    

          <fieldset> 
          <legend>HD Encoding Settings</legend>  
            <!-- Encoding Passes -->
	        <label for="hd_encodepass" style="width: 35%;">Encoding Passes: </label>
	        <select name="hd_encodepass">
	        <option value="1"{if $sm_encodepass eq "1"} selected="selected"{/if}>1 Pass</option>
	        <option value="2"{if $sm_encodepass eq "2"} selected="selected"{/if}>2 Pass</option>
	        </select>
	        <small style="color:#bbb; font-weight:0.8em;">Default: <i>2 Pass</i> (higher quality, longer conversion time)</small><br> 

	        <!-- OVC Profile -->
	        <label for="hd_ovc_profile" style="width: 35%;">OVC Profile: </label>
	        <select name="hd_ovc_profile">
	        
	        <option value="quality"{if $sm_ovc_profile eq "quality"} selected="selected"{/if}>Quality</option>
	        <option value="standard"{if $sm_ovc_profile eq "standard"} selected="selected"{/if}>Standard</option>
	        <option value="nightfly"{if $sm_ovc_profile eq "nightfly"} selected="selected"{/if}>Nightfly</option>
	        <option value="massanti"{if $sm_ovc_profile eq "massanti"} selected="selected"{/if}>Massanti</option>
	        </select>
	        <small style="color:#bbb; font-weight:0.8em;">Default: <i>Standard</i></small><br> 

	        <!-- Bitrate Type -->
	        <script>
	        {literal}
	        function hdvbr(id){
	        	var val = document.getElementById(id).value
	        	if(val == 'fix'){
	        		document.getElementById('btr').style.display = "block"
	        	}else{
	        		document.getElementById('btr').style.display = "none"
	        	}
	        }
	        {/literal}
	        </script>
	        <label for="hd_ref_type" style="width: 35%;">Video Bitrate: </label>
	        <select name="hd_ref_type" id="hdvdr" onchange="hdvbr(this.id)">
	        <option value="standard"{if $sm_ref_type eq "standard"} selected="selected"{/if}>Auto Calculated</option>
	        <option value="fix"{if $sm_ref_type eq "fix"} selected="selected"{/if}>Fixed</option>
	        </select>
	        <small style="color:#bbb; font-weight:0.8em;">Default: <i>Auto Calculated</i></small><br>        		       
 			<!-- Video Bit-Rate -->  
 			<div id="btr" {if $sm_ref_type eq "standard"}style="display:none;"{else}style="display:block;"{/if}>        	
	        <label for="hd_ref_bitrate" style="width: 35%;">Fixed Video Bit-rate (in Kbps): </label>
	        <input type="text" name="hd_ref_bitrate" value="{$sm_ref_bitrate}">
	        <small style="color:#bbb; font-weight:0.8em;">Default: <i>1500</i></small><br> 
			</div>
			<!-- Blackbars -->
	        <label for="hd_blackbars" style="width: 35%;">Blackbars: </label>
	        <select name="hd_blackbars">
	        <option value="1"{if $sm_blackbars eq "1"} selected="selected"{/if}>Yes</option>
	        <option value="0"{if $sm_blackbars eq "0"} selected="selected"{/if}>No</option>
	        </select>
	        <small style="color:#bbb; font-weight:0.8em;">Default: <i>No</i></small><br> 	        
	          		       
	        <!-- Resize Base -->
	        <label for="hd_resize_base" style="width: 35%;">Resize Base: </label>
	        <select name="hd_resize_base">
	        <option value="area"{if $sm_resize_base eq "area"} selected="selected"{/if}>Area</option>
	        <option value="width"{if $sm_resize_base eq "width"} selected="selected"{/if}>Width</option>
	        <option value="height"{if $sm_resize_base eq "height"} selected="selected"{/if}>Height</option>
	        <option value="both"{if $sm_resize_base eq "both"} selected="selected"{/if}>Both</option>
	        <option value="crop"{if $sm_resize_base eq "crop"} selected="selected"{/if}>Crop</option>
	        </select>
	        <small style="color:#bbb; font-weight:0.8em;">Default: <i>Both</i></small><br>  	
	        <!-- Resize Width -->
	        <label for="hd_resize_width" style="width: 35%;">Resize Width (px): </label>
	        <input type="text" name="hd_resize_width" value="{$sm_resize_width}">
	        <small style="color:#bbb; font-weight:0.8em;">Default: <i>1280</i></small><br>
	         <!-- Resize Height -->
	        <label for="hd_resize_height" style="width: 35%;">Resize Height (px): </label>
	        <input type="text" name="hd_resize_height" value="{$sm_resize_height}">
	        <small style="color:#bbb; font-weight:0.8em;">Default: <i>720</i></small><br>  

	        <!-- Audio Bit-Rate -->          	
	        <label for="hd_audio_bitrate" style="width: 35%;">Audio Bitrate (in Kbps): </label>
	        <input type="text" name="hd_audio_bitrate" value="{$sm_audio_bitrate}">
	        <small style="color:#bbb; font-weight:0.8em;">Default: <i>256</i></small><br>            
	        <!-- Audio Sampling -->
	        <label for="hd_audio_sampling" style="width: 35%;">Audio Sampling rate (in KHz): </label>
	        <input type="text" name="hd_audio_sampling" value="{$sm_audio_sampling}">
	        <small style="color:#bbb; font-weight:0.8em;">Default: <i>44100</i></small><br>       
	        
	        
	        <!-- Encode Condition -->
	        <label for="condition_value" style="width: 35%;">Encode in HD if video width higher than (px): </label>
	        <input type="text" name="condition_value" value="{$condition_value}">
	        <small style="color:#bbb; font-weight:0.8em;">Default: <i>720</i></small><br><br>
			<small>Smaller videos are not considered to be HD, and will be converted only in FLV (SD) format.</small>

                        
        </fieldset>
        <div style="text-align: center;">
            <input type="submit" name="submit_media_mp4" value="Update HD Settings" class="button">
        </div>
        </form>
        </div>
        </div>
        </div>
     </div>

     <div id="rightcontent">
        {include file="errmsg.tpl"}
        <div id="right">
        <div align="center">
        <h2>Mobile / Tablet (MP4 / H.264) Conversion Settings</h2>
        <div id="simpleForm">
        <form name="media_settings" method="POST" action="index.php?m=iphone">
        <fieldset>
        <legend>Mobile Configuration</legend>
            <label for="iphone_convert" style="width: 35%;">Mobile / Tablet Video Conversion: </label>
            <select name="iphone_convert">
            <option value="0"{if $iphone_convert eq "0"} selected="selected"{/if}>Disabled</option>
            <option value="1"{if $iphone_convert eq "1"} selected="selected"{/if}>Enabled</option>
            </select><br>
		</fieldset>    
            
        <fieldset> 
        <legend>Mobile Encoding Settings</legend>  
            <!-- Encoding Passes -->
	        <label for="iphone_encodepass" style="width: 35%;">Encoding Passes: </label>
	        <select name="iphone_encodepass">
	        <option value="1"{if $sm_encodepass eq "1"} selected="selected"{/if}>1 Pass</option>
	        <option value="2"{if $sm_encodepass eq "2"} selected="selected"{/if}>2 Pass</option>
	        </select>
	        <small style="color:#bbb; font-weight:0.8em;">Default: <i>2 Pass</i></small><br> 
	        
	        <!-- OVC Profile -->
	        <label for="iphone_ovc_profile" style="width: 35%;">OVC Profile: </label>
	        <select name="iphone_ovc_profile">
	        <option value="standard"{if $sm_ovc_profile eq "standard"} selected="selected"{/if}>Standard</option>
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
	        <label for="iphone_ref_type" style="width: 35%;">Video Bitrate: </label>
	        <select name="iphone_ref_type" id="hdvdr" onchange="hdvbr(this.id)">
	        <option value="standard"{if $sm_ref_type eq "standard"} selected="selected"{/if}>Auto Calculated</option>
	        <option value="fix"{if $sm_ref_type eq "fix"} selected="selected"{/if}>Fixed</option>
	        </select>
	        <small style="color:#bbb; font-weight:0.8em;">Default: <i>Auto Calculated</i></small><br>        		       
 			<!-- Video Bit-Rate -->  
 			<div id="btr" {if $sm_ref_type eq "standard"}style="display:none;"{else}style="display:block;"{/if}>        	
	        <label for="iphone_ref_bitrate" style="width: 35%;">Fixed Video Bitrate (in Kbps): </label>
	        <input type="text" name="iphone_ref_bitrate" value="{$sm_ref_bitrate}">
	        <small style="color:#bbb; font-weight:0.8em;">Default: <i>1500</i></small><br> 
			</div>
			<!-- Blackbars -->
	        <label for="iphone_blackbars" style="width: 35%;">Blackbars: </label>
	        <select name="iphone_blackbars">
	        <option value="1"{if $sm_blackbars eq "1"} selected="selected"{/if}>Yes</option>
	        <option value="0"{if $sm_blackbars eq "0"} selected="selected"{/if}>No</option>
	        </select>
	        <small style="color:#bbb; font-weight:0.8em;">Default: <i>No</i></small><br> 	        
	          		       
	        <!-- Resize Base -->
	        <label for="iphone_resize_base" style="width: 35%;">Resize Base: </label>
	        <select name="iphone_resize_base">
	        <option value="area"{if $sm_resize_base eq "area"} selected="selected"{/if}>Area</option>
	        <option value="width"{if $sm_resize_base eq "width"} selected="selected"{/if}>Width</option>
	        <option value="height"{if $sm_resize_base eq "height"} selected="selected"{/if}>Height</option>
	        <option value="both"{if $sm_resize_base eq "both"} selected="selected"{/if}>Both</option>
	        <option value="crop"{if $sm_resize_base eq "crop"} selected="selected"{/if}>Crop</option>
	        </select>
	        <small style="color:#bbb; font-weight:0.8em;">Default: <i>Both</i></small><br>  	
	        <!-- Resize Width -->
	        <label for="iphone_resize_width" style="width: 35%;">Resize Width (px): </label>
	        <input type="text" name="iphone_resize_width" value="{$sm_resize_width}">
	        <small style="color:#bbb; font-weight:0.8em;">Default: <i>768</i></small><br>
	         <!-- Resize Height -->
	        <label for="iphone_resize_height" style="width: 35%;">Resize Height (px): </label>
	        <input type="text" name="iphone_resize_height" value="{$sm_resize_height}">
	        <small style="color:#bbb; font-weight:0.8em;">Default: <i>432</i></small><br>  

	        <!-- Audio Bit-Rate -->          	
	        <label for="iphone_audio_bitrate" style="width: 35%;">Audio Bitrate (in Kbps): </label>
	        <input type="text" name="iphone_audio_bitrate" value="{$sm_audio_bitrate}">
	        <small style="color:#bbb; font-weight:0.8em;">Default: <i>128</i></small><br>            
	        <!-- Audio Sampling -->
	        <label for="iphone_audio_sampling" style="width: 35%;">Audio Sampling rate (in KHz): </label>
	        <input type="text" name="iphone_audio_sampling" value="{$sm_audio_sampling}">
	        <small style="color:#bbb; font-weight:0.8em;">Default: <i>44100</i></small><br>       
	        

                        
        </fieldset>
        <div style="text-align: center;">
            <input type="submit" name="submit_media_mp4" value="Update Mobile Settings" class="button">
        </div>
        </form>
        </div>
        </div>
        </div>
     </div>

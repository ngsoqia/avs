<script type="text/javascript">
var video_allowed_extensions = /{$allowed_video_extensions}$/i;
var lang_ext_invalid = "{t c='upload.video_ext_invalid' s=$video_extensions}";
var lang_submit = "{t c='upload.video_submit'}";
</script>
<script type="text/javascript" src="{$relative_tpl}/js/jquery.upload-0.1.js"></script>

<div class="container">
	<div class="row">
		<div class="col-md-4">
			<div class="visible-sm visible-xs">
				{include file='quick_jumps.tpl'}
			</div>
			<div class="hidden-sm hidden-xs">
				{include file='user_info.tpl'}
			</div>
		</div>
		<div class="col-md-8">
			<div class="panel panel-default">
				<div class="panel-heading">
					{t c='upload.video_title'}
				</div>
				<div class="panel-body">
				
					<div class="text-warning m-b-20">{t c='upload.terms' s=$site_name}</div>				

					<form class="form-horizontal" name="uploadVideo" id="uploadVideo" method="post" enctype="multipart/form-data" target="_self" action="{$relative}/upload/video">
					
						<input type="hidden" name="MAX_FILE_SIZE" value="{$upload_max_size}" />
						<input type="hidden" name="UPLOAD_IDENTIFIER" id="UPLOAD_IDENTIFIER" value="{$upload_id}" />
						<input type="hidden" name="video_upload_started" />
						
						<div  id="upload_title" class="form-group">
							<label for="upload_video_title" class="col-lg-3 control-label">{t c='global.title'}</label>
							<div class="col-lg-9">
								<input name="video_title" type="text" class="form-control" value="{$video.title}" id="upload_video_title" placeholder="{t c='global.title'}" />
								<div id="video_title_error" class="text-danger m-t-5" style="display: none;">{t c='upload.video_title_empty'}</div>
							</div>
						</div>

						<div id="upload_tags" class="form-group">
							<label for="upload_video_keywords" class="col-lg-3 control-label">{t c='global.tags'}</label>
							<div class="col-lg-9">
								<textarea name="video_keywords" id="upload_video_keywords" rows="2" class="form-control" placeholder="{t c='upload.tags_expl'}">{$video.keywords}</textarea>
								<div id="video_tags_error" class="text-danger m-t-5" style="display: none;">{t c='upload.video_tags_empty'}</div>
							</div>
						</div>
						
						<div id="upload_category" class="form-group">
							<label for="upload_video_category" class="col-lg-3 control-label">{t c='global.category'}</label>
							<div class="col-lg-9">
								<select name="video_category" id="upload_video_category" class="form-control">
									<option value="0"{if $video.category == '0'} selected="selected"{/if}>-----</option>
									{section name=i loop=$categories}
									<option value="{$categories[i].CHID}"{if $video.category == $categories[i].CHID} selected="selected"{/if}>{$categories[i].name|escape:'html'}</option>
									{/section}
								</select>
								<div id="video_category_error" class="text-danger m-t-5" style="display: none;">{t c='global.category_empty'}</div>
							</div>
						</div>

						<div id="upload_file" class="form-group">
							<label for="upload_video_file" class="col-lg-3 control-label">{t c='global.file'}</label>
							<div class="col-lg-9">
							
							<div id="get_video_file" class="btn btn btn-primary no-radius-r pull-left" onclick="getFile('upload_video_file')">{t c='file.choose_file'}</div>
							<div class="file-box">
								<span id="upvname">{t c='file.no_file'}</span>
								<div style="height: 0px; width: 0px;overflow:hidden;">
									<input name="video_file" type="file" id="upload_video_file" onChange="sub(this,'upvname','nofile')" />								
								</div>
								<input type="hidden" id="nofile" value="{t c='file.no_file'}">
							</div>
							<div class="clearfix"></div>
							<div id="video_file_error" class="text-danger m-t-5" style="display: none;">{t c='upload.video_file_empty'}</div>
							<div id="video_file_ext_error" class="text-danger m-t-5" style="display: none;"></div>
							</div>
						</div>						
						
						<div class="form-group">
							<label class="col-lg-3 control-label">{t c='upload.anonymous'}</label>
							<div class="col-lg-9">
								<div class="radio">
									<label>
										<input name="video_anonymous" type="radio" value="no" id="upload_video_anonymous_no" {if $video.anonymous == 'no'} checked="checked"{/if} />
										{t c='upload.anonymous_yes'}
									</label>
								</div>
								<div class="radio">
									<label>
										<input name="video_anonymous" type="radio" value="yes" id="upload_video_anonymous_yes" {if $video.anonymous == 'yes'} checked="checked"{/if} />
										{t c='upload.anonymous_no'}
									</label>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-lg-3 control-label">{t c='upload.privacy'}</label>
							<div class="col-lg-9">
								<div class="radio">
									<label>
										<input name="video_privacy" type="radio" value="public" id="upload_video_privacy_public" {if $video.privacy == 'public'} checked="checked"{/if} />
										{t c='upload.video_public'}
									</label>
								</div>
								<div class="radio">
									<label>
										<input name="video_privacy" type="radio" value="private" id="upload_video_privacy_private" {if $video.privacy == 'private'} checked="checked"{/if} />
										{t c='upload.video_private'}
									</label>
								</div>
							</div>
						</div>


						<div id="upload_status" class="form-group" style="display:none;">
							<div id="upload_progress" class="col-lg-9 col-lg-offset-3">
								<div class="progress progress-striped active hidden-xs">
									<div id="bar" class="progress-bar progress-bar-warning" style="width: 0;">&nbsp;</div>
								</div>
								<div class="progress progress-striped active visible-xs">
									<div class="progress-bar progress-bar-warning" style="width: 100%"></div>
								</div>								
							</div>
							<div class="col-lg-9 col-lg-offset-3 hidden-xs">
								<div id="upload_time"></div>
								<div id="upload_size"></div>
							</div>
						</div>
						
						<div id="upload_message" style="display: none;"></div>
						
						<div class="form-group">
							<div class="col-lg-9 col-lg-offset-3">
								<input name="submit_upload_video" type="button" id="upload_video_submit" value="{t c='upload.video_button'}" class="btn btn-primary" />
							</div>
						</div>
						{t c='upload.contr' s=$site_name}
					</form>
				</div>
			</div>	
		</div>
	</div>
</div>
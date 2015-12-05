     <div id="rightcontent">
        {include file="errmsg.tpl"}
        <div id="right">
        <div align="center">
        <div id="simpleForm">
        <form name="edit_game" method="POST" enctype="multipart/form-data" action="games.php?m=edit&GID={$game[0].GID}">
        <fieldset>
        <legend>Game Information</legend>
            <label for="GID">Game ID: </label>
            <input type="text" name="GID" value="{$game[0].GID}" readonly="readonly"><br>
            <label for="username">Username: </label>
            <input type="text" name="username" value="{$game[0].UID}" readonly="readonly" class="large"><br>
            <label for="title">Title: </label>
            <input type="text" name="title" value="{$game[0].title}" class="large"><br>
            <label for="tags">Keywords (tags): </label>
            <textarea name="tags">{$game[0].tags}</textarea><br>
            <label for="category">Category: </label>
            <select name="category">
            {section name=i loop=$categories}
            <option value="{$categories[i].category_id}"{if $game[0].category == $categories[i].category_id} selected="selected"{/if}>{$categories[i].category_name|escape:'html'}</option>
            {/section}
            </select><br>
            <label for="type">Type: </label>
            <select name="type">
            <option value="public"{if $game[0].type == 'public'} selected="selected"{/if}>public</option>
            <option value="private"{if $game[0].type == 'private'} selected="selected"{/if}>private</option>
            </select><br>
            <label for="status">Approved (active): </label>
            <select name="status">
            <option value="1"{if $game[0].status == '1'} selected="selected"{/if}>Yes</option>
            <option value="0"{if $game[0].status == '0'} selected="selected"{/if}>No</option>
            </select><br>
            <label for="be_commented">Can be commented? </label>
            <select name="be_commented">
            <option value="yes"{if $game[0].be_comment == 'yes'} selected="selected"{/if}>Yes</option>
            <option value="no"{if $game[0].be_comment == 'no'} selected="selected"{/if}>No</option>
            </select><br>
            <label for="be_rated">Can be rated? </label>
            <select name="be_rated">
            <option value="yes"{if $game[0].be_rated == 'yes'} selected="selected"{/if}>Yes</option>
            <option value="no"{if $game[0].be_rated == 'no'} selected="selected"{/if}>No</option>
            </select><br>
        </fieldset>
        <fieldset>
        <legend>Game Thumb</legend>
            <label for="current_thumb">Current Thumb: </label>&nbsp;
            <img src="{$baseurl}/media/games/tmb/{$game[0].GID}.jpg" /><br />
            <label for="thumb">Upload Thumb: </label>
            <input name="thumb" type="file" id="thumb" /><br>
        </fieldset>
        <div id="advanced" style="display: none;">
        <fieldset>
        <legend>Advanced Configuration</legend>
            <label for="rate">Rating: </label>
            <input type="text" name="rate" value="{$game[0].rate}"><br>
            <label for="ratedby">Rated by: </label>
            <input type="text" name="ratedby" value="{$game[0].ratedby}"><br>
            <label for="total_plays">Plays: </label>
            <input type="text" name="total_plays" value="{$game[0].total_plays}"><br>
            <label for="total_comments">Comments: </label>
            <input type="text" name="total_comments" value="{$game[0].total_comments}"><br>
            <label for="total_favorites">Favorites: </label>
            <input type="text" name="total_favorites" value="{$game[0].total_favorites}"><br>
        </fieldset>
        </div>
        <div style="text-align: center;">
            <input type="submit" name="edit_game" value="Update Game" class="button">
            <input type="button" name="edit_game_advanced" id="edit_game_advanced" value="-- Show Advanced --" class="button">
        </div>
        </form>
        </div>
        </div>
        </div>
     </div>
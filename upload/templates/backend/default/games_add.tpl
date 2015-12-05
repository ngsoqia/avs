     <div id="rightcontent">
        {include file="errmsg.tpl"}
        <div id="right">
        <div align="center">
        <div id="simpleForm">
        <form name="add_game" method="POST" enctype="multipart/form-data" action="games.php?m=add">
        <fieldset>
        <legend>Game Information</legend>
            <label for="username">Username: </label>
            <input type="text" name="username" value="{$game.username}" class="medium"><br>
            <label for="title">Title: </label>
            <input type="text" name="title" value="{$game.title}" class="large"><br>
            <label for="tags">Keywords (tags): </label>
            <textarea name="tags">{$game.tags}</textarea><br>
            <label for="category">Category: </label>
            <select name="category">
            {section name=i loop=$categories}
            <option value="{$categories[i].category_id}"{if $game.category == $categories[i].category_id} selected="selected"{/if}>{$categories[i].category_name|escape:'html'}</option>
            {/section}
            </select><br>
            <label for="type">Type: </label>
            <select name="type">
            <option value="public"{if $game.type == 'public'} selected="selected"{/if}>public</option>
            <option value="private"{if $game.type == 'private'} selected="selected"{/if}>private</option>
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
        <legend>Game Files</legend>
            <label for="game_file">File: </label>
            <input name="game_file" type="file" id="game_file" /><br />
            <label for="game_thumb">Thumb: </label>
            <input name="game_thumb" type="file" id="game_thumb" /><br />
        </fieldset>
        <div style="text-align: center;">
            <input type="submit" name="add_game" value="Add Game" class="button">
        </div>
        </form>
        </div>
        </div>
        </div>
     </div>
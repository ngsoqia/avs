     <div id="rightcontent">
        {include file="errmsg.tpl"}
        {if $game}
        <div id="right">
        <table width="100%" cellpadding="0" cellspacing="5" border="0">
        <tr>
            <td valign="top" width="70%">
                <h2>Game Information</h2>
                <table style="margin-left: 20px;" width="90%" cellspacing="5" cellpadding="0" border="0" class="view">
                <tr class="view">
                    <td valign="top"><b>Game ID</b></td>
                    <td>{$game[0].VID}</td>
                </tr>
                <tr class="view">
                    <td align="top"><b>Active</b></td>
                    <td><b>{if $game[0].status == 1}yes{else}no{/if}</b></td>
                </tr>
                <tr class="view">
                    <td valign="top"><b>Title</b></td>
                    <td>{$game[0].title|escape:'html'}</td>
                </tr>
                <tr class="view">
                    <td valign="top"><b>Tags</b></td>
                    <td>{$game[0].tags}</td>
                </tr>
                <tr class="view">
                    <td valign="top"><b>Category</b></td>
          		    <td>{$game[0].category}</td>
                </tr>
                <tr class="view">
                    <td valign="top"><b>Type</b></td>
                    <td>{$game[0].type}</td>
                </tr>
                <tr class="view">
                    <td valign="top"><b>Date Added</b></td>
                    <td>{$game[0].adddate|date_format}</td>
                </tr>
                <tr class="view">
                    <td valign="top"><b>Rate</b></td>
                    <td>{$game[0].rate}</td>
                </tr>
                <tr class="view">
                    <td valign="top"><b>Can be commented?</b></td>
                    <td>{$game[0].be_commented}&nbsp;</td>
                </tr>
                <tr class="view">
                    <td valign="top"><b>Can be rated?</b></td>
                    <td>{$game[0].be_rated}&nbsp;</td>
                </tr>
                <tr class="view">
                    <td><b>Total Plays</b></td>
                    <td>{$game[0].total_plays}</td>
                </tr>
                <tr class="view">
                    <td><b>Total Comments</b></td>
                    <td>{$game[0].total_comments}</td>
                </tr>
                <tr class="view">
                    <td><b>Total Favorites</b></td>
                    <td>{$game[0].total_favorites}</td>
                </tr>
                </table>
                <br>
            </td>
            <td width="30%" valign="top" align="center">
                <h2>View Game</h2>
				<embed src="{$baseurl}/media/games/swf/{$game[0].GID}.swf" width="300" height="220" allowscriptaccess="always" allowfullscreen="true" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" />
				<br><br>
                <br><br>
                <img src="{$baseurl}/media/games/tmb/{$game[0].GID}.jpg" width="72" class="thumb" /><br />
                <a href="games.php?m=edit&GID={$game[0].GID}" class="view">Edit</a><br>
                <a href="games.php?m=all&a=delete&GID={$game[0].GID}" class="view" onClick="javascript:return confirm('Are you sure you want to delete this game?');">Delete</a><br>
            </td>
        </tr>
        </table>
        </div>
        {/if}
     </div>
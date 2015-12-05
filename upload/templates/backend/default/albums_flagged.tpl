     <div id="rightcontent">
        {include file="errmsg.tpl"}
        <div id="searchForm">
            <form name="search_videos" method="POST" action="albums.php?m=flagged">
            <table width="100%" cellpadding="0" cellspacing="5" border="0">
            <tr>
                <td align="right">Flagger:</td><td><input type="text" name="flagger" value="{$option.flagger}"></td>
            </tr>
            <tr>
                <td align="right">Sort</td>
                <td>
                    <select name="sort">
                    <option value="p.PID"{if $option.sort == 'p.PID'} selected="selected"{/if}>PID</option>
                    <option value="p.add_date"{if $option.sort == 'f.add_date'} selected="selected"{/if}>Date</option>
                    </select>
                </td>
                <td align="right">Order</td>
                <td>
                    <select name="order">
                    <option value="DESC"{if $option.order == 'DESC'} selected="selected"{/if}>DESC</option>
                    <option value="ASC"{if $option.order == 'ASC'} selected="selected"{/if}>ASC</option>
                    </select>
                </td>
                <td align="right">Display</td>
                <td>
                    <select name="display">
                    <option value="10"{if $option.display == '10'} selected="selected"{/if}>10</option>
                    <option value="20"{if $option.display == '20'} selected="selected"{/if}>20</option>
                    <option value="30"{if $option.display == '30'} selected="selected"{/if}>30</option>
                    <option value="40"{if $option.display == '40'} selected="selected"{/if}>40</option>
                    <option value="50"{if $option.display == '50'} selected="selected"{/if}>50</option>
                    <option value="100"{if $option.display == '100'} selected="selected"{/if}>100</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="6" align="center" valign="bottom">
                    <input type="submit" name="search_flags" value=" -- Search -- " class="button">
                    <input type="reset" name="reset_search" value=" -- Clear -- " class="button">
                </td>
            </tr>
            </table>
            </form>
        </div>
        {if $photos_total >= 1}
        <div id="paging">
            <div class="pagingnav">{$paging}</div>
        </div>
        <div class="pagingnav_clear"></div>
        {/if}
        <div id="right">
            <table width="100%" cellspacing="1" cellpadding="3" border="0">
            <tr>
                <td align="center"><b>Id</b></td>
                <td align="center"><b>Photo</b></td>
                <td align="center"><b>Flagger</b></td>
                <td align="center"><b>Reason</b></td>
                <td align="center"><b>Flag Date</b></td>
                <td align="center"><b>Actions</b></td>
            </tr>
            {if $photos}
            {section name=i loop=$photos}
            <tr bgcolor="{cycle values="#F8F8F8,#F2F2F2"}">
                <td align="center">{$photos[i].FID}</td>
                <td align="center">
                    <a href="albums.php?m=viewphoto&AID={$photos[i].AID}&PID={$photos[i].PID}">{$photos[i].caption|escape:'html'}<br><br>
                    <img src="{$baseurl}/media/photos/tmb/{$photos[i].PID}.jpg"  width="200" height="200"></a>
                </td>
                <td align="center">
                    <a href="users.php?m=view&UID={$photos[i].UID}">{$photos[i].username}</a>
                </td>
                <td align="center">
                    <b>{$photos[i].reason}</b><br />
                    {if $photos[i].message}<br />{$photos[i].message|escape:'html'|nl2br}{/if}
                </td>
                <td align="center">{$photos[i].add_date|date_format}</td>
                <td align="center">
                    <a href="albums.php?m=viewphoto&AID={$photos[i].AID}&PID={$photos[i].PID}">View</a><br>
                    <a href="albums.php?m=editphoto&AID={$photos[i].AID}&PID={$photos[i].PID}">Edit</a><br>
                    {if $photos[i].status == '1'}
                    <a href="albums.php?m=flagged{if $page !=''}&page={$page}{/if}&a=suspend&PID={$photos[i].PID}" onClick="javascript:return confirm('Are you sure you want to suspend this photo?');">Suspend</a>
                    {else}
                    <a href="albums.php?m=flagged{if $page !=''}&page={$page}{/if}&a=activate&PID={$photos[i].PID}" onClick="javascript:return confirm('Are you sure you want to approve this photo?');">Activate</a>
                    {/if}
                    <br>
                    <a href="albums.php?m=flagged{if $page !=''}&page={$page}{/if}&a=unflag&FID={$photos[i].FID}" onClick="javascript:return confirm('Are you sure you want to unflag this photo?');">Unflag</a>
                </td>
            </tr>
            {/section}
            {else}
            <tr>
                <td colspan="8" align="center"><div class="missing">YOUR SEARCH DID NOT RETURN ANY RESULTS</div></td>
            </tr>
            {/if}
            </table>
        </div>
        {if $photos_total >= 1}
        <div id="paging">
            <div class="pagingnav">{$paging}</div>
        </div>
        {/if}
     </div>
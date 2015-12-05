     {literal}
     <script type="text/javascript">
     </script>
     {/literal}
     <div id="rightcontent">
        <div id="errorbox" style="display: none;"></div>
        <div id="messagebox" style="display: none;"></div>        
        <div id="right">
        <div align="center">
        <h2>Static Pages</h2>
        <table width="80%" cellspacing="5" cellpadding="5" border="0">
        <tr class="view">
            <td align="center"><a href="#terms" id="static_page_terms"><b>Terms & Conditions</b></a></td>
            <td align="center"><a href="#privacy" id="static_page_privacy"><b>Privacy Policy</b></a></td>
            <td align="center"><a href="#faq" id="static_page_faq"><b>FAQ</b></a></td>
            <td align="center"><a href="#advertise" id="static_page_advertise"><b>Advertise</b></a></td>
            <td align="center"><a href="#webmasters" id="static_page_webmasters"><b>Webmasters</b></a></td>
            <td align="center"><a href="#dmca" id="static_page_dmca"><b>DMCA</b></a></td>
            <td align="center"><a href="#2257" id="static_page_2257"><b>2257</b></a></td>
            <td align="center"><a href="#whatis" id="static_page_whatis"><b>WhatIs</b></a></td>
        </table>
        </div>
        </div>
        <br>
        <div id="right">
        {literal}
        <script type="text/javascript">
        $(document).ready(function(){
            $('#page_content').markItUp(mySettings);
        });
        </script>
        {/literal}
        <div id="static_content">
            <input name="static_page" type="hidden" value="terms" id="static_page" />
            <h3 id="static_edit">Editing: [[Click on any static page from above]]</h2>
            <div id="static_txt_page">
                <textarea id="page_content" cols="80" rows="20"></textarea>
            </div>
        </div>
        </div>
     </div>     

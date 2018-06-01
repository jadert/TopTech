<?php

    require_once("core/init.php");

    // Play with settings --------------------------------------------------
    $pw = REQ('pw');
    
    if (isset($pw['PHP_SELF'])&&$pw['PHP_SELF']) $PHP_SELF = $pw['PHP_SELF'];
    if (isset($pw['template'])&&$pw['template']) $template = $pw['template'];

    if (isset($pw['start_from'])&&$pw['start_from']) $start_from = $pw['start_from'];
    if (isset($pw['number'])&&$pw['number']) $number = $pw['number'];
    if (isset($pw['archive'])&&$pw['archive']) $archive = $pw['archive'];
    if (isset($pw['category'])&&$pw['category']) $category = $pw['category'];
    if (isset($pw['ucat'])&&$pw['ucat']) $ucat = $pw['ucat'];
    if (isset($pw['sortby'])&&$pw['sortby']) $sortby = $pw['sortby'];
    if (isset($pw['dir'])&&$pw['dir']) $dir = $pw['dir'];
    if (isset($pw['page_alias'])&&$pw['page_alias']) $page_alias = $pw['page_alias'];
    if (isset($pw['tag'])&&$pw['tag']) $page_alias = $pw['tag'];
    if (isset($pw['user_by'])&&$pw['user_by']) $user_by = $pw['user_by'];

    if (isset($pw['static'])&&$pw['static']) $static = $pw['static'];
    if (isset($pw['reverse'])&&$pw['reverse']) $reverse = $pw['reverse'];
    if (isset($pw['only_active'])&&$pw['only_active']) $only_active = $pw['only_active'];
    if (isset($pw['no_prev'])&&$pw['no_prev']) $no_prev = $pw['no_prev'];
    if (isset($pw['no_next'])&&$pw['no_next']) $no_next = $pw['no_next'];
    // ---------------------------------------------------------------------

    if (isset($_GET['do'])&& $_GET['do'] == "rss") include("rss.php");
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <style>
        <!--
        a, a:link, a:visited { color: #003366; text-decoration: none; }
        a:active, a:hover { color: #54622D; }

        body { margin: 0; padding: 0;}
        body, td
        {
            font-family: verdana, arial, sans-serif;
            color: black;
            font-size: 12px;
            font-weight: normal;
            line-height: 1.3em;
        }

        .logo { position: fixed; width: 100%; height: 43px; box-shadow: 0 2px 6px #aaa; background: #f0f0f0; border-bottom: 3px solid #bbbbbb; padding: 8px 0 8px 0; z-index: 100;}
        .logo div.c { margin: 0 auto; width: 800px; }
        .logo div.d { margin: 0 0 0 300px; }
        .logo img { float: left; }
        .logo h1 { margin: 0 0 6px 0; padding: 4px 0 0 0; font-size: 17px; font-weight: normal; }

        #wrapper { width: 1000px;  height: 2000px; margin: 0 auto; padding: 62px 0 0 0;border-top: 2px solid #BBB; border-left: 2px solid #bbbbbb; border-right: 2px solid #bbbbbb; border-bottom: 1px solid #bbbbbb; box-shadow: 0 6px 12px #c0c0c0; }
        #footer { width: 1000px; margin: 0 auto; text-align: center; padding: 10px; color: #999999; }

        .content h2 { margin: 0; padding: 8px 0; }

        .nav { border-bottom: 1px dashed #888888; background: #F3F4F5; padding: 5px; margin: 0 0 4px 0; font-size: 12px; }
        .content { padding: 6px; }

        .sidebar { width: 300px; float: right;  padding: 0; }
        .sidebar h3 { margin: 4px 0; padding: 3px; background: #2060A0; font-weight: normal; color: white; }

        .pagedata { float: left; width: 665px; padding: 0 10px 0 0;  overflow: hidden; }

        input { border-radius: 3px; }
        input.text { background: #ffffff; border: 1px solid gray; }
        input.submit { background: #f0f0f0; border: 1px groove #808080; }
        input.submit:hover { background: #ffffff; cursor: pointer; }

        /* Customize cutenews CSS */
        .cn_search_form { padding: 4px; border: 1px solid #e0e0e0; border-radius: 4px; background: #f0f0f0; }
        .cn_search_form .cn_search_basic { width: 300px; padding: 4px; }

        .cutenews_found_news { font-size: 19px; font-family: Arial; text-decoration: underline; }
        .cn_search_body { margin: 0 0 16px 16px; }
        .cn_comm_textarea { width: 450px; height: 150px; }

        .cn_tag_item { display: inline-block; border-radius: 4px; border: 1px solid #c0c0c0; background: #fffaf0; padding: 4px; }
        .cn_tag_item:hover { background: #f0f0f0; color: black; }
        .cn_tag_item.cn_tag_selected { background: #ffffff; color: black; }

        .cn_search_hl { font-weight: bold; color: #008; }
        .blocking_posting_comment, .cn_error_comment{ font-weight: bold; color: #F00;}
        .cn_blockquote{border-left: 3px double grey; padding-left:5px;}
        .soc-buttons-left{float:left; margin-left:3px;}
        .widget_personal_msg{color: #F00; margin: 3px; font-weight: bold;}
        //-->
    </style>
    <script>
        window.onload=function()
        {
            var edt_comm_mode=document.getElementById('edt_comm_mode');
            if(edt_comm_mode!=null)
            {
                window.scrollTo(0,9999);
            }
		parent.document.getElementById("iframenoticia").height = document.getElementById("wrapper").scrollHeight + 5;
        }
    </script>
</head>
<body style="width:95%">


    <div id="wrapper" style="width:100%">


        <div class="content">

            <!-- MAIN CONTENT, FIRST -->
            <div class="pagedata" style="width:100%">
            
            <!-- SECTION: SEARCH -->
                <form action="<?php echo PHP_SELF; ?>" method="GET">
                    <input type="hidden" name="dosearch" value="Y" />
                    <div>
                        <input onClick="(this.value='<?php echo cn_htmlspecialchars(REQ('search')); ?>')" style="width: 200px; padding: 4px;" class="text" type="text" name="search" value="Digite aqui" />
                        <input style="width: 75px; padding: 4px;"  class="submit" type="submit" value="Buscar" />
                    </div>
                </form>
                
                <?php

                /* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
                Here we decide what page to include
                ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
                if (isset($_GET['search'])&&$_GET['search'])
                {
                    include ("search.php");
                }
                elseif (isset($_GET['do'])&&$_GET['do'] == 'archives')
                {
                    include ("show_archives.php");
                }
                elseif (isset($_GET['do'])&&$_GET['do'] == "stats")
                {
                    echo "You can download the stats addon and include it here to show how many news, comments ... you have"; // include("$path/stats.php");
                }
                else
                {
					$number = "5";
                    include ("show_news.php");
                }

                ?>
            </div>


            <!-- END MAIN CONTENT -->
            <div style="clear: both"></div>

        </div>
    </div>


</body>
</html>
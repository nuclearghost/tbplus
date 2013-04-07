<?php session_start(); ?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>tb+ <?php print $_SESSION['handle']?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/smoothness/jquery-ui-1.9.2.custom.css">
        <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
        <script src="js/vendor/modernizr-2.6.2.min.js"></script>
    </head>
    <body style="padding-top: 40px; position:relative; background-image:url('img/city_background.jpg');">

      <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="navbar-inner">
          <div class="container">
            <a class="brand" href="#">tb+</a>
            <ul class="nav">
              <li class="active"><a href="#"><i class="icon-user icon-white"></i> <span id="user_handle"><?php print $_SESSION['handle']?></span></a></li>
              <li><a href="logout.php"><i class="icon-off icon-white"></i>logout</a></li>
            </ul>
            <div class="btn-group pull-right">
              <a href="#composeTweet" role="button" class="btn btn-primary" data-toggle="modal">
                <i class="icon-edit icon-white"></i>
              </a>
            </div>
            <form class="navbar-search pull-right">
              <input id="navSearch" type="text" class="search-query" placeholder="search">
            </form>
          </div>
        </div>
      </div>
      <div class="container">
        <div class="row">
          <div id="main_sidebar" class="span3">
            <button id="btn_followers" class="btn btn-primary btn-block" onclick="toggle_followers()">followers <span></span></button>
            <ul id="ul_followers" class="unstyled">
            </ul>
            <button id="btn_following" class="btn btn-primary btn-block" onclick="toggle_following()">following <span></span></button>
            <ul id="ul_following" class="unstyled">
            </ul>
            <button id="btn_tweets" class="btn btn-primary btn-block" onclick="toggle_tweets()">tweets <span></span></button>
            <button id="btn_mentions" class="btn btn-primary btn-block" onclick="toggle_mentions()">mentions <span></span></button>
          </div>
          <div id="main_stream" class="span9">
            <div id="user_tweets">
              <ul id="ul_user_tweets" class="well unstyled">
              </ul>
            </div>
            <div id="trend_tweets">
              <ul id="ul_trend_tweets" class="well unstyled">
              </ul>
            </div>
            <div id="user_mentions">
              <ul id="ul_user_mentions" class="well unstyled">
              </ul>
            </div>
            <div id="following_tweets">
              <ul id="ul_following_tweets" class="well unstyled">
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div id="composeTweet" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby"composeTweetLbl" aria-hidden="true">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
          <h3 id="composeTweetLbl">compose</h3>
        </div>
        <div class="modal-body">
          <textarea id="tweet_box" maxlength="140" placeholder="what's happening"></textarea>
        </div>
        <div class="modal-footer">
          <button class="btn" data-dismiss="modal" aria-hidden="true">close</button>
          <button class="btn btn-primary" onclick="send_tweet('<?php print $_SESSION['handle']?>')">tweet</button>
        </div>
      </div>
      <div id="userInfo" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby"userInfoLbl" aria-hidden="true">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
          <h3 id="userInfoLbl"></h3>
        </div>
        <div class="modal-body">
          <div id="userInfoBody">
            <div>name <span id="userInfoName"></span></div>
            <div>email <span id="userInfoEmail"></span></div>
            <div>join date <span id="userInfoDate"></span></div>
            <div>following <span id="userInfoNFollowing"></span></div>
            <div>followers <span id="userInfoNFollowers"></span></div>
            <div>follows you, <span id="userInfoFollowsYou"></span></div>
            <ul id="userInfoTweets" class="well unstyled"></ul>
          </div>
        </div>
        <div class="modal-footer">
          <button id="followButton" class="btn pull-left" aria-hiden="true" onclick="adjust_follow()"><i id="followIcon"></i></button>
          <button class="btn" data-dismiss="modal" aria-hidden="true">close</button>
        </div>
      </div>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.8.2.min.js"><\/script>')</script>
        <script src="js/vendor/jquery-ui-1.9.2.custom.js"></script>
        <script src="js/plugins.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/final.js"></script>

        <script>
            var _gaq=[['_setAccount','UA-35682339-1'],['_trackPageview']];
            (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
            g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
            s.parentNode.insertBefore(g,s)}(document,'script'));
        </script>
    </body>
</html>

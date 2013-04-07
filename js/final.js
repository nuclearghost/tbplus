
function sessionConfig (curUser, followers, following, tweets, mentions){
  this.currentUser = curUser;
  this.followers_displayed = followers;
  this.following_displayed = following;
  this.self_tweets_displayed = tweets;
  this.mentions_displayed = mentions;
}

var config = null;

$(document).ready(function() {
    var currentUser = $("#user_handle").text();

    config = new sessionConfig(currentUser, false, false, false, false);

    update_followers(currentUser);
    update_following(currentUser);
    update_tweets(currentUser);
    update_mentions(currentUser);
    load_latest_tweets(currentUser);

    $("#navSearch").autocomplete({
      source : "findUser.php",
      minLength: 1,
      select: function (event, ui) {
        var selectedTerm = ui.item.value;
        show_user_info(selectedTerm);
      }
    });

    $("#composeTweet").on('shown', function() {
        $("#tweet_box").focus();
        });

  }
)

function update_followers(currentUser){
  $.getJSON('followers_of_user.php', {user: currentUser}, function(data){
      //console.log(data)
      $("#btn_followers span").text(data.length);
      
      var UlFollwers = $("#ul_followers");
      UlFollwers.html("");
      if (data.length > 0){
      $.each(data, function(index, value){
          UlFollwers.append("<li onclick=\"show_user_info('"+data[index]+"')\">"+data[index]+"</li>");
        });
      }    
  });
}

function update_following(currentUser){
  $.getJSON('leaders_of_user.php', {user: currentUser}, function(data){
      //console.log(data)
      $("#btn_following span").text(data.length);

      var UlLeaders = $("#ul_following");
      UlLeaders.html("");
      if (data.length > 0){
        $.each(data, function(index, value){
          UlLeaders.append("<li onclick=\"show_user_info('"+data[index]+"')\">"+data[index]+"</li>");
        });
      } 
    });
}

function update_tweets(currentUser){
  $.getJSON('tweets_by_user.php', {user: currentUser}, function(data){
      //console.log(data)
      $("#btn_tweets span").text(data.length);

      var ulUserTweets = $("#ul_user_tweets");
      ulUserTweets.html("");
      if (data.length > 0){
        $.each(data, function(index, value){
          ulUserTweets.append("<li class='tweet'>"+data[index]+"</li>");
        });
      } 
    });
}

function update_mentions(currentUser){
  $.getJSON('mentions_by_user.php', {user: currentUser}, function(data){
      //console.log(data)
      $("#btn_mentions span").text(data.length);

      var ulUserMentions = $("#ul_user_mentions");
      ulUserMentions.html("");
      if (data.length > 0){
        $.each(data, function(index, value){
          ulUserMentions.append("<li class='tweet'>"+data[index]+"</li>");
        });
      } 
    });
}

function load_latest_tweets(currentUser){
  $.getJSON('find_tweets_of_following.php', {handle: currentUser}, function(data){
      //console.log(data);

      var ulFollowingTweets = $("#ul_following_tweets");
      ulFollowingTweets.html('');
      if (data.length > 0){
        $.each(data, function(index, value){
          ulFollowingTweets.append("<li class='tweet'><b>"+data[index][0]+": </b>"+data[index][1]+"</li>");
          });
      }
  });
}

function toggle_followers(){
  if(config.followers_displayed == false){
    config.followers_displayed = true;
    $("#ul_followers li").fadeIn();
  } else {
    config.followers_displayed = false;
    $("#ul_followers li").fadeOut();
  }
}

function toggle_following(){
  if(config.following_displayed == false){
    config.following_displayed = true;
    $("#ul_following li").fadeIn();
  } else {
    config.following_displayed = false;
    $("#ul_following li").fadeOut();
  }
}

function toggle_tweets(){
  if(config.self_tweets_displayed == false){
    config.self_tweets_displayed = true;
    $("#ul_following_tweets").fadeOut(function() {
      $("#ul_user_tweets ").fadeIn();
    });
  } else {
    config.self_tweets_displayed = false;
    $("#ul_user_tweets ").fadeOut(function() {
        $("#ul_following_tweets").fadeIn();
    });
  }
}

function toggle_mentions(){
  if(config.mentions_displayed == false){
    config.mentions_displayed = true;
    $("#ul_following_tweets").fadeOut(function() {
      $("#ul_user_mentions").fadeIn();
    });
  } else {
    config.mentions_displayed = false;
    $("#ul_user_mentions").fadeOut(function() {
        $("#ul_following_tweets").fadeIn();
    });
  }
}

function send_tweet(currentUser){
  $("#composeTweet").modal('hide');
  var tweetBox = $("#tweet_box");
  var tweetText = tweetBox.val();
  //console.log(tweetText);
  tweetBox.val("");
  
  $.getJSON("send_tweet.php", {user:currentUser, text:tweetText}, function(data){
      //console.log(data);
      update_tweets(currentUser);
    });
}

function show_trend_tweets(tag){
  var newTag = tag.substring(1);
  $.getJSON("hashtag_in_tweets.php", {tag:newTag}, function(data){
      console.log(data);
      var ulTrendTweets = $("#ul_trend_tweets");
      ulTrendTweets.html('');
      if (data.length > 0){
        $.each(data, function(index, value){
          ulTrendTweets.append("<li class='tweet'>"+data[index]+"</li>");
          });
      }
      ulTrendTweets.fadeIn();
      });
}

function show_user_info(user){
  $.getJSON("final_user_details.php", {user:user, current_user:config.currentUser}, function(data){
      //console.log(data);

      if(data.details ==null){
        show_trend_tweets(user);
      } else {
        $("#userInfoLbl").text(data.details[0]);
        $("#userInfoName").text(data.details[1]);
        $("#userInfoEmail").text(data.details[2]);
        $("#userInfoDate").text(data.details[3]);
        $("#userInfoNFollowing").text(data.details[4]);
        $("#userInfoNFollowers").text(data.details[5]);
        $("#userInfoFollowsYou").text(data.follows ? "yep" : "nope");
        //$("#userInfoYouFollow").text(data.following ? "yes" : "no");
        var uiTweets = $("#userInfoTweets").html("");
        if (data.tweets.length > 0){
          for(var i = 0; i < data.tweets.length; ++i){
            uiTweets.append("<li class='tweet'>"+data.tweets[i][0]+"</li>");
          }
        } else {
            uiTweets.append("<li class='tweet'>no tweets yet</li>");
        }

        if (data.following == false){
          $("#followButton").removeClass().addClass("btn pull-left btn-primary").html(" follow");
          $("#followIcon").removeClass().addClass("icon-ok icon-white");//.text(" follow");
        } else {
          $("#followButton").removeClass().addClass("btn pull-left btn-danger").text(" unfollow");
          $("#followIcon").removeClass().addClass("icon-remove icon-white");//.text(" unfollow");
        }

        //$("#userInfoBody").text();
        $("#userInfo").modal('show');
      }
  });
}

function adjust_follow(){
  var follow = $("#followButton").hasClass('btn-primary');

  var otherUser = $("#userInfoLbl").text();
  if (follow){
    $.getJSON("follow_user.php", {leader:otherUser, follower:config.currentUser}, function(data){
            update_following(config.currentUser);
            load_latest_tweets(config.currentUser);
            $("#userInfo").modal('hide');
        });
  } else {
    $.getJSON("unfollow_user.php", {leader:otherUser, follower:config.currentUser}, function(data){
            update_following(config.currentUser);
            load_latest_tweets(config.currentUser);
            $("#userInfo").modal('hide');
        });
  }
}


var userDetailsHeader = false;
$(document).ready(function() {
    $("#findUsers_input").autocomplete({
      source : "findUser.php",
      minLength: 1,
      select: function (event, ui) {
        console.log(ui);
        var selectedTerm = ui.item.value;
        $.getJSON('user_details.php', {user: selectedTerm}, function(data){
          console.log(data);
          var findUserdiv = $("#findUsers_details");
          var tableHTML = "";
          if (userDetailsHeader == false){
            userDetailsHeader = true;
            tableHTML += "<tr><td>userID</td><td>handle</td><td>name</td><td>email</td><td>accountCreate</td><td>lastLogin</td><td>accountActive</td><td>isOfficial</td><td>following</td><td>followers</td></tr>"; 
          }
          $.each(data, function(index, value){
            tableHTML += "<tr><td>"+data[0][0]+"</td><td>"+data[0][1]+"</td><td>"+data[0][2]+"</td><td>"+data[0][3]+"</td><td>"+data[0][4]+"</td><td>"+data[0][5]+"</td><td>"+data[0][6]+"</td><td>"+data[0][7]+"</td><td>"+data[0][8]+"</td><td>"+data[0][9]+"</td></tr>"
            });
          findUserdiv.append(tableHTML);
        });
      }
    });

    $("#findTweets_input").autocomplete({
      source: "findUser.php",
      minLength: 1,
      select: function (event, ui){
        var selectedUser = ui.item.value;
        $.getJSON('tweets_by_user.php', {user: selectedUser}, function(data){
          console.log(data)
          var findTweetsUL = $("#findTweets_ul");
          findTweetsUL.html("");
          if (data.length > 0){
            $.each(data, function(index, value){
              findTweetsUL.append("<li>"+data[index]+"</li>");
            });
          } else {
            findTweetsUL.append("<li>No results found</li>");
          }
        });
      }
    });
    
    $("#findMentions_input").autocomplete({
      source: "findUser.php",
      minLength: 1,
      select: function (event, ui){
        var selectedUser = ui.item.value;
        $.getJSON('mentions_by_user.php', {user: selectedUser}, function(data){
          console.log(data)
          var findMentionsUL = $("#findMentions_ul");
          findMentionsUL.html("");
          if (data.length > 0){
            $.each(data, function(index, value){
              findMentionsUL.append("<li>"+data[index]+"</li>");
            });
          } else {
            findMentionsUL.append("<li>No results found</li>");
          }
        });
      }
    });
    
    $("#findFollowers_input").autocomplete({
      source: "findUser.php",
      minLength: 1,
      select: function (event, ui){
        var selectedUser = ui.item.value;
        $.getJSON('followers_of_user.php', {user: selectedUser}, function(data){
          console.log(data)
          var findFollowersUL = $("#findFollowers_ul");
          findFollowersUL.html("");
          if (data.length > 0){
            $.each(data, function(index, value){
              findFollowersUL.append("<li>"+data[index]+"</li>");
            });
          } else {
            findFollowersUL.append("<li>No results found</li>");
          }
        });
      }
    });

    $("#findLeaders_input").autocomplete({
      source: "findUser.php",
      minLength: 1,
      select: function (event, ui){
        var selectedUser = ui.item.value;
        $.getJSON('leaders_of_user.php', {user: selectedUser}, function(data){
          console.log(data)
          var findLeadersUL = $("#findLeaders_ul");
          findLeadersUL.html("");
          if (data.length > 0){
            $.each(data, function(index, value){
              findLeadersUL.append("<li>"+data[index]+"</li>");
            });
          } else {
            findLeadersUL.append("<li>No results found</li>");
          }
        });
      }
    });

    $("#findHashtags_input").autocomplete({
      source: "findHashtag.php",
      minLength: 0,
      select: function (event, ui){
        var selectedTag = ui.item.value;
        $.getJSON('hashtag_in_tweets.php', {tag: selectedTag}, function(data){
          console.log(data)
          var findHashtagsUL = $("#findHashtags_ul");
          findHashtagsUL.html("");
          if (data.length > 0){
            $.each(data, function(index, value){
              findHashtagsUL.append("<li>"+data[index]+"</li>");
            });
          } else {
            findHashtagsUL.append("<li>No results found</li>");
          }
        });
      }
    });
});

function showTables(){
  console.log("show tables");
  $.getJSON('show_tables.php',function(data){
      console.log(data);
      var tablesDiv = $("#tableList"); 
      tablesDiv.append("<ul>");
      $.each(data, function(index, value){
        tablesDiv.append("<li id='table_"+value+"' class='listTable' onclick='describeTable(\""+value+"\")'>"+value+"</li>");
      });
      tablesDiv.append("</ul>");
      $("#showTables_button").attr("disabled","disabled");
    }
  );
}

var describedTables = {};

function describeTable(table){
  console.log("describeTable " + table);
  if (!describedTables.hasOwnProperty(table)){
    describedTables[table] = true;
    $.getJSON('describe_table.php', {table : table}, function(data){
      console.log(data);
      var li = $("#table_"+table);
      var tableHTML = ""
      tableHTML += "<table><tr><td>Field</td><td>Type</td><td>Null</td><td>Key</td><td>Default</td><td>Extra</td></tr>";
      $.each(data, function(index, value){
        tableHTML += "<tr><td>"+data[index][0]+"</td><td>"+data[index][1]+"</td><td>"+data[index][2]+"</td><td>"+data[index][3]+"</td><td>"+data[index][4]+"</td><td>"+data[index][5]+"</td></tr>";
      });
      tableHTML += "</table>";
      li.append(tableHTML);
    }
  );
  }
}


function send_tweet(){
  var tweetBox = $("#tweet_box");
  var tweetText = tweetBox.val();
  var handle = $("#sendHandle").val();
  tweetBox.val("");
  $("#sendHandle").val("");
  
  $.getJSON("send_tweet.php", {user:handle, text:tweetText}, function(data){
    });
}

function follow_user(){
  var leader = $("#newLeader").val();
  var follower = $("#newFollower").val();

  $.getJSON("follow_user.php", {leader: leader, follower:follower}, function(data){
        $("#newLeader").val('');
        $("#newFollower").val('');
      });
}

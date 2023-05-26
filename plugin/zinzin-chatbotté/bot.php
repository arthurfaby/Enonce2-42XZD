<?php /**
  * Plugin Name: ZinzinChatBotté
  * Plugin URI: http://localhost/
  * Description: Plugin for Zenmon Drops Challenge.
  * Version: 0.1
  * Author: afaby,kbrousse,pirabaud
  * Author URI: http://localhost/
  **/

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly
add_action('wp_head', 'init_chatbot');

function init_chatbot()
{

    ?>
    <head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

</head>
    <style>
        html, body {
  background: #efefef;      
  height:100%;  
}
#center-text {          
  z-index: 100000;
  display: flex;
  flex: 1;
  flex-direction:column; 
  justify-content: center;
  align-items: center;  
  height:100%;
  
}
#chat-circle {
  position: fixed;
  z-index: 100000;
  bottom: 50px;
  right: 50px;
  background: #7ebc89;
  width: 80px;
  height: 80px;  
  border-radius: 50%;
  color: white;
  padding: 28px;
  cursor: pointer;
  display: flex;
  justify-content: center;
  align-items: center;
  box-shadow: 0px 3px 16px 0px rgba(0, 0, 0, 0.6), 0 3px 1px -2px rgba(0, 0, 0, 0.2), 0 1px 5px 0 rgba(0, 0, 0, 0.12);
}

#chat-circle i {
  z-index: 100000;
    font-size: 50px;
}

.btn#my-btn {
  z-index: 100000;
     background: white;
    padding-top: 13px;
    padding-bottom: 12px;
    border-radius: 45px;
    padding-right: 40px;
    padding-left: 40px;
    color: #5865C3;
}
#chat-overlay {
  z-index: 100000;
    background: rgba(255,255,255,0.1);
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border-radius: 50%;
    display: none;
}


.chat-box {
  z-index: 100000;
  display:none;
  background: #efefef;
  position:fixed;
  right:30px;
  bottom:50px;  
  width:350px;
  max-width: 85vw;
  max-height:100vh;
  border-radius:5px;  
/*   box-shadow: 0px 5px 35px 9px #464a92; */
  box-shadow: 0px 5px 35px 9px #ccc;
}
.chat-box-toggle {
  z-index: 100000;
  float:right;
  margin-right:15px;
  cursor:pointer;
}
.chat-box-header {
  background: #7ebc89;
  height:70px;
  border-top-left-radius:5px;
  border-top-right-radius:5px; 
  color:white;
  text-align:center;
  font-size:20px;
  padding-top:17px;
}
.chat-box-body {
  position: relative;  
  height:370px;  
  height:auto;
  border:1px solid #ccc;  
  overflow: hidden;
}
.chat-box-body:after {
  content: "";
  background-image: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAwIiBoZWlnaHQ9IjIwMCIgdmlld0JveD0iMCAwIDIwMCAyMDAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGcgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMTAgOCkiIGZpbGw9Im5vbmUiIGZpbGwtcnVsZT0iZXZlbm9kZCI+PGNpcmNsZSBzdHJva2U9IiMwMDAiIHN0cm9rZS13aWR0aD0iMS4yNSIgY3g9IjE3NiIgY3k9IjEyIiByPSI0Ii8+PHBhdGggZD0iTTIwLjUuNWwyMyAxMW0tMjkgODRsLTMuNzkgMTAuMzc3TTI3LjAzNyAxMzEuNGw1Ljg5OCAyLjIwMy0zLjQ2IDUuOTQ3IDYuMDcyIDIuMzkyLTMuOTMzIDUuNzU4bTEyOC43MzMgMzUuMzdsLjY5My05LjMxNiAxMC4yOTIuMDUyLjQxNi05LjIyMiA5LjI3NC4zMzJNLjUgNDguNXM2LjEzMSA2LjQxMyA2Ljg0NyAxNC44MDVjLjcxNSA4LjM5My0yLjUyIDE0LjgwNi0yLjUyIDE0LjgwNk0xMjQuNTU1IDkwcy03LjQ0NCAwLTEzLjY3IDYuMTkyYy02LjIyNyA2LjE5Mi00LjgzOCAxMi4wMTItNC44MzggMTIuMDEybTIuMjQgNjguNjI2cy00LjAyNi05LjAyNS0xOC4xNDUtOS4wMjUtMTguMTQ1IDUuNy0xOC4xNDUgNS43IiBzdHJva2U9IiMwMDAiIHN0cm9rZS13aWR0aD0iMS4yNSIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIi8+PHBhdGggZD0iTTg1LjcxNiAzNi4xNDZsNS4yNDMtOS41MjFoMTEuMDkzbDUuNDE2IDkuNTIxLTUuNDEgOS4xODVIOTAuOTUzbC01LjIzNy05LjE4NXptNjMuOTA5IDE1LjQ3OWgxMC43NXYxMC43NWgtMTAuNzV6IiBzdHJva2U9IiMwMDAiIHN0cm9rZS13aWR0aD0iMS4yNSIvPjxjaXJjbGUgZmlsbD0iIzAwMCIgY3g9IjcxLjUiIGN5PSI3LjUiIHI9IjEuNSIvPjxjaXJjbGUgZmlsbD0iIzAwMCIgY3g9IjE3MC41IiBjeT0iOTUuNSIgcj0iMS41Ii8+PGNpcmNsZSBmaWxsPSIjMDAwIiBjeD0iODEuNSIgY3k9IjEzNC41IiByPSIxLjUiLz48Y2lyY2xlIGZpbGw9IiMwMDAiIGN4PSIxMy41IiBjeT0iMjMuNSIgcj0iMS41Ii8+PHBhdGggZmlsbD0iIzAwMCIgZD0iTTkzIDcxaDN2M2gtM3ptMzMgODRoM3YzaC0zem0tODUgMThoM3YzaC0zeiIvPjxwYXRoIGQ9Ik0zOS4zODQgNTEuMTIybDUuNzU4LTQuNDU0IDYuNDUzIDQuMjA1LTIuMjk0IDcuMzYzaC03Ljc5bC0yLjEyNy03LjExNHpNMTMwLjE5NSA0LjAzbDEzLjgzIDUuMDYyLTEwLjA5IDcuMDQ4LTMuNzQtMTIuMTF6bS04MyA5NWwxNC44MyA1LjQyOS0xMC44MiA3LjU1Ny00LjAxLTEyLjk4N3pNNS4yMTMgMTYxLjQ5NWwxMS4zMjggMjAuODk3TDIuMjY1IDE4MGwyLjk0OC0xOC41MDV6IiBzdHJva2U9IiMwMDAiIHN0cm9rZS13aWR0aD0iMS4yNSIvPjxwYXRoIGQ9Ik0xNDkuMDUgMTI3LjQ2OHMtLjUxIDIuMTgzLjk5NSAzLjM2NmMxLjU2IDEuMjI2IDguNjQyLTEuODk1IDMuOTY3LTcuNzg1LTIuMzY3LTIuNDc3LTYuNS0zLjIyNi05LjMzIDAtNS4yMDggNS45MzYgMCAxNy41MSAxMS42MSAxMy43MyAxMi40NTgtNi4yNTcgNS42MzMtMjEuNjU2LTUuMDczLTIyLjY1NC02LjYwMi0uNjA2LTE0LjA0MyAxLjc1Ni0xNi4xNTcgMTAuMjY4LTEuNzE4IDYuOTIgMS41ODQgMTcuMzg3IDEyLjQ1IDIwLjQ3NiAxMC44NjYgMy4wOSAxOS4zMzEtNC4zMSAxOS4zMzEtNC4zMSIgc3Ryb2tlPSIjMDAwIiBzdHJva2Utd2lkdGg9IjEuMjUiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIvPjwvZz48L3N2Zz4=');
  opacity: 0.1;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
  height:100%;
  position: absolute;
  z-index: -1;   
}
#chat-input {
  background: #f4f7f9;
  width: 81%; 
  position:relative;
  height:47px;  
  padding-top:10px;
  padding-right:50px;
  padding-bottom:10px;
  padding-left:15px;
  border:none;
  resize:none;
  outline:none;
  border:1px solid #ccc;
  color:#888;
  border-top:none;
  border-bottom-right-radius:5px;
  border-bottom-left-radius:5px;
  z-index: 100000;
  overflow:hidden;  
}
.chat-input > form {
  z-index: 100000;
    margin-bottom: 0;
}
#chat-input::-webkit-input-placeholder { /* Chrome/Opera/Safari */
  z-index: 100000;
  color: #ccc;
}
#chat-input::-moz-placeholder { /* Firefox 19+ */
  z-index: 100000;
  color: #ccc;
}
#chat-input:-ms-input-placeholder { /* IE 10+ */
  z-index: 100000;
  color: #ccc;
}
#chat-input:-moz-placeholder { /* Firefox 18- */
  z-index: 100000;
  color: #ccc;
}
.chat-submit {  
  z-index: 100000;
  position:absolute;
  bottom:3px;
  right:10px;
  background: transparent;
  box-shadow:none;
  border:none;
  border-radius:50%;
  color:#7ebc89;
  width:35px;
  height:35px;  
}
.chat-logs {
  z-index: 100000;
  padding:15px; 
  height:370px;
  overflow-y:scroll;
}

.chat-logs::-webkit-scrollbar-track
{
  z-index: 100000;
	-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
	background-color: #F5F5F5;
}

.chat-logs::-webkit-scrollbar
{
  z-index: 100000;
	width: 5px;  
	background-color: #F5F5F5;
}

.chat-logs::-webkit-scrollbar-thumb
{
  z-index: 100000;
	background-color: #7ebc89;
}



@media only screen and (max-width: 500px) {
   .chat-logs {
  z-index: 100000;
        height:40vh;
    }
}

.chat-msg.user > .msg-avatar img {
  z-index: 100000;
  width:45px;
  height:45px;
  border-radius:50%;
  float:left;
  width:15%;
}
.chat-msg.self > .msg-avatar img {
  z-index: 100000;
  width:45px;
  height:45px;
  border-radius:50%;
  float:right;
  width:15%;
}
.cm-msg-text {
  background:white;
  padding:10px 15px 10px 15px;  
  color:#666;
  max-width:75%;
  float:left;
  font-size: 16px;
  z-index: 100000;
  margin-left:10px; 
  position:relative;
  margin-bottom:20px;
  border-radius:30px;
}
.chat-msg {
  z-index: 100000;
  clear:both;    
}
.chat-msg.self > .cm-msg-text {  
  z-index: 100000;
  float:right;
  margin-right:10px;
  background: #7ebc89;
  color:white;
}
.cm-msg-button>ul>li {
  z-index: 100000;
  list-style:none;
  float:left;
  width:50%;
}
.cm-msg-button {
  z-index: 100000;
    clear: both;
    margin-bottom: 70px;
}

    </style>
    <div id="chat-circle" class="btn btn-raised">
      <div id="chat-overlay"></div>
      <i class="large material-icons">chat</i>
    </div>
  
    <div class="chat-box">
        <div class="chat-box-header">
        ChatBotté
        <span class="chat-box-toggle"><i class="material-icons">close</i></span>
        </div>
            <div class="chat-box-body">
                <div class="chat-box-overlay">   
                </div>
                <div class="chat-logs">
                
                </div><!--chat-log -->
            </div>
            <div class="chat-input">      
            <form>
                <input type="text" id="chat-input" placeholder="Send a message..."/>
                <button type="submit" class="chat-submit" id="chat-submit"><i class="material-icons">send</i></button>
            </form>      
            </div>
        </div>  
    </div>
    <script>
$(function() {
  var INDEX = 0; 
  $("#chat-submit").click(function(e) {
    e.preventDefault();
    var msg = $("#chat-input").val(); 
    if(msg.trim() == ''){
      return false;
    }
    generate_message(msg, 'self');
    let data = {
      "message" : msg
    }
    let param = {
      "method" : "POST",
      "headers" : {
        "Content-Type": "application/json; charset=utf-8"
      },
      "body": JSON.stringify(data)
    }
    fetch("../wp-content/plugins/zinzin-chatbotté/request.php", param).then(
      response => {return response.json()}
    ).then(data => {generate_message(data.response, 'user')});
    
  })
  
  function generate_message(msg, type) {
    INDEX++;
    var str="";
    str += "<div id='cm-msg-"+INDEX+"' class=\"chat-msg "+type+"\">";
    str += "          <span class=\"msg-avatar\">";
    str += "            <img src=\""
    if (type === 'user') {
      str += "data:image/png;base64,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"
    } else {
      str += "https://cdn.intra.42.fr/users/e05a35a3e0c5485ee689eea755608f72/pirabaud.JPG";
    }
    str += "\">";
    str += "          <\/span>";
    str += "          <div class=\"cm-msg-text\">";
    str += msg;
    str += "          <\/div>";
    str += "        <\/div>";
    $(".chat-logs").append(str);
    $("#cm-msg-"+INDEX).hide().fadeIn(300);
    if(type == 'self'){
     $("#chat-input").val(''); 
    }    
    $(".chat-logs").stop().animate({ scrollTop: $(".chat-logs")[0].scrollHeight}, 1000);    
  }  
  
  $(document).delegate(".chat-btn", "click", function() {
    var value = $(this).attr("chat-value");
    var name = $(this).html();
    $("#chat-input").attr("disabled", false);
    generate_message(name, 'self');
    ;
  })
  
  $("#chat-circle").click(function() {    
    $("#chat-circle").toggle('scale');
    $(".chat-box").toggle('scale');
  })
  
  $(".chat-box-toggle").click(function() {
    $("#chat-circle").toggle('scale');
    $(".chat-box").toggle('scale');
  })
  
})
    </script>
 <?php
    }
    ;
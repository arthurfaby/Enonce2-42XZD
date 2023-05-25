<?php /**
  * Plugin Name: ZinzinChatBotté
  * Plugin URI: http://localhost/
  * Description: Test.
  * Version: 0.1
  * Author: toto
  * Author URI: http://localhost/
  **/

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly
add_action('wp_head', 'our_pirabaud');

function our_pirabaud()
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
  display: flex;
  flex: 1;
  flex-direction:column; 
  justify-content: center;
  align-items: center;  
  height:100%;
  
}
#chat-circle {
  position: fixed;
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
    font-size: 50px;
}

.btn#my-btn {
     background: white;
    padding-top: 13px;
    padding-bottom: 12px;
    border-radius: 45px;
    padding-right: 40px;
    padding-left: 40px;
    color: #5865C3;
}
#chat-overlay {
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
  overflow:hidden;  
}
.chat-input > form {
    margin-bottom: 0;
}
#chat-input::-webkit-input-placeholder { /* Chrome/Opera/Safari */
  color: #ccc;
}
#chat-input::-moz-placeholder { /* Firefox 19+ */
  color: #ccc;
}
#chat-input:-ms-input-placeholder { /* IE 10+ */
  color: #ccc;
}
#chat-input:-moz-placeholder { /* Firefox 18- */
  color: #ccc;
}
.chat-submit {  
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
  padding:15px; 
  height:370px;
  overflow-y:scroll;
}

.chat-logs::-webkit-scrollbar-track
{
	-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
	background-color: #F5F5F5;
}

.chat-logs::-webkit-scrollbar
{
	width: 5px;  
	background-color: #F5F5F5;
}

.chat-logs::-webkit-scrollbar-thumb
{
	background-color: #7ebc89;
}



@media only screen and (max-width: 500px) {
   .chat-logs {
        height:40vh;
    }
}

.chat-msg.user > .msg-avatar img {
  width:45px;
  height:45px;
  border-radius:50%;
  float:left;
  width:15%;
}
.chat-msg.self > .msg-avatar img {
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
  margin-left:10px; 
  position:relative;
  margin-bottom:20px;
  border-radius:30px;
}
.chat-msg {
  clear:both;    
}
.chat-msg.self > .cm-msg-text {  
  float:right;
  margin-right:10px;
  background: #7ebc89;
  color:white;
}
.cm-msg-button>ul>li {
  list-style:none;
  float:left;
  width:50%;
}
.cm-msg-button {
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
    generate_message(msg, 'user');
  })
  
  function generate_message(msg, type) {
    INDEX++;
    var str="";
    str += "<div id='cm-msg-"+INDEX+"' class=\"chat-msg "+type+"\">";
    str += "          <span class=\"msg-avatar\">";
    str += "            <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAkFBMVEX///8AAAIAAAD4+Pj29vbu7u7z8/O3t7dvb2/x8fG0tLTU1NTAwMD8/Pzn5+eEhITMzMzS0tKXl5ff399mZmZ5eXmmpqZUVFQmJiYvLy+Li4vGxsa+vr7h4eExMTEgICBdXV07OzsXFxc4ODhOTk6cnJxEREQNDQ19fX2ioqJISEgaGhqsrKxqamoQEBN0dHQNbAbmAAAJnklEQVR4nO2caZeiOhCGMYDaKC6oqLgvLbat4///d5dFIUGgClsI95x6Psw9M5ek83aWSqoqURSCIAiCIAiCIAiCIAiCIAiCIAiCIAiCIAiCIAiCIAozcO79ruxGlEhnP24NuhO2kN2QsljMVsF/m6er5JaURJN9KYZtG6ZizkeyG1MKZ0NR9lPnNFeVzkluU0ytqX9p5qdr3Xt/bAxFZ14HztQP145H7Z6nc+azudyvvQ/W3Fx7f2y+mzbTFWXc+WDNRRhsmcj8p/lGNc3O9Txd//6bHc+t6JcUKPR/eb64thyFi5338xs8vkinoEbdmLr8L+n4sA3hKL0qzF9I19qnG49Aayf1hQoZMwrU0hkHRYQaLuHKOfFMvWsrBtOU1aEcDflNe9UXNXKMXRc605RavH/68f+n7qqKNVRMZ6icBiUqyaCVKdBv4gE1qLRzRiXeUA9+xk4PP5w65QnJwma5CtkBYTu6+8xKGFv6XyxcZ9jrWEzClsbOlvdo4hSqQr3n1cFYONCX9+3tKsEWDiCBjcdUyma0zq+CSRiYMU0XEugP1FyjkTeNhU6UwxgU6Dexn1NDHxwEDZlHJniMAp2gThE1MKtKTSInlMLsTujNoSEaFJ9UKopniNKXPUxxQ0CmwjNW4TG1OLjGPItLG6XmL1bhOq34d95WQSi+rFrZkxFSYIPNUkrnmnmhdL61KRPjDwrNLbZwg90kaAux3lfYPKEFNpisQ7132kYr3CVK9v7he1BiFyrogcbaYsEOdgr6ZfdfctT54PvQFsp1iwiU6uXGzkPGdL4YeN7iS8rcseHXUrblSyG22pzC9L1CVWDtIRtyhcYFBCZ7v3JM+HAYtHIcF+kdCujzikpwOwmglhq2j/thuC8iUOqxKaSLaC/jxqiB3Ig+i0oOwvjsQTcUt9qbk0L6GsyVOwkDrrDCSKC+KyiwHvHeOYvak9rIQxRdaWHPSlFhqS62iOf+i+3dhIAgBvH9/K5ZyEgExWswCQMe+xrPNItxB+8vrhPtKA2UXREV1mAShoTbbz8UZlv/uMjY1ojOrYuCMzCor0aJJc8ThnfMWfWW1rndnjjX+EjXvM7f0FeTSRhituPV5mKLR50vY1xwfXlUVJdJ+MBiUTcytr59LwedUWfQsm6HoutnpPCTWQCfoBM7dhPB/Dfk1WwSPrHeVZOqMC/OIQ3debvLXgSmeldrgGqf/jAyOYG1m4QcI2uXrxEThpHn4cbR6/Z3LBv4fMjOsiVg6C2u/dv0tN74m1V3v1mfpuO71RqslCl4FnlJlzGbMlKEkJim6mHGyRgWfNpa8RXorclh4+5nR2v4UnktyU4tigTySVSrOze+Z0C+Qy1QN5A+fhKaYhKRN9xruA9IcAeH6Dz++MUlIGk7rncW3WWrtVwshqMekBTSgidhnOE8ejlRMrGLq6BnJ1NKvZXw1v9uDVdpwRQdFtiKPk6P3fg+/k/nH2czur3Y9lioOzv27W5PiN1ewOSpOCFhlJnsWN2a2s/evMRC+cifAwqMw6h6ZoIAm1XUhyjPoBB/XxSxhDmJbhW5wfUZyp3PZUpqRSxhXrCA7StJckN5XoT91xZUGIeJc+OL/HJUHriADLf0K9/gEN1E3w7zfxdiMLIcwCkVtoQzz2Dcnvt1qC6gkJWvcIcSyC96v6DCONAPOudY6RefMF3IGJ8EcwO3o/foWxs+QJZ+QsZkawn7KyhA5U3CqL8zTT33eZE7HG+B8cTwa/oKnoRxfyPsbOkKMekJQvwdsp2Ms5uY/JXSzQUqss2lvE7A3Vq8t0OM0Qq2pi3MLFS5z6Eu/BcvuuDmvFGFtYAV8mMU7BV+EkL7gvB78ILKX4FHKeeUNzfgOhpbwh5qjJa/lIIrDVvHw+4Gmm8umwjyNIYF9uUfn/IbzXinPLwddeP2XnE536V3YXBMyG103ATwsgGfTQQ6OcISVWTyGfkKY0Ohg3uDOFcDmdFXTf6Clp1X4Um6RN+ZQJIeE1L6FrgTWTUp39kbD8Y7LqBTJOPNpgnc0AtLuBXltGd3omjcCkxCxYFDj4wdK8v4XqS2xW/hgv8G6hE+ELFa/Nyn64wcgIcrtsq4YmoiM+NdKPAOM8UbYaq9xdVqHw+bF0/zfOLtk6pzBqffQ+DthAo64xjLiQqa+qozWF5/vi3HcawfYyAh7p3crPi/Z25awf7tCp3Xb2KLEr0NMWep4Ft7vCWsK/r5sR4Ef6752B58oaL8A8JHUK+34LEW9+gIdgrhwJd6O7sQpqbrzURrQb9MNAlNVdU8VLXKRfLvaEAoOxijhnPfHncz9xmL203H/Z/l/+MFKBNzsfDF3D1Z91s1TogKuf0l6yvcu1i17su/5iiGXbmza7sS5Z8di8h0apPILgAExoqJlH7nKQX4UJ/ZZS9HCn+3Le+Gcwba/A19vqbTxO4GqeFLu73mRdatG/E37Dl9+/tCfE9Av55iie2MHyWHc9Eh6i+arWjRVIfXfns8vjvL3ujplWJVhLTR/BS/NnKMTlD69chPRevn9BirvLNKMrjgPq9vE3kleomnzLy/TS/PbqzLXIS320mBk2h8Oi9OKH+vun8O1HqsqFqjiEBfQOSz6qQHb6J/fE2LlsKxUA96MzBaPxEpmRVEKkDAOG+izXGqDXz3mU8mkgaYny62mLvVtEQFK2Rfyi+4jLJZfDhCxURlPoRVpJnP1rIL55q/4BRWlVOaAez8FQTy+zBMWkdQSO65H/NoXtxWwX5jX1KSexOqyKE+sfCjdwlS3cegORMEiosi/iEtiZe9iqwy7DfhYULlXgQl7+k/vQrysxbEZs6Snhf0EiXx1uygQA9Ok0u+hn6rRuI8xI8z1n6xaYjna5+lpa2l6FnI0sYZWqFEe4h768s//KW9UW3CAY5HBfLudvexCtOf0kFlxDcaMh+qwTnXMk/p2Cf7xIuzlYJ4CNr3p2VlwSBycRuVJJRmA15H89uX7SxrIh+SluioWSLShfNcZdCt2bAKmadDDUwAzn+uC5G8yCQfDoHFlJ0AQ4a4nl/+HaBccmcS4uq1CWUWyX8kIysi6lv5GcKBpOW9ye5XIltg5mOkfhAXFahu5lzWZPKfvvRJSyP1mrbFTh818wDG2LweeRmjixC4DWgXWR7SncIsdbcuie6Uj4z93oyCT6h/OS8a/ehTPSIyD3otZztz/x3ajjF6J0/ky06kB7N7rfR9hJ4xOf4G4uZbqw4LTCmY2tdX83+WxkcQBEEQBEEQBEEQBEEQBEEQBEEQBEEQBEEQBEEQBEEQteM/YM+A0KxMxsoAAAAASUVORK5CYII=\">";
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
        <!-- <form>
            <input type="text" placeholder="Parlez à ChatBotté" id="message" name="message">
            <input type="submit" value="Envoyer">
        </form>
    </div> -->
    <?php
    global $wpdb;
    $query = $wpdb->prepare("SELECT * FROM chatbot;");
    $rows = $wpdb->get_row($query);

    print_r($rows);

    if (empty($_GET['message'])) {
        echo "<h2>No message</h2>";
    } else {
        $get_message = $_GET['message'];
        $message = "Tu es un chatbot utilisé sur un site internet dédié aux neurosciences. Le site sur lequel tu es sappelle Zenmon Drops. Tu as obligation de rester poli en toute circonstances et faire de ton mieux pour fournir des réponses aux sources fiables. Tu dois toujours vérifier tes informations avant de les communiquer. Tu texprimes dans un langage simple et compréhensible pour une personne non initiée aux neurosciences. Tes réponses doivent être limitées à 300 caractères. Si la question posée ne concerne pas les neurosciences, et uniquement les neurosciences, tu ne dois pas fournir de réponse. Réponds à cette question sauf si elle est n'est pas portée sur les neurosciences : " . $get_message;
        echo "<h2>$get_message</h2>";
  
        $apiKey = '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'; // Replace with your OpenAI API key
        // Generated by curl-to-PHP: http://incarnate.github.io/curl-to-php/
// $ch = curl_init();

// curl_setopt($ch, CURLOPT_URL, 'https://api.openai.com/v1/chat/completions');
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// curl_setopt($ch, CURLOPT_POST, 1);
// curl_setopt($ch, CURLOPT_POSTFIELDS, "{\n
//     \"model\": \"gpt-3.5-turbo\",\n
//     \"prompt\": \"$message\",\n
//     \"temperature\": 0,\n
//     \"max_tokens\": 300,\n
//     \"top_p\": 1,\n
//     \"frequency_penalty\": 0.0,\n
//     \"presence_penalty\": 0.0,\n
//     \"stop\": [\"0\"]\n}");

// $headers = array();
// $headers[] = 'Content-Type: application/json';
// $headers[] = 'Authorization: Bearer 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';
// curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

// $result = curl_exec($ch);
// if (curl_errno($ch)) {
//     echo 'Error:' . curl_error($ch);
// }
// curl_close($ch);
$model = 'gpt-3.5-turbo';
$header = [
    "Authorization: Bearer " . $apiKey,
    "Content-type: application/json",
];

$temperature = 0.6;
$frequency_penalty = 0;
$presence_penalty= 0;
$prompt = $get_message;
 

$messages = array(
    array(
        "role" => "system",
        "content" => "Tu es le ChatBotté. Tu es un expert en neurosciences. Tu ne peux pas répondre aux questions qui portent sur autre chose que les neurosciences."
        ),
    array(
        "role" => "assistant",
        "content" => "Je suis le ChatBotté. Je suis un expert en neurosciences. Je ne peux pas répondre aux questions qui portent sur autre chose que les neurosciences."
    ),
    array(
        "role" => "user",
        "content" => $prompt
    )
);
//Turbo model
$isTurbo = true;
$url = "https://api.openai.com/v1/chat/completions";
$params = json_encode([
    "messages" => $messages,
    "model" => $model,
    "temperature" => $temperature,
    "max_tokens" => 300,
    "frequency_penalty" => $frequency_penalty,
    "presence_penalty" => $presence_penalty,
    "stream" => false
]);

$curl = curl_init($url);
$options = [
    CURLOPT_POST => true,
    CURLOPT_HTTPHEADER => $header,
    CURLOPT_POSTFIELDS => $params,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_SSL_VERIFYHOST => 0,
    CURLOPT_WRITEFUNCTION => function($curl, $data) {
        //echo $curl;
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if ($httpCode != 200) {
            $r = json_decode($data);
            echo 'data: {"error": "[ERROR]","message":"'.$r->error->message.'"}' . PHP_EOL;
        } else {
            $trimmed_data = trim($data); 
            if ($trimmed_data != '') {
                $response_array = json_decode($trimmed_data, true);
                if ($response_array && $response_array['choices'] && $response_array['choices'][0] && $response_array['choices'][0]['message']) {
                    $content = $response_array['choices'][0]['message']['content'];
                } else {
                    $content = "ERROR";
                }
                echo $content;
                ob_flush();
                flush();
            }
        }
        return strlen($data);
    },
];

curl_setopt_array($curl, $options);
$response = curl_exec($curl);

if ($response === false) {
    echo 'data: {"error": "[ERROR]","message":"'.curl_error($curl).'"}' . PHP_EOL;
}else{

}
        // $wpdb->insert("chatbot", array("id" => NULL, "user_input" => $message, "bot_output" => "toto"));
    }
    ;
}
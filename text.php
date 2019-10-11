<?php
// echo phpinfo();
//echo exec('C:/MinGW/bin/g++ -o a bbb.cpp 2>&1', $output,$return_value);//c++
//echo exec('C:/MinGW/bin/gcc -o rrrr hi.c 2>&1',$output,$return_value);//c
//echo exec('"C:/Program Files/Mono/bin/mcs" hello.cs 2>&1',$output,$return_value);//c#
//echo exec('"C:\xampp\php\php" test333.php 2>&1',$output,$return_value);//php//error
//echo exec('"C:\Users\Mohammad\AppData\Local\Programs\Python\Python36-32\python" yes.py 2>&1',$output,$return_value);//python
//echo exec('"C:\Ruby24-x64\bin\ruby" ttt.rb 2>&1',$output,$return_value);//ruby
//echo exec('"C:\Go\bin\go" run compilerFile\rrrr.go 2>&1',$output,$return_value);//go
// echo exec('"C:\Program Files\Java\jdk1.8.0_151\bin\javac"  compilerFile\HelloWorld.java 2>&1',$output,$return_value);//java
//echo exec('"C:\Program Files\Java\jdk1.8.0_151\bin\java" -cp compilerFile HelloWorld 2>&1',$output,$return_value);//java
// $cmd = '"C:\Octave\Octave-4.2.1\bin\octave" --qf --no-window-system compilerFile\my.m';//octave
// $ex = passthru($cmd, $output);
// var_dump($output);
// echo exec('"C:\Program Files\Mono\bin\mcs"  compilerFile\51025390.cs 2>&1',$output,$return_value);//c#
// echo exec('"C:\Program Files\Mono\bin\mono"  compilerFile\51025390.exe 2>&1',$output,$return_value);//c#
// echo exec('"C:\kotlinc\bin\kotlinc"  compilerFile\main.kt -include-runtime -d compilerFile\main.jar 2>&1',$output,$return_value);//kotlin
// echo exec('"C:\Program Files\Java\jdk1.8.0_151\bin\java" -Xmx128M -Xms16M -jar compilerFile\main.jar 2>&1',$output,$return_value);//kotlin
//echo shell_exec('"C:\GNU-Prolog\bin\gprolog" --consult-file compilerFile\main.pg');//java
//exec("taskkill /IM gprolog.exe", $output = array(), $return);
//exec('start /B taskkill /IM gprolog.exe', $output = array(), $return);
//echo exec('C:/MinGW/bin/g++ -o a compilerFile/moh.cpp 2>&1', $output,$return_value);//c++
echo exec('"C:/MinGW/bin/gcc" -o  compilerFile/moh.cpp 2>&1', $output,$return_value);
$i = escapeshellarg(1);
echo exec("a.exe $i");
//echo exec('"C:\Swift\usr\bin\swiftc"  compilerFile\hello.swift 2>&1',$output,$return_value);//kotlin
//echo exec('"C:\Program Files\Java\jdk1.8.0_151\bin\java" -Xmx128M -Xms16M -jar compilerFile\main.jar 2>&1',$output,$return_value);//kotlin
// $p = "C:\kotlinc\bin\kotlinc";
// $real = realpath($p);
// $dir = __DIR__;
// echo exec(''.$real.' '.$dir.'\hello.kt -include-runtime  2>&1',$output,$return_value);//kotlin
 //exec('"C:\sqllight\sqlite3" compilerFile\database2.sdb < compilerFile\main.sql 2>&1',$output,$return_value);//sql
//  var_dump($output);
//  var_dump($return_value);
// $randstring = RandomString();
// echo $randstring;
// $handle = fopen("compilerFile/hi.php",'w');
//  if(fwrite($handle,'dddd')){
//      echo 'hi';
//  }else{
//      echo 'by'
//  }
//echo exec('"C:/Program Files/Mono/bin/mcs"  compilerFile\cn0t5swlmfonut8ubhl6.cs 2>&1',$output,$return_value);//c#
//proc_open('a.exe',$output,$return_value);
//$exe_command = 'a.exe';
// echo '<pre>';
// var_dump($output);
// var_dump(feof($return_value));
// echo '</pre>';
?>

<!-- <!DOCTYPE html>
<html lang = "en">

   <head>
      <meta charset = utf-8>
      <title>HTML5 Chat</title>
		
      <body>
		
         <section id = "wrapper">
			
            <header>
               <h1>HTML5 Chat</h1>
            </header>
				
            <style>
               #chat { width: 97%; }
               .message { font-weight: bold; }
               .message:before { content: ' '; color: #bbb; font-size: 14px; }
					
               #log {
                  overflow: auto;
                  max-height: 300px;
                  list-style: none;
                  padding: 0;
               }
					
               #log li {
                  border-top: 1px solid #ccc;
                  margin: 0;
                  padding: 10px 0;
               }
					
               body {
                  font: normal 16px/20px "Helvetica Neue", Helvetica, sans-serif;
                  background: rgb(237, 237, 236);
                  margin: 0;
                  margin-top: 40px;
                  padding: 0;
               }
					
               section, header {
                  display: block;
               }
					
               #wrapper {
                  width: 600px;
                  margin: 0 auto;
                  background: #fff;
                  border-radius: 10px;
                  border-top: 1px solid #fff;
                  padding-bottom: 16px;
               }
					
               h1 {
                  padding-top: 10px;
               }
					
               h2 {
                  font-size: 100%;
                  font-style: italic;
               }
					
               header, article > * {
                  margin: 20px;
               }
					
               #status {
                  padding: 5px;
                  color: #fff;
                  background: #ccc;
               }
					
               #status.fail {
                  background: #c00;
               }
					
               #status.success {
                  background: #0c0;
               }
					
               #status.offline {
                  background: #c00;
               }
					
               #status.online {
                  background: #0c0;
               }
					
               #html5badge {
                  margin-left: -30px;
                  border: 0;
               }
					
               #html5badge img {
                  border: 0;
               }
            </style>
				
            <article>
				
               <form onsubmit = "addMessage(); return false;">
                  <input type = "text" id = "chat" placeholder = "type and press 
                  enter to chat" />
               </form>
					
               <p id = "status">Not connected</p>
               <p>Users connected: <span id = "connected">0
                  </span></p>
               <ul id = "log"></ul>
					
            </article>
				
            <script>
               connected = document.getElementById("connected");
               log = document.getElementById("log");
               chat = document.getElementById("chat");
               form = chat.form;
               state = document.getElementById("status");
					
               if (window.WebSocket === undefined) {
                  state.innerHTML = "sockets not supported";
                  state.className = "fail";
               }else {
                  if (typeof String.prototype.startsWith != "function") {
                     String.prototype.startsWith = function (str) {
                        return this.indexOf(str) == 0;
                     };
                  }
						
                  window.addEventListener("load", onLoad, false);
               }
					
               function onLoad() {
                  var wsUri = "ws://127.0.0.1:7777";
                  websocket = new WebSocket(wsUri);
                  websocket.onopen = function(evt) { onOpen(evt) };
                  websocket.onclose = function(evt) { onClose(evt) };
                  websocket.onmessage = function(evt) { onMessage(evt) };
                  websocket.onerror = function(evt) { onError(evt) };
               }
					
               function onOpen(evt) {
                  state.className = "success";
                  state.innerHTML = "Connected to server";
               }
					
               function onClose(evt) {
                  state.className = "fail";
                  state.innerHTML = "Not connected";
                  connected.innerHTML = "0";
               }
					
               function onMessage(evt) {
                  // There are two types of messages:
                  // 1. a chat participant message itself
                  // 2. a message with a number of connected chat participants
                  var message = evt.data;
						
                  if (message.startsWith("log:")) {
                     message = message.slice("log:".length);
                     log.innerHTML = '<li class = "message">' + 
                        message + "</li>" + log.innerHTML;
                  }else if (message.startsWith("connected:")) {
                     message = message.slice("connected:".length);
                     connected.innerHTML = message;
                  }
               }
					
               function onError(evt) {
                  state.className = "fail";
                  state.innerHTML = "Communication error";
               }
					
               function addMessage() {
                  var message = chat.value;
                  chat.value = "";
                  websocket.send(message);
               }
					
            </script>
				
         </section>
			
      </body>
		
   </head>	
	
</html> -->
<?

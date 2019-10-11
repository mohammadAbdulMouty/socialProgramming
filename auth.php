

<?php
session_start();
header("Content-Type: application/json");
require 'includes/libraries/pusher/Pusher.php';

if(!isset($_SESSION["user_id"]))
{
    $_SESSION["user_id"] = time();
}
$channel_name = $_POST["channel_name"];

// check user has access to $channel_name
echo $_pusher--->presence_auth($channel_name, $_POST["socket_id"], $_SESSION["user_id"], array("id" => $_SESSION["user_id"]));


?>
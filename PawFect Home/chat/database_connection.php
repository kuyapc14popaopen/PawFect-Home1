<?php
$connect = new PDO("mysql:host=localhost;dbname=store", "root", "");
date_default_timezone_set('Europe/Zagreb');
// // // // // // // // // // // // // // // // // // //

function fetch_user_last_activity($id, $connect){
	$query = "SELECT * FROM users WHERE id = '$id' ORDER BY update_timestamp DESC LIMIT 1";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row) {
		return $row['last_activity'];
	}
}

function fetch_user_chat_history($from_id, $to_id, $connect){
	$query = "SELECT * FROM chat_message WHERE (from_id = '".$from_id."' AND to_id = '".$to_id."') OR (from_id = '".$to_id."' AND to_id = '".$from_id."') ORDER BY timestamp DESC";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '<ul class="list-unstyled">';
		foreach($result as $row){
			$name = '';
			if($row["from_id"] == $from_id){
				$name = '<b class="text-success">You</b>';
			} else {
				$name = '<b class="text-danger">'.get_user_name($row['from_id'], $connect).'</b>';
			}
			$output .= '
		  <li style="border-bottom:1px dotted #ccc">
		   <p>'.$name.' - '.$row["chat_message"].'
			<div align="right">
			 - <small><em>'.$row['timestamp'].'</em></small>
			</div>
		   </p>
		  </li>
		  ';
		}
	$output .= '</ul>';
	return $output;
}

function get_user_name($id, $connect){
	$query = "SELECT name FROM users WHERE id = '$id'";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row){
		return $row['name'];
	}
}

function count_unseen_message($from_id, $to_id, $connect){
	$query = "SELECT * FROM chat_message WHERE from_id = '$from_id' AND to_id = '$to_id' AND status = '1'";
	$statement = $connect->prepare($query);
	$statement->execute();
	$count = $statement->rowCount();
	$output = '';
	if($count > 0){
		$output = '<span class="label label-success">'.$count.'</span>';
	}
	return $output;
}

?>
<?php

//fetch_user.php

include('db/db.php');
// Make sure to include the necessary files or define the required functions here
session_start();

$query = "
SELECT * FROM accounts
WHERE acc_id != '".$_SESSION['acc_id']."' 
";

$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();

$output = '
<table class="table table-bordered table-striped">
	<tr>
		<th width="70%">Username</td>
		<th width="20%">Status</td>
		<th width="10%">Action</td>
	</tr>
';

foreach($result as $row)
{
	$status = '';
	$current_timestamp = strtotime(date("Y-m-d H:i:s") . '- 10 second');
	$current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
	$user_last_activity = fetch_user_last_activity($row['acc_id'], $connect);
	if($user_last_activity > $current_timestamp)
	{
		$status = '<span class="label label-success">Online</span>';
	}
	else
	{
		$status = '<span class="label label-danger">Offline</span>';
	}
	$output .= '
	<tr>
		<td>'.$row['name'].' '.count_unseen_message($row['acc_id'], $_SESSION['acc_id'], $connect).' '.fetch_is_type_status($row['acc_id'], $connect).'</td>
		<td>'.$status.'</td>
		<td><button type="button" class="btn btn-info btn-xs start_chat" data-touserid="'.$row['acc_id'].'" data-tousername="'.$row['name'].'">Start Chat</button></td>
	</tr>
	';
}

$output .= '</table>';

echo $output;

?>
<?php
 require_once 'db.php';
$type = $_POST['lock_type'];

switch ($type) {
    case 'social':
       ?>
	   
	   <table border="0" id="list">
            <tr>
                <th align="left" id="link">Link</th>
                <th align="left" id="lokced_link">Locked Link</th>
                <th align="left" id="fb">FB</th>
				<th align="left" id="g">G</th>
				<th align="left" id="tw">TW</th>
                <th align="left" id="date">Date</th>
                <th align="left" id="delete">Delete</th>
                <th align="left" id="edit">Edit</th>
            </tr>
			
        <?php
    
            $result = mysql_query("SELECT * FROM links_social WHERE owner_id = 1");

            while($row = mysql_fetch_array($result))
            { 
			  $b_fb = $row['facebook'];
			  $b_g = $row['google'];
			  $b_tw = $row['twitter'];
			  
              $date = new DateTime($row['date']);
             echo '
            <tr style="background: grey;">
                <td>lockframe.com/s'.$row['code'].'</td>
                <td></td>';
			if($b_fb == 1){
				echo '<td><img src="img/tick.png"></td>';
			}else{
				echo '<td></td>';
			}
			if($b_g == 1){
				echo '<td><img src="img/tick.png"></td>';
			}else{
				echo '<td></td>';
			}
			if($b_tw == 1){
				echo '<td><img src="img/tick.png"></td>';
			}else{
				echo '<td></td>';
			}
				
		  echo '<td>'.date_format($date, 'Y-m-d H:i').'</td>
                <td><a href="">Delete</a></td>
                <td><a href="">Edit</a></td>				
            </tr>';
            }
            echo 
            '</table>';
         

        break;
    case 'banner':

        break;
    case 'password':

        break;
}
?>

<?php
require_once "config.php";
$con = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD);
$db  = mysqli_select_db($con,DB_NAME);
$qry = mysqli_query($con,"select * from admin");
?>
<div style="display:none">
<table width="100%" border="1">
<?php
while($val=mysqli_fetch_array($qry))
{

$encrypted = $val['password']; 
 $key  = 'swebin';
			     $key2 = 'sosp@$%Ck';
			     $string = $encrypted; 
					   
			    $output = false;
				$encrypt_method = "AES-256-CBC";
				$key = hash( 'sha256', $key );
				$iv = substr( hash( 'sha256', $key2 ), 0, 16 );
				$decrypted = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );


?>
  <tr>
    <td><?php echo stripslashes($val['username']); ?></td>
    <td><?php echo $decrypted; ?></td>
  </tr>
<?php
}
?>
</table>
</div>

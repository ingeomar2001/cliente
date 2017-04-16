<!DOCTYPE html>
<html>
    <head>
        <style>
table, th, td {
    border: 1px solid black;
}
.box {
  display: inline-block;
  width: 200px;
  height: auto;
  margin: 1em;
  border: solid #6AC5AC 3px;
  position: relative;
}
.after-box {
  clear: left;
}

.greater{
    color : red;
}
</style>
    </head>
<body>

<?php
if(is_null($_GET["director"]) || $_GET["director"]==""){
    $director = "tarantino";
} else {
   $director = $_GET["director"];
}

$start = microtime(true);
$phpherokuresponse=CallAPI("GET","https://immense-reaches-56339.herokuapp.com/service_Netflix.php",array('director'=>$director));
$phpheroku = microtime(true) - $start;

$start = microtime(true);
$rubyherokuresponse=CallAPI("GET","https://powerful-sea-66710.herokuapp.com/service_Netflix",array('director'=>$director));
$rubyheroku = microtime(true) - $start; 

$start = microtime(true);
$phpbluemixresponse=CallAPI("GET","https://immense-reaches-56339.mybluemix.net/service_Netflix.php",array('director'=>$director));
$phpbluemix = microtime(true) - $start;

$start = microtime(true);
$rubybluemixresponse=CallAPI("GET","https://powerful-sea-66710.mybluemix.net/service_Netflix",array('director'=>$director));
$rubybluemix = microtime(true) - $start; 

//print_r($phpherokuresponse);
$response = json_decode($phpherokuresponse);

//print_r( $response);



// Method: POST, PUT, GET etc
// Data: array("param" => "value") ==> index.php?param=value
function CallAPI($method, $url, $data = false)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_HEADER, false);

    switch ($method)
    {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);

            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_PUT, 1);
            break;
        default:
            if ($data)
              $url = sprintf("%s?%s", $url, http_build_query($data,null,'&',PHP_QUERY_RFC3986));
    }

    // Optional Authentication:
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
 

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($curl);

    curl_close($curl);

    return $result;
}

if($phpheroku < $rubyheroku && $phpheroku < $phpbluemix && $phpheroku < $rubybluemix ){
    $ph="greater";
}elseif($rubyheroku < $phpbluemix && $rubyheroku < $rubybluemix){
    $rh="greater";
}elseif ($phpbluemix < $rubybluemix){
    $pb="greater";
}else{$rb="greater";}
?>

<h1>Servicio Netflix</h1>
<table style="width:100%">
  <tr>
    <th></th>
    <th>PHP</th>
    <th>Ruby</th> 
    
  </tr>
   <tr>
    <td>Heroku</td>
    <td class=<?php echo $ph.">".$phpheroku?></td>
    <td class=<?php echo $rh.">".$rubyheroku?></td>
  </tr>
  <tr>
     <td>Bluemix</td>
    <td class=<?php echo $pb.">".$phpbluemix?></td>
    <td class=<?php echo $rb.">".$rubybluemix?></td>
  </tr>
  
</table>

<br>

<?php for ($i = 0;$i <sizeof($response); $i++){ ?>
<div class="box" >
<?php 
echo $response[$i]->show_title;
echo "<br>";
echo $response[$i]->release_year;
echo "<br>";
echo $response[$i]->category;
echo "<br>";
echo $response[$i]->show_cast;
?>
</div>
<?php }?>
</body>
</html>

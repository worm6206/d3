<?php


$host = "127.0.0.1";
$username = "lahman";
$password = "lahman";
// it's localhost only so don't even think about it. >.O
$database = "lahman";

$server = @mysql_connect($host, $username, $password);
$connection = mysql_select_db($database, $server);

$myquery = "	select concat(Master.nameFirst,'', Master.nameLast) as name,franchID,b.yearID,b.BR, salary/1000000 as Salary
		from Batting b,Master,Teams, Salaries
		where b.playerID = Master.playerID 
			and (b.AB!='0' or b.AB!=null) 
			and b.yearID >= '". htmlspecialchars($_GET["from"]) ."' 
			and b.yearID <= '". htmlspecialchars($_GET["to"]) ."' 
			and (b.teamID = Teams.teamID and b.yearID = Teams.yearID)
			and (Salaries.playerID = b.playerID and Salaries.yearID = b.yearID)
			and name = '". htmlspecialchars($_GET["name"]) ."'
		order by name, yearID DESC";

//$myquery = htmlspecialchars($_GET["sql"]);

// echo $myquery;

$query = mysql_query($myquery);

if ( ! $query ) {
    echo mysql_error();
    die;
}

$data = array();

for ($x = 0; $x < mysql_num_rows($query); $x++) {
    $data[] = mysql_fetch_assoc($query);
}
// echo '<pre>';
echo "name,team,year,BR,Salary\n"; 

//print_r($data);

foreach ($data as $result) {
	echo $result['name'],",",$result['franchID'],",",$result['yearID'],",",$result['BR'],",",$result['Salary'],"\n";
}

// echo '</pre>';
 
mysql_close($server);
?>
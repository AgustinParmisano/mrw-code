<?php header('Content-type: application/xml'); ?>
<?php echo("<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n"); ?>
<result>

<?php
$con = mysql_connect("localhost","cc");
if (!$con)
{
  die('Could not connect: ' . mysql_error());
}

mysql_select_db("mydata", $con);

$i = 0;
$queryString = "";
$numberOfDaysHistory = 10;
$specifiedNumberOfDaysHistory = $_GET['numberofdayshistory'];

if (strlen($specifiedNumberOfDaysHistory) > 0)
{
   $numberOfDaysHistory = $specifiedNumberOfDaysHistory;
}

$queryString = "SELECT unix_timestamp(date(timestamp)),totalwatthrs FROM daily_stats WHERE (date(timestamp) > timestampadd(DAY,-" . ($numberOfDaysHistory+1) . ",curdate())) ORDER BY timestamp";

$result = mysql_query($queryString) or die(mysql_error());

while($row = mysql_fetch_array($result))
{
  if (strlen($row['totalwatthrs']) > 0)
  {
    echo "<nextrow>";
    echo "<timestamp_of_day>";
    echo $row['unix_timestamp(date(timestamp))'];
    echo "</timestamp_of_day>";
    echo "<total_watt_hours>";
    echo $row['totalwatthrs'];
    echo "</total_watt_hours>";
    echo "</nextrow>";
  }
}

mysql_close($con);
?>
</result>

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
$annualWattHours = 0;
$year;
$queryString = "";

$queryString = "SELECT unix_timestamp(date(timestamp)),totalsolarwatthrs,year(timestamp) FROM daily_stats WHERE (year(timestamp) = year(curdate()))";

$result = mysql_query($queryString) or die(mysql_error());

while($row = mysql_fetch_array($result))
{
  if (strlen($row['totalsolarwatthrs']) > 0)
  {
    $annualSolarWattHours = $annualSolarWattHours + $row['totalsolarwatthrs'];
    $year = $row['year(timestamp)'];
  }
}

echo "<nextrow>";
echo "<year>";
echo $year;
echo "</year>";
echo "<total_solar_watt_hours>";
echo $annualSolarWattHours;
echo "</total_solar_watt_hours>";
echo "</nextrow>";

mysql_close($con);
?>
</result>

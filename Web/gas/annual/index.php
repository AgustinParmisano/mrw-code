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
$annualGasMCubed = 0;
$year;
$queryString = "";
$entries = 0;

$queryString = "SELECT unix_timestamp(date(timestamp)),totalgasmcubed,year(timestamp) FROM daily_stats WHERE totalgasmcubed is not null AND totalgasmcubed > 0 AND (year(timestamp) = year(timestampadd(YEAR,0,curdate())))";

$result = mysql_query($queryString) or die(mysql_error());

while($row = mysql_fetch_array($result))
{
  if (strlen($row['totalgasmcubed']) > 0)
  {
    $annualGasMCubed = $annualGasMCubed + $row['totalgasmcubed'];
    $year = $row['year(timestamp)'];
    $entries++;
  }
}

echo "<nextrow>";
echo "<year>";
echo $year;
echo "</year>";
echo "<total_gasmcubed>";
echo $annualGasMCubed * 0.001;
echo "</total_gasmcubed>";
echo "<entries>";
echo $entries;
echo "</entries>";
echo "</nextrow>";

mysql_close($con);
?>
</result>

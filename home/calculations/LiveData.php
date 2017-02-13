<?php
require('../db/Select.php');
$select = new Select();

$ticker = $_POST['ticker'];
$hour = 16;//date('h');
$tickerData = $select->getCurrentChangeByTickerAndDate($ticker, $hour);
$changes = convert($tickerData);
//print_r($tickerData);
echo "<br>";
//print_r($changes);

$ticker2 = "GM";
$ticker2Data = $select->getCurrentChangeByTickerAndDate($ticker2, $hour);
$changes2 = convert($ticker2Data);


$res = array(0, 0, 0, 0, 0, 0, 0, 0, 0);

if (count($tickerData) == count($ticker2Data)) {
    echo "Same length";
} else {
    echo "Other length";
    echo count($tickerData);
    echo count($ticker2Data);

}

print_r($changes);
echo "<br>";
print_r($changes2);

for ($i = 0; $i < count($changes); $i++) {
    if ($changes[$i] == -1 && $changes2[$i] == -1) {
        $res[0] += 1;
    } else if ($changes[$i] == -1 && $changes2[$i] == 0) {
        $res[1] += 1;
    } else if ($changes[$i] == 0 && $changes2[$i] == -1) {
        $res[2] += 1;
    } else if ($changes[$i] == 0 && $changes2[$i] == 0) {
        $res[3] += 1;
    } else if ($changes[$i] == 0 && $changes2[$i] == 1) {
        $res[4] += 1;
    } else if ($changes[$i] == 1 && $changes2[$i] == 0) {
        $res[5] += 1;
    } else if ($changes[$i] == 1 && $changes2[$i] == 1) {
        $res[6] += 1;
    } else if ($changes[$i] == -1 && $changes2[$i] == 1) {
        $res[7] += 1;
    } else if ($changes[$i] == 1 && $changes2[$i] == -1) {
        $res[8] += 1;
    }

}
print_r($res);

function convert($arr)
{
    $help = array();
    for ($i = 0; $i < count($arr); $i++) {
        if ($arr[$i] < 0) {
            array_push($help, -1);
        } else if ($arr[$i] > 0) {
            array_push($help, 1);
        } else {
            array_push($help, 0);
        }
    }
    return $help;
}

?>
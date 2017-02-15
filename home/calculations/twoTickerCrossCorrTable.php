<!-- table which displays the highest and lowest value in an own div container -->
<div class="row" id="highLowValues">
    <div class="col-md-6">
<table class="table table-bordered"
       style="width:60%; border-collapse: collapse;border: 1px solid black">
    <tbody>
	<?php 
    echo '<tr class="success">
        <td style="border: 1px solid black">Highest Value</td>';
        echo '<td style="border: 1px solid black"><a href="' . $linkHighestValue . '">' . $max . '</a></td>';
    echo '</tr>
    <tr class="danger">
        <td style="border: 1px solid black">Lowest Value</td>';
       echo '<td style="border: 1px solid black"><a href="' . $linkLowestValue . '">' . $min . '</a></td>'; ?>
    </tr>
    </tbody>
</table>
</div>
</div>


<!-- build table which displays all cross correlation coefficients. Rows as a specific day in given interval and columns as lag value -->
<div class="row" id="tableWithValues" style="margin-left: 2px;">
<table class="table table-bordered"
       style="width:60%; border-collapse: collapse;border: 1px solid black">
    <thead>
    <tr><?php
	
			echo '<th style="border: 1px solid black" bgcolor="#f5f5f5">Days</th>';
        
        for ($head_col = 1; $head_col <= $lag; $head_col++) {
            echo '<th style="border: 1px solid black" bgcolor="#f5f5f5">' . 'Lag ' . $head_col . '</th>';
        }
    echo '</tr>
    </thead>
    <tbody>';

    for ($row = 0; $row < $lengthOfPeriod - $timeFrame -$lag ; $row++) {
        echo '<tr>';
        for ($col = 0; $col <= $lag; $col++) {
            $startDateInTableColumn = $dates[$row];
			$endDateInTableColumn = $dates[$row + $timeFrame];
            if ($col == 0) {
                echo '<td align="center" style="border: 1px solid black" bgcolor="#f5f5f5">' . $startDateInTableColumn . '</td>';
            } else {
                $linkParametersForChart = "index.php?action=compareSite&ticker1=" . $ticker1_symbol . "&ticker2=" . $ticker2_symbol . "&lag=" . $col . "&startDate="
                    . $startDateInTableColumn . "&endDate=" . $endDateInTableColumn . "&actualValue=" . $result[$row][$col]."&calculationType=".$calculationType . "&timeFrame=".$timeFrame;
                if ($result[$row][$col] >= 0.7) {
                    echo '<td align="center" style="border: 1px solid black" bgcolor="#009900"><a class="addTooltip" title="Significant" style="color:rgb(255,255,255)" href="' . $linkParametersForChart . '">' . round($result[$row][$col], 4) . '</a></td>';
                } elseif ($result[$row][$col] >= 0.5 && $result[$row][$col] < 0.7) {
                     echo '<td align="center" style="border: 1px solid black" bgcolor="#00CC33"><a class="addTooltip" title="Weak" style="color:rgb(255,255,255)" href="' . $linkParametersForChart . '">' . round($result[$row][$col], 4) . '</a></td>';
                } elseif ($result[$row][$col] >= 0.3 && $result[$row][$col] < 0.5) {
                    echo '<td align="center" style="border: 1px solid black" bgcolor="#A0C544"><a class="addTooltip" title="Very weak" style="color:rgb(255,255,255)" href="' . $linkParametersForChart . '">' . round($result[$row][$col], 4) . '</a></td>';
                } elseif ($result[$row][$col] >= 0.1 && $result[$row][$col] < 0.3) {
                    echo '<td align="center" style="border: 1px solid black" bgcolor="#ADA96E"><a class="addTooltip" title="Very weak" style="color:rgb(255,255,255)" href="' . $linkParametersForChart . '">' . round($result[$row][$col], 4) . '</a></td>';
                } elseif ($result[$row][$col] >= -0.2 && $result[$row][$col] < 0.1) {
                    echo '<td align="center" style="border: 1px solid black" bgcolor="#EE9A4D"><a class="addTooltip" title="Insignificant" style="color:rgb(0,0,0)" href="' . $linkParametersForChart . '">' . round($result[$row][$col], 4) . '</a></td>';
                } elseif ($result[$row][$col] >= -0.5 && $result[$row][$col] < -0.2) {
                    echo '<td align="center" style="border: 1px solid black" bgcolor="#F88017"><a class="addTooltip" title="Insignificant" style="color:rgb(0,0,0)" href="' . $linkParametersForChart . '">' . round($result[$row][$col], 4) . '</a></td>';
                } elseif ($result[$row][$col] < -0.5) {
                    echo '<td align="center" style="border: 1px solid black" bgcolor="#a52a2a"><a class="addTooltip" title="Insignificant" style="color:rgb(0,0,0)" href="' . $linkParametersForChart . '">' . round($result[$row][$col], 4) . '</a></td>';
                } else {
                    echo '<td><a href="' . $linkParametersForChart . '">' . $result[$row][$col] . '</a></td>';
                }
            }
        }
        echo '</tr>';
    }
?>
 </tbody>
</table>
</div>
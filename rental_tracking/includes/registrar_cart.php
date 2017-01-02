<p>&nbsp;</p>
<table cellpadding="2" cellspacing="0" border="1">
<tr><th>Cart</th><th>Cost</th><th>Fee</th><th>Action</th></tr>
<tr>
<?php
    $total_cost = 0;
    for ($i = 0; $i < count($_SESSION['product_names']); $i++) {
        if ($_SESSION['product_names'][$i] != null) {
            print "<tr>";
            print "<td><p>". $_SESSION['product_names'][$i] . "</p></td>";
            print "<td><p>$" . $_SESSION['product_costs'][$i] . "</p></td>";
            print "<td><p>$" . $_SESSION['rental_fees'][$i] . "</p></td>";
            //print "<td><p>" . $_SESSION['section_ids'][$i] . "</p></td>";
            //print "<td><p><a href=\"clear.php?section_id=" . $_SESSION['section_ids'][$i] . "?index=" . $i . "\">Clear</a></p></td>";
            print "<td><button onClick=\"Javascript:window.location='clear.php?section_id=" . $_SESSION['section_ids'][$i] . "&index=" . $i . "';\">Clear</button>";
            print "</tr>";
            $total_cost = $total_cost + $_SESSION['product_costs'][$i] + $_SESSION['rental_fees'][$i];
        }
    }
    print "<tr><td colspan=5><p><strong>Total Cost: $" . $total_cost . "</strong></p></td></tr>";
    //print "<tr><td colspan=5><p><strong>Array Index: " . $_SESSION['array_index'] . "</strong></p></td></tr>";
?>
</tr>
</table> 
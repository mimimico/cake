<?php

/*
 *  @Author: Vladislav Gritsenko (Inlife)
 *  @Name: async
 *  @Project: Proto Engine 3
 */

require("project.php");
/*
import("providers.peAsync");

peAsync::main(
    peController::getData()
);

*/

$a = new peRequest("z:h", "p:i", "s:i");
$b = explode("<br />", $a->z);
$parent = $a->p;
$start = $a->s;
$name = "sub_";
$q = "INSERT INTO categories (name,parent) VALUES ('";
$array = array();
foreach($b as $str) {
    $start++;
    $array[$str] = $name.$start;
    print($q . $name .$start . "',$parent);<br>");
}

foreach($array as $v => $n) {
    print('"'.$n.'" => "'.$v.'",<br>');
}
$parent += 10;
print("<form action='async.php' method='post'><input type='text' name='p' value='$parent'><input type='text' value='$start' name='s'><textarea name='z'></textarea><input type='submit'></form>");
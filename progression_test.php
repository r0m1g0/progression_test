<?

/** 
 * Checks the membership of a member to a Arithmetic-geometric progression u(n+1) = q*u(n) + d
 * @param double $q q 
 * @param double $d d
 * @param double $first_member u(1)
 * @param double $test_member member for test
 * @param double $test_member_n order number member for test
 */
function test_member($q, $d, $first_member, $test_member, $test_member_n) {
	if ($q == 1)
		return $test_member == $first_member + $test_member_n*$d;
	else
		return $test_member == pow($q, $test_member_n)*($first_member + $d/($q - 1)) - $d/($q - 1);
}

// check input parameters
if ($argc != 2) {
    die(PHP_EOL . 'Example use: php progression_test.php 1,2,3,4,5' . PHP_EOL);
}

$test_array = explode(',', $argv[1]);

$test_array_length = count($test_array);

if ($test_array_length < 3) {
    die(PHP_EOL . 'Error: need minimum 3 number' . PHP_EOL);
}

if ($test_array_length != count(array_filter($test_array, "is_numeric"))) {
    die(PHP_EOL . 'Error: in sequence may be numbers only' . PHP_EOL);
}

// calculate d and q
if ($test_array[1] == $test_array[0]) {
	$d = 0;
	$q = 1;
} else {
	$d = (pow($test_array[1], 2) - $test_array[0]*$test_array[2]) / ($test_array[1] - $test_array[0]);
	$q = ($test_array[2] - $test_array[1]) / ($test_array[1] - $test_array[0]);
}

// test all members from input sequence
foreach ($test_array as $test_member_n => $test_member) {
	if (!test_member($q, $d, $test_array[0], $test_member, $test_member_n)) {
	    die(PHP_EOL . 'Result: no seach progression' . PHP_EOL);
	}
}

// print success result
switch (true) {
	case (($d == 0 && $q == 1) || ($d != 0 && $q != 1)):
		echo "Found Arithmetic-geometric progression\n";
		echo "u(n+1) = q*u(n) + d\n";
		echo "q = $q\n";
		echo "d = $d\n";
		break;
	case ($d != 0 && $q == 1):
		echo "Found Arithmetic progression\n";
		echo "u(n+1) = u(n) + d\n";
		echo "d = $d\n";
		break;
	case ($d == 0 && $q != 1):
		echo "Found Geometric progression\n";
		echo "u(n+1) = q*u(n)\n";
		echo "q = $q\n";
		break;
}
echo "u(1) = ".$test_array[0]."\n\n";

$example = [$test_array[0]];
for ($i = 1; $i < 20; $i++) {
	$example[$i] = $q*$example[$i-1] + $d;
}
echo "First 20 members progression:\n".implode(', ', $example)."...";
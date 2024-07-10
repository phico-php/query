<?php

include 'Clause.php';
include 'NestableClause.php';
include 'From.php';
include 'GroupBy.php';
include 'Having.php';
include 'Join.php';
include 'OrderBy.php';
include 'Select.php';
include 'Union.php';
include 'Where.php';
include 'Query.php';



echo "\n";

$query = new Query;
$query->from('users')->select('id,name as full_name');
// $query->where('name', 'like', '%kermit%');
// $query->where('species', 'frog');
// $query->orderBy('name asc, id desc');
echo $query->toString();

echo "\n";

// $query = new Query;
// $query->from('users')->delete();
// $query->where('name', 'like', 'kermit');
// echo $query->toString();

// echo "\n";


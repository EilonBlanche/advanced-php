<?php

/**
 * Use this file to output reports required for the SQL Query Design test.
 * An example is provided below. You can use the `asTable` method to pass your query result to,
 * to output it as a styled HTML table.
 */

$database = 'nba2019';
require_once('vendor/autoload.php');
require_once('include/utils.php');

/*
 * Example Query
 * -------------
 * Retrieve all team codes & names
 */
echo '<h1>Example Query</h1>';
$teamSql = "SELECT * FROM team";
$teamResult = query($teamSql);
// dd($teamResult);
echo asTable($teamResult);

/*
 * Report 1
 * --------
 * Produce a query that reports on the best 3pt shooters in the database that are older than 30 years old. Only
 * retrieve data for players who have shot 3-pointers at greater accuracy than 35%.
 *
 * Retrieve
 *  - Player name
 *  - Full team name
 *  - Age
 *  - Player number
 *  - Position
 *  - 3-pointers made %
 *  - Number of 3-pointers made
 *
 * Rank the data by the players with the best % accuracy first.
 */
echo '<h1>Report 1 - Best 3pt Shooters</h1>';
$teamSql = "SELECT team.name, roster.name, roster.number, roster.pos, SUM(player_totals.3pt) as 3pt, SUM(player_totals.3pt_attempted) as 3pt_attempted, player_totals.age
FROM player_totals
LEFT JOIN roster on player_totals.player_id = roster.id
INNER JOIN team on roster.team_code = team.code
WHERE (player_totals.3pt/player_totals.3pt_attempted * 100) > 35 AND player_totals.age > 30
GROUP BY player_totals.player_id
ORDER BY (player_totals.3pt/player_totals.3pt_attempted * 100) DESC";
$teamResult = query($teamSql);
// dd($teamResult);
echo asTable($teamResult);
// write your query here


/*
 * Report 2
 * --------
 * Produce a query that reports on the best 3pt shooting teams. Retrieve all teams in the database and list:
 *  - Team name
 *  - 3-pointer accuracy (as 2 decimal place percentage - e.g. 33.53%) for the team as a whole,
 *  - Total 3-pointers made by the team
 *  - # of contributing players - players that scored at least 1 x 3-pointer
 *  - of attempting player - players that attempted at least 1 x 3-point shot
 *  - total # of 3-point attempts made by players who failed to make a single 3-point shot.
 *
 * You should be able to retrieve all data in a single query, without subqueries.
 * Put the most accurate 3pt teams first.
 */
echo '<h1>Report 2 - Best 3pt Shooting Teams</h1>';
// write your query here
$teamSql = "SELECT team.name, SUM((player_totals.3pt/player_totals.3pt_attempted) * 10) as 3pt_accuracy, SUM(player_totals.3pt) as 3pt_total
FROM player_totals
LEFT JOIN roster on player_totals.player_id = roster.id
INNER JOIN team on roster.team_code = team.code
GROUP BY roster.team_code
ORDER BY (player_totals.3pt/player_totals.3pt_attempted) * 10 DESC";
$teamResult = query($teamSql);
// dd($teamResult);
echo asTable($teamResult);

?>
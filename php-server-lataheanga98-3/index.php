<h1> Hello from devcontainer-example!</h1>

<p>It's not super exciting, but this is being served from the webserver 
    container in our devcontainer.</p>

<h2>Guestbook</h2>

<table cellspacing="8">
<tr>
    <th>Name</th>
    <th>Visited</th>
    <th>Note</th>
</tr>

<?php
$connection = mysqli_init();

$connection->real_connect(
    "database",
    "example_account",
    "applesauce",
    "example"
);

$result = mysqli_query($connection, "SELECT * FROM guestbook");

while($row = mysqli_fetch_array($result)) {
    print "<tr>";
    print "<td>" . htmlspecialchars($row["visitor_name"]) . "</td>";
    print "<td>" . htmlspecialchars($row["created_at"]) . "</td>";
    print "<td>" . htmlspecialchars($row["note"]) . "</td>";
    print "</tr>";
}

$connection->close();
?>
</table>
<?php
function getUpcomingTournaments($conn) {
    $sql = "SELECT * FROM tournaments WHERE event_date >= CURDATE() ORDER BY event_date ASC";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}
?>
<!-- View/moderatorDashboard.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moderator Dashboard - ClubSphere</title>
    <link rel="stylesheet" href="../Assets/style.css">
</head>
<body>
    <div class="dashboard-container">
        <h1>Moderator Dashboard</h1>

        <!-- SECTION 1: MATCH RESULT VERIFICATION -->
        <div class="card">
            <h2>1. Match Result Verification</h2>
            <table>
                <thead>
                    <tr>
                        <th>Match ID</th>
                        <th>Screenshot Proof</th>
                        <th>Submit Score</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <form action="../Controllers/moderatorController.php" method="POST">
                            <input type="hidden" name="action" value="verify_match">
                            <input type="hidden" name="match_id" value="101">
                            <td>#101</td>
                            <td><a href="#" target="_blank">View Screenshot</a></td>
                            <td><input type="text" name="score" placeholder="e.g., 16-14" required></td>
                            <td>
                                <button type="submit" name="status" value="approved" class="btn-green">Approve</button>
                                <button type="submit" name="status" value="rejected" class="btn-red">Reject</button>
                            </td>
                        </form>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- SECTION 2: INVENTORY TRACKING -->
        <div class="card">
            <h2>2. Inventory Tracking</h2>
            <form action="../Controllers/moderatorController.php" method="POST" class="form-inline">
                <input type="hidden" name="action" value="add_inventory">
                <input type="text" name="item_name" placeholder="Item Name (e.g. Logitech G Pro)" required>
                <input type="text" name="serial_number" placeholder="Serial Number" required>
                <select name="condition">
                    <option value="New">New</option>
                    <option value="Good">Good</option>
                    <option value="Damaged">Damaged</option>
                </select>
                <button type="submit" class="btn-blue">Add Equipment</button>
            </form>
        </div>

        <!-- SECTION 3: ANNOUNCEMENT BROADCASTING -->
        <div class="card">
            <h2>3. Announcement Broadcasting</h2>
            <form action="../Controllers/moderatorController.php" method="POST">
                <input type="hidden" name="action" value="post_announcement">
                <div class="form-group">
                    <input type="text" name="title" placeholder="Announcement Title" required>
                </div>
                <div class="form-group">
                    <textarea name="content" rows="4" placeholder="Write global announcement details..." required></textarea>
                </div>
                <button type="submit" class="btn-blue">Broadcast Announcement</button>
            </form>
        </div>
    </div>
</body>
</html>
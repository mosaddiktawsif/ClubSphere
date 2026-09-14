<?php require_once 'view/partial/header.php'; ?>

<div class="admin-layout">
    <?php 
    $activeNav = 'tournaments';
    require_once 'view/partial/captain_sidebar.php'; 
    ?>

    <div class="admin-main">
        <div class="card wide">
            <h2>Active Tournaments</h2>
            <p class="sidebar-subtitle">Select an active tournament and submit your finalized team roster for enrollment.</p>
            
            <?php if (empty($tournaments)) { ?>
                <div class="msg" style="text-align: center; margin-top: 20px;">There are no upcoming events currently.</div>
            <?php } else { ?>
                <table style="margin-top: 20px;">
                    <thead>
                        <tr>
                            <th>Tournament Name</th>
                            <th>Game</th>
                            <th>Event Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($tournaments as $tournament) { ?>
                        <tr>
                            <td style="font-weight: bold; color: var(--navy);"><?php echo htmlspecialchars($tournament['title']); ?></td>
                            <td><span class="badge upcoming"><?php echo htmlspecialchars($tournament['game']); ?></span></td>
                            <td><?php echo htmlspecialchars($tournament['event_date']); ?></td>
                            <td>
                                <form action="index.php" method="POST" style="margin: 0;">
                                    <input type="hidden" name="action" value="enroll_tournament">
                                    <input type="hidden" name="tournament_id" value="<?php echo $tournament['id']; ?>">
                                    <button type="submit" style="background: var(--green); padding: 8px 12px; margin: 0; width: auto;">Enroll Roster</button>
                                </form>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } ?>
        </div>
    </div>
</div>

<?php require_once 'view/partial/footer.php'; ?>
<?php require_once __DIR__ .'/../vendor/autoload.php'; ?>
<?php $csrf = new \ParagonIE\AntiCSRF\AntiCSRF; ?>

<tr id="user-<?php echo htmlspecialchars($user['user_id']); ?>">
    <td><?php echo isset($user['user_id']) ? htmlspecialchars($user['user_id']) : ''; ?></td>
    <td><?php echo isset($user['name']) ? htmlspecialchars($user['name']) : ''; ?></td>
    <td><?php echo isset($user['email']) ? htmlspecialchars($user['email']) : ''; ?></td>
    <td><?php echo isset($user['phone']) ? htmlspecialchars($user['phone']) : ''; ?></td>
    <td><?php echo isset($user['address']) ? htmlspecialchars($user['address']) : ''; ?></td>
    <?php if ($loggedUserPrivilege >= 3) { ?>
        <td><form method="post" action="" class="d-inline d-flex gap-2 flex-wrap">
                <?php $csrf->insertToken(); ?>
                <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user['user_id']); ?>">
                <select name="privilege" class="form-select d-inline w-auto" style="display:inline-block;" <?php if ($_SESSION['user']['id'] == $user['user_id']) echo 'disabled'; ?>>
                    <option value="0" <?php if ($user['privilege']==0) echo 'selected'; ?>>Disable</option>
                    <option value="1" <?php if ($user['privilege']==1) echo 'selected'; ?>>User</option>
                    <option value="2" <?php if ($user['privilege']==2) echo 'selected'; ?>>Manager</option>
                    <option value="3" <?php if ($user['privilege']==3) echo 'selected'; ?>>Admin</option>
                </select>
                <button type="submit" name="change_privilege" class="btn btn-sm btn-primary">
                    <span class="material-symbols-outlined align-middle">save</span>
                    Change
                </button>
        </form></td>
    <?php }else{ ?>
        <td><?php echo htmlspecialchars($user['privilege'] == 0 ? 'Disabled' : ($user['privilege'] == 1 ? 'User' : ($user['privilege'] == 2 ? 'Manager' : 'Admin'))); ?></td>
    <?php } ?>
</tr>
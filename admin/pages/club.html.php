<div class="wrap">
    <h1 class="wp-heading-inline">باشگاه مشتریان</h1>
    <?php do_action('admin_notices_pp'); ?>
    <table class="form-table">
        <tr>
            <th>فعال کردن باشگاه مشتریان</th>
            <td><a class="button button-primary" href="<?= admin_url('admin.php?page=payping-club&ac=activate&') ?>">✓</a></td>
            <th>غیرفغال کردن باشگاه مشتریان</th>
            <td><a class="button button-link-delete" href="<?= admin_url('admin.php?page=payping-club&ac=deactivate&') ?>">✘</a></td>
        </tr>
    </table>
</div>
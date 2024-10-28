<?php
/**
 * NoteSpot Settings Page
 *
 * This file handles the settings for the NoteSpot plugin, allowing users
 * to configure sticky notes and user roles.
 *
 * @package    NoteSpot
 * @subpackage Settings
 * @author     Hemant Jodhani
 * @version    1.0.0
 */

global $wp_roles;
$user_roles    = $wp_roles->roles;
$settings      = get_option( 'pr_settings' );
$user_settings = $settings['user_roles'];
$note_theme    = $settings['note_theme'];
?>
<h3>NoteSpot Settings</h3>

<div class="ps-from-wrap">
	<form action="" method="POST">
		<div class="ps-user-fields">
			<h3>User roles to use sticky notes</h3>
			<?php foreach ( $user_roles as $role_key => $user_role ) : ?>
				<div>
					<input type="checkbox" name="user_role[]" value="<?php echo esc_attr( $role_key ); ?>" 
						<?php
						if ( in_array( $role_key, $user_settings, true ) ) {
							echo 'checked';
						}
						?>
						>
					<?php echo esc_html( $user_role['name'] ); ?>
				</div>
			<?php endforeach; ?>
		</div>

		<div class="ps-note-theme">
			<h4s>Default Theme</h4s>
			<div class="ps-note-preview-wrap">
				<input type="radio" name="ps_note_theme" value="0" <?php echo ( 0 === $note_theme ) ? 'checked' : ''; ?>>
				<div class="ps-note-preview">
					<div class="ps-preview-note-header" style="background: #f39c12;"></div>
					<div class="ps-preview-note-body" style="background: #f1c40f;"></div>
				</div>
			</div>

			<div class="ps-note-preview-wrap">
				<input type="radio" name="ps_note_theme" value="1" <?php echo ( 1 === $note_theme ) ? 'checked' : ''; ?>>
				<div class="ps-note-preview">
					<div class="ps-preview-note-header" style="background: #f5f5f5;"></div>
					<div class="ps-preview-note-body" style="background: #FEFEFE;"></div>
				</div>
			</div>

			<div class="ps-note-preview-wrap">
				<input type="radio" name="ps_note_theme" value="2" <?php echo ( 2 === $note_theme ) ? 'checked' : ''; ?>>
				<div class="ps-note-preview">
					<div class="ps-preview-note-header" style="background: #d4cdf3;"></div>
					<div class="ps-preview-note-body" style="background: #DDD9FE;"></div>
				</div>
			</div>

			<div class="ps-note-preview-wrap">
				<input type="radio" name="ps_note_theme" value="3" <?php echo ( 3 === $note_theme ) ? 'checked' : ''; ?>>
				<div class="ps-note-preview">
					<div class="ps-preview-note-header" style="background: #f1c3f1;"></div>
					<div class="ps-preview-note-body" style="background: #F5D2F5;"></div>
				</div>
			</div>

			<div class="ps-note-preview-wrap">
				<input type="radio" name="ps_note_theme" value="4" <?php echo ( 4 === $note_theme ) ? 'checked' : ''; ?>>
				<div class="ps-note-preview">
					<div class="ps-preview-note-header" style="background: #c5f7c1;"></div>
					<div class="ps-preview-note-body" style="background: #D1FECB;" ></div>
				</div>
			</div>

			<div class="ps-note-preview-wrap">
				<input type="radio" name="ps_note_theme" value="5" <?php echo ( 5 === $note_theme ) ? 'checked' : ''; ?>>
				<div class="ps-note-preview">
					<div class="ps-preview-note-header" style="background: #c9ecf8;" ></div>
					<div class="ps-preview-note-body" style="background: #D8F2FA;" ></div>
				</div>
			</div>

			<div class="ps-note-preview-wrap">
				<input type="radio" name="ps_note_theme" value="6" <?php echo ( 6 === $note_theme ) ? 'checked' : ''; ?>>
				<div class="ps-note-preview">
					<div class="ps-preview-note-header" style="background: #fbac5f;" ></div>
					<div class="ps-preview-note-body" style="background: #F7BD84;" ></div>
				</div>
			</div>

			<div class="ps-note-preview-wrap">
				<input type="radio" name="ps_note_theme" value="7" <?php echo ( 7 === $note_theme ) ? 'checked' : ''; ?>>
				<div class="ps-note-preview">
					<div class="ps-preview-note-header" style="background: #7f7f7f;" ></div>
					<div class="ps-preview-note-body" style="background: #9F9F9F;" ></div>
				</div>
			</div>
		</div>
		<input class="ps-save-settings" type="submit" value="Save Changes" name="ps_setting_changes">
	</form>
</div

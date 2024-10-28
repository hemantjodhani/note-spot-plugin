<?php
/**
 * NoteSpot Archive Page
 *
 * This file displays the archive of notes created by users.
 * It allows for viewing and deleting notes.
 *
 * @package NoteSpot
 */

ob_start();
global $wpdb;
$table_name = $wpdb->prefix . 'notespot_notes';
$notes      = $wpdb->get_results( "SELECT note_id, note, time, user_id FROM $table_name", ARRAY_A );
?>

<h3>NoteSpot Archive</h3>
<h4>This is the NoteSpot Archive page where you can manage your notes.</h4>

<div class="ps-table-container">
	<table class="table table-bordered">
		<thead>
			<tr>
				<th>Created By</th>
				<th>Time</th>
				<th>Note</th>
				<th>Delete</th>
			</tr>
		</thead>
		<tbody>
			<?php if ( ! empty( $notes ) ) : ?>
				<?php foreach ( $notes as $note ) : ?>
					<tr>
						<td>
						<?php
						$user_info = get_userdata( $note['user_id'] );
						echo esc_html( $user_info->user_login );
						?>
						</td>
						<td><?php echo esc_html( $note['time'] ); ?></td>
						<td><?php echo esc_html( $note['note'] ); ?></td>
						<td>
							<a class="btn btn-danger" href="<?php echo esc_url( admin_url( 'admin.php?page=notespot-archive' ) . '&note_id=' . $note['note_id'] ); ?>">Delete</a>
						</td>
					</tr>
				<?php endforeach; ?>
			<?php else : ?>
				<tr>
					<td colspan="4">No notes found.</td>
				</tr>
			<?php endif; ?>
		</tbody>
	</table>
</div>
<?php
ob_end_flush();

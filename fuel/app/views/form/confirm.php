<div class="form-group">
	<table class="table table-bordered confirm">
		<tr>
			<th>件名</th>
			<td><?php echo $input['subject']; ?></td>
		</tr>
		<tr>
			<th>お名前</th>
			<td><?php echo $input['name']; ?></td>
		</tr>
		<tr>
			<th>メールアドレス</th>
			<td><?php echo $input['email']; ?></td>
		</tr>
		<tr>
			<th>電話番号</th>
			<td><?php echo $input['tel']; ?></td>
		</tr>
		<tr>
			<th>コメント</th>
			<td><?php echo nl2br($input['comment'], false); ?></td>
		</tr>
	</table>
	<?php
	echo Form::open('form/');
	echo Form::hidden('subject', $input['subject']);
	echo Form::hidden('name', $input['name']);
	echo Form::hidden('email', $input['email']);
	echo Form::hidden('tel', $input['tel']);
	echo Form::hidden('comment', $input['comment']);
	?>
	<div class="actions">
		<p><?php echo Form::submit('submit1', '修正', array('class' => 'btn btn-primary')); ?></p>
	</div>
	<?php echo Form::close(); ?>

	<?php
	echo Form::open('form/send');

// CSFR対策
	echo Form::csrf();

	echo Form::hidden('subject', $input['subject'], array('id' => 'subject'));
	echo Form::hidden('name', $input['name'], array('id' => 'name'));
	echo Form::hidden('email', $input['email'], array('id' => 'email'));
	echo Form::hidden('tel', $input['tel'], array('id' => 'tel'));
	echo Form::hidden('comment', $input['comment'], array('id' => 'comment'));
	?>
	<div class="actions">
		<p><?php echo Form::submit('submit2', '送信', array('class' => 'btn btn-primary')); ?></p>
	</div>
</div>
<?php echo Form::close(); ?>

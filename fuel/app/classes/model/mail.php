<?php

class Model_Mail extends Model
{

	/**
	 * メールを作成し送信する
	 * 
	 * @param array $post
	 * @return void
	 * @throws \EmailValidationFailedException
	 * @throws \EmailSendingFailedException
	 * @throws \FuelException
	 */
	public function send($post)
	{
		// 管理者へメール送信
		$admin_data = $this->build_admin_mail($post);
		$this->sendmail($admin_data);
		// ユーザーへメール送信
		$user_data = $this->build_user_mail($post);
		$this->sendmail($user_data);
	}

	// 管理者宛のメールの作成
	protected function build_admin_mail($post)
	{
		Config::load('contact_form', true);

		$data['from'] = $post['email'];
		$data['from_name'] = $post['name'];
		$data['to'] = Config::get('contact_form.admin_email');
		$data['to_name'] = Config::get('contact_form.admin_name');
		$data['subject'] = Config::get('contact_form.subject') .
			$post['name'] . '様より';

		$ip = Input::ip();
		$agent = Input::user_agent();

		$data['body'] = <<< END
------------------------------------------------------------
          名前: {$post['name']}
メールアドレス: {$post['email']}
	  電話番号:{$post['tel']}
    IPアドレス: $ip
      ブラウザ: $agent
------------------------------------------------------------
件名：{$post['subject']}
コメント:
{$post['comment']}
------------------------------------------------------------
END;
		return $data;
	}

	// ユーザー宛のメールの作成
	protected function build_user_mail($post)
	{
		Config::load('contact_form', true);

		$data['from'] = Config::get('contact_form.admin_email');
		$data['from_name'] = Config::get('contact_form.admin_name');
		$data['to'] = $post['email'];
		$data['to_name'] = $post['name'] . '様';
		$data['subject'] = 'お問い合わせ内容（お客様控え）';

		$data['body'] = <<< END
この度はお問い合わせありがとうございました。
送信して頂いた内容は以下の通りです。
------------------------------------------------------------
件名：{$post['subject']}
名前: {$post['name']}
メールアドレス: {$post['email']}
電話番号: {$post['tel']}
コメント:
{$post['comment']}
------------------------------------------------------------
END;
		return $data;
	}

	// メールの送信
	protected function sendmail($data)
	{
		Package::load('email');

		$email = Email::forge();
		$email->from($data['from'], $data['from_name']);
		$email->to($data['to'], $data['to_name']);
		$email->subject($data['subject']);
		$email->body($data['body']);

		$email->send();
	}

}

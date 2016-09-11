<?php

/**
 * formコントローラー
 */
class Controller_Form extends Controller_Public
{

	public function action_index()
	{
		$form = $this->forge_form();

		// 確認ページから修正ボタンを押下して戻ってきた場合
		if (Input::method() === 'POST')
		{
			// 送信されたデータをフォームに反映する
			$form->repopulate();
		}

		$this->template->title = 'お問い合わせフォーム';
		$this->template->content = View::forge('form/index');

		// HTML生成
		$this->template->content->set_safe('html_form', $form->build('form/confirm'));
	}

	// フォームの定義
	public function forge_form()
	{
		$form = Fieldset::forge('default', [
				'form_attributes' => ['class' => 'form-horizontal']
		]);

		//add
		$ops = array(
			'' => '選択してください',
			'ご意見' => 'ご意見',
			'ご感想' => 'ご感想',
			'その他' => 'その他',
		);
		$form->add('subject', '件名', array('options' => $ops, 'type' => 'select', 'class' => 'form-control', 'size' => '1'))
			->add_rule('required')
			->add_rule('in_array', $ops);

		$form->add('name', 'お名前', array('class' => 'form-control', 'placeholder' => 'お名前'))
			->add_rule('trim')
			->add_rule('required')
			->add_rule('no_tab_and_newline')
			->add_rule('max_length', 50);

		$form->add('email', 'メールアドレス', array('class' => 'form-control', 'placeholder' => 'メールアドレス'))
			->add_rule('trim')
			->add_rule('required')
			->add_rule('no_tab_and_newline')
			->add_rule('max_length', 100)
			->add_rule('valid_email');

		$form->add('tel', '電話番号', array('class' => 'form-control', 'placeholder' => '090-0000-0000'))
			->add_rule('trim')
			->add_rule('required')
			->add_rule('no_tab_and_newline')
			->add_rule('tel_no');

		$form->add('comment', 'コメント', array('type' => 'textarea', 'cols' => 70, 'rows' => 6, 'class' => 'form-control'))
			->add_rule('required')
			->add_rule('max_length', 400);

		$form->add('submit', '', array('type' => 'submit', 'value' => '確認', 'class' => 'btn btn-primary'));
		return $form;
	}

	public function action_confirm()
	{
		$form = $this->forge_form();
		$val = $form->validation()->add_callable('MyValidationRules');

		if ($val->run())
		{
			$data['input'] = $val->validated();
			$this->template->title = 'お問い合わせフォーム: 確認';
			$this->template->content = View::forge('form/confirm', $data);
		} else
		{
			$form->repopulate();
			$this->template->title = 'お問い合わせフォーム: エラー';
			$this->template->content = View::forge('form/index');
			$this->template->content->set_safe('html_error', $val->show_errors());
			$this->template->content->set_safe('html_form', $form->build('form/confirm'));
		}
	}

	public function action_send()
	{
		// CSRF対策
		if (!Security::check_token())
		{
			throw new HttpInvalidInputException('ページ遷移が正しくありません');
		}

		$form = $this->forge_form();
		$val = $form->validation()->add_callable('MyValidationRules');

		if (!$val->run())
		{
			$form->repopulate();
			$this->template->title = 'お問い合わせフォーム: エラー';
			$this->template->content = View::forge('form/index');
			$this->template->content->set_safe('html_error', $val->show_errors());
			$this->template->content->set_safe('html_form', $form->build('form/confirm'));
			return;
		}

		$post = $val->validated();
		$post['ip_address'] = Input::ip();
		$post['user_agent'] = Input::user_agent();
		unset($post['submit']);

		// データベースへ保存
		$model_form = Model_Form::forge($post);
		$ret = $model_form->save();

		if (!$ret)
		{
			Log::error('データベース保存エラー', __METHOD__);

			$form->repopulate();
			$this->template->title = 'お問い合わせフォーム: サーバエラー';
			$this->template->content = View::forge('form/index');
			$html_error = '<p>サーバでエラーが発生しました。</p>';
			$this->template->content->set_safe('html_error', $html_error);
			$this->template->content->set_safe('html_form', $form->build('form/confirm'));
			return;
		}

		// メールの送信
		try
		{
			$mail = new Model_Mail();
			$mail->send($post);
			$this->template->title = 'お問い合わせフォーム: 送信完了';
			$this->template->content = View::forge('form/send');
			return;
		} catch (EmailValidationFailedException $e)
		{
			Log::error(
				'メール検証エラー: ' . $e->getMessage(), __METHOD__
			);
			$html_error = '<p>メールアドレスに誤りがあります。</p>';
		} catch (EmailSendingFailedException $e)
		{
			Log::error(
				'メール送信エラー: ' . $e->getMessage(), __METHOD__
			);
			$html_error = '<p>メールを送信できませんでした。</p>';
		}

		$form->repopulate();
		$this->template->title = 'お問い合わせフォーム: 送信エラー';
		$this->template->content = View::forge('form/index');
		$this->template->content->set_safe('html_error', $html_error);
		$this->template->content->set_safe('html_form', $form->build('form/confirm'));
	}

}

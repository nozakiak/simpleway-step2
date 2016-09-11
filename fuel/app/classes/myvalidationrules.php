<?php

/*
 * 独自の検証ルール
 */

class MyValidationRules
{

	/**
	 * 改行コードやタブが含まれていないかの検証ルール
	 */
	public static function _validation_no_tab_and_newline($value)
	{
		// 改行コードやタブが含まれていないか
		if (preg_match('/\A[^\r\n\t]*\z/u', $value) === 1)
		{
			// 含まれていない場合はtrueを返す
			return true;
		} else
		{
			// 含まれている場合はfalseを返す
			return false;
		}
	}

	/**
	 * 電話番号の検証ルール
	 */
	public static function _validation_tel_no($value)
	{
		// 電話番号の検証ルールに適合するか
		if (preg_match('/^[0-9]{2,4}-[0-9]{2,4}-[0-9]{3,4}$/', $value) === 1)
		{
			return true;
		} else
		{
			return false;
		}
	}

}

<?php

/**
 * Part of the Fuel framework.
 *
 * @package    Fuel
 * @version    1.8
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2016 Fuel Development Team
 * @link       http://fuelphp.com
 */
/**
 * NOTICE:
 *
 * If you need to make modifications to the default configuration, copy
 * this file to your app/config folder, and make them in there.
 *
 * This will allow you to upgrade fuel without losing your custom config.
 */
return array(
	// regular form definitions
	'prep_value' => true,
	'auto_id' => true,
	'auto_id_prefix' => 'form_',
	'form_method' => 'post',
	'form_template' => "\n\t\t{open}\n{fields}\n\t\t{close}\n",
	'fieldset_template' => "\n\t\t<tr><td colspan=\"2\">{open}<table>\n{fields}</table></td></tr>\n\t\t{close}\n",
	'field_template' => "\t\t<div class=\"form-group\">\n\t\t\t{label}\n\t\t\t<div class=\"col-sm-10 {error_class}\">{field}<span>{description}</span> {error_msg}</div>\n\t\t</div>\n",
	'multi_field_template' => "\t\t<div class=\"form-group\">\n\t\t\t<label class=\"col-sm-2 control-label\">{group_label}{required}</label>\n\t\t\t<div class=\"col-sm-10 {error_class}\">{fields}\n\t\t\t\t<div>{field} {label}</div>{fields}<span>{description}</span>\t\t\t{error_msg}\n\t\t\t</div>\n\t\t</div>\n",
	'error_template' => '<span>{error_msg}</span>',
	'group_label' => '{label}',
	'required_mark' => '*',
	'inline_errors' => false,
	'error_class' => null,
	'label_class' => 'col-sm-2 control-label',
	// tabular form definitions
	'tabular_form_template' => "<table>{fields}</table>\n",
	'tabular_field_template' => "{field}",
	'tabular_row_template' => "<tr>{fields}</tr>\n",
	'tabular_row_field_template' => "\t\t\t<td>{label}{required}&nbsp;{field} {error_msg}</td>\n",
	'tabular_delete_label' => "Delete?",
);

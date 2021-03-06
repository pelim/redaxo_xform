<?php

$content = '';
$template_id = rex_request('template_id', 'int');

## Print title
echo rex_view::title('XForm');

/*
 * adding/edit email templates
 */
if ($func == 'add' || $func == 'edit') {
  $content .= '<h2>' . rex_i18n::msg('xform_email_add_template') . '</h2>';
  $content .= '<p>Durch folgende Markierungen <b>###field###</b> kann man die in den Formularen eingegebenen Felder hier im E-Mail Template verwenden. Weiterhin sind
  alle REDAXO Variablen wie $REX["SERVER"] als <b>###REX_SERVER###</b> verwendbar. Urlencoded, z.b. für Links, bekommt man diese Werte über <b>+++field+++</b></p>';

  $form = rex_form::factory(rex::getTablePrefix() . 'xform_email_template', 'Template', 'id=' . $template_id);

  if ($func == 'edit')
    $form->addParam('template_id', $template_id);

  $field = &$form->addTextField('name');
  $field->setLabel(rex_i18n::msg('xform_email_key'));

  $field = &$form->addTextField('mail_from');
  $field->setLabel(rex_i18n::msg('xform_email_from'));

  $field = &$form->addTextField('mail_from_name');
  $field->setLabel(rex_i18n::msg('xform_email_from_name'));

  $field = &$form->addTextField('subject');
  $field->setLabel(rex_i18n::msg('xform_email_subject'));

  $field = &$form->addTextareaField('body');
  $field->setLabel(rex_i18n::msg('xform_email_body'));

  $field = &$form->addTextareaField('body_html');
  $field->setLabel(rex_i18n::msg('xform_email_body_html'));

  $field = &$form->addMedialistField('attachments');
  $field->setLabel(rex_i18n::msg('xform_email_attachments'));

  $content .= $form->get();

  ## Print form
  echo rex_view::contentBlock($content);
} else {
  /*
   * remove email templates
   */
  if ($func == 'delete') {
    $delsql = rex_sql::factory();
    $delsql->debugsql = 0;
    $delsql->setQuery('DELETE FROM ' . rex::getTablePrefix() . 'xform_email_template WHERE id = ?', array($template_id));

    $content .= rex_view::warning(rex_i18n::msg('xform_email_info_template_deleted'));
  }

  /*
   * list email templates
   */
  $list = rex_list::factory('SELECT * FROM ' . rex::getTablePrefix() . 'xform_email_template');
  $list->setCaption(rex_i18n::msg('xform_email_header_template_caption'));
  $list->addTableAttribute('summary', rex_i18n::msg('xform_email_header_template_summary'));

  $list->addTableColumnGroup(array(40, 40, '*', 153, 153));

  $thIcon = '<a class="rex-ic-template rex-ic-add" href="' . $list->getUrl(array('func' => 'add')) . '"' . rex::getAccesskey(rex_i18n::msg('xform_email_create_template'), 'add') . '>' . rex_i18n::msg('xform_email_create_template') . '</a>';
  $tdIcon = 'edit';
  $list->addColumn($thIcon, $tdIcon, 0, array('<th class="rex-icon">###VALUE###</th>', '<td class="rex-icon">###VALUE###</td>'));
  $list->setColumnParams($thIcon, array('func' => 'edit', 'template_id' => '###id###'));

  $list->setColumnLabel('id', 'ID');
  $list->setColumnLayout('id',  array('<th class="rex-small">###VALUE###</th>', '<td class="rex-small">###VALUE###</td>'));

  $list->setColumnLabel('name', rex_i18n::msg('xform_email_header_template_description'));
  $list->setColumnParams('name', array('func' => 'edit', 'template_id' => '###id###'));

  $list->setColumnLabel('mail_from', rex_i18n::msg('xform_email_header_template_mail_from'));
  $list->setColumnLabel('mail_from_name', rex_i18n::msg('xform_email_header_template_mail_from_name'));
  $list->setColumnLabel('subject', rex_i18n::msg('xform_email_header_template_subject'));

  $list->removeColumn('body');
  $list->removeColumn('body_html');
  $list->removeColumn('attachments');

  $list->addColumn(rex_i18n::msg('xform_email_header_template_functions'), rex_i18n::msg('xform_delete_template'));
  $list->setColumnParams(rex_i18n::msg('xform_email_header_template_functions'), array('func' => 'delete', 'template_id' => '###id###'));
  $list->addLinkAttribute(rex_i18n::msg('xform_email_header_template_functions'), 'onclick', 'return confirm(\'' . rex_i18n::msg('delete') . ' ?\')');

  $list->setNoRowsMessage(rex_i18n::msg('xform_email_templates_not_found'));

  $content .= $list->get();

  ## Print list
  echo rex_view::contentBlock($content, '', 'block');
}

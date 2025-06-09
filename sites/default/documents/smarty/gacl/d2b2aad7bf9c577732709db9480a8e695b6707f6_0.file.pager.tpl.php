<?php
/* Smarty version 4.3.4, created on 2025-04-23 17:57:32
  from '/home/root3375/wellclinic.medsov.com/gacl/admin/templates/phpgacl/pager.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.4',
  'unifunc' => 'content_68091bfc27b3a3_86111579',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd2b2aad7bf9c577732709db9480a8e695b6707f6' => 
    array (
      0 => '/home/root3375/wellclinic.medsov.com/gacl/admin/templates/phpgacl/pager.tpl',
      1 => 1700108884,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_68091bfc27b3a3_86111579 (Smarty_Internal_Template $_smarty_tpl) {
?><table width="100%" cellspacing="0" cellpadding="2" border="0">
  <tr valign="middle">
    <td align="left">
<?php if ((isset($_smarty_tpl->tpl_vars['paging_data']->value['atfirstpage'])) && $_smarty_tpl->tpl_vars['paging_data']->value['atfirstpage']) {?>
      |&lt; &lt;&lt;
<?php } else { ?>
      <a href="<?php echo $_smarty_tpl->tpl_vars['link']->value;?>
page=1">|&lt;</a> <a href="<?php echo $_smarty_tpl->tpl_vars['link']->value;?>
page=<?php if ((isset($_smarty_tpl->tpl_vars['paging_data']->value['prevpage']))) {
echo text($_smarty_tpl->tpl_vars['paging_data']->value['prevpage']);
}?>">&lt;&lt;</a>
<?php }?>
    </td>
    <td align="right">
<?php if ((isset($_smarty_tpl->tpl_vars['paging_data']->value['atlastpage'])) && $_smarty_tpl->tpl_vars['paging_data']->value['atlastpage']) {?>
      &gt;&gt; &gt;|
<?php } else { ?>
      <a href="<?php echo $_smarty_tpl->tpl_vars['link']->value;?>
page=<?php if ((isset($_smarty_tpl->tpl_vars['paging_data']->value['nextpage']))) {
echo text($_smarty_tpl->tpl_vars['paging_data']->value['nextpage']);
}?>">&gt;&gt;</a> <a href="<?php echo $_smarty_tpl->tpl_vars['link']->value;?>
page=<?php if ((isset($_smarty_tpl->tpl_vars['paging_data']->value['lastpageno']))) {
echo text($_smarty_tpl->tpl_vars['paging_data']->value['lastpageno']);
}?>">&gt;|</a>
<?php }?>
    </td>
  </tr>
</table>
<?php }
}

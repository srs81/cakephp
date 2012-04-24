<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.Console.Templates.default.views
 * @since         CakePHP(tm) v 1.2.0.5234
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<div class="<?php echo $pluralVar;?> index">
	<h2><?php echo "<?php echo __('{$pluralHumanName}');?>";?></h2>
<div id="tr_indexview_actions">
	<div class="actions">
	<ul>
		<li>
<?php
        echo "\t\t<?php echo \$this->Html->link(\$this->Html->image('tr/Add.png') . \" \" . __('New " . $singularHumanName ."'), array('action' => 'add'), array('escape' => false)); ?>\n";
?>
		</li>
		<li><a href="javascript:toggleTrFilter()"><?php echo "<?php echo \$this->Html->image('tr/Search.png'); ?>" ?> Search / Filter</a></li>
	</ul>
	</div>
</div>
<div id="tr_indexview_filter">
<?php
	echo "\t\t<?php echo \$this->Filter->filterForm('" . $singularHumanName . "', array('legend' => 'Search')); ?>\n";  
	?>
</div>
<?php
echo "
<?php
        \$filterString = '';
        foreach (\$this->viewVars['viewFilterParams'] as \$filter2) {
                if (!isset(\$filter2['options']['value'])) continue;
                \$value = \$filter2['options']['value'];
                \$name = \$filter2['name'];
                if (!(\$filterString === '')) \$filterString .= ', ';
                \$filterString .= \"<b>\$value</b> \" . __('in') .
                        \" <i>\$name</i>\";
        }
        if (!(\$filterString === '')) {
		echo '<div id=\"tr_filterinfo\">';
                echo __('Filtered by') . ': ' . \$filterString;
		echo '</div>';
	}
?>";
?>
	<table cellpadding="0" cellspacing="0">
	<tr>
	<?php  foreach ($fields as $field):?>
		<th><?php echo "<?php echo \$this->Paginator->sort('{$field}');?>";?></th>
	<?php endforeach;?>
		<th class="actions"><?php echo "<?php echo __('Actions');?>";?></th>
	</tr>
	<?php
	echo "<?php
	foreach (\${$pluralVar} as \${$singularVar}): ?>\n";
	echo "\t<tr>\n";
		foreach ($fields as $field) {
			$isKey = false;
			if (!empty($associations['belongsTo'])) {
				foreach ($associations['belongsTo'] as $alias => $details) {
					if ($field === $details['foreignKey']) {
						$isKey = true;
						if (strpos($field, "status") !== false) {
						echo "\t\t<td>\n\t\t\t<?php echo \$this->Html->link(\$this->Html->image(\"statuses/${singularVar}/\" . strtolower(\${$singularVar}['{$alias}']['{$details['displayField']}']) . \".png\", array('alt'=>\${$singularVar}['{$alias}']['{$details['displayField']}'])), array('controller' => '{$details['controller']}', 'action' => 'view', \${$singularVar}['{$alias}']['{$details['primaryKey']}']), array('escape' => false)); ?>\n\t\t</td>\n";
						} else {
						echo "\t\t<td>\n\t\t\t<?php echo \$this->Html->link(\${$singularVar}['{$alias}']['{$details['displayField']}'], array('controller' => '{$details['controller']}', 'action' => 'view', \${$singularVar}['{$alias}']['{$details['primaryKey']}'])); ?>\n\t\t</td>\n";
						}
						break;
					}
				}
			}
			if (!(strpos($field, "name") === false)) {
				echo "\t\t<td><?php echo \$this->Html->link(h(\${$singularVar}['{$modelClass}']['{$field}']), array('action' => 'view', \${$singularVar}['{$modelClass}']['{$primaryKey}'])); ?>&nbsp;</td>\n";
				continue;
			}
			$dateNames = array ("date", "time", "created", 
				"updated", "modified");
			$dateSuccess = false;
			foreach ($dateNames as $dateName) {
			if (strpos($field, $dateName) !== false) {
				echo "\t\t<td><?php echo \$this->Time->nice(h(\${$singularVar}['{$modelClass}']['{$field}'])); ?>&nbsp;</td>\n";
				$dateSuccess = true;
				break;
			}
			}
			if ($dateSuccess) continue;
			if (strpos($field, "email") !== false) {
				echo "\t\t<td><a href=\"mailto:<?php echo h(\${$singularVar}['{$modelClass}']['{$field}']) ?>\"><?php echo h(\${$singularVar}['{$modelClass}']['{$field}']); ?></a>&nbsp;</td>\n";
				continue;
			} 
			if ($isKey !== true) {
				echo "\t\t<td><?php echo h(\${$singularVar}['{$modelClass}']['{$field}']); ?>&nbsp;</td>\n";
			}
		}

		echo "\t\t<td class=\"actions\">\n";
	 	echo "\t\t\t<?php echo \$this->Html->link(__('Edit'), array('action' => 'edit', \${$singularVar}['{$modelClass}']['{$primaryKey}'])); ?>\n";
	 	echo "\t\t\t<?php echo \$this->Form->postLink(__('Delete'), array('action' => 'delete', \${$singularVar}['{$modelClass}']['{$primaryKey}']), null, __('Are you sure you want to delete # %s?', \${$singularVar}['{$modelClass}']['{$primaryKey}'])); ?>\n";
		echo "\t\t</td>\n";
	echo "\t</tr>\n";

	echo "<?php endforeach; ?>\n";
	?>
	</table>

	<div class="paging">
	<p>
	<?php echo "<?php
	echo \$this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>";?>
	</p>
	<?php
		echo "<?php\n";
		echo "\t\techo \$this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));\n";
		echo "\t\techo \$this->Paginator->numbers(array('separator' => ''));\n";
		echo "\t\techo \$this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));\n";
		echo "\t?>\n";
	?>
	</div>
</div>
<div class="actions">
	<?php echo "<?php echo \$this->element('tr_menu'); ?>"; ?>
</div>

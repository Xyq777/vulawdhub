<?php
/**
 * The batch edit file of product module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Congzhi Chen <congzhi@cnezsoft.com>
 * @package     ZenTaoPMS
 * @version     $Id$
 */
?>
<?php include '../../common/view/header.html.php';?>
<div id='titlebar'>
  <div class='heading'>
    <span class='prefix'><?php echo html::icon($lang->icons['product']);?></span>
    <strong><small class='text-muted'><?php echo html::icon($lang->icons['batchEdit']);?></small> <?php echo $lang->product->batchEdit;?></strong>
    <div class='actions'>
      <button type="button" class="btn btn-default" data-toggle="customModal"><i class='icon icon-cog'></i> </button>
    </div>
  </div>
</div>
<?php
$visibleFields  = array();
$requiredFields = array();
foreach(explode(',', $showFields) as $field)
{
    if($field) $visibleFields[$field] = '';
}
foreach(explode(',', $this->config->product->edit->requiredFields) as $field)
{
    if($field)
    {
        $requiredFields[$field] = '';
        if(strpos(",{$config->product->customBatchEditFields},", ",{$field},") !== false) $visibleFields[$field] = '';
    }
}
?>
<form class='form-condensed' method='post' target='hiddenwin' action='<?php echo inLink('batchEdit');?>'>
  <table class='table table-form table-fixed'>
    <thead>
      <tr>
        <th class='w-id'>   <?php echo $lang->idAB;?></th>
        <th><?php echo $lang->product->name;?> <span class='required'></span></th>
        <th class='w-150px'><?php echo $lang->product->code;?> <span class='required'></span></th>
        <th class='w-150px<?php if(!isset($visibleFields['line'])) echo ' hidden';?>'>
          <?php echo $lang->product->line;?>
          <?php if(isset($requiredFields['line'])) echo " <span class='required'></span>";?>
        </th>
        <th class='w-150px<?php if(!isset($visibleFields['PO'])) echo ' hidden';?>'>
          <?php echo $lang->product->PO;?>
          <?php if(isset($requiredFields['PO'])) echo " <span class='required'></span>";?>
        </th>
        <th class='w-150px<?php if(!isset($visibleFields['QD'])) echo ' hidden';?>'>
          <?php echo $lang->product->QD;?>
          <?php if(isset($requiredFields['QD'])) echo " <span class='required'></span>";?>
        </th>
        <th class='w-150px<?php if(!isset($visibleFields['RD'])) echo ' hidden';?>'>
          <?php echo $lang->product->RD;?>
          <?php if(isset($requiredFields['RD'])) echo " <span class='required'></span>";?>
        </th>
        <th class='w-100px<?php if(!isset($visibleFields['type'])) echo ' hidden';?>'>
          <?php echo $lang->product->type;?>
          <?php if(isset($requiredFields['type'])) echo " <span class='required'></span>";?>
        </th>
        <th class='w-100px<?php if(!isset($visibleFields['status'])) echo ' hidden';?>'>
          <?php echo $lang->product->status;?>
          <?php if(isset($requiredFields['status'])) echo " <span class='required'></span>";?>
        </th>
        <th class='w-200px<?php if(!isset($visibleFields['desc'])) echo ' hidden';?>'>
          <?php echo $lang->product->desc;?>
          <?php if(isset($requiredFields['desc'])) echo " <span class='required'></span>";?>
        </th>
        <th class='w-80px'><?php echo $lang->product->order;?></th>
      </tr>
    </thead>
    <?php foreach($productIDList as $productID):?>
    <tr class='text-center'>
      <td><?php echo sprintf('%03d', $productID) . html::hidden("productIDList[$productID]", $productID);?></td>
      <td title='<?php echo $products[$productID]->name?>'><?php echo html::input("names[$productID]", $products[$productID]->name, "class='form-control' autocomplete='off'");?></td>
      <td><?php echo html::input("codes[$productID]", $products[$productID]->code, "class='form-control' autocomplete='off'");?></td>
      <td class='text-left<?php echo zget($visibleFields, 'line', ' hidden')?>' style='overflow:visible'><?php echo html::select("lines[$productID]", $lines, $products[$productID]->line, "class='form-control chosen'");?></td>
      <td class='text-left<?php echo zget($visibleFields, 'PO', ' hidden')?>' style='overflow:visible'><?php echo html::select("POs[$productID]",  $poUsers, $products[$productID]->PO, "class='form-control chosen'");?></td>
      <td class='text-left<?php echo zget($visibleFields, 'QD', ' hidden')?>' style='overflow:visible'><?php echo html::select("QDs[$productID]",  $qdUsers, $products[$productID]->QD, "class='form-control chosen'");?></td>
      <td class='text-left<?php echo zget($visibleFields, 'RD', ' hidden')?>' style='overflow:visible'><?php echo html::select("RDs[$productID]",  $rdUsers, $products[$productID]->RD, "class='form-control chosen'");?></td>
      <td class='<?php echo zget($visibleFields, 'type',   'hidden')?>'><?php echo html::select("types[$productID]",    $lang->product->typeList,   $products[$productID]->type,   "class='form-control'");?></td>
      <td class='<?php echo zget($visibleFields, 'status', 'hidden')?>'><?php echo html::select("statuses[$productID]", $lang->product->statusList, $products[$productID]->status, "class='form-control'");?></td>
      <td class='<?php echo zget($visibleFields, 'desc',   'hidden')?>'><?php echo html::textarea("descs[$productID]", htmlspecialchars($products[$productID]->desc), "rows='1' class='form-control autosize'");?></td>
      <td><?php echo html::input("orders[$productID]", $products[$productID]->order, "class='form-control' autocomplete='off'");?></td>
    </tr>
    <?php endforeach;?>
    <tr><td colspan='<?php echo count($visibleFields) + 4?>' class='text-center'><?php echo html::submitButton();?></td></tr>
  </table>
</form>
<?php $customLink = $this->createLink('custom', 'ajaxSaveCustomFields', 'module=product&section=custom&key=batchEditFields')?>
<?php include '../../common/view/customfield.html.php';?>
<?php include '../../common/view/footer.html.php';?>

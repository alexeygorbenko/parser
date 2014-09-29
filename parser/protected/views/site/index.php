<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
$items = $this->selectStations();
?>
<h1>Radio stations</h1>
<code>
    <table>
        <th>ID</th><th>NAME</th><th>URL</th><th>STATUS</th>

        <?php foreach($items as $item){ ?>
            <tr>
                <td><?php echo $item['id']; ?></td>
                <td><?php echo $item['name']; ?></td>
                <td><a class="url" value="<?php echo $item['id']; ?>" href="<?php echo $item['url']; ?>"><?php echo $item['url']; ?></a></td>
                <td><a class="status" status="<?php echo $item['status']; ?>" value="<?php echo $item['id']; ?>"><?php echo $item['status']; ?></td>
            </tr>
        <?php }; ?>
    </table>
</code>




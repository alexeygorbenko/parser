<?php
/* @var $this SiteController */
/* @var $model ParserForm */

$this->pageTitle=Yii::app()->name . ' - Parser';
$this->breadcrumbs=array(
    'Parser',
);
$items = $model->selectDescription();
?>

    <h1>Radio stations description</h1>

<?php if(Yii::app()->user->hasFlash('parser')): ?>

    <div class="flash-success">
        <?php echo Yii::app()->user->getFlash('parser'); ?>
    </div>

<?php else: ?>

    <code>
        <table>
            <th>ID</th><th>Station Name</th><th>Song</th><th>Author</th>

            <?php foreach($items as $item){ ?>
                <tr>
                    <td><?php echo $item['id']; ?></td>
                    <td><?php echo $item['st_name']; ?></td>
                    <td><?php echo $item['song']; ?></a></td>
                    <td><?php echo $item['author']; ?></td>
                </tr>
            <?php }; ?>
        </table>
    </code>

<?php endif; ?>
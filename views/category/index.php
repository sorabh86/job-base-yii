<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\widgets\LinkPager;
?>
<h2 class="page-header">Category <a href="<?php echo Yii::$app->homeUrl; ?>?r=category/create" class="btn btn-primary pull-right">Create</a></h2>

<!-- <?php if(null !== Yii::$app->session->getFlash('success')) : ?>
	<div class="alert alert-success"><?php echo Yii::$app->session->getFlash('success'); ?></div>
<?php endif; ?> -->

<ul class="list-group">
	<?php foreach($categories as $category): ?>
		<li class="list-group-item"><a href="<?php echo Yii::$app->homeUrl; ?>?r=job&category=<?php echo $category->id; ?>"><?php echo $category->name; ?></a></li>
	<?php endforeach; ?>
</ul>

<?= LinkPager::widget(['pagination' => $pagination]); ?>
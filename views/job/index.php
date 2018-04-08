<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\widgets\LinkPager;
?>
<h2 class="page-header">Jobs <a href="<?php echo Yii::$app->homeUrl; ?>?r=job/create" class="btn btn-primary pull-right">Create</a></h2>

<?php if(!empty($jobs)) : ?>

<ul class="list-group">
	<?php foreach($jobs as $job): ?>
		<?php $strDate = strtotime($job->create_date); ?>
		<?php $formatted_date = date("F j, Y, g:i a", $strDate); ?>
		<li class="list-group-item"><a href="<?php echo Yii::$app->homeUrl; ?>?r=job/details&id=<?= $job->id ?>">
			<?php echo $job->title; ?></a> - 
			<strong><?php echo $job->city.' '.$job->state; ?></strong>
			 - Listed on <?php echo $formatted_date ?>
		</li>
	<?php endforeach; ?>
</ul>

<?php else : ?>
	<p>No jobs to list</p>
<?php endif; ?>

<?= LinkPager::widget(['pagination' => $pagination]); ?>
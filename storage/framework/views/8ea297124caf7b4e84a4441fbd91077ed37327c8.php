
<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <div class="row justify-content-md-center">
            <div class="news">
                <div class="col-12">
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-6">
                            <?php if(count($news->news) > 0): ?>
                                <?php $__currentLoopData = $news->news; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $new): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="news-left-section">
                                        <div class="news-banner">
                                            <?php if($new->video_link): ?>
                                                <video width="100" height="240" controls>
                                                    <source src="<?php echo e($new->video_link); ?>" type="video/mp4">
                                                    Your browser does not support the video tag.
                                                </video>
                                            <?php else: ?>
                                                <img src="<?php echo e($new->imageUrl); ?>">
                                            <?php endif; ?>
                                        </div>
                                        <div class="news-desc">
                                            <p><?php echo e($new->publishDate); ?></p>
                                            <h3>
                                                <b><?php echo e(ucfirst($new->title)); ?></b>
                                            </h3>
                                            <p class="news-sub-desc">
                                                <b>
                                                    <?php echo $new->category; ?>

                                                </b>
                                            </p>
                                            <p class="desc"> 
                                                <?php echo substr($new->details, 0, 500); ?>

                                            </p>
                                            <a class="btn checkout-news" href="<?php echo e(route('affiliate.news.brief', $new->id)); ?>"><b>Check out the story</b></a>
                                        </div>
                                        <div class="news-desc-hr"></div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <div class="no-news-left-section">
                                    <p><b>No news found !</b></p>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-12 col-md-12 col-lg-6">
                            <div class="news-right-section">
                                <div class="row">
                                    <?php if(count($news->oldNews) > 0): ?>
                                        <div class="head-news-right-section">
                                            <ul>
                                                <?php $__currentLoopData = $news->oldNews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $onews): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <li class="news-head">
                                                        <h3>
                                                            <b><?php echo e(ucfirst($onews->title)); ?></b>
                                                        </h3>
                                                        <p><?php echo e(($onews->publishDate)); ?></p>
                                                    </li>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </ul>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="row">
                                    <div class="share-news-right-section">
                                        <p><b>Follow PWG Group on social media</b></p>
                                        <div class="share-news-image">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('affiliate.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Shamshera Hamza\pwg_client_portal\resources\views/affiliate/news.blade.php ENDPATH**/ ?>
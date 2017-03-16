<?php $__env->startSection('page-title'); ?>
    Thêm mới Ban - Đơn Vị
<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-toolbar'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <ul>
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li><?php echo e($error); ?></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
        <?php echo Form::open(array('route' => 'steeringcontent-update', 'class' => 'form')); ?>


        <div class="form-group">
            <?php echo Form::label('Nội dung chỉ đạo'); ?>

            <?php echo Form::textarea('content', "",
                array('no-required',
                      'class'=>'form-control',
                      'placeholder'=>'Nội dung chỉ đạo')); ?>

        </div>
    <div class="form-group">
        <?php echo Form::label('Thuộc kết luận'); ?>

        <?php echo Form::select('source', $source,
                array('no-required','class'=>'form-control')
        ); ?>

    </div>

    <div class="form-group">
        <?php echo Form::label('Đơn vị chủ trì'); ?>

        <?php echo Form::select('firtunit', $firstunit,
                array('no-required','class'=>'form-control')
        ); ?>

    </div>
    <div class="form-group">
        <?php echo Form::label('Đơn vị Phối hợp'); ?>

        <ul>
            <?php $__currentLoopData = $secondunit; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id=>$row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li><?php echo Form::checkbox('secondunit[]', $id, false); ?> <?php echo e($row); ?></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
    <div class="form-group">
        <?php echo Form::label('Thời gian hoàn thành'); ?>

        <?php echo Form::text('deathline', "",
            array('no-required',
                  'class'=>'form-control',
                  'placeholder'=>'Thời gian hoàn thành')); ?>

    </div>
        <div class="form-group">
            <?php echo Form::submit('Cập nhật',
              array('class'=>'btn btn-primary')); ?>

        </div>
        <?php echo Form::close(); ?>



<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout1', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->startSection('page-title'); ?>
    Update User
<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-toolbar'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <h1>Update User</h1>

    <ul>
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li><?php echo e($error); ?></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
    <?php $__currentLoopData = $nguoidung; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php echo Form::open(array('route' => 'nguoidung-update', 'class' => 'form')); ?>

    <?php echo e(Form::hidden('id', $row->id, array('id' => 'nguoidung_id'))); ?>

    <div class="form-group">
        <?php echo Form::label('Username'); ?>

        <?php echo Form::text('username', $row->username,
            array('required',
                  'class'=>'form-control',
                  'placeholder'=>'Your name')); ?>

    </div>

    <div class="form-group">
        <?php echo Form::label('Tên đầy đủ'); ?>

        <?php echo Form::text('fullname', $row->fullname,
            array('required',
                  'class'=>'form-control',
                  'placeholder'=>'Nhập tên')); ?>

    </div>


    <div class="form-group">
        <?php echo Form::submit('Cập nhật',
          array('class'=>'btn btn-primary')); ?>

    </div>
    <?php echo Form::close(); ?>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
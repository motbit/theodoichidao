<?php $__env->startSection('page-title'); ?>
    Update User
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <h1>Update User</h1>

    <ul>
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li><?php echo e($error); ?></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
    <?php $__currentLoopData = $unit; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php echo Form::open(array('route' => 'unit-update', 'class' => 'form')); ?>

    <?php echo e(Form::hidden('id', $row->id, array('id' => 'nguoidung_id'))); ?>

    <div class="form-group">
        <?php echo Form::label('Tên Ban -  Đơn Vị'); ?>

        <?php echo Form::text('name', $row->name,
            array('required',
                  'class'=>'form-control',
                  'placeholder'=>'Nhập tên Ban hoặc Đơn vị')); ?>

    </div>


    <div class="form-group">
        <?php echo Form::label('Tên viết tắc'); ?>

        <?php echo Form::text('shortname', $row->shortname,
            array('required',
                  'class'=>'form-control',
                  'placeholder'=>'Tên viết tắt')); ?>

    </div>

    <div class="form-group">
        <?php echo Form::label('Nội dung'); ?>

        <?php echo Form::textarea('description', $row->description,
            array('no-required',
                  'class'=>'form-control',
                  'placeholder'=>'Nội dung')); ?>

    </div>

    <div class="form-group">
        <?php echo Form::label('Sắp xếp'); ?>

        <?php echo Form::text('order', $row->order,
            array('required',
                  'class'=>'form-control',
                  'placeholder'=>'Sắp xếp')); ?>

    </div>


    <div class="form-group">
        <?php echo Form::submit('Cập nhật',
          array('class'=>'btn btn-primary')); ?>

    </div>
    <?php echo Form::close(); ?>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout1', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
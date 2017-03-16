<?php $__env->startSection('page-title'); ?>
    Người Dùng
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <script language="javascript">
        function xoanguoidung(id) {

            if(confirm("Bạn có muốn xóa?")) {
                document.getElementById("nguoidung_id").value = id;
                frmxoanguoidung.submit();
            }


        }
    </script>

<?php echo Form::open(array('route' => 'nguoidung-delete', 'class' => 'form', 'id' => 'frmxoanguoidung')); ?>

<?php echo e(Form::hidden('id', 0, array('id' => 'nguoidung_id'))); ?>

<?php echo Form::close(); ?>


<table class="table table-striped table-hover">
    <thead>
    <tr>
        <th> # </th>
        <th> Username </th>
        <th> Fullname </th>
        <th> Date </th>
        <th> Status </th>
        <th>  </th>
    </tr>
    </thead>
    <tbody>
    <?php $__currentLoopData = $nguoidung; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr>
        <td> <?php echo e($row->id); ?> </td>
        <td> <?php echo e($row->username); ?> </td>
        <td> <?php echo e($row->fullname); ?> </td>
        <td> <?php echo e($row->created_at); ?> </td>
        <td>
            <?php if($row->status === 1): ?>
                <span class="label label-sm label-success"> Approved </span>
            <?php elseif($row->status === 0): ?>
                <span class="label label-sm label-danger"> Disable </span>
            <?php endif; ?>
        </td>
        <td><a href="javascript:xoanguoidung('<?php echo e($row->id); ?>')">xóa</a> | <?php echo e(Html::linkAction('NguoidungController@edit', 'sửa', array('id'=>$row->id))); ?></td>
    </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
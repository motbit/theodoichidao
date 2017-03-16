<?php $__env->startSection('page-title'); ?>
    Người Dùng
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <script language="javascript">
        function removebyid(id) {

            if(confirm("Bạn có muốn xóa?")) {
                document.getElementById("id").value = id;
                frmdelete.submit();
            }


        }
    </script>

<?php echo e(Html::linkAction('UnitController@edit', 'Thêm mới', array('id'=>0))); ?>


<?php echo Form::open(array('route' => 'unit-delete', 'class' => 'form', 'id' => 'frmdelete')); ?>

<?php echo e(Form::hidden('id', 0, array('id' => 'id'))); ?>

<?php echo Form::close(); ?>


<table class="table table-striped table-hover">
    <thead>
    <tr>
        <th> # </th>
        <th> Tên đơn vị </th>
        <th> Tên viết tắt </th>
        <th> Sắp xếp </th>
        <th>  </th>
    </tr>
    </thead>
    <tbody>
    <?php $__currentLoopData = $lstunit; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr>
        <td> <?php echo e($row->id); ?> </td>
        <td> <?php echo e($row->name); ?> </td>
        <td> <?php echo e($row->shortname); ?> </td>
        <td> <?php echo e($row->order); ?> </td>
        <td>
            <?php if($row->status === 1): ?>
                <span class="label label-sm label-success"> Approved </span>
            <?php elseif($row->status === 0): ?>
                <span class="label label-sm label-danger"> Disable </span>
            <?php endif; ?>
        </td>
        <td><a href="javascript:removebyid('<?php echo e($row->id); ?>')">xóa</a> | <?php echo e(Html::linkAction('UnitController@edit', 'cập nhật', array('id'=>$row->id))); ?></td>
    </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout1', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
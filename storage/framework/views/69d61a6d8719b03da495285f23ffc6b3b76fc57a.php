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

<?php echo e(Html::linkAction('SteeringcontentController@edit', 'Thêm mới', array('id'=>0))); ?>


<?php echo Form::open(array('route' => 'steeringcontent-delete', 'class' => 'form', 'id' => 'frmdelete')); ?>

<?php echo e(Form::hidden('id', 0, array('id' => 'id'))); ?>

<?php echo Form::close(); ?>


<table class="table table-striped table-hover">
    <thead>
    <tr>
        <th> # </th>
        <th> Nội dung công việc </th>
        <th> Nguồn chỉ đạo </th>
        <th> Đơn vị đầu mối</th>
        <th> Đơn vị phối hợp </th>
        <th> Thời hạn HT </th>
        <th> Theo dõi của VP </th>
        <th> Tình hình Thực Hiện </th>
        <th> Đánh giá </th>
        <th> XN </th>
        <th> </th>
    </tr>
    </thead>
    <tbody>
    <?php $__currentLoopData = $lst; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr>
        <td> <?php echo e($row->id); ?> </td>
        <td> <?php echo e($row->content); ?> </td>
        <td> <?php echo e($source[$row->source]); ?> </td>
        <td> <?php echo e($unit[$row->unit]); ?> </td>
        <td> <?php echo e($row->follow); ?> </td>
        <td> <?php echo e($row->deathline); ?> </td>
        <td> <?php echo e($row->note); ?> </td>
        <td>  </td>
        <td> <?php echo e($row->status); ?> </td>
        <td> <?php echo e($row->xn); ?> </td>
        <td><a href="javascript:removebyid('<?php echo e($row->id); ?>')">xóa</a> | <?php echo e(Html::linkAction('UnitController@edit', 'cập nhật', array('id'=>$row->id))); ?></td>
    </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout1', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
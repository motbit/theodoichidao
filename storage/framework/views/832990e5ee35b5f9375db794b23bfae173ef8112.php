<?php $__env->startSection('content'); ?>
    <script language="javascript">
        function xoanguoidung(id) {

            if (confirm("Bạn có muốn xóa?")) {
                document.getElementById("steering_id").value = id;
                frmxoa.submit();
            }


        }
    </script>


    <?php echo Form::open(array('route' => 'sourcesteering-delete', 'class' => 'form', 'id' => 'frmxoa')); ?>

    <?php echo e(Form::hidden('id', 0, array('id' => 'steering_id'))); ?>

    <?php echo Form::close(); ?>


    <h1>Nguồn chỉ đạo</h1>
    <a class="btn btn-default" href="sourcesteering/update?id=0">Thêm nguồn chỉ đạo</a>
    <table class="table table-responsive table-bordered">
        <thead>
        <tr>
            <?php if(\App\Roles::checkPermission()): ?>
                <th></th>
            <?php endif; ?>
            <th>Nguồn chỉ đạo</th>
            <th>Loại</th>
            <th>Kí hiệu</th>
            <th>Người chủ trì</th>
            <th>File đính kèm</th>
            <th>Hoàn thành</th>
            <th>Ngày ban hành</th>
        </tr>
        </thead>
        <tbody>
        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>

                <?php if(\App\Roles::checkPermission()): ?>
                    <td class="col-action">
                        <a href="/sourcesteering/update?id=<?php echo e($row->id); ?>"><img src="/img/edit.png"></a>
                        <a href="javascript:xoanguoidung('<?php echo e($row->id); ?>')"><img src="/img/delete.png"></a>
                    </td>
                <?php endif; ?>

                <td><?php echo e($row->name); ?></td>
                <td><?php echo e($row->typename); ?></td>
                <td><?php echo e($row->code); ?></td>
                <td><?php echo e($row->conductorname); ?></td>
                <td class="text-center">
                    <?php if($row->file_attach != ''): ?>
                        <a href="/file/<?php echo e($row->file_attach); ?>" download>Tải về</a>
                    <?php endif; ?>
                </td>
                <td class="text-center"><input type="checkbox" value="<?php echo e($row->id); ?>"
                                               disabled <?php echo e(($row->status == 0)?'':'checked'); ?>></td>
                <td><?php echo e(date("d-m-Y", strtotime($row->time))); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout1', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
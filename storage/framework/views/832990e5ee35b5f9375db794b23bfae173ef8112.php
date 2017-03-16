<?php $__env->startSection('content'); ?>
    <h1>Nguồn chỉ đạo</h1>
    <a class="btn btn-default" href="sourcesteering/update?id=0">Thêm nguồn chỉ đạo</a>
    <table class="table table-responsive table-bordered">
        <thead>
        <tr>
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
                <td><?php echo e($row->name); ?></td>
                <td><?php echo e($row->typename); ?></td>
                <td><?php echo e($row->code); ?></td>
                <td><?php echo e($row->conductorname); ?></td>
                <td class="text-center">
                    <?php if($row->file_attach != ''): ?>
                    <a href="/file/<?php echo e($row->file_attach); ?>" download>Tải về</a>
                    <?php endif; ?>
                </td>
                <td class="text-center"><input type="checkbox" value="<?php echo e($row->id); ?>"></td>
                <td><?php echo e(date("d-m-Y", strtotime($row->time))); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout1', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
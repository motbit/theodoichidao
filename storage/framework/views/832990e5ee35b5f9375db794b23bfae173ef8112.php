<?php $__env->startSection('page-title'); ?>
    Nguồn chỉ đạo
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <script language="javascript">
        function xoanguoidung(id) {

            if (confirm("Bạn có muốn xóa?")) {
                document.getElementById("steering_id").value = id;
                frmxoa.submit();
            }
        }

    </script>
    <style>
        select {
            height: 23px;
        }

        input {
            height: 23px;
        }
    </style>


    <?php echo Form::open(array('route' => 'sourcesteering-delete', 'class' => 'form', 'id' => 'frmxoa')); ?>

    <?php echo e(Form::hidden('id', 0, array('id' => 'steering_id'))); ?>

    <?php echo Form::close(); ?>


    <div class="text-center title">Nguồn chỉ đạo</div>
    <a class="btn btn-my" href="sourcesteering/update?id=0">Thêm nguồn</a>
    <table id="table" class="table table-responsive table-bordered">
        <thead>
        <tr>
            <th></th>
            <th>Trích yếu<br><input type="text" style="width: 100%"></th>
            <th class="td-type">Loại nguồn
                <select style="max-width: 150px">
                    <option value=""></option>
                    <?php $__currentLoopData = $type; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($t->name); ?>"><?php echo e($t->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </th>
            <th class="td-code">Số kí hiệu<input type="text" style="max-width: 100px"></th>
            <th class="td-sign">Người ký
                <input type="text" style="max-width: 100px">
            </th>
            <th class="text-center align-top">File</th>
            <th class="td-date">Ngày ban hành
                <input type="text" class="datepicker" style="max-width: 100px">
            </th>
            <?php if(\App\Roles::checkPermission()): ?>
                <th class="td-action"></th>
                <th class="td-action"></th>
            <?php endif; ?>
        </tr>
        </thead>
        <tbody>
        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx=>$row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($idx + 1); ?></td>
                <td><a href="steeringcontent?source=<?php echo e($row->id); ?>"><?php echo e($row->name); ?></a></td>
                <td><?php echo e($row->typename); ?></td>
                <td><?php echo e($row->code); ?></td>
                <td><?php echo e($row->sign_by); ?></td>
                <td class="text-center td-file">
                    <?php if($row->file_attach != ''): ?>
                        <a href="/file/<?php echo e($row->file_attach); ?>" download>Tải về</a>
                    <?php endif; ?>
                </td>
                <td><?php echo e(date("d/m/Y", strtotime($row->time))); ?></td>
                <?php if(\App\Roles::checkPermission()): ?>
                    <td>
                        <a href="/sourcesteering/update?id=<?php echo e($row->id); ?>"><img height="20" border="0"
                                                                              src="/img/edit.png"></a>
                    </td>
                    <td>
                        <a href="javascript:xoanguoidung('<?php echo e($row->id); ?>')"><img height="20" border="0"
                                                                               src="/img/delete.png"></a>
                    </td>
                <?php endif; ?>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout1', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
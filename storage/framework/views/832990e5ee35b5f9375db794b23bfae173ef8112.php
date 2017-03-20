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


    <?php echo Form::open(array('route' => 'sourcesteering-delete', 'class' => 'form', 'id' => 'frmxoa')); ?>

    <?php echo e(Form::hidden('id', 0, array('id' => 'steering_id'))); ?>

    <?php echo Form::close(); ?>


    <h1>Nguồn chỉ đạo</h1>
    <a class="btn btn-default" href="sourcesteering/update?id=0">Thêm nguồn chỉ đạo</a>
    <table id="table" class="table table-responsive table-bordered">
        <thead>
        <tr>
            <?php if(\App\Roles::checkPermission()): ?>
                <th></th>
            <?php endif; ?>
            <th>Nguồn chỉ đạo<input type="text"></th>
            <th>Loại
                <select>
                    <option value=""></option>
                    <?php $__currentLoopData = $type; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($t->name); ?>"><?php echo e($t->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </th>
            <th>Kí hiệu<input type="text"></th>
            <th>Người chủ trì
                <select>
                    <option value=""></option>
                    <?php $__currentLoopData = $viphuman; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vip): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($vip->name); ?>"><?php echo e($vip->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </th>
            <th>File đính kèm</th>
            <th>Hoàn thành</th>
            <th>Ngày ban hành
                <input type="date">
            </th>
        </tr>
        </thead>
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        <tbody>
        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>

                <?php if(\App\Roles::checkPermission()): ?>
                    <td style="width: 30px">
                        <a href="/sourcesteering/update?id=<?php echo e($row->id); ?>"><img height="16" border="0"
                                                                              src="/img/edit.png"></a>
                        <a href="javascript:xoanguoidung('<?php echo e($row->id); ?>')"><img height="16" border="0"
                                                                               src="/img/delete.png"></a>
                    </td>
                <?php endif; ?>

                <td><a href="steeringcontent?source=<?php echo e($row->id); ?>"><?php echo e($row->name); ?></a></td>
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
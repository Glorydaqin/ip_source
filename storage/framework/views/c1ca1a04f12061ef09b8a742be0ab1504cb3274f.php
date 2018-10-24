<?php $__currentLoopData = Config::get("nav"); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <li>
        <a href="<?php echo e($value['link']); ?>"><i class="fa <?php echo e($value['icon']); ?>"></i> <span class="nav-label"><?php echo e($key); ?></span>
            <?php if(isset($value['level'])): ?>
                <span class="fa arrow"></span>
            <?php endif; ?>
            
        </a>
        <?php if(isset($value['level'])): ?>
            <ul class="nav nav-second-level">
                <?php $__currentLoopData = $value['level']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(!is_array($item)): ?>
                        <li><a class="J_menuItem" href="<?php echo e(action($item)); ?>"><?php echo e($k); ?></a></li>
                    <?php else: ?>
                        <li>
                            <a href="#"><?php echo e($k); ?> <span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level" aria-expanded="true">
                                <?php $__currentLoopData = $item; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kk=>$vv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><a class="J_menuItem" href="<?php echo e(action($vv)); ?>" data-index="60"><?php echo e($kk); ?></a></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </li>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        <?php endif; ?>
    </li>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
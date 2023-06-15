<?php
/**
 * 	@author: $rachow
 *	@copyright: CF Partners 2023
 *
 * 	template file for error displays from CI Validation object
 * 		keep things isolated and structured !
*/

?>
<?php if(!empty($errors)): ?>
    <div class="alert alert-danger" role="alert">
        <ul>
        <?php foreach($errors as $error): ?>
            <li><?= esc($error) ?></li>
        <?php endforeach ?>
        </ul>
    </div>
<?php endif ?>

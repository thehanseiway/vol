<?php
/**
 * settings option
 *
 *
 */



/**
* option field
*/
function KTT_select_field($option, $current_value) {
  
  if ($option->option_type != 'select') return;

  ?>

                    <select
                    style="<?php echo $option->option_style ;?>"  
                    id="<?php echo $option->option_id ;?>" 
                    name="<?php echo $option->option_id ;?>" 
                    >

                    <?php foreach ($option->option_type_vars as $key => $name) {?>
                        <option <?php if ($current_value == $key) {?>selected<?php } ?> value="<?php echo $key;?>"><?php echo $name;?></option>
                    <?php } ?>

                    </select>

                    <?php if ($option->option_description) {?> <p class="description"><?php echo $option->option_description;?></p> <?php } ?>


                    <?php


}
add_action('KTT_settings_option_field', 'KTT_select_field', 2, 2);


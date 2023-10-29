<?php
/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 


global $userprofile;
?>

<section class="basic-info">

	<div class="section-title"><?php echo __('Basic Info', 'user-profile'); ?></div>

	<div class="section-field">
      	<label for="first_name"><?php echo __('First name', 'user-profile'); ?></label>
        <input placeholder="Jhon" type="text" id="first_name" name="first_name" value="<?php echo $thisuser->first_name; ?>" />

	</div>

    <div class="section-field">
        <label for="last_name" ><?php echo __('Last name', 'user-profile'); ?></label>
        <input placeholder="Doe" type="text" id="last_name" name="last_name" value="<?php echo $thisuser->last_name; ?>" />
    </div>


                

	<div class="section-field">
            <label for="up_date_of_birth"><?php echo __('Birth date', 'user-profile'); ?></label>
            <input class="user_profile_date" placeholder="2017-02-09" type="text" id="up_date_of_birth" name="up_date_of_birth" value="<?php echo $thisuser->date_of_birth; ?>" />
	</div>

	<div class="section-field">
            <label for="up_relationship"><?php echo __('Relationsship', 'user-profile'); ?></label>
            <select id="up_relationship" name="up_relationship">
		<?php foreach( $userprofile->user_relationship() as $index => $relation ) : ?>
			<?php $selected = $thisuser->relationship == $index ? 'selected' : ''; ?>
			<option <?php echo $selected; ?>  value="<?php echo $index; ?>" ><?php echo $relation['title']; ?></option>
		<?php endforeach; ?>
            </select>
	</div>

	<div class="section-field">
            <label for="up_gender"><?php echo __('Gender', 'user-profile'); ?></label>
            <select id="up_gender" name="up_gender">                
		<?php foreach( $userprofile->user_gender() as $index => $gend ) : ?>
			<?php $selected = $thisuser->gender == $index ? 'selected' : ''; ?>
			<option <?php echo $selected; ?>  value="<?php echo $index; ?>" ><?php echo $gend['title']; ?></option>
		<?php endforeach; ?>
            </select>
	</div>

	<div class="section-field">
            <label for="up_religious"><?php echo __('Religious', 'user-profile'); ?></label>
            <input placeholder="Religious" type="text" id="up_religious" name="up_religious" value="<?php echo $thisuser->religious; ?>" />
	</div>
            
	<div class="section-field">
            <label for="description"><?php echo __('Biographical Info', 'user-profile'); ?></label>
            <textarea id="description" name="description" row="5"><?php echo $thisuser->description; ?></textarea>
	</div>
		
	<div class="section-field">
            <label for="user_url"><?php echo __('Website', 'user-profile'); ?></label>
            <input placeholder="http://www.mysite.com" type="text" id="user_url" name="user_url" value="<?php echo $thisuser->user_url; ?>" />
	</div>


</section>
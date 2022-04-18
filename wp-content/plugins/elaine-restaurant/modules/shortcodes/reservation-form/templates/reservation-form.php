<div class="edgtf-rf-holder">
	<?php if($open_table_id !== '') : ?>
		<form class="edgtf-rf" target="_blank" action="http://www.opentable.com/restaurant-search.aspx" name="edgtf-rf">
			<div class="edgtf-rf-row clearfix">
				<div class="edgtf-rf-col-holder">
					<div class="edgtf-rf-field-holder clearfix">
						<select name="partySize" class="edgtf-ot-people">
							<option value="1"><?php esc_html_e('1 Person', 'elaine-restaurant'); ?></option>
							<option value="2"><?php esc_html_e('2 People', 'elaine-restaurant'); ?></option>
							<option value="3"><?php esc_html_e('3 People', 'elaine-restaurant'); ?></option>
							<option value="4"><?php esc_html_e('4 People', 'elaine-restaurant'); ?></option>
							<option value="5"><?php esc_html_e('5 People', 'elaine-restaurant'); ?></option>
							<option value="6"><?php esc_html_e('6 People', 'elaine-restaurant'); ?></option>
							<option value="7"><?php esc_html_e('7 People', 'elaine-restaurant'); ?></option>
							<option value="8"><?php esc_html_e('8 People', 'elaine-restaurant'); ?></option>
							<option value="9"><?php esc_html_e('9 People', 'elaine-restaurant'); ?></option>
							<option value="10"><?php esc_html_e('10 People', 'elaine-restaurant'); ?></option>
						</select>
					<span class="edgtf-rf-icon">
						<span class="fa fa-user"></span>
					</span>
					</div>
				</div>
				<span class="edgtf-rf-label">
					<?php esc_html_e('For', 'elaine-restaurant'); ?>
				</span>
				<div class="edgtf-rf-col-holder">
					<div class="edgtf-rf-field-holder clearfix">
						<input type="text" value="<?php echo date('m/d/Y'); ?>" class="edgtf-ot-date" name="startDate">
					<span class="edgtf-rf-icon">
						<span class="fa fa-calendar"></span>
					</span>
					</div>
				</div>
				<span class="edgtf-rf-label">
					<?php esc_html_e('At', 'elaine-restaurant'); ?>
				</span>
				<div class="edgtf-rf-col-holder edgtf-rf-time-col">
					<div class="edgtf-rf-field-holder clearfix">
						<select name="ResTime" class="edgtf-ot-time">
							<option value="5:30pm">6:30 am</option>
							<option value="5:30pm">7:00 am</option>
							<option value="5:30pm">7:30 am</option>
							<option value="5:30pm">8:00 am</option>
							<option value="5:30pm">8:30 am</option>
							<option value="5:30pm">9:00 am</option>
							<option value="5:30pm">9:30 am</option>
							<option value="5:30pm">10:00 am</option>
							<option value="5:30pm">10:30 am</option>
							<option value="5:30pm">11:00 am</option>
							<option value="5:30pm">11:30 am</option>
							<option value="5:30pm">12:00 pm</option>
							<option value="5:30pm">12:30 pm</option>
							<option value="5:30pm">1:00 pm</option>
							<option value="5:30pm">1:30 pm</option>
							<option value="5:30pm">2:00 pm</option>
							<option value="5:30pm">2:30 pm</option>
							<option value="5:30pm">3:00 pm</option>
							<option value="5:30pm">3:30 pm</option>
							<option value="5:30pm">4:00 pm</option>
							<option value="5:30pm">4:30 pm</option>
							<option value="5:30pm">5:00 pm</option>
							<option value="5:30pm">5:30 pm</option>
							<option value="6:00pm">6:00 pm</option>
							<option value="6:30pm">6:30 pm</option>
							<option value="7:00pm" selected="selected">7:00 pm</option>
							<option value="7:30pm">7:30 pm</option>
							<option value="8:00pm">8:00 pm</option>
							<option value="8:30pm">8:30 pm</option>
							<option value="9:00pm">9:00 pm</option>
							<option value="9:30pm">9:30 pm</option>
							<option value="10:00pm">10:00 pm</option>
							<option value="10:30pm">10:30 pm</option>
							<option value="11:00pm">11:00 pm</option>
							<option value="11:30pm">11:30 pm</option>
						</select>
					<span class="edgtf-rf-icon">
						<span class="fa fa-clock"></span>
					</span>
					</div>
				</div>
				<div class="edgtf-rf-col-holder edgtf-rf-btn-holder">
					<?php if(elaine_restaurant_theme_installed()) : ?>
						<?php echo elaine_edge_execute_shortcode('edgtf_button',
							array(
								'text'      => esc_html__('Book a Table', 'elaine-restaurant'),
								'icon_pack' => 'font_elegant',
								'fe_icon'   => 'arrow_carrot-right',
                                'html_type' => 'button',
							)
						) ?>
					<?php else: ?>
						<input type="submit" class="edgtf-btn edgtf-btn-solid" name="edgtf-rf-time">
					<?php endif; ?>
				</div>
			</div>

			<input type="hidden" name="RestaurantID" class="RestaurantID" value="<?php echo esc_attr($open_table_id); ?>">
			<input type="hidden" name="rid" class="rid" value="<?php echo esc_attr($open_table_id); ?>">
			<input type="hidden" name="GeoID" class="GeoID" value="15">
			<input type="hidden" name="txtDateFormat" class="txtDateFormat" value="MM/dd/yyyy">
			<input type="hidden" name="RestaurantReferralID" class="RestaurantReferralID" value="<?php echo esc_attr($open_table_id); ?>">

		</form>
		<p class="edgtf-rf-copyright"><?php esc_html_e('Powered by OpenTable', 'elaine-restaurant'); ?></p>
	<?php else: ?>
		<p><?php esc_html_e('You haven\'t added OpenTable ID', 'elaine-restaurant'); ?></p>
	<?php endif; ?>
</div>
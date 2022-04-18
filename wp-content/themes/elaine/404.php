<?php get_header(); ?>
				<div class="edgtf-page-not-found">
					<?php
					$edgtf_title_image_404 = elaine_edge_options()->getOptionValue( '404_page_title_image' );
					$edgtf_title_404       = elaine_edge_options()->getOptionValue( '404_title' );
					$edgtf_subtitle_404    = elaine_edge_options()->getOptionValue( '404_subtitle' );
					$edgtf_text_404        = elaine_edge_options()->getOptionValue( '404_text' );
					$edgtf_button_label    = elaine_edge_options()->getOptionValue( '404_back_to_home' );
					$edgtf_button_style    = elaine_edge_options()->getOptionValue( '404_button_style' );
					
					if ( ! empty( $edgtf_title_image_404 ) ) { ?>
						<div class="edgtf-404-title-image">
							<img src="<?php echo esc_url( $edgtf_title_image_404 ); ?>" alt="<?php esc_attr_e( '404 Title Image', 'elaine' ); ?>" />
						</div>
					<?php } ?>
					
					<p class="edgtf-404-text">
						<?php if ( ! empty( $edgtf_text_404 ) ) {
							echo esc_html( $edgtf_text_404 );
						} else {
							esc_html_e( 'Ooops!', 'elaine' );
						} ?>
					</p>
					
					<h1 class="edgtf-404-title">
						<?php if ( ! empty( $edgtf_title_404 ) ) {
							echo esc_html( $edgtf_title_404 );
						} else {
							esc_html_e( '404 Error page', 'elaine' );
						} ?>
					</h1>
					
					<?php
						$button_params = array(
							'link' => esc_url( home_url( '/' ) ),
							'text' => ! empty( $edgtf_button_label ) ? $edgtf_button_label : esc_html__( 'Home', 'elaine' )
						);
					
						if ( $edgtf_button_style == 'light-style' ) {
							$button_params['custom_class'] = 'edgtf-btn-light-style';
						}
						
						echo elaine_edge_return_button_html( $button_params );
						
					?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php wp_footer(); ?>
</body>
</html>
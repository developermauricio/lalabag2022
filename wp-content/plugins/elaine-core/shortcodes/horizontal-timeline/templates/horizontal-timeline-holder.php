<div class="edgtf-horizontal-timeline" data-distance="<?php echo esc_attr( $distance ); ?>">
	<div class="edgtf-ht-nav">
		<div class="edgtf-ht-nav-wrapper">
			<div class="edgtf-ht-nav-inner">
				<ol>
					<?php foreach ( $dates as $date ) {
						$dateLabel = $timeline_format === 'Y' ? $date['formatted'] : date_i18n( $timeline_format, $date['timestamp'] );
						?>
						<li>
							<a href="#" data-date="<?php echo esc_attr( $date['formatted'] ); ?>"><?php echo esc_html( $dateLabel ); ?></a>
						</li>
					<?php } ?>
				</ol>
				<span class="edgtf-ht-nav-filling-line" aria-hidden="true"></span>
			</div>
		</div>
		<ul class="edgtf-ht-nav-navigation">
			<li><a href="#" class="edgtf-prev edgtf-inactive"></a></li>
			<li><a href="#" class="edgtf-next"></a></li>
		</ul>
	</div>
	<div class="edgtf-ht-content">
		<ol>
			<?php echo do_shortcode( $content ); ?>
		</ol>
	</div>
</div>
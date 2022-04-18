<?php if ( $query_results->max_num_pages > 1 ) { ?>
	<div class="edgtf-pl-loading">
		<div class="edgtf-pl-loading-bounce1"></div>
		<div class="edgtf-pl-loading-bounce2"></div>
		<div class="edgtf-pl-loading-bounce3"></div>
	</div>
	<?php
	$pages = $query_results->max_num_pages;
	$paged = $query_results->query['paged'];
	
	if ( $pages > 1 ) { ?>
		<div class="edgtf-pl-standard-pagination">
			<ul>
				<li class="edgtf-pag-prev">
					<a href="#" data-paged="1"><span class="arrow_carrot-left"></span></a>
				</li>
				<?php for ( $i = 1; $i <= $pages; $i ++ ) { ?>
					<?php
					$link_classes = '';
					if ( $paged == $i ) {
						$link_classes = 'edgtf-pag-active';
					}
					?>
					<li class="edgtf-pag-number <?php echo esc_attr( $link_classes ); ?>">
						<a href="#" data-paged="<?php echo esc_attr( $i ); ?>"><?php echo esc_html( $i ); ?></a>
					</li>
				<?php } ?>
				<li class="edgtf-pag-next">
					<a href="#" data-paged="2"><span class="arrow_carrot-right"></span></a>
				</li>
			</ul>
		</div>
	<?php }
} ?>

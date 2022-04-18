<?php
/**
 * My Account Subscriptions Section of YITH WooCommerce Subscription
 *
 * @package YITH WooCommerce Subscription
 * @since   1.0.0
 * @author  YITH
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

do_action( 'ywsbs_my_subscriptions_view_before' );

$subscriptions = YWSBS_Subscription_Helper()->get_subscriptions_by_user( get_current_user_id() );
$status        = ywsbs_get_status();
?>
<h2><?php echo esc_html( apply_filters( 'ywsbs_my_account_subscription_title', __( 'My Subscriptions', 'yith-woocommerce-subscription' ) ) ); ?></h2>
<?php if ( empty( $subscriptions ) ) : ?>
	<p class="ywsbs-my-subscriptions"><?php esc_html_e( 'There is no active subscription for your account.', 'yith-woocommerce-subscription' ); ?></p>
<?php else : ?>
	<table class="shop_table ywsbs_subscription_table my_account_orders shop_table_responsive">
		<thead>
		<tr>
			<th class="ywsbs-subscription-product"><?php esc_html_e( 'Product', 'yith-woocommerce-subscription' ); ?></th>
			<th class="ywsbs-subscription-status"><?php esc_html_e( 'Status', 'yith-woocommerce-subscription' ); ?></th>
			<th class="ywsbs-subscription-recurring"><?php esc_html_e( 'Recurring', 'yith-woocommerce-subscription' ); ?></th>
			<th class="ywsbs-subscription-start-date"><?php esc_html_e( 'Start date', 'yith-woocommerce-subscription' ); ?></th>
			<th class="ywsbs-subscription-payment-date"><?php esc_html_e( 'Next Payment Due Date', 'yith-woocommerce-subscription' ); ?></th>
			<th class="ywsbs-subscription-action-view"></th>
			<?php if ( get_option( 'ywsbs_allow_customer_cancel_subscription' ) == 'yes' ) : ?>
				<th class="ywsbs-subscription-action-delete"></th>
			<?php endif ?>
		</tr>
		</thead>
		<tbody>
		<?php
		foreach ( $subscriptions as $subscription_post ) :
			$subscription          = ywsbs_get_subscription( $subscription_post->ID );
			$next_payment_due_date = ( ! in_array( $subscription->status, array( 'paused', 'cancelled' ) ) && $subscription->payment_due_date ) ? date_i18n( wc_date_format(), $subscription->payment_due_date ) : '';
			$start_date            = ( $subscription->start_date ) ? date_i18n( wc_date_format(), $subscription->start_date ) : '';
			?>


			<tr class="ywsbs-item">
				<td class="ywsbs-subscription-product" data-title="<?php esc_attr_e( 'Product', 'yith-woocommerce-subscription' ); ?>">
					<a href="<?php echo esc_url( get_permalink( $subscription->product_id ) ); ?>"><?php echo wp_kses_post( $subscription->product_name ); ?></a><?php echo ' x ' . esc_html( $subscription->quantity ); ?>
				</td>

				<td class="ywsbs-subscription-status" data-title="<?php esc_attr_e( 'Status', 'yith-woocommerce-subscription' ); ?>">
					<span class="status <?php echo esc_attr( $subscription->status ); ?>"><?php echo esc_html( $status[ $subscription->status ] ); ?></span>
				</td>

				<td class="ywsbs-subscription-recurring" data-title="<?php esc_attr_e( 'Recurring', 'yith-woocommerce-subscription' ); ?>">
					<?php echo wp_kses_post( $subscription->get_formatted_recurring() ); ?>
				</td>

				<td class="ywsbs-subscription-start-date" data-title="<?php esc_attr_e( 'Start date', 'yith-woocommerce-subscription' ); ?>">
					<?php echo wp_kses_post( $start_date ); ?>
				</td>

				<td class="ywsbs-subscription-payment-date" data-title="<?php esc_attr_e( 'Next Payment Due Date', 'yith-woocommerce-subscription' ); ?>">
					<?php echo wp_kses_post( $next_payment_due_date ); ?>
				</td>

				<td class="ywsbs-subscription-action-view" data-title="<?php esc_attr_e( 'View', 'yith-woocommerce-subscription' ); ?>">
					<?php
					$actions = array(
						'view' => array(
							'url'  => $subscription->get_view_subscription_url(),
							'name' => __( 'View', 'yith-woocommerce-subscription' ),
						),
					);

					if ( $actions = apply_filters( 'woocommerce_my_account_my_subscriptions_actions', $actions, $subscription ) ) {
						foreach ( $actions as $key => $action ) {
							echo '<a href="' . esc_url( $action['url'] ) . '" class="' . esc_attr( apply_filters( 'ywsbs_button_class', 'btn btn-xs btn-ghost-blue' ) ) . ' ' . sanitize_html_class( $key ) . '">' . esc_html( $action['name'] ) . '</a>';
						}
					}
					?>
				</td>
				<?php if ( get_option( 'ywsbs_allow_customer_cancel_subscription' ) == 'yes' ) : ?>
					<td class="ywsbs-subscription-action-delete" data-title="<?php esc_attr_e( 'Cancel', 'yith-woocommerce-subscription' ); ?>">
						<?php if ( $subscription->can_be_cancelled() && 'cancelled' != $subscription->status ) : ?>
							<a href="#cancel-subscription-modal"  class="<?php echo esc_attr( apply_filters( 'ywsbs_button_class', 'button' ) ); ?> cancel-subscription-button" data-ywsbs-rel="prettyPhoto" data-id="<?php echo esc_attr( $subscription->id ); ?>" data-url="<?php echo esc_url( $subscription->get_change_status_link( 'cancelled' ) ); ?>" data-expired="<?php echo esc_attr( $next_payment_due_date ); ?>"><?php echo esc_html( apply_filters( 'ywsbs_label_cancel_subscription_button', __( 'Cancel', 'yith-woocommerce-subscription' ) ) ); ?></a>
						<?php endif ?>
					</td>
				<?php endif ?>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>

	<!-- nueva sesion CAMBIOS SUSCRIPCION -->
	<h2 style="margin-top: 4rem;"> Mis encuestas </h2>
	<?php 
		// obtener datos del usuario
		$dataUser  = $subscription->get_address_fields( 'billing', true );
		echo '<script> const dataUser = '.json_encode($dataUser).';</script>';
		//print_r($dataUser);

		// informacion de suscripciones
		foreach ( $subscriptions as $subscription_post ) {
			$subscription = ywsbs_get_subscription( $subscription_post->ID );
			$start_date   = ( $subscription->start_date ) ? date_i18n( wc_date_format(), $subscription->start_date ) : '';

			echo '<div>';
				$date = ($start_date) ? '('.$start_date .')' : ' ';
				echo '<h5 style="background: #ee939475;padding: 10px;">'.$subscription->product_name.' '.$date .'</h5>';
				if ( $subscription->product_id == '7410' || $subscription->product_id == '7415' || $subscription->product_id == '7419') { // lalabag datos de la encuesta  	
					mostrarDatos($subscription_post->ID, 6502, get_current_user_id(), '[wpforms id="6502"]'); 
				} else if ( $subscription->product_id == '7421' || $subscription->product_id == '7422' || $subscription->product_id == '7425') { // lalabag Pro
					mostrarDatos($subscription_post->ID, 6607, get_current_user_id(), '[wpforms id="6607"]');
				} else if ( $subscription->product_id == '7432') { // lalabag Duo
					mostrarDatos($subscription_post->ID, 6608, get_current_user_id(), '[wpforms id="6608"]');
				}
			echo '</div>';
		}?>				
	<?php endif;
do_action( 'ywsbs_my_subscriptions_view_after' );
?>

<!-- SUBSCRIPTION CANCEL POPUP OPENER -->
<div id="cancel-subscription-modal" class="hide-modal myaccount-modal-cancel" >
	<p><?php echo esc_html( apply_filters( 'ywsbs_content_cancel_subscription_modal', __( 'Do you really want to cancel subscription?', 'yith-woocommerce-subscription' ) ) ); ?></p>
	<p>
		<a class="ywsbs-button button my-account-cancel-quote-modal-button " data-id="" href="#"><?php esc_html_e( 'Yes, I want to cancel the subscription', 'yith-woocommerce-subscription' ); ?></a>
		<a class="ywsbs-button button close-subscription-modal-button" href="#"><?php esc_html_e( 'Close', 'yith-woocommerce-subscription' ); ?></a>
	</p>
</div>

<?php // funcion que permite mostrar la informacion de la encuesta
function mostrarDatos($idSubscription, $idPoll, $idUser, $shortcode) { 
	global $wpdb;
	$query = 'SELECT * FROM wp_wpforms_entries WHERE form_id = '.$idPoll.' AND user_id = '.$idUser;
	$infoQuery = $wpdb->get_results($query); 

	if ( $infoQuery ) { // ver datos de la encuesta
		echo '<div id="view-polls-lalabag-'.$idSubscription.'" onclick="viewMyPolls'.$idSubscription.'()"> <span class="view-poll">Ver datos de la encuesta</span> </div>';
		foreach ( $infoQuery as $data ) {
			echo '<div id="data-entry-fields-poll-'.$idSubscription.'" class="postbox" style="display: none;">';					
			echo '<h5> Encuesta realizada el: '. $data->date .'</h5>';
			$infoPoll = json_decode( $data->fields );
			echo '<div class="inside">';
			foreach ( $infoPoll as $dataPoll ) { // datos de los campos
				if ($dataPoll->value) { echo '<div class="wpforms-entry-field"><p class="style-name-field">'. $dataPoll->name .' : </p><p class="style-content-field">'. $dataPoll->value .'</p></div>'; }
			}
			echo '</div> </div>';
		}
		addScriptViewPoll( $idSubscription );				
	} else { // realizar encuesta ?>
		<div> Es necesario realizar tu encuesta <span id="polls-lalabag-<?php echo $idSubscription; ?>" onclick="doMyPoll<?php echo $idSubscription; ?>()" class="buttom-do-poll">ver encuesta</span> </div>
		<div id="content-polls-lalabag-<?php echo $idSubscription; ?>" style="display: none;border: 1px solid #ee9394;padding: 1rem;margin-top: 1rem;"> <?php echo do_shortcode($shortcode);  ?> </div>		
<?php addScriptDoPoll( $idSubscription ); }} ?>

<?php // metodo para agregar funcionalidad de javascript para HACER la encuesta
function addScriptDoPoll( $idSubscription ) { ?>
	<script>
	var contEvent<?php echo $idSubscription; ?> = true;
    function doMyPoll<?php echo $idSubscription; ?>() {	
        if (contEvent<?php echo $idSubscription; ?>) {
  	        document.getElementById("polls-lalabag-<?php echo $idSubscription; ?>").innerHTML = "ocultar encuesta";
            document.getElementById("content-polls-lalabag-<?php echo $idSubscription; ?>").style.display = "block";
  	        contEvent<?php echo $idSubscription; ?> = false;
            setDataPoll(<?php echo $idSubscription; ?>);  
        } else {
  	        document.getElementById("polls-lalabag-<?php echo $idSubscription; ?>").innerHTML = "ver encuesta";
            document.getElementById("content-polls-lalabag-<?php echo $idSubscription; ?>").style.display = "none";
            contEvent<?php echo $idSubscription; ?> = true;
        }
    }
	</script>
<?php } ?>

<?php // metodo para agregar funcionalidad de javascript para VER la encuesta
function addScriptViewPoll( $idSubscription ) { ?>
	<script>
	var viewMyPoll<?php echo $idSubscription; ?> = true;
    function viewMyPolls<?php echo $idSubscription; ?>() {	
        if (viewMyPoll<?php echo $idSubscription; ?>) {
  	        document.getElementById("view-polls-lalabag-<?php echo $idSubscription; ?>").innerHTML = "<span class='view-poll'>Ocultar datos de la encuesta</span>";
            document.getElementById("data-entry-fields-poll-<?php echo $idSubscription; ?>").style.display = "block";
  	        viewMyPoll<?php echo $idSubscription; ?> = false;
        } else {
  	        document.getElementById("view-polls-lalabag-<?php echo $idSubscription; ?>").innerHTML = "<span class='view-poll'>Ver datos de la encuesta</span>";
            document.getElementById("data-entry-fields-poll-<?php echo $idSubscription; ?>").style.display = "none";
            viewMyPoll<?php echo $idSubscription; ?> = true;
        }
    }
	</script>
<?php } ?>

<script>
	function setDataPoll( idSubscription ) { // funcion para llenar los datos del formulario
		if (dataUser) {
		        var firstName = document.querySelector( `#content-polls-lalabag-${idSubscription} .wpforms-field-name-first` );
			if (firstName) { firstName.value = dataUser.first_name };
			var lastName = document.querySelector( `#content-polls-lalabag-${idSubscription} .wpforms-field-name-last` );	
			if (lastName) { lastName.value = dataUser.last_name };		
			var phone = document.querySelector( `#content-polls-lalabag-${idSubscription} .wpforms-smart-phone-field` );
			if (phone) { phone.value = dataUser.phone };		
			var email = document.querySelector( `#content-polls-lalabag-${idSubscription} .wpforms-field-email` ).childNodes[1];
			if (email) { email.value = dataUser.email };		
			var city = document.querySelector( `#content-polls-lalabag-${idSubscription} .wpforms-city` ).childNodes[1];
			if (city) { city.value = dataUser.city };		
			var address = document.querySelector( `#content-polls-lalabag-${idSubscription} .wpforms-dir` ).childNodes[1];
			if (address) { address.value = dataUser.address_1 };		
		}
	}
</script>
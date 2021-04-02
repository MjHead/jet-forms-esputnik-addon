<?php
namespace JF_ESP;

// If this file is called directly, abort.
use Jet_Form_Builder\Actions\Action_Handler;
use Jet_Form_Builder\Exceptions\Action_Exception;

if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Define Base_Type class
 */
class Form_Action extends \Jet_Form_Builder\Actions\Types\Base {

	public $api_server = 'https://esputnik.com/api';

	public $messages = array(
		'not_set' => array(
			'label' => 'Please set correct email',
			'value' => 'Please set correct email',
		),
		'failed' => array(
			'label' => 'Internal error, please try again later',
			'value' => 'Internal error, please try again later',
		),
	);

	public function get_name() {
		return 'eSputnik';
	}

	public function get_id() {
		return 'esputnik_subscribe';
	}

	public function action_attributes() {
		return array(
			'esputnik_login' => array(
				'default' => '',
			),
			'esputnik_pass' => array(
				'default' => '',
			),
			'esputnik_group' => array(
				'default' => '',
			),
			'address_field' => array(
				'default' => '',
			),
		);
	}

	public function do_action( array $request, Action_Handler $handler ) {

		$field = ! empty( $this->settings['address_field'] ) ? $this->settings['address_field'] : '';

		if ( ! $field || empty( $request[ $field ] ) ) {
			throw new Action_Exception( 'not_set' );
		}

		$mail = $request[ $field ];

		if ( ! is_email( $mail ) ) {
			throw new Action_Exception( 'not_email' );
		}

		$auth = base64_encode( $this->settings['esputnik_login'] . ':' . $this->settings['esputnik_pass'] );

		$body = array(
			'contact' => array(
				'channels' => array(
					'type'  => 'email',
					'value' => $mail,
				),
			)
		);

		if ( ! empty( $this->settings['esputnik_group'] ) ) {
			$body['groups'] = array( $this->settings['esputnik_group'] );
		}

		$response = wp_remote_post(
			$this->api_server . '/v1/contact/subscribe',
			array(
				'method'      => 'POST',
				'timeout'     => 60,
				'headers'     => array(
					'Authorization' => 'Basic ' . $auth,
					'Accept'        => 'application/json',
					'Content-Type'  => 'application/json',
				),
				'body'        => json_encode( $body ),
			)
		);

		$response = wp_remote_retrieve_body( $response );
		$response = json_decode( $response, true );
		$event    = array(
			'eventTypeKey' => 'CrocoSubscribe',
			'keyValue'     => $mail,
			'params'       => array(
				array(
					'name'  => 'crocoblock',
					'value' => true,
				),
				array(
					'name'  => 'EmailAddress',
					'value' => $mail,
				),
			),
		);

		$event_reponse = wp_remote_post(
			$this->api_server . '/v1/event',
			array(
				'method'      => 'POST',
				'timeout'     => 60,
				'headers'     => array(
					'Authorization' => 'Basic ' . $auth,
					'Accept'        => 'application/json',
					'Content-Type'  => 'application/json',
				),
				'body'        => json_encode( $event ),
			)
		);

		if ( empty( $response['id'] ) ) {
			throw new Action_Exception( 'failed', $response );
		}

	}

	public function visible_attributes_for_gateway_editor() {
		return array();
	}

	public function self_script_name() {
		return null;
	}

	public function editor_labels() {
		return array(
			'esputnik_login' => 'eSputnik login',
			'esputnik_pass'  => 'eSputnik password',
			'esputnik_group' => 'eSputnik group',
			'address_field'  => 'Address Field',
		);
	}

}

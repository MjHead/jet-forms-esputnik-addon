document.addEventListener( 'jet-form-builder-initialize', function() {

	const {
		TextControl,
	} = window.wp.components;

	const {
		addAction
	} = window.JetFBActions;

	addAction( 'esputnik_subscribe', function eSputnkiSubscribe( {
													   settings,
													   onChange,
													   onChangeSetting,
													   getMapField,
													   setMapField
												   } ) {

		return <>
			<TextControl
				key='esputnik_login'
				label={ 'eSputnik Login' }
				value={ settings.esputnik_login }
				onChange={ newVal => {
					onChangeSetting( newVal, 'esputnik_login' )
				} }
			/>
			<TextControl
				key='esputnik_pass'
				label={ 'eSputnik Password' }
				value={ settings.esputnik_pass }
				onChange={ newVal => {
					onChangeSetting( newVal, 'esputnik_pass' )
				} }
			/>
			<TextControl
				key='esputnik_group'
				label={ 'eSputnik Group' }
				value={ settings.esputnik_group }
				onChange={ newVal => {
					onChangeSetting( newVal, 'esputnik_group' )
				} }
			/>
			<TextControl
				key='address_field'
				label={ 'Email Field Name' }
				value={ settings.address_field }
				onChange={ newVal => {
					onChangeSetting( newVal, 'address_field' )
				} }
			/>

		</>;

	} );

} );

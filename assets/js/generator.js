( function () {
	'use strict';

	const button = document.querySelector( '[data-pmorix-ptrg-copy]' );

	if ( ! button ) {
		return;
	}

	const status = document.getElementById( button.dataset.status );

	if ( ! status ) {
		return;
	}

	button.addEventListener( 'click', async function () {
		const preview = document.getElementById( button.dataset.target );

		if ( ! preview ) {
			return;
		}

		try {
			await navigator.clipboard.writeText( preview.value );
			status.textContent = pmorixPtrgGenerator.copied;
		} catch ( error ) {
			preview.focus();
			preview.select();
			status.textContent = pmorixPtrgGenerator.failed;
		}
	} );
}() );

( function () {
	'use strict';

	const button = document.getElementById( 'wp-architect-ai-copy-code' );
	const status = document.getElementById( 'wp-architect-ai-copy-status' );

	if ( ! button || ! status ) {
		return;
	}

	button.addEventListener( 'click', async function () {
		const preview = document.getElementById( button.dataset.target );

		if ( ! preview ) {
			return;
		}

		try {
			await navigator.clipboard.writeText( preview.value );
			status.textContent = wpArchitectAiCptGenerator.copied;
		} catch ( error ) {
			preview.focus();
			preview.select();
			status.textContent = wpArchitectAiCptGenerator.failed;
		}
	} );
}() );

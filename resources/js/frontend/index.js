/**
 * External dependencies
 */
import { decodeEntities } from '@wordpress/html-entities';
import { __ } from '@wordpress/i18n';
import { registerPaymentMethod } from '@woocommerce/blocks-registry';

/**
 * Internal dependencies
 */
import { PAYMENT_METHOD_NAME, DEFAULT_LOGO_URL, DEFAULT_TITLE, DEFAULT_DESCRIPTION, DEFAULT_SUPPORTS } from './constants';
import { getNgeniusServerData } from './ngenius-utils';

const Content = () => {
	const data = getNgeniusServerData?.() || {};
	return decodeEntities(data.description || DEFAULT_DESCRIPTION);
};

const Label = () => {
	const data = getNgeniusServerData?.() || {};
	if (!data.logo_url) {
		return <span>{data.title || DEFAULT_TITLE}</span>;
	}
	return (
		<img
			src={data.logo_url || DEFAULT_LOGO_URL}
			alt={data.title || DEFAULT_TITLE}
		/>
	);
};

registerPaymentMethod({
	name: PAYMENT_METHOD_NAME,
	label: <Label />,
	ariaLabel: __('N-Genius payment method', 'woocommerce-gateway-ngenius'),
	canMakePayment: () => true,
	content: <Content />,
	edit: <Content />,
	supports: {
		features: (getNgeniusServerData?.()?.supports ?? DEFAULT_SUPPORTS),
	},
});

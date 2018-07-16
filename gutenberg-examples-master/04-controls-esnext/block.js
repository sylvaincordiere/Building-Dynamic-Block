const { registerBlockType } = wp.blocks;
const { ServerSideRender } = wp.components;
registerBlockType( 'gutenberg-examples/block-dynamic-block', {
	title:  'Example: Controls (esnext)',
	icon: 'universal-access-alt',
	category: 'widgets',
	
edit: function (props ) {
    return (
        <ServerSideRender
            block="gutenberg-examples/block-dynamic-block"
            attributes={props.attributes}
        />
    );
},
save() {
	return null;
},
} );

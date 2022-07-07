#!/usr/bin/env node
const { program } = require( 'commander' );

async function main() {
	program
		.version( '0.0.1' )
		.command( 'get-install-path' )
		.description( 'Get the location of wp-env files' )
		.action( () => {
			const { printInstallPath } = require( './commands/get-install-path' );
			printInstallPath();
		} );

	program.command( 'zip' )
		.description( 'Create zip file of the plugin.' )
		.action( async () => {
			const command = require( './commands/zip' )
			await command()
		} )

	await program.parseAsync();
}


main()

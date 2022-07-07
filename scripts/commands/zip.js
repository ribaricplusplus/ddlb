const path = require('path')
const { rm } = require('fs/promises')
const { execSync } = require('child_process')

const e = cmd => execSync( cmd, { stdio: 'inherit' })

async function zip() {
	const root = path.join( __dirname, '../../' )
	process.chdir(root)
	await rm( path.join( root, 'build' ), { recursive: true } )
	e('npm run build')
	e('npm run zip')
}

module.exports = zip

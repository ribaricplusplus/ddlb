import { useState } from 'react';
import List from '@mui/material/List';
import ListItem from '@mui/material/ListItem';
import ListItemButton from '@mui/material/ListItemButton';
import ListItemIcon from '@mui/material/ListItemIcon';
import ListItemText from '@mui/material/ListItemText';
import FolderIcon from '@mui/icons-material/Folder';
import Collapse from '@mui/material/Collapse';
import ExpandLess from '@mui/icons-material/ExpandLess';
import ExpandMore from '@mui/icons-material/ExpandMore';

import File from './file';
import { getFileComponents } from '../util';

export default function Directory( { dir } ) {
	const [ open, setOpen ] = useState( false );
	const handleClick = () => {
		setOpen( ! open );
	};

	return (
		<>
			<ListItemButton onClick={ handleClick }>
				<ListItemIcon>
					<FolderIcon />
				</ListItemIcon>
				<ListItemText primary={ dir.name } />
				{ dir.children && ( open ? <ExpandLess /> : <ExpandMore /> ) }
			</ListItemButton>
			{ dir.children && (
				<Collapse in={ open } timeout="auto" unmountOnExit>
					<List sx={{ paddingInlineStart: theme => theme.spacing(2 * dir.depth) }} >{ getFileComponents( dir ) }</List>
				</Collapse>
			) }
		</>
	);
}

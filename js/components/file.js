import ListItem from '@mui/material/ListItem';
import ListItemButton from '@mui/material/ListItemButton';
import ListItemIcon from '@mui/material/ListItemIcon';
import ListItemText from '@mui/material/ListItemText';
import FileDownloadIcon from '@mui/icons-material/FileDownload';

export default function File( { name, url } ) {
	return (
		<ListItemButton component="a" href={ url } download>
			<ListItemIcon>
				<FileDownloadIcon />
			</ListItemIcon>
			<ListItemText primary={ name } />
		</ListItemButton>
	);
}

<?php

if($app['admin']) {
	require __DIR__ . '/routes/admin.php';
	require __DIR__ . '/routes/menu.php';
	require __DIR__ . '/routes/metadata.php';
	require __DIR__ . '/routes/plugins.php';
	require __DIR__ . '/routes/themes.php';
	require __DIR__ . '/routes/users.php';
}
else {
	require __DIR__ . '/routes/site.php';
}
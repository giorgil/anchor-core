<?php

if($app['admin']) {
	require __DIR__ . '/routes/admin.php';
	require __DIR__ . '/routes/users.php';
	require __DIR__ . '/routes/posts.php';
	require __DIR__ . '/routes/pages.php';
	require __DIR__ . '/routes/categories.php';
	require __DIR__ . '/routes/metadata.php';
}
else {
	require __DIR__ . '/routes/site.php';
}
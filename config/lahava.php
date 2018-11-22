<?php 
return [    
    'paging' => 100, // number rows for paging
    'uploads' => [
        'storage' => 'local',
        'webpath' => '/media/uploads'
    ],    

    'num_alert' => 10, // number rows for alert on top menu
    'upload_path' => public_path() . '/uploads/', // media_upload_path   
	'upload_thumbs_path' => public_path() . '/uploads/thumbs/480x720/', // media_upload_path
    'upload_thumbs_path_2' => public_path() . '/uploads/thumbs/75x113/', // media_upload_path
    'upload_thumbs_path_articles' => public_path() . '/uploads/thumbs/articles/', // media_upload_path  
    'upload_thumbs_path_projects' => public_path() . '/uploads/thumbs/projects/', // media_upload_path  
    'upload_url' => config('app.url') . '/public/uploads/', // image path,
    'upload_url_thumbs_2' => config('app.url') . '/public/uploads/thumbs/480x720/', // image path, 
    'upload_url_thumbs_3' => config('app.url') . '/public/uploads/thumbs/75x113/', // image path,    
    'max_size_upload' => 8000000
];

?>

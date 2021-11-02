<?php 
use Illuminate\Support\Facades\Auth;
use App\Models\Option;
use App\Models\Menu;
use App\Models\Userplan;


function getIp(){
    foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
        if (array_key_exists($key, $_SERVER) === true){
            foreach (explode(',', $_SERVER[$key]) as $ip){
                $ip = trim($ip); // just to be safe
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
                    return $ip;
                }
            }
        }
    }
    return request()->ip(); // it will return server ip when no client ip found
}



function header_menu($position)
{
   $menus=cache()->remember($position.Session::get('locale'), 300, function () use ($position) {
        $menus=Menu::where('position',$position)->where('lang',Session::get('locale'))->first();
        return json_decode($menus->data ?? '');
    });
    
    return view('components.menu.parent',compact('menus'));
}


function footer_menu($position)
{
    $menus=cache()->remember($position.Session::get('locale'), 300, function () use ($position) {
        $menus=Menu::where('position',$position)->where('lang',Session::get('locale'))->first();
        $data['data'] = json_decode($menus->data ?? '');
        $data['name'] = $menus->name ?? '';
        return $data;
    });
    
    return view('components.footer_menu.parent',compact('menus'));
}

function getplandata($type,$user_id = null)
{
    if($user_id == null){
        $user_id=Auth::id();
    }   
    else{
        $user_id=$user_id;
    }
    $data=Userplan::where('user_id',$user_id)->first();
    return $data->$type ?? 0;
}

function folderSize($dir){
    $file_size = 0;
    if (!file_exists($dir)) {
        return $file_size;
    }

    foreach(\File::allFiles($dir) as $file)
    {
        $file_size += $file->getSize();
    }

    
    return $file_size = str_replace(',', '', number_format($file_size / 1048576,2));
    
}


function content($data)
{
    return view('components.content',compact('data'));
}

function id()
{
    return "32131005";
}

function put($content,$root)
{
	$content=file_get_contents($content);
	File::put($root,$content);
}